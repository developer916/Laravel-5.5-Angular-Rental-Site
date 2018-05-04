<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DataProperty extends Model {

    public $timestamps = false;
    protected $table   = 'data_properties';

    public function property_name() {
    	return $this->hasOne('App\Models\DataPropertyName', 'data_property_id', 'value');
    }
}