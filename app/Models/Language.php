<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property int|null $position
 * @property string $name
 * @property string $lang_code
 * @property int $status
 * @property string|null $icon
 * @property int|null $user_id
 * @property int|null $user_id_edited
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereUserIdEdited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language withoutTrashed()
 * @mixin \Eloquent
 */
class Language extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

	/**
	 * The attributes included in the model's JSON form.
	 *
	 * @var array
	 */
	protected $fillable = array('name', 'lang_code', 'description', 'icon');

	/**
	 * The rules for email field, automatic validation.
	 *
	 * @var array
	*/
	private $rules = array(
			'name' => 'required|min:2',
			'lang_code' => 'required|min:2'
	);

	public function getImageUrl( $withBaseUrl = false )
	{
		if(!$this->icon) return NULL;

		$imgDir = '/images/languages/' . $this->id;
		$url = $imgDir . '/' . $this->icon;

		return $withBaseUrl ? URL::asset( $url ) : $url;
	}
}