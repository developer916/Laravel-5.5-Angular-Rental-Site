<?php

namespace App;

use App\Models\Property;
use Kodeine\Acl\Traits\HasRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $email
 * @property string $password
 * @property string $confirmation_code
 * @property int $confirmed
 * @property int $admin
 * @property string|null $remember_token
 * @property int $has_demo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property int $has_login
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Kodeine\Acl\Models\Eloquent\Permission[] $permissions
 * @property-read \App\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Kodeine\Acl\Models\Eloquent\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @property-read \App\Models\Invoice $tenantInvoice
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereHasDemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereHasLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable,   HasRole;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dates = ['deleted_at'];

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password','confirmation_code'
    ];

    public $incrementing = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role () {
        return $this->belongsToMany('App\Models\Role');
    }

    public function profile () {
        return $this->hasOne('App\Models\Profile');
    }

    public function messages () {
        return $this->belongsToMany('App\Models\Message', 'message_user', 'user_id', 'message_id')
            ->whereNull('message_user.deleted_at')
            ->withPivot('read', 'starred', 'read_date', 'postponed_date')
            ->with('sender', 'properties', 'tags');
    }

    public function orderedMessages()
    {
        return $this->messages()->orderBy('created_at','DESC');
    }

    public function tags() {
        return $this->hasMany('App\Models\Tag', 'user_id', 'id');
    }

    public function tasks() {
        return $this->hasMany('App\Models\Task', 'user_id', 'id');
    }

    public function hasRole($role) {
        return $this->role()->where('name', '=', $role)->count() > 0;
    }

    public function tenantInvoice(){
        return $this->belongsTo('App\Models\Invoice','tenant_id');
    }

    public function landlordInvitationTenant(){
        return $this->hasOne('App\Models\LandlordInvitation');
    }

    public function tenantInvitationLandlord(){
        return $this->hasMany('App\Models\TenantInvitation', 'landlord_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
