<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translations
 *
 * @property int $id
 * @property string $label
 * @property string $label_key
 * @property int|null $user_id
 * @property int|null $language_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereLabelKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereUserId($value)
 * @mixin \Eloquent
 */
class Translations extends Model
{
    protected $table = 'i18n';
}
