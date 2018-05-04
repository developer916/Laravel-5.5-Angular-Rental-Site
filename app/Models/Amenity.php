<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Amenity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $title
 * @property int|null $amenity_category_id
 * @property string $type
 * @property string|null $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\AmenityCategory|null $category
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Amenity onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereAmenityCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenity whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Amenity withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Amenity withoutTrashed()
 * @mixin \Eloquent
 */
class Amenity extends Model
{
    use SoftDeletes;

    /**
     * Amenities Category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\AmenityCategory','amenity_category_id');
    }
}
