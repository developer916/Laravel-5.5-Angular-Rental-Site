<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DepositCharge extends Model {

    public $timestamps = false;
    protected $table   = 'deposit_charges';
}