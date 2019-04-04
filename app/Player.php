<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    // Only allow player_name, address and skill to get updated via mass assignment
    protected $fillable = ["player_name", "skill", "address"];
}
