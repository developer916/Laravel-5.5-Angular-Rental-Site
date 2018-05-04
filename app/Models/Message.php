<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $thread
 * @property string $subject
 * @property string $text
 * @property int $sender_id
 * @property int $priority
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string $to
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Property[] $properties
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $recipients
 * @property-read \App\User $sender
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereThread($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message withoutTrashed()
 * @mixin \Eloquent
 */
class Message extends Model
{
	use SoftDeletes;

	protected $fillable = ['thread', 'sender_id', 'text', 'subject', 'priority', 'type', 'to', 'type'];

	protected $dates = ['deleted_at'];

	/**
	 * Return the Sender of this message.
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sender() {
		return $this->belongsTo('App\User')->select('id', 'name');
	}

	public function getThread($threadID = 0) {
		if ($this->thread)
			return Message::where('thread', $this->thread);
		return response()->json(['success' => 0]);
	}

	/**
	 * Return the recipients for this message.
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function recipients() {
		return $this->belongsToMany('App\User', 'message_user');
	}

	/**
	 * Return the properties to which the message has been announced.
	 */
	public function properties() {
		return $this->belongsToMany('App\Models\Property')
				->select('properties.id', 'title', 'slug', 'address', 'city', 'user_id');
	}

	/**
	 * Gets all the tags connected
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function tags() {
		return $this->belongsToMany('App\Models\Tag');
	}
}
