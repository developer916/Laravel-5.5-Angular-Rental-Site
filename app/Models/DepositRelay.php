<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositRelay extends Model
{
    protected $table = 'deposit_relays';

    public function scopeCancelledDepositRelay($query) {

//        return $query->where(function($query){
//            return $query->where('status', \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_TENANT'))
//                ->orWhere('status', \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_LANDLORD'));
//        });
        return $query->where('status', 0);
    }

}