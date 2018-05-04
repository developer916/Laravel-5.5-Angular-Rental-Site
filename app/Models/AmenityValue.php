<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AmenityValue
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AmenityValue onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AmenityValue withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AmenityValue withoutTrashed()
 * @mixin \Eloquent
 */
class AmenityValue extends Model
{
    use SoftDeletes;
}
