<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AmenityCategory
 *
 * @property int $id
 * @property string|null $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AmenityCategory onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenityCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenityCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenityCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenityCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenityCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AmenityCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AmenityCategory withoutTrashed()
 * @mixin \Eloquent
 */
class AmenityCategory extends Model
{
    use SoftDeletes;
}
