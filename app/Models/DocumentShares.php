<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DocumentShares
 *
 * @property int $id
 * @property int|null $document_id
 * @property int|null $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \App\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DocumentShares onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DocumentShares whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DocumentShares whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DocumentShares whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DocumentShares whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DocumentShares whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DocumentShares whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DocumentShares withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DocumentShares withoutTrashed()
 * @mixin \Eloquent
 */
class DocumentShares extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
