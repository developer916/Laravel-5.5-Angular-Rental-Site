<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
 * App\Models\PropertyTenant
 *
 * @property int $id
 * @property int|null $property_id
 * @property int|null $user_id
 * @property int $collection_day
 * @property string $start_date
 * @property string $end_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property int|null $unit_id
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Property|null $property
 * @property-read \App\Models\Tenant|null $tenant
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyTenant onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereCollectionDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTenant whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyTenant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyTenant withoutTrashed()
 * @mixin \Eloquent
 */
class PropertyTenant extends Model {
        use SoftDeletes;
        protected $guarded = [
            'deleted_at'
        ];
        protected $table   = 'property_tenants';

        private $rules = [
            'start_date'     => 'required|date|date_format:Y-m-d',
            'end_date'       => 'date|date_format:Y-m-d|after:start_date|nullable',
            'collection_day' => 'required|numeric|between:1,31',
        ];

        public function validate () {
            $v = \Validator::make($this->attributes, $this->rules);
            if ($v->passes()) {
                return true;
            }
            $this->errors = $v->messages();
            return false;
        }

        /**
         * PropertyTenants tenant
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function tenant () {
            return $this->belongsTo('App\Models\Tenant', 'user_id');
        }

        public function profile () {
            return $this->hasOne('App\Models\Profile', 'user_id', 'user_id');
        }

        public function property(){
            return $this->belongsTo('App\Models\Property','property_id');
        }
        public function user(){
            return $this->belongsTo('App\User','user_id');
        }

        public function userInfo(){
            return $this->belongsTo('App\Models\UserInfo','user_id', 'user_id');
        }
    }
