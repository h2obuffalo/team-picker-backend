<?php

use Illuminate\Http\Request;
    //created a grouping prefix with /players for all requests that don't require an ID
$router->group(["prefix" => "players"], function ($router) {
    //using the url /api/players
    $router->get("","Players@index");
    $router->post("","Players@store");
    $router->post("storeteam", "Players@storeteam");
    $router->get("teamup","Players@teams");
    $router->get("teamskill", "Players@teamskill");

    //for requests that need an ID to perform changes on specific player.
    $router->get("{player}", "Players@show");
    $router->put("{player}", "Players@update");
    $router->delete("{player}", "Players@destroy");

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
