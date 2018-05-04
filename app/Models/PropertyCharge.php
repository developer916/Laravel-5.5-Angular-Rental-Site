<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PropertyCharge extends Model {

    public $timestamps = false;
    protected $table   = 'property_charges';
}