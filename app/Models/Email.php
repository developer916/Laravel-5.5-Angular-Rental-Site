<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	/**
 * App\Models\Email
 *
 * @property int $id
 * @property string $email_subject
 * @property string $event
 * @property string $status
 * @property string $language_id
 * @property int|null $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereEmailSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email whereUserId($value)
 * @mixin \Eloquent
 */
class Email extends Model {
		public function language () {
			return $this->belongsTo('App\Models\Language');
		}
	}
