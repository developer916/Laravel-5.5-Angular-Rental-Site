<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property int $landlord_id
 * @property int $tenant_id
 * @property float $amount
 * @property string $status
 * @property string $payment_method
 * @property string $payment_status
 * @property string|null $merchant_reference
 * @property string|null $psp_reference
 * @property string|null $payment_auth_result
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\User $author
 * @property-read \App\User $tenant
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereLandlordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereMerchantReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePaymentAuthResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePspReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment withoutTrashed()
 * @mixin \Eloquent
 */
class Payment extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function tenant()
    {
        return $this->belongsTo('App\User','tenant_id');
    }

    /**
     * Get the post's author.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo('App\User');
    }



    /**
     * Get the photo's language.
     *
     * @return Language
     */
    public function language()
    {
//        return $this->belongsTo('App\Language');
    }
}
