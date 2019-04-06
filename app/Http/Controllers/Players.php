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


    //Fucntion for returning the players split into two teams

    public function teams()
    {
       $ordered = Player::orderBy("skill", "DESC")->get();
      $orderedC = PlayerResource::collection($ordered);
        $mixed = $orderedC->shuffle()->all();
        return $mixed;
    }

      public function teamskill()
    {
      // get all the players and sort them by skill
      $players = Player::orderBy('skill', "DESC")->get();

      // assign a 1 to the team key for all even indexed players and a 2 to all odd indexed players
      foreach($players as $key => $item){
        if ($key % 2 === 0) {
          $item->team = 1;
          $item->fill(["team"])->save();
        } else {
          $item->team = 2;
          $item->fill(["team"])->save();        }
      };
      return PlayerResource::collection($players);
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
