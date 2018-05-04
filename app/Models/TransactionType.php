<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TransactionType
 *
 * @property int $id
 * @property string|null $title
 * @property int $sign
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionType whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionType whereTitle($value)
 * @mixin \Eloquent
 */
class TransactionType extends Model
{
    //
}
