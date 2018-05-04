<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Tenant
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
 * @property-read \App\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Property[] $properties
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyUserTransaction[] $transactions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tenant onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereHasDemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereHasLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tenant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tenant withoutTrashed()
 * @mixin \Eloquent
 */
class Tenant extends Model
{

    use SoftDeletes;

    protected $table = 'users';

    protected $dates = ['deleted_at'];

    protected $hidden = ['password'];

    protected $fillable = ['name', 'role_id', 'parent_id', 'email', 'password', 'confirmed', 'admin','confirmation_code'];

    private function rules($id)
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,id,' . $id
        ];
    }

    public function validate($id = null)
    {
        $v = \Validator::make($this->attributes, $this->rules($id));
        if ($v->passes()) {
            return true;
        }
        $this->errors = $v->messages();
        return false;
    }

    public function properties()
    {
        return $this->belongsToMany('App\Models\Property', 'property_tenants', 'property_id', 'user_id');
    }

    /**
     * Property transaction
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\PropertyUserTransaction');
    }

    public function profile () {
        return $this->hasOne('App\Models\Profile','user_id');
    }
}
