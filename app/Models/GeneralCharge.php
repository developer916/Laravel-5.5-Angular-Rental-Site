<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class GeneralCharge extends Model {

    public $timestamps = false;
    protected $table   = 'general_charges';
}