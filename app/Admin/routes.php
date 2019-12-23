<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('users', UserController::class);
    $router->resource('text', TextController::class);
    $router->resource('image', ImgController::class);
    $router->resource('voice', VoiceController::class);
    $router->resource('goods', GoodsController::class);
    $router->resource('media', MediaController::class);
    $router->resource('qscene', QsceneController::class);


});
