<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PropertyAmenity
 *
 * @property int $id
 * @property int|null $amenity_id
 * @property int|null $property_id
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyAmenity whereAmenityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyAmenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyAmenity wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyAmenity whereValue($value)
 * @mixin \Eloquent
 */
class PropertyAmenity extends Model
{
    public $timestamps = false;
    protected $guarded = [];
}
