<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('info', function () {
    phpinfo();
});

Route::get('wx','WeiXin\wxcontroller@wx');
Route::post('wx','WeiXin\wxcontroller@wxer');
Route::get('wx/menu','WeiXin\wxcontroller@menu');
Route::get('vote','WeiXin\VoteConteller@index');
Route::get('key','WeiXin\VoteConteller@delkey');
//商城路由
Route::get('goods','WeiXin\GoodsController@index');
Route::get('goodslist','WeiXin\GoodsController@goodslist');
Route::get('goods/goods','WeiXin\GoodsController@goods');





