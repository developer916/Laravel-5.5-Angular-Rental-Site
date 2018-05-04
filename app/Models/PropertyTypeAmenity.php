<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PropertyTypeAmenity
 *
 * @property int $id
 * @property int|null $amenity_id
 * @property int|null $property_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Amenity|null $amenity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeAmenity whereAmenityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeAmenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeAmenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeAmenity wherePropertyTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeAmenity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PropertyTypeAmenity extends Model
{
    /**
     * Amenities
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function amenity()
    {
        return $this->belongsTo('App\Models\Amenity');
    }
}
