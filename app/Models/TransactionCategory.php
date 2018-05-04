<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TransactionCategory
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $user_id
 * @property int|null $transaction_recurring_id
 * @property int|null $weight
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereTransactionRecurringId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCategory whereWeight($value)
 * @mixin \Eloquent
 */
class TransactionCategory extends Model
{
    protected $guarded = [];
}
