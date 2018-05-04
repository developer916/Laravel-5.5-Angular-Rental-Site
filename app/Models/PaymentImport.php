<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PaymentImport extends Model {

    public $timestamps = false;
    protected $table   = 'payment_imports';
}