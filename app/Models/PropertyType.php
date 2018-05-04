<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PropertyType
 *
 * @property int $id
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereTitle($value)
 * @mixin \Eloquent
 */
class PropertyType extends Model
{
	public $timestamps = false;
}
