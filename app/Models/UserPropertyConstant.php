<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserPropertyConstant extends Model {

    public $timestamps = false;
    protected $table   = 'user_property_constants';
}