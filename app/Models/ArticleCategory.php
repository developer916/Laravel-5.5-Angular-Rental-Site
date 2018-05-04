<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArticleCategory
 *
 * @property-read \App\User $author
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleCategory onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ArticleCategory extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $table = "article_categories";

	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function description()
	{
		return nl2br($this->description);
	}

	/**
	 * Get the author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * Get the slider's images.
	 *
	 * @return array
	 */
	public function articles()
	{
//		return $this->hasMany('App\Article');
	}

	/**
	 * Get the category's language.
	 *
	 * @return Language
	 */
	public function language()
	{
//		return $this->belongsTo('App\Language');
	}
}
