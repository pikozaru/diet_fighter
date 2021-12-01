@extends('layouts.app')

@section('content')
<div class="ml-3 mr-3 mt-4">
    <h2 class="mx-auto text-center under mb-5" style="width:10em">スキル一覧</h2>
    
    @foreach($possessionSkills as $possessionSkill)
        <div class="card card-body mb-1 shadow-sm">
        <div class="text-right">
            <p class="skill-level-under">Lv：{{$possessionSkill->level}}</p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h3 class="mb-5 pb-4" style="border-bottom:solid 2px #ffcb42;">{{$possessionSkill->skill->name}}</h3>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col text-center">
                    <p class="list-arrow-sub">消費行動力：{{$possessionSkill->skill->required_action_points}}</p>
                </div>
                <div class="col text-center">
                    <p class="list-arrow-sub">消費MP：{{$possessionSkill->skill->consumed_magic_points}}</p>
                </div>
            </div>
            <p class="text-center skill-border pt-3 pb-3">{{$possessionSkill->skill->description}}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection