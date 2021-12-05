<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\WebController@index')->name('web.index');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth','verified']], function(){
    Route::get('register/verify/{token}', 'Auth\RegisterController@showForm');
    
    Route::group(['as' => 'mains.'], function () {
        Route::get('mains', 'App\Http\Controllers\MainController@index')->name('index');
        Route::post('mains/store', 'App\Http\Controllers\MainController@store')->name('store');
        Route::post('mains/update', 'App\Http\Controllers\MainController@update')->name('update');
    });
    
    Route::resource('quests', 'App\Http\Controllers\QuestController', ['only' => ['create','store','show']]);
    Route::group(['as' => 'quests.'], function () {    
        Route::post('quests/command/{quest}','App\Http\Controllers\QuestController@command')->name('command');
        Route::get('quests/rankCount/{quest}','App\Http\Controllers\QuestController@rankCount')->name('rankCount');
        Route::get('quests/result/{quest}','App\Http\Controllers\QuestController@result')->name('result');
        Route::get('quests/resultLose/{quest}','App\Http\Controllers\QuestController@resultLose')->name('resultLose');
        Route::post('quests/finish/{quest}','App\Http\Controllers\QuestController@finish')->name('finish');
    });
        
    Route::resource('rankings', 'App\Http\Controllers\RankingController', ['only' => ['index']]);
    
    Route::group(['as' => 'records.'], function () {    
        Route::get('records/latest', 'App\Http\Controllers\RecordController@latest')->name('latest');
        Route::get('records', 'App\Http\Controllers\RecordController@index')->name('index');
        Route::post('records', 'App\Http\Controllers\RecordController@store')->name('store');
        Route::get('records/show/{record}', 'App\Http\Controllers\RecordController@show')->name('show');
    });
    
    Route::get('nameEdits', 'App\Http\Controllers\EditController@nameEdit')->name('edits.name');
    Route::post('nameEdits', 'App\Http\Controllers\EditController@nameUpdate')->name('updates.name');
    
    Route::get('emailEdits', 'App\Http\Controllers\EditController@emailEdit')->name('edits.email');
    Route::post('emailEdits', 'App\Http\Controllers\EditController@emailUpdate')->name('updates.email');
    
    Route::get('heightEdits', 'App\Http\Controllers\EditController@heightEdit')->name('edits.height');
    Route::post('heightEdits', 'App\Http\Controllers\EditController@heightUpdate')->name('updates.height');

    Route::get('userinformations', 'App\Http\Controllers\UserInformationController@index')->name('userInformations.index');
    
    Route::resource('items', 'App\Http\Controllers\ItemController', ['except' => ['show', 'edit', 'update', 'destroy']]);
    
    Route::resource('skills', 'App\Http\Controllers\SkillController',['except' => ['show', 'edit', 'update', 'destroy']]);    
    Route::group(['as' => 'skills.'], function () {
        Route::get('skills/index', 'App\Http\Controllers\SkillController@index')->name('index');
        Route::post('skills/levelUp', 'App\Http\Controllers\SkillController@levelUp')->name('levelUp');
    });
    
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
    Route::post('/home', 'App\Http\Controllers\HomeController@store')->name('home');
});

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}