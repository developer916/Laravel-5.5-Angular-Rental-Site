<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantInvitation extends Model
{
    protected $table = 'tenant_invitations';

    public function landlord() {
        return $this->belongsTo('App\User','landlord_id');
    }
}