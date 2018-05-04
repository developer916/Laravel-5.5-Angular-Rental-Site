<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TransactionRecurring
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $weight
 * @property string|null $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionRecurring whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionRecurring whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionRecurring whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionRecurring whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionRecurring whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionRecurring whereWeight($value)
 * @mixin \Eloquent
 */
class TransactionRecurring extends Model
{
    protected $guarded = [];
}
