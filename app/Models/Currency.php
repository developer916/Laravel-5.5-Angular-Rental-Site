<?php

namespace App\Models;

//use Cviebrock\EloquentSluggable\SluggableInterface;
//use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $symbol
 * @property string|null $html
 * @property string|null $slug
 * @property int $weight
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Currency onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Currency withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Currency withoutTrashed()
 * @mixin \Eloquent
 */
class Currency extends Model
{
    use SoftDeletes;
//    use SluggableTrait;

    protected $fillable = ['title'];

    protected $sluggable = array(
        'build_from' => 'title',
        'on_update' => true,
    );
}
