<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RoomCleaning extends Model {

    public $timestamps = false;
    protected $table   = 'room_cleanings';
}