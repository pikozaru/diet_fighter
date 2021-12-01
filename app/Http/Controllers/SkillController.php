<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\PossessionSkills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skills = Skill::all();
        $possessionSkillIds = PossessionSkills::where('user_id', Auth::id())->pluck('skill_id')->toArray();
        $heal = PossessionSkills::where('user_id', Auth::id())->where('skill_id', 1)->first();
        $fire = PossessionSkills::where('user_id', Auth::id())->where('skill_id', 2)->first();
        $ice = PossessionSkills::where('user_id', Auth::id())->where('skill_id', 3)->first();
        $poison = PossessionSkills::where('user_id', Auth::id())->where('skill_id', 4)->first();
        $train = PossessionSkills::where('user_id', Auth::id())->where('skill_id', 5)->first();
        $user = Auth::user();
        
        return view('skills.create', compact('skills', 'heal', 'fire', 'ice', 'poison', 'train', 'possessionSkillIds', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user )
    {
        $possessionSkill = new PossessionSkills;
        $possessionSkill->user_id = Auth::id();
        $possessionSkill->skill_id = $request->input('skill_id');
        $skill = Skill::where('id', $request->input('skill_id'))->first();
        $possessionSkill->magnification = $skill->first_magnification;
        $possessionSkill->required_upgrade_points = $skill->required_points * ($skill->upgrade_magnification + 3);
        $possessionSkill->upgrade_magnification = $skill->upgrade_magnification;
        $possessionSkill->save();
        
        $user = Auth::user();
        $user->point -= Skill::where('id', $possessionSkill->skill_id)->value('required_points');
        $user->update();
        
        return redirect()->route('skills.create', ['skill' => $possessionSkill->id]);
    }

    
    public function levelUp(Request $request)
    {
        $possessionSkillLevelUp = PossessionSkills::where('user_id', Auth::id())->where('skill_id', $request->input('skill_id'))->first();
        $user = Auth::user();
        
        $user->point -= $possessionSkillLevelUp->required_upgrade_points;
        $user->save();
        
        if($request->input('skill_id') === "1") {
            $possessionSkillLevelUp->magnification += 2;
        } elseif($request->input('skill_id') === "3") {
            $possessionSkillLevelUp->magnification += 0.05;
        } else{
            $possessionSkillLevelUp->magnification += 0.1;
        }
        $possessionSkillLevelUp->level += 1;
        $possessionSkillLevelUp->required_upgrade_points *= $possessionSkillLevelUp->upgrade_magnification + 3;
        $possessionSkillLevelUp->save();
        
        return redirect()->route('skills.create');
    }

    
    public function index()
    {
        $possessionSkills = PossessionSkills::where('user_id', Auth::id())->orderBy('skill_id', 'asc')->get();
        
        return view('skills.index', compact('possessionSkills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
