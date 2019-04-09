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

    //function to take whole array of player objects and store each player in the database
     public function storeteam(Request $request)
    {
        $request = $request->json()->all();

            foreach ($request['players'] as $player) {
                $newPlayer = Player::create($player);
                $newPlayer->fill($player)->save();
            }
            return Players::teamskill();
    }

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


    //Fucntion for returning the players split into two random teams

    public function teams()
    {
        $players = Player::orderBy('skill', "DESC")->get();

        foreach($players as $key => $player){
          $team = random_int(1, 2);
          $player->team = $team;
          $player->fill(['team'])->save();
      }
      return PlayerResource::collection($players);
  }

  public function teamskill()
  {
      $players = Player::orderBy('skill', "DESC")->get();
      // dd($players);
      foreach($players as $key => $player){
        if ($key % 2 === 0) {
          $player->team = 1;
          $player->fill(['team'])->save();
      } else {
          $player->team = 2;
          $player->fill(['team'])->save();
      }
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

    public function dropplayers()
    {
        Player::truncate();
        return response(null, 204);
    }
}
