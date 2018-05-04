<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Kodeine\Acl\Traits\HasRole;
use Auth;

/**
 * App\Models\Landlord
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Property[] $properties
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Landlord onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereHasDemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereHasLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Landlord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Landlord withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Landlord withoutTrashed()
 * @mixin \Eloquent
 */
class Landlord extends Model
{

//    use SoftDeletes, HasRole;
    use SoftDeletes;

    protected $table = 'users';

    protected $dates = ['deleted_at'];

    protected $hidden = ['password'];

    protected $fillable = ['name', 'parent_id', 'email', 'password', 'confirmed', 'admin'];

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


    public function properties() {
        return $this->hasMany('App\Models\Property', 'user_id');
    }
}
