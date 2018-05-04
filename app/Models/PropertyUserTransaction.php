<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PropertyUserTransaction
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $property_transaction_id
 * @property int|null $transaction_type_id
 * @property float|null $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyUserTransaction onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction wherePropertyTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction whereTransactionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyUserTransaction whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyUserTransaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyUserTransaction withoutTrashed()
 * @mixin \Eloquent
 */
class PropertyUserTransaction extends Model
{
    use SoftDeletes;
}
