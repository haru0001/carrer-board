<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', 'UserController@userList');

//ユーザー登録
Route::post('/user', 'UserController@userCreate');
Route::get('/skillInfos', 'UserController@skillInfos');


Route::get('/user/{user}', 'UserController@userDetail');



Route::delete('/user/{user}', 'UserController@userDelete');

// 検索機能用
Route::get('/show-all-user', 'UserController@showAllUsers');
Route::get('/search_carrer', 'UserController@searchSkills');
// Route::post('/search_carrer', 'UserController@searchSkills');

//編集画面
// Route::patch('/user/{user}', 'UserController@userEdit');
Route::post('/user/update', 'UserController@userEdit');
Route::get('/skillDelete/', 'UserController@skillDelete');

//詳細画面
Route::get('/userSkills/{user}', 'UserController@getUserSkills');

//新規登録や編集画面でのスキル検索
Route::get('/getSuggestionListTags', 'UserController@getSuggestionListTags');



//test