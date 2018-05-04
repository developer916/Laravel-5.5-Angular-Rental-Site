<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PropertyPhoto
 *
 * @property int $id
 * @property int|null $property_id
 * @property string|null $file
 * @property int|null $file_size
 * @property int $status
 * @property string|null $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int|null $is_main
 * @property-read mixed $model
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyPhoto onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyPhoto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyPhoto withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PropertyPhoto withoutTrashed()
 * @mixin \Eloquent
 */
class PropertyPhoto extends Model
{
    use SoftDeletes;

    public function getModelAttribute()
    {
        return 'PropertyPhoto';
    }

    protected $appends = ['model'];
    protected $guarded = ['model'];

}
