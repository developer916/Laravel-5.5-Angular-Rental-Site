<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandlordInvitation extends Model
{
    protected $table = 'landlord_invitations';

    public function tenant(){
        return $this->belongsTo('App\User','tenant_id');
    }
}