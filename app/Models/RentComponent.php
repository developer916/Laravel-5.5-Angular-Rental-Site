<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RentComponent extends Model {

    public  $timestamps = false;
    protected $table   = 'rent_components';

    public function property(){
        return $this->belongsTo('App\Models\Property','property_id');
    }
}