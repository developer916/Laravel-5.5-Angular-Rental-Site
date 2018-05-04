<?php

namespace App;

use Kodeine\Acl\Traits\HasRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class DepositRelay extends Authenticatable
{
    use Notifiable,   HasRole;

    protected $table = 'deposit_relays';

    protected $guard = 'deposit';

    public $incrementing = false;
}