<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereTitle($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    public $timestamps = false;
}
