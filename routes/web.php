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
//刷新订阅号菜单
Route::get('wx/menu','WeiXin\wxcontroller@menu');
Route::get('vote','WeiXin\VoteConteller@index');
Route::get('key','WeiXin\VoteConteller@delkey');
Route::get('wx/qunfa','WeiXin\wxcontroller@qunfa');
Route::get('wx/imgsend','WeiXin\wxcontroller@imgsend');
Route::get('wx/addimg','WeiXin\wxcontroller@addimg');
//二维码
Route::get('wx/erweima','WeiXin\wxcontroller@erweima');
Route::get('qrs','WeiXin\QrsceneController@index');

//商城路由
Route::get('goods','WeiXin\GoodsController@index');
Route::get('goodslist/{goods_id}','WeiXin\GoodsController@goodslist');
Route::get('goodsgoods','WeiXin\GoodsController@goods');
Route::get('goodslogin','WeiXin\GoodsController@login');
Route::get('index/login','WeiXin\GoodsController@indexlogin');



//月考
// Route::get('weixin','WX\WeiXin@weixin');
Route::get('wei','WX\WeiXin@wei');
Route::post('wei','WX\WeiXin@wxer');
Route::get('ke','WX\WeiXin@ke');
Route::post('wx/insert','WX\WeiXin@insert');
Route::get('sss','WX\WeiXin@sss');
Route::get('wei/upd/{k_id}','WX\WeiXin@upd');
Route::post('wx/update','WX\WeiXin@update');


Route::get('token','WX\WeiXin@token');





