<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Record;
use App\Models\ActionHistory;
use App\Models\Enemies;
use App\Models\EnemyDatabase;
use App\Models\PossessionItem;
use App\Models\PossessionSkills;
use App\Models\Quest;
use App\Models\QuestItems;
use App\Models\Item;
use App\Models\Skill;
use App\Models\Ranking;
use Carbon\Carbon;

class QuestController extends Controller
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
        $record = Record::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        $possessionItems = PossessionItem::where('user_id', Auth::id())->get();
        $quest = Quest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        $questEndAt = Quest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->value('end_at');
        $questId = Quest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->value('id');
        if(QuestItems::where('user_id', Auth::id())->get() !== null){
            $questItems = QuestItems::where('user_id', Auth::id())->get();
        }
        
        //クエスト進行中の場合
        if($quest !== null) {
            return redirect()->route('quests.show', ['quest' => $questId]);
        }
        
        //クエスト未登録の場合
        return view('quests.create', compact('record', 'possessionItems', 'questItems'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Record $record, Request $request)
    {
        $questRecently = Quest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        $questId = Quest::where('user_id', Auth::id())->orderBy('id', 'desc')->value('id');
        if($questRecently !== null) {
            return redirect()->route('quests.show', ['quest' => $questId]);
        }
        
        $getActionPoint = Record::where('user_id', Auth::id())->value('get_action_point');
        $carbon = new Carbon('now');
        $quest = new Quest();
        $quest->user_id = Auth::id();
        $quest->weight_before = $request->input('weight_before');
        $quest->body_fat_percentage_before = $request->input('body_fat_percentage_before');
        $quest->weight_after = $request->input('weight_after');
        $quest->body_fat_percentage_after = $request->input('body_fat_percentage_after');
        
        //開始日時
        $quest->start_at = new Carbon('now');
        //終了日時
        if($request->input('end_at') === "7") {
            $quest->end_at = $carbon->addweek(1);
            $quest->value = 7;
        } elseif($request->input('end_at') === "14") {
            $quest->end_at = $carbon->addweek(2);
            $quest->value = 14;
        } elseif($request->input('end_at') === "1m") {
            $quest->end_at = $carbon->addMonth(1);
            $quest->value = 30;
        }
        
        //プレイヤーの初期ステータス
        $quest->level = 1;
        $quest->action_point = $getActionPoint;
        $quest->max_hit_point = 100;
        $quest->max_magical_point = 100;
        $quest->hit_point = 100;
        $quest->magical_point = 100;
        $quest->attack_point = 20;
        $quest->defense_point = 5;
        $quest->exp = 0;
        $quest->save();
        
        //アイテムの持ち込み
        if($request->get('item')) {
            $items = $request->input('item');
            foreach($items as $item){
                $questItem = new QuestItems;
                $questItem->user_id = Auth::id();
                $questItem->item_id = $item;
                $questItem->quest_id = $quest->id;
                $questItem->save();
                
                $possessionItem = PossessionItem::where('user_id', Auth::id())->where('item_id', $item)->first();
                $possessionItem->possession_number -= 1;
                $possessionItem->save();
            }
        }
        
        //敵をを出現
        $enemydatabase = new EnemyDatabase();
        $enemydatabase->quest_id = $quest->id;
        $enemydatabase->enemy_id = 1;
        $enemydatabase->save();
        $enemydatabase->now_hit_point = $enemydatabase->enemy->hit_point;
        $enemydatabase->now_max_hit_point = $enemydatabase->enemy->max_hit_point;
        $enemydatabase->now_magical_point = $enemydatabase->enemy->magical_point;
        $enemydatabase->now_attack_point = $enemydatabase->enemy->attack_point;
        $enemydatabase->now_defense_point = $enemydatabase->enemy->defense_point;
        $enemydatabase->save();
        
        return redirect()->route('quests.show', ['quest' => $quest->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Quest $quest)
    {
        $user = Auth::user();
        $carbon = new Carbon('now');
        $possessionSkills = PossessionSkills::where('user_id', Auth::id())->orderBy('skill_id', 'asc')->get();
        $possessionSkillsEmpty = $possessionSkills->isEmpty();
        $questItems = QuestItems::where('user_id', Auth::id())->get();
        $actionHistories = ActionHistory::where('quest_id', $quest->id)->get();
        $nowHP = $quest->hit_point / $quest->max_hit_point;
        $nowMP = $quest->magical_point / $quest->max_magical_point;
        $nowExp = $quest->exp / self::calcurateRequiredLevel($quest->level);
        $subExp = self::calcurateRequiredLevel($quest->level) - $quest->exp;
        
        //クエスト終了処理へ
        // start_judge = 5 →クエスト終了
        if($quest->start_judge == 5) {
            return redirect()->route('quests.rankCount', $quest->id);
        }

        // クエスト画面を表示
        return view('quests.show', compact('user', 'quest', 'carbon', 'possessionSkills', 'possessionSkillsEmpty', 'questItems', 'actionHistories', 'nowHP', 'nowMP', 'nowExp', 'subExp'));
    }
    
    
    public function command(Request $request, Quest $quest)
    {
        //防御を選択
        if($request->get('defense')) {
            $user = Auth::user();
            $enemyDataBases = $quest->enemyDataBases;
            
            // start_judge = 0 →リセット
            $quest->start_judge = 0;
            
            //メッセージの削除
            if(ActionHistory::where('quest_id', $quest->id)->get() !== null) {
                ActionHistory::where('quest_id', $quest->id)->delete();
            }
            
            //アクションポイントを減少
            $quest->action_point -= 2;
            
            // プレイヤーのログ内容（防御）
            $actionHistoryEnemy = new ActionHistory;
            $actionHistoryEnemy->quest_id = $quest->id;
            $actionHistoryEnemy->log = $user->name."は身を守った";
            $actionHistoryEnemy->save();
            
            //敵全体の攻撃値
            $sumAttacked = 0;
            foreach ($enemyDataBases as $enemyDataBase) {
                // 敵側の攻撃処理
                if($enemyDataBase->frozen_count > 0) {
                    $enemyDataBase->frozen_count -= 1;
                    
                    // 敵のログ内容（氷結）
                    $actionHistoryEnemy = new ActionHistory;
                    $actionHistoryEnemy->quest_id = $quest->id;
                    $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は凍り付いていて動けない";
                    $actionHistoryEnemy->save();
                } elseif($enemyDataBase->frozen_count <= 0 and $enemyDataBase->now_hit_point > 0) {
                    $defensed = $enemyDataBase->now_attack_point - floor($quest->defense_point * 1.5);
                    if($defensed < 1) {
                        $defensed = 1;
                    }
                    $quest->hit_point -= $defensed;
                    $sumAttacked += $defensed;
                }
                
                // 毒攻撃
                if($enemyDataBase->poison_count > 0 and $enemyDataBase->now_hit_point >= 0) {
                    $poison = Skill::where('name', "ポイズン")->first();
                    $enemyDataBase->poison_count -= 1;
                    $attackPoison = $quest->attack_point * $poison->possessionSkill->magnification - round($enemyDataBase->now_defense_point / 3, 0);
                    if($attackPoison < 0) {
                        $attackPoison == 1;
                    }
                    $enemyDataBase->now_hit_point -= $attackPoison;
                    
                    // 敵のログ内容（毒）
                    $actionHistoryEnemy = new ActionHistory;
                    $actionHistoryEnemy->quest_id = $quest->id;
                    $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は毒で".$attackPoison."のダメージ";
                    $actionHistoryEnemy->save();
                }
                
                // 毒ターンの減少
                if($enemyDataBase->poison_count > 0) {
                    $enemyDataBase->poison_count -= 1;
                }
                $enemyDataBase->save();
                
                // 敵の死活判定
                if ($enemyDataBase->now_hit_point <= 0) {
                    //倒した敵からスコアを獲得
                    //exp=クエストレベルの経験値
                    //point=スキル習得、アイテム購入で使用
                    
                    // スキル:スコアアップ使用中の場合
                    if($quest->score_up_count >= 1) {
                        $quest->exp += $enemyDataBase->enemy->score;
                        $quest->clear_exp += $enemyDataBase->enemy->score;
                        $quest->clear_score += $enemyDataBase->enemy->score * 1.2;
                        $quest->score += $enemyDataBase->enemy->score * 1.2;
                        $user->clear_score += $enemyDataBase->enemy->score * 1.2;
                        $user->clear_point += $enemyDataBase->enemy->score;
                        $user->point += $enemyDataBase->enemy->score;
                        $user->save();
                    } 
                    // スキル:ポイントアップ使用中の場合
                    elseif($quest->point_up_count >= 1) {
                        $quest->exp += $enemyDataBase->enemy->score;
                        $quest->clear_exp += $enemyDataBase->enemy->score;
                        $quest->clear_score += $enemyDataBase->enemy->score;
                        $quest->score += $enemyDataBase->enemy->score;
                        $user->clear_score += $enemyDataBase->enemy->score;
                        $user->clear_point += $enemyDataBase->enemy->score * 1.2;
                        $user->point += $enemyDataBase->enemy->score * 1.2;
                        $user->save();
                    } else {
                        $quest->exp += $enemyDataBase->enemy->score;
                        $quest->clear_exp += $enemyDataBase->enemy->score;
                        $quest->clear_score += $enemyDataBase->enemy->score;
                        $quest->score += $enemyDataBase->enemy->score;
                        $user->clear_score += $enemyDataBase->enemy->score;
                        $user->clear_point += $enemyDataBase->enemy->score;
                        $user->point += $enemyDataBase->enemy->score;
                        $user->save();
                    }
                    
                    //倒した敵の数をカウント
                    $quest->enemy_destorying_count += 1;
                }
                
                $enemyDataBase->save();
            }
            
            // 敵のログ内容（攻撃）
            $actionHistoryEnemy = new ActionHistory;
            $actionHistoryEnemy->quest_id = $quest->id;
            $actionHistoryEnemy->log = "敵の攻撃！\r\n".$user->name."に合わせて".$sumAttacked."のダメージ";
            $actionHistoryEnemy->save();
            
            // 攻撃力アップターンの減少
            if($quest->train_count > 0) {
                $quest->train_count -= 1;
            }
            
            // スコアアップターンの減少
            if($quest->score_up_count > 0) {
                $quest->score_up_count -= 1;
            }
            
            // ポイントアップターンの減少
            if($quest->point_up_count > 0) {
                $quest->point_up_count -= 1;
            }
            
            // ハイポーションターンの減少
            if($quest->hi_potion_count > 0) {
                $quest->hi_potion_count -= 1;
            }
            
            if ($quest->hit_point <= 0) {
                $quest->hit_point = 0;
            }
            
            // ユーザの死活判定
            if ($quest->hit_point == 0) {
                return redirect()->route('quests.rankCount', $quest->id);
            }
            
            // HPが0の敵をテーブルから削除
            $quest->enemyDataBases()->where('now_hit_point', 0)->delete();
            
            // レベルアップ＋ステータスアップ
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->exp >= self::calcurateRequiredLevel($quest->level)) {
                $quest->last_time_level = $quest->level;
                $levelUpCount = round($quest->exp / self::calcurateRequiredLevel($quest->level), 0) - $quest->level;
                $quest->level += $levelUpCount;
                $quest->attack_point += 3 * $levelUpCount;
                $quest->defense_point += 1 * $levelUpCount;
                //start_judge = 4 →レベルアップ
                $quest->start_judge = 4;
            }
            
            //start_judge = 2 →敵が全滅
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->start_judge != 4) {
                $quest->start_judge = 2;
            }
        
            $quest->save();
            
            return redirect()->route('quests.show', $quest->id);
        } 
        
        //攻撃を選択
        elseif($request->get('attack')) {
            $enemyDataBases = $quest->enemyDataBases;
            $user = Auth::user();
            
            // start_judge = 0 →リセット
            $quest->start_judge = 0;
            //メッセージの削除
            if(ActionHistory::where('quest_id', $quest->id)->get() !== null) {
                ActionHistory::where('quest_id', $quest->id)->delete();
            }
            
            //攻撃対象
            $targetEnemyDataBaseIds = $request->input("attack");
            //敵全体の攻撃値
            $sumAttacked = 0;
            
            foreach ($enemyDataBases as $enemyDataBase) {
                // 攻撃対象（ブラウザフォーム側でチェックされた）かどうかを確認
                if (in_array($enemyDataBase->id, (array)$targetEnemyDataBaseIds)) {
                    
                    if($quest->train_count > 0) {
                        $train = Skill::where('name', "鍛える")->first();
                        
                        //プレイヤーの攻撃力アップ
                        $trainMultiple = $train->possessionSkill->magnification;
                    } elseif ($quest->train_count <= 0) {
                        $trainMultiple = 1;
                    }
                    
                    // プレイヤーの攻撃処理
                    $attacked = $trainMultiple * $quest->attack_point - $enemyDataBase->now_defense_point;
                    
                    //最低でも1のダメージを与える
                    if($attacked <= 1) {
                        $attacked = 1;
                    }
                    $enemyDataBase->now_hit_point -= $attacked;
                    
                    //アクションポイントの減少
                    $quest->action_point -= 5;
                    //敵のHPが負の場合
                    if ($enemyDataBase->now_hit_point < 0) {
                        $enemyDataBase->now_hit_point = 0;
                    }
                    
                    // 毒攻撃
                    if($enemyDataBase->poison_count > 0 and $enemyDataBase->now_hit_point >= 0) {
                        $poison = Skill::where('name', "ポイズン")->first();
                        $enemyDataBase->poison_count -= 1;
                        $attackPoison = $quest->attack_point * $poison->possessionSkill->magnification - round($enemyDataBase->now_defense_point / 3, 0);
                        if($attackPoison < 0) {
                            $attackPoison == 1;
                        }
                        $enemyDataBase->now_hit_point -= $attackPoison;
                        
                        // 敵のログ内容（毒）
                        $actionHistoryEnemy = new ActionHistory;
                        $actionHistoryEnemy->quest_id = $quest->id;
                        $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は毒で".$attackPoison."のダメージ";
                        $actionHistoryEnemy->save();
                    }
                    
                    // 毒ターンの減少
                    if($enemyDataBase->poison_count > 0) {
                        $enemyDataBase->poison_count -= 1;
                    }
                    $enemyDataBase->save();
                    
                    // 敵の死活判定
                    if ($enemyDataBase->now_hit_point <= 0) {
                        //倒した敵からスコアを獲得
                        //exp=クエストレベルの経験値
                        //point=スキル習得、アイテム購入で使用
                        
                        // スキル:スコアアップ使用中の場合
                        if($quest->score_up_count >= 1) {
                            $quest->exp += $enemyDataBase->enemy->score;
                            $quest->clear_exp += $enemyDataBase->enemy->score;
                            $quest->clear_score += $enemyDataBase->enemy->score * 1.2;
                            $quest->score += $enemyDataBase->enemy->score * 1.2;
                            $user->clear_score += $enemyDataBase->enemy->score * 1.2;
                            $user->clear_point += $enemyDataBase->enemy->score;
                            $user->point += $enemyDataBase->enemy->score;
                            $user->save();
                        } 
                        // スキル:ポイントアップ使用中の場合
                        elseif($quest->point_up_count >= 1) {
                            $quest->exp += $enemyDataBase->enemy->score;
                            $quest->clear_exp += $enemyDataBase->enemy->score;
                            $quest->clear_score += $enemyDataBase->enemy->score;
                            $quest->score += $enemyDataBase->enemy->score;
                            $user->clear_score += $enemyDataBase->enemy->score;
                            $user->clear_point += $enemyDataBase->enemy->score * 1.2;
                            $user->point += $enemyDataBase->enemy->score * 1.2;
                            $user->save();
                        } else {
                            $quest->exp += $enemyDataBase->enemy->score;
                            $quest->clear_exp += $enemyDataBase->enemy->score;
                            $quest->clear_score += $enemyDataBase->enemy->score;
                            $quest->score += $enemyDataBase->enemy->score;
                            $user->clear_score += $enemyDataBase->enemy->score;
                            $user->clear_point += $enemyDataBase->enemy->score;
                            $user->point += $enemyDataBase->enemy->score;
                            $user->save();
                        }
                        
                        // 倒した敵の数をカウント
                        $quest->enemy_destorying_count += 1;
                    }
                }
                
                // 敵側の攻撃処理
                if($enemyDataBase->frozen_count > 0) {
                    $enemyDataBase->frozen_count -= 1;
                    
                    // 敵のログ内容（氷結）
                    $actionHistoryEnemy = new ActionHistory;
                    $actionHistoryEnemy->quest_id = $quest->id;
                    $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は凍り付いていて動けない";
                    $actionHistoryEnemy->save();
                } elseif($enemyDataBase->frozen_count <= 0 and $enemyDataBase->now_hit_point > 0) {
                    $quest->hit_point -= $enemyDataBase->now_attack_point - $quest->defense_point;
                    $sumAttacked += $enemyDataBase->now_attack_point - $quest->defense_point;
                }
                
                $enemyDataBase->save();

                if ($quest->hit_point < 0) {
                    $quest->hit_point = 0;
                    $quest->save();
                }
                
                // ユーザの死活判定
                if ($quest->hit_point == 0) {
                    return redirect()->route('quests.rankCount', $quest->id);
                }
            }
            
            // プレイヤーのログ内容（攻撃）
            $actionHistoryPlayer = new ActionHistory;
            $actionHistoryPlayer->quest_id = $quest->id;
            $actionHistoryPlayer->log = $user->name."の攻撃！\r\n".$enemyDataBase->enemy->name."に".$attacked."のダメージ";
            $actionHistoryPlayer->save();
            
            // 敵のログ内容（攻撃）
            $actionHistoryEnemy = new ActionHistory;
            $actionHistoryEnemy->quest_id = $quest->id;
            $actionHistoryEnemy->log = "敵の攻撃！\r\n".$user->name."に合わせて".$sumAttacked."のダメージ";
            $actionHistoryEnemy->save();
            
            // 攻撃力アップターンの減少
            if($quest->train_count > 0) {
                $quest->train_count -= 1;
            }
            
            // スコアアップターンの減少
            if($quest->score_up_count > 0) {
                $quest->score_up_count -= 1;
            }
            
            // ポイントアップターンの減少
            if($quest->point_up_count > 0) {
                $quest->point_up_count -= 1;
            }
            
            // ハイポーションターンの減少
            if($quest->hi_potion_count > 0) {
                $quest->hi_potion_count -= 1;
            }
    
            // HPが0の敵をテーブルから削除
            $quest->enemyDataBases()->where('now_hit_point', 0)->delete();
            
            // レベルアップ判定
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->exp >= self::calcurateRequiredLevel($quest->level)) {
                $quest->last_time_level = $quest->level;
                $levelUpCount = round($quest->exp / self::calcurateRequiredLevel($quest->level), 0) - $quest->level;
                $quest->level += $levelUpCount;
                $quest->attack_point += 3 * $levelUpCount;
                $quest->defense_point += 1 * $levelUpCount;
                //start_judge = 4 →レベルアップ
                $quest->start_judge = 4;
            }
            
            //start_judge = 2 →敵が全滅
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->start_judge != 4) {
                $quest->start_judge = 2;
            }
            
            $quest->save();
    
            // メイン画面に戻る        
            return redirect()->route('quests.show', $quest->id);
            
        }
        
        //アイテムを選択
        elseif($request->get('itemUse')) {
            $enemyDataBases = $quest->enemyDataBases;
            $user = Auth::user();
            
            // start_judge = 0 →リセット
            $quest->start_judge = 0;
            //メッセージの削除
            if(ActionHistory::where('quest_id', $quest->id)->get() !== null) {
                ActionHistory::where('quest_id', $quest->id)->delete();
            }
            
            // スコアアップターンの減少
            if($quest->score_up_count > 0) {
                $quest->score_up_count -= 1;
            }
            
            // ポイントアップターンの減少
            if($quest->point_up_count > 0) {
                $quest->point_up_count -= 1;
            }
            
            // ハイポーションターンの減少
            if($quest->hi_potion_count > 0) {
                $quest->hi_potion_count -= 1;
            }
            
            // アイテムの種類
            if($request->input('itemUse') === "回復薬"){
                $quest->hit_point += 50;
                if($quest->hit_point > 100) {
                    $quest->hit_point = 100;
                }
                $questItem = QuestItems::where('user_id', Auth::id())->where('item_id', 1)->first();
                $questItem->possession_number -= 1;
                $questItem->save();

                // プレイヤーのログ内容（HP回復）
                $actionHistoryPlayer = new ActionHistory;
                $actionHistoryPlayer->quest_id = $quest->id;
                $actionHistoryPlayer->log = $user->name."は回復薬を使った\r\n".$user->name."のHPが50回復した！";
                $actionHistoryPlayer->save();
            } elseif($request->input('itemUse') === "ポーション"){
                $quest->magical_point += 50;
                $questItem = QuestItems::where('user_id', Auth::id())->where('item_id', 2)->first();
                $questItem->possession_number -= 1;
                $questItem->save();
                
                // プレイヤーのログ内容（MP回復）
                $actionHistoryPlayer = new ActionHistory;
                $actionHistoryPlayer->quest_id = $quest->id;
                $actionHistoryPlayer->log = $user->name."はポーションを使った\r\n".$user->name."のMPが50回復した！";
                $actionHistoryPlayer->save();
            } elseif($request->input('itemUse') === "スコアUP"){
                $quest->score_up_count = 5;
                $questItem = QuestItems::where('user_id', Auth::id())->where('item_id', 3)->first();
                $questItem->possession_number -= 1;
                $questItem->save();
                
                // プレイヤーのログ内容（スコアアップ）
                $actionHistoryPlayer = new ActionHistory;
                $actionHistoryPlayer->quest_id = $quest->id;
                $actionHistoryPlayer->log = $user->name."はスコアUPを使った\r\n5ターンの間、獲得スコアがUP！";
                $actionHistoryPlayer->save();
            } elseif($request->input('itemUse') === "ポイントUP"){
                $quest->point_up_count = 5;
                $questItem = QuestItems::where('user_id', Auth::id())->where('item_id', 4)->first();
                $questItem->possession_number -= 1;
                $questItem->save();
                
                // プレイヤーのログ内容（ポイントアップ）
                $actionHistoryPlayer = new ActionHistory;
                $actionHistoryPlayer->quest_id = $quest->id;
                $actionHistoryPlayer->log = $user->name."はポイントUPを使った\r\n5ターンの間、獲得ポイントがUP！";
                $actionHistoryPlayer->save();
            } elseif($request->input('itemUse') === "ハイポーション"){
                $quest->hi_potion_count = 5;
                $questItem = QuestItems::where('user_id', Auth::id())->where('item_id', 5)->first();
                $questItem->possession_number -= 1;
                $questItem->save();
                
                // プレイヤーのログ内容（MP∞）
                $actionHistoryPlayer = new ActionHistory;
                $actionHistoryPlayer->quest_id = $quest->id;
                $actionHistoryPlayer->log = $user->name."はハイポーションを使った\r\n5ターンの間、MPを消費しなくなった！";
                $actionHistoryPlayer->save();
            }
            
            // 敵全体の攻撃値
            $sumAttacked = 0;
            
            foreach ($enemyDataBases as $enemyDataBase) {        
                // 敵側の攻撃処理
                if($enemyDataBase->frozen_count > 0) {
                    $enemyDataBase->frozen_count -= 1;
                    
                    // 敵のログ内容（氷結）
                    $actionHistoryEnemy = new ActionHistory;
                    $actionHistoryEnemy->quest_id = $quest->id;
                    $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は凍り付いていて動けない";
                    $actionHistoryEnemy->save();
                } elseif($enemyDataBase->frozen_count <= 0 and $enemyDataBase->now_hit_point > 0) {
                    $quest->hit_point -= $enemyDataBase->now_attack_point - $quest->defense_point;
                    $sumAttacked += $enemyDataBase->now_attack_point - $quest->defense_point;
                }
                
                // 毒攻撃
                if($enemyDataBase->poison_count > 0 and $enemyDataBase->now_hit_point >= 0) {
                    $poison = Skill::where('name', "ポイズン")->first();
                    $enemyDataBase->poison_count -= 1;
                    $attackPoison = $quest->attack_point * $poison->possessionSkill->magnification - round($enemyDataBase->now_defense_point / 3, 0);
                    $enemyDataBase->now_hit_point -= $attackPoison;
                    
                    // 敵のログ内容（毒）
                    $actionHistoryEnemy = new ActionHistory;
                    $actionHistoryEnemy->quest_id = $quest->id;
                    $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は毒で".$attackPoison."のダメージ";
                    $actionHistoryEnemy->save();
                }
                
                // 毒ターンの減少
                if($enemyDataBase->poison_count > 0) {
                    $enemyDataBase->poison_count -= 1;
                }
                $enemyDataBase->save();
               
                // 死活判定
                if ($enemyDataBase->now_hit_point <= 0) {
                    //倒した敵からスコアを獲得
                    //exp=クエストレベルの経験値
                    //point=スキル習得、アイテム購入で使用
                    
                    // スキル:スコアアップ使用中の場合
                    if($quest->score_up_count >= 1) {
                        $quest->exp += $enemyDataBase->enemy->score;
                        $quest->clear_exp += $enemyDataBase->enemy->score;
                        $quest->clear_score += $enemyDataBase->enemy->score * 1.2;
                        $quest->score += $enemyDataBase->enemy->score * 1.2;
                        $user->clear_score += $enemyDataBase->enemy->score * 1.2;
                        $user->clear_point += $enemyDataBase->enemy->score;
                        $user->point += $enemyDataBase->enemy->score;
                        $user->save();
                    } 
                    // スキル:ポイントアップ使用中の場合
                    elseif($quest->point_up_count >= 1) {
                        $quest->exp += $enemyDataBase->enemy->score;
                        $quest->clear_exp += $enemyDataBase->enemy->score;
                        $quest->clear_score += $enemyDataBase->enemy->score;
                        $quest->score += $enemyDataBase->enemy->score;
                        $user->clear_score += $enemyDataBase->enemy->score;
                        $user->clear_point += $enemyDataBase->enemy->score * 1.2;
                        $user->point += $enemyDataBase->enemy->score * 1.2;
                        $user->save();
                    } else {
                        $quest->exp += $enemyDataBase->enemy->score;
                        $quest->clear_exp += $enemyDataBase->enemy->score;
                        $quest->clear_score += $enemyDataBase->enemy->score;
                        $quest->score += $enemyDataBase->enemy->score;
                        $user->clear_score += $enemyDataBase->enemy->score;
                        $user->clear_point += $enemyDataBase->enemy->score;
                        $user->point += $enemyDataBase->enemy->score;
                        $user->save();
                    }
                    
                    // 倒した敵の数をカウント
                    $quest->enemy_destorying_count += 1;
                }
                
                $enemyDataBase->save();

                if ($quest->hit_point < 0) {
                    $quest->hit_point = 0;
                }
                
                // ユーザの死活判定
                if ($quest->hit_point == 0) {
                    return redirect()->route('quests.rankCount', $quest->id);
                }
            }
            
            // 敵のログ内容
            $actionHistoryEnemy = new ActionHistory;
            $actionHistoryEnemy->quest_id = $quest->id;
            $actionHistoryEnemy->log = "敵の攻撃！\r\n".$user->name."に合わせて".$sumAttacked."のダメージ";
            $actionHistoryEnemy->save();
            
            // 攻撃力アップターンの減少
            if($quest->train_count > 0) {
                $quest->train_count -= 1;
            }
            
            // HPが0の敵をテーブルから削除する
            $quest->enemyDataBases()->where('now_hit_point', 0)->delete();
            
            // レベルアップ判定
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->exp >= self::calcurateRequiredLevel($quest->level)) {
                $quest->last_time_level = $quest->level;
                $levelUpCount = round($quest->exp / self::calcurateRequiredLevel($quest->level), 0) - $quest->level;
                $quest->level += $levelUpCount;
                $quest->attack_point += 3 * $levelUpCount;
                $quest->defense_point += 1 * $levelUpCount;
                //start_judge = 4 →レベルアップ
                $quest->start_judge = 4;
            }
            
            //start_judge = 2 →敵が全滅
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->start_judge != 4) {
                $quest->start_judge = 2;
            }
            
            $quest->save();
    
            // メイン画面に戻る        
            return redirect()->route('quests.show', $quest->id);
            
        }
        
        // スキルを選択
        elseif($request->input('enemyDataBases') or $request->input('selectSkill')) {
            $enemyDataBases = $quest->enemyDataBases;
            $user = Auth::user();
            
            // start_judge = 0 →リセット
            //メッセージの削除
            $quest->start_judge = 0;
            if(ActionHistory::where('quest_id', $quest->id)->get() !== null) {
                ActionHistory::where('quest_id', $quest->id)->delete();
            }
            
            $targetEnemyDataBaseIds = $request->input("enemyDataBases");
            
            // 攻撃力アップターンの減少
            if($quest->train_count > 0) {
                $quest->train_count -= 1;
            }
            
            $sumAttacked = 0;
            
            //　ヒーラー・バフスキル
            if ($request->input("selectSkill") === "ヒール") {
                $heal = Skill::where('name', "ヒール")->first();
                $quest->hit_point += 30 + $heal->possessionSkill->magnification;
                $quest->action_point -= $heal->required_action_points;
                if($quest->hi_potion_count >= 1) {
                    $quest->magical_point -= 0;
                } else {
                    $quest->magical_point -= $heal->consumed_magic_points;
                }
                if($quest->hit_point > 100) {
                    $quest->hit_point = 100;
                }
                $quest->save();
                
                // プレイヤーのログ内容（ヒール）
                $actionHistoryPlayer = new ActionHistory;
                $actionHistoryPlayer->quest_id = $quest->id;
                $actionHistoryPlayer->log = $user->name."はヒールを唱えた！\r\n".$user->name."のHPが回復した";
                $actionHistoryPlayer->save();
            } elseif ($request->input("selectSkill") === "鍛える") {
                $train = Skill::where('name', "鍛える")->first();
                $quest->action_point -= $train->required_action_points;
                $quest->train_count = 5;
                $quest->save();
                
                // プレイヤーのログ内容（鍛える）
                $actionHistoryPlayer = new ActionHistory;
                $actionHistoryPlayer->quest_id = $quest->id;
                $actionHistoryPlayer->log = $user->name."はとにかく鍛えた\r\nおかげで攻撃力が上がった！";
                $actionHistoryPlayer->save();
            }
            
            foreach ($enemyDataBases as $enemyDataBase) {
                // 攻撃対象（ブラウザフォーム側でチェックされた）かどうかを確認する
                if (in_array($enemyDataBase->id, (array)$targetEnemyDataBaseIds)) {
                    if($quest->train_count > 0) {
                        $train = Skill::where('name', "鍛える")->first();
                        $trainMultiple = $train->possessionSkill->magnification;
                    } elseif ($quest->train <= 0) {
                        $trainMultiple = 1;
                    }
                    
                    // 攻撃スキル処理
                    if ($request->input("selectSkill") === "ファイア") {
                        $fire = Skill::where('name', "ファイア")->first();
                        $attackFire = $trainMultiple * $quest->attack_point * $fire->possessionSkill->magnification - $enemyDataBase->now_defense_point;
                        if($attackFire <= 0) {
                            $attackFire = 1;
                        }
                        $enemyDataBase->now_hit_point -= $attackFire;
                        $quest->action_point -= $fire->required_action_points;
                        if($quest->hi_potion_count >= 1) {
                            $quest->magical_point -= 0;
                        } else {
                            $quest->magical_point -= $fire->consumed_magic_points;
                        }
                        $enemyDataBase->save();
                        
                        // プレイヤーのログ内容（ファイア）
                        $actionHistoryPlayer = new ActionHistory;
                        $actionHistoryPlayer->quest_id = $quest->id;
                        $actionHistoryPlayer->log = $user->name."はファイアを唱えた！\r\n".$enemyDataBase->enemy->name."に".$attackFire."のダメージ";
                        $actionHistoryPlayer->save();
                    } elseif ($request->input("selectSkill") === "アイス") {
                        $ice = Skill::where('name', "アイス")->first();
                        $attackIce = $trainMultiple * $quest->attack_point * $ice->possessionSkill->magnification - $enemyDataBase->now_defense_point;
                        if($attackIce <= 0) {
                            $attackIce = 1;
                        }
                        $enemyDataBase->now_hit_point -= $attackIce;
                        $quest->action_point -= $ice->required_action_points;
                        if($quest->hi_potion_count >= 1) {
                            $quest->magical_point -= 0;
                        } else {
                            $quest->magical_point -= $ice->consumed_magic_points;
                        }
                        $enemyDataBase->frozen_count = 4;
                        $enemyDataBase->save();
                        
                        // プレイヤーのログ内容（アイス）
                        $actionHistoryPlayer = new ActionHistory;
                        $actionHistoryPlayer->quest_id = $quest->id;
                        $actionHistoryPlayer->log = $user->name."はアイスを唱えた！\r\n".$enemyDataBase->enemy->name."に".$attackIce."のダメージ\r\n".$enemyDataBase->enemy->name."は凍結した";
                        $actionHistoryPlayer->save();
                    } elseif ($request->input("selectSkill") === "ポイズン") {
                        $poison = Skill::where('name', "ポイズン")->first();
                        $quest->action_point -= $poison->required_action_points;
                        if($quest->hi_potion_count >= 1) {
                            $quest->magical_point -= 0;
                        } else {
                            $quest->magical_point -= $poison->consumed_magic_points;
                        }
                        $enemyDataBase->poison_count = 6;
                        $enemyDataBase->save();
                        
                        // プレイヤーのログ内容（ポイズン）
                        $actionHistoryPlayer = new ActionHistory;
                        $actionHistoryPlayer->quest_id = $quest->id;
                        $actionHistoryPlayer->log = $user->name."はポイズンを唱えた！\r\n".$enemyDataBase->enemy->name."は毒状態になった";
                        $actionHistoryPlayer->save();
                    } elseif ($request->input("selectSkill") === "貫通攻撃") {
                        $attackPenetration->now_hit_point -= Skill::penetrationAttack($quest->attack_point);
                        $enemyDataBase->now_hit_point -= $attackPenetration;
                        $penetrationAttack = Skill::where('name', "貫通攻撃")->first();
                        $quest->action_point -= $penetrationAttack->required_action_points;
                        $enemyDataBase->save();
                        
                        // プレイヤーのログ内容（貫通攻撃）
                        $actionHistoryPlayer = new ActionHistory;
                        $actionHistoryPlayer->quest_id = $quest->id;
                        $actionHistoryPlayer->log = $user->name."の貫通攻撃！\r\n".$enemyDataBase->enemy->name."に".$attackPenetration."のダメージ";
                        $actionHistoryPlayer->save();
                    }
                }
                
                // 攻撃対象（ブラウザフォーム側でチェックされた）かどうかを確認する
                if (in_array($enemyDataBase->id, (array)$targetEnemyDataBaseIds)) {        
                    if ($enemyDataBase->now_hit_point < 0) {
                        $enemyDataBase->now_hit_point = 0;
                    }
                    $enemyDataBase->save();
                    
                    // 死活判定
                    if ($enemyDataBase->now_hit_point <= 0) {
                        //倒した敵からスコアを獲得
                        //exp=クエストレベルの経験値
                        //point=スキル習得、アイテム購入で使用
                        
                        // スキル:スコアアップ使用中の場合
                        if($quest->score_up_count >= 1) {
                            $quest->exp += $enemyDataBase->enemy->score;
                            $quest->clear_exp += $enemyDataBase->enemy->score;
                            $quest->clear_score += $enemyDataBase->enemy->score * 1.2;
                            $quest->score += $enemyDataBase->enemy->score * 1.2;
                            $user->clear_score += $enemyDataBase->enemy->score * 1.2;
                            $user->clear_point += $enemyDataBase->enemy->score;
                            $user->point += $enemyDataBase->enemy->score;
                            $user->save();
                        } 
                        // スキル:ポイントアップ使用中の場合
                        elseif($quest->point_up_count >= 1) {
                            $quest->exp += $enemyDataBase->enemy->score;
                            $quest->clear_exp += $enemyDataBase->enemy->score;
                            $quest->clear_score += $enemyDataBase->enemy->score;
                            $quest->score += $enemyDataBase->enemy->score;
                            $user->clear_score += $enemyDataBase->enemy->score;
                            $user->clear_point += $enemyDataBase->enemy->score * 1.2;
                            $user->point += $enemyDataBase->enemy->score * 1.2;
                            $user->save();
                        } else {
                            $quest->exp += $enemyDataBase->enemy->score;
                            $quest->clear_exp += $enemyDataBase->enemy->score;
                            $quest->clear_score += $enemyDataBase->enemy->score;
                            $quest->score += $enemyDataBase->enemy->score;
                            $user->clear_score += $enemyDataBase->enemy->score;
                            $user->clear_point += $enemyDataBase->enemy->score;
                            $user->point += $enemyDataBase->enemy->score;
                            $user->save();
                        }
                        
                        // 倒した敵の数をカウント
                        $quest->enemy_destorying_count += 1;
                    }
                }
    
                // 敵側の攻撃処理
                if($enemyDataBase->frozen_count > 0) {
                    $enemyDataBase->frozen_count -= 1;
                    
                    // 敵のログ内容（氷結）
                    $actionHistoryEnemy = new ActionHistory;
                    $actionHistoryEnemy->quest_id = $quest->id;
                    $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は凍り付いていて動けない";
                    $actionHistoryEnemy->save();
                } elseif($enemyDataBase->frozen_count <= 0 and $enemyDataBase->now_hit_point > 0) {
                    $quest->hit_point -= $enemyDataBase->now_attack_point - $quest->defense_point;
                    $sumAttacked += $enemyDataBase->now_attack_point - $quest->defense_point;
                }
                // 毒攻撃
                if($enemyDataBase->poison_count > 0 and $enemyDataBase->now_hit_point >= 0) {
                    $poison = Skill::where('name', "ポイズン")->first();
                    $attackPoison = $quest->attack_point * $poison->possessionSkill->magnification - round($enemyDataBase->now_defense_point / 3, 0);
                    $enemyDataBase->now_hit_point -= $attackPoison;
                    
                    // 敵のログ内容
                    $actionHistoryEnemy = new ActionHistory;
                    $actionHistoryEnemy->quest_id = $quest->id;
                    $actionHistoryEnemy->log = $enemyDataBase->enemy->name."は毒で".$attackPoison."のダメージ";
                    $actionHistoryEnemy->save();
                }
                
                // 毒ターンの減少
                if($enemyDataBase->poison_count > 0) {
                    $enemyDataBase->poison_count -= 1;
                }
                $enemyDataBase->save();
                
                if ($quest->hit_point < 0) {
                    $quest->hit_point = 0;
                }
                
                // ユーザの死活判定
                if ($quest->hit_point == 0) {
                    return redirect()->route('quests.rankCount', $quest->id);
                }
            }
            
            // 敵のログ内容（攻撃）
            $actionHistoryEnemy = new ActionHistory;
            $actionHistoryEnemy->quest_id = $quest->id;
            $actionHistoryEnemy->log = "敵の攻撃！\r\n".$user->name."に合わせて".$sumAttacked."のダメージ";
            $actionHistoryEnemy->save();
            
            // スコアアップターンの減少
            if($quest->score_up_count > 0) {
                $quest->score_up_count -= 1;
            }
            
            // ポイントアップターンの減少
            if($quest->point_up_count > 0) {
                $quest->point_up_count -= 1;
            }
            
            // ハイポーションターンの減少
            if($quest->hi_potion_count > 0) {
                $quest->hi_potion_count -= 1;
            }
    
            // HPが0の敵をテーブルから削除する
            $quest->enemyDataBases()->where('now_hit_point', 0)->delete();
            
            // レベルアップ判定
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->exp >= self::calcurateRequiredLevel($quest->level)) {
                $quest->last_time_level = $quest->level;
                $levelUpCount = round($quest->exp / self::calcurateRequiredLevel($quest->level), 0) - $quest->level;
                $quest->level += $levelUpCount;
                $quest->attack_point += 3 * $levelUpCount;
                $quest->defense_point += 1 * $levelUpCount;
                //start_judge = 4 →レベルアップ
                $quest->start_judge = 4;
            }
            
            //start_judge = 2 →敵が全滅
            if(!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists() and $quest->start_judge != 4) {
                $quest->start_judge = 2;
            }
            
            $quest->save();
    
            // メイン画面に戻る        
            return redirect()->route('quests.show', $quest->id);
        
        //敵が全滅したとき    
        } elseif($request->get('nextQuest')) {
            if (!$quest->enemyDataBases()->where('now_hit_point', '!=', 0)->exists()) {
                // プレイヤーのレベルごとに敵のステータスを強化
                if($quest->level % 10 == 0) {    
                    $quest->enemy_annihilation_count += 1.4;
                }
                
                // 各レベルに達した場合の出現するボス
                for($i = 1 ; $i < mt_rand(2, 3) ; $i++) {
                    $addEnemyDataBase = new EnemyDatabase();
                    $addEnemyDataBase->quest_id = $quest->id;
                    if($quest->level >= 20 and $quest->boss_count == 0) {
                        $addEnemyDataBase->enemy_id = 13;
                        $quest->boss_count += 1;
                    } elseif($quest->level >= 40 and $quest->boss_count == 1) {
                        $addEnemyDataBase->enemy_id = 14;
                        $quest->boss_count += 1;
                    } elseif($quest->level >= 70 and $quest->boss_count == 2) {
                        $addEnemyDataBase->enemy_id = 15;
                        $quest->boss_count += 1;
                    } elseif($quest->level >= 100 and $quest->boss_count == 3) {
                        $addEnemyDataBase->enemy_id = 16;
                        $quest->boss_count += 1;
                    } else {
                        
                        // ボス以外の敵を追加
                        $addEnemyDataBase->enemy_id = Enemies::pop_probability($quest->level);
                    }
                    $addEnemyDataBase->save();
                    
                    // 敵のステータスを追加
                    $addEnemyDataBase->now_hit_point = floor($addEnemyDataBase->enemy->hit_point * $quest->enemy_annihilation_count);
                    $addEnemyDataBase->now_max_hit_point = floor($addEnemyDataBase->enemy->max_hit_point * $quest->enemy_annihilation_count);
                    $addEnemyDataBase->now_magical_point = floor($addEnemyDataBase->enemy->magical_point * $quest->enemy_annihilation_count);
                    $addEnemyDataBase->now_attack_point = floor($addEnemyDataBase->enemy->attack_point * $quest->enemy_annihilation_count);
                    $addEnemyDataBase->now_defense_point = floor($addEnemyDataBase->enemy->defense_point * $quest->enemy_annihilation_count);
                    $addEnemyDataBase->save();
                }
                
                // ボスを一体のみにする
                if(EnemyDatabase::whereBetween('enemy_id', [13, 16])->get()->count() >= 2) {
                    $deleteBoss = EnemyDatabase::where('quest_id', $quest->id)->first();
                    $deleteBoss->delete();
                }
            }
            
            // start_judge = 1 →最初のクエスト画面
            $quest->start_judge = 1;
            // 前回取得した経験値、スコアをリセット
            $quest->clear_exp = 0;
            $quest->clear_score = 0;
            $quest->save();
            
            $user = Auth::user();
            // 前回取得した経験値、スコアをリセット
            $user->clear_point = 0;
            $user->save();
            
            // メイン画面に戻る        
            return redirect()->route('quests.show', $quest->id);
        }
        
    }
    
    public function rankCount(Request $request, Quest $quest)
    {
        $user = Auth::user();
        
        //クエストでのスコアを加算
        $user->total_score += $user->clear_score;
        //スコアをリセット
        $user->clear_score = 0;
        $user->save();
        
        // ランクアップ判定
        if($user->total_score >= self::calcurateRequiredRank($user->rank)) {
            $user->last_time_rank = $user->rank;
            $rankUpCount = round($user->total_score / self::calcurateRequiredRank($user->rank), 0) - $user->rank;
            $user->rank += $rankUpCount;
        }
        $user->save();
        
        if($quest->hit_point <= 0) {
            //プレイヤーが負けた場合
            return redirect()->route('quests.resultLose', $quest->id);
        } else {
            //クエストが終了した場合
            return redirect()->route('quests.result', $quest->id);
        }
    }
    
    //クエスト終了
    public function result(Request $request, Quest $quest)
    {
        $user = Auth::user();
        $carbon = new Carbon('now');
        $rankUpJudge = $user->total_score - self::calcurateRequiredRank($user->rank);
        $nowRanking = Ranking::where('user_id', Auth::id())->first();
        
        //スコアの更新
        if($quest->score > $nowRanking->score) {
            Ranking::where('user_id', Auth::id())->delete();
            $ranking = new Ranking;
            $ranking->user_id = Auth::id();
            $ranking->level = $quest->level;
            $ranking->enemy_destorying_count = $quest->enemy_destorying_count;
            $ranking->score = $quest->score;
            $ranking->start_at = $quest->start_at;
            $ranking->end_at = $quest->end_at;
            $ranking->value = $quest->value;
            $ranking->save();
        }
        
        // start_judge = 5 →クエスト終了
        $quest->start_judge = 5;
        $quest->save();
        
        return view('quests.result', compact('quest', 'carbon', 'user', 'rankUpJudge'));
    }
    
    //クエスト失敗
    public function resultLose(Request $request, Quest $quest)
    {
        $user = Auth::user();
        $rankUpJudge = $user->total_score - self::calcurateRequiredRank($user->rank);
        
        // start_judge = 5 →クエスト終了
        $quest->start_judge = 5;
        $quest->save();
        
        return view('quests.resultLose', compact('quest', 'user', 'rankUpJudge'));
    }
    
    
    public function finish(Request $request, Quest $quest)
    {
        $user = Auth::user();
        $quest = Quest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        
        //出現中の敵を削除
        $quest->enemyDataBases()->delete();
        //終了したクエストを削除
        $quest->delete();
        //未使用のアイテムを削除
        $user->questitems()->delete();
        
        return redirect()->route('quests.create');
    }
    
    
    //次のレベルアップに必要なexpを算出
     
    private static function calcurateRequiredLevel($level)
    {
        $level_up_point = 100;
        $rate = 1.1;
        $score = 0;
        
        for ($i = 0; $i < $level; $i++) {
            $score += $level_up_point * ($rate ** ($i));
        }

        return floor($score);
    }
    
    //次のレベルアップに必要なトータルscoreを算出する
    private static function calcurateRequiredRank($rank)
    {
        $rankUpPoint = 500;
        $rate = 1.2;
        $scoreToExp = 0;
        
        for ($i = 0; $i < $rank; $i++) {
            $scoreToExp += $rankUpPoint * ($rate ** ($i));
        }

        return floor($scoreToExp);
    }
    
}
