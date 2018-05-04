<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCostAccount extends Model
{
    //    
    public $timestamps = false;
    protected $table = 'SCaccounts';

    public function sca_type() {
    	return $this->hasOne('App\Models\DataPropertyName', 'data_property_id', 'costID');
    }
}
