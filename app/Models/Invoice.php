<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\URL;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
 * App\Models\Invoice
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $landlord_id
 * @property int|null $tenant_id
 * @property int $status
 * @property float $amount
 * @property int $discount
 * @property int $currency
 * @property string|null $notes
 * @property string|null $description
 * @property string $due_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property int|null $property_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invoice onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDueAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereLandlordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invoice withoutTrashed()
 * @mixin \Eloquent
 */
class Invoice extends Model {

        use SoftDeletes;

        protected $dates = ['deleted_at'];

//        public function landlord () {
//            return $this->hasOne('App\User', 'id', 'landlord_id');
//        }
//
//        public function tenant () {
//            return $this->hasOne('App\User', 'id', 'landlord_id');
//        }
//
//        public function user () {
//            return $this->belongsTo('App\User');
//        }
//
//        public function property () {
//            return $this->hasOne('App\Models\Property','id','property_id');
//        }

    }
