<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PropertyTransaction
 *
 * @property int $id
 * @property int|null $property_id
 * @property int|null $unit_id
 * @property int|null $user_id
 * @property int|null $transaction_category_id
 * @property int|null $transaction_recurring_id
 * @property float|null $amount
 * @property float|null $amount_tax
 * @property int|null $amount_tax_included
 * @property float|null $amount_total
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\TransactionCategory|null $transactionCategory
 * @property-read \App\Models\TransactionRecurring|null $transactionRecurring
 * @property-read \App\Models\Property|null $unit
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyTransaction onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereAmountTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereAmountTaxIncluded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereAmountTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereTransactionCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereTransactionRecurringId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTransaction whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyTransaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyTransaction withoutTrashed()
 * @mixin \Eloquent
 */
class PropertyTransaction extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    private $rules = [
        'amount' => 'required|numeric',
    ];

    /**
     * Transaction Category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionCategory()
    {
        return $this->belongsTo('App\Models\TransactionCategory');
    }

    /**
     * Transaction Recurring
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionRecurring()
    {
        return $this->belongsTo('App\Models\TransactionRecurring');
    }

    /**
     * Unit
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo('App\Models\Property','unit_id');
    }

    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) {
            return true;
        }
        $this->errors = $v->messages();
        return false;
    }
}
