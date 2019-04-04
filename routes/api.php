<?php

use Illuminate\Http\Request;

$router->group(["prefix" => "players"], function ($router) {
    $router->get("","Players@index");
    $router->post("","Players@store");
    $router->get("{player}", "Players@show");
    $router->put("{player}", "Players@update");
    $router->delete("{player}", "Players@destroy");
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
