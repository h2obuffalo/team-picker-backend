<?php

namespace App\Http\Controllers;
use App\Player;
use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use Illuminate\Http\Request;

class Players extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PlayerResource::collection(Player::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerRequest $request)
    {
        $data = $request->only("player_name", "skill", "address");
        $player = Player::create($data);
        $player->fill($data)->save();
        return new PlayerResource($player);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return new PlayerResource($player);
    }

    public function teams()
    {
       $ordered = Player::orderBy("skill", "DESC")->get();
                return PlayerResource::collection($ordered);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlayerRequest $request, Player $player)
    {
        $data = $request->only("player_name", "skill", "address");
        $player->fill($data)->save();
        return new PlayerResource($player);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {

        $player->delete();
        return response(null, 204);
    }
}
