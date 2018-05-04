<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\URL;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
 * App\Models\Notification
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property int $creator_id
 * @property \App\User $receiver_id
 * @property string|null $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\User $create_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification withoutTrashed()
 * @mixin \Eloquent
 */
class Notification extends Model {

        use SoftDeletes;

        protected $table = 'notifications';

        protected $dates = ['deleted_at'];

        protected $fillable = ['action', 'creator_id', 'receiver_id', 'message'];

        public function create_id () {
            return $this->belongsTo('App\User');
        }

        public function receiver_id () {
            return $this->belongsTo('App\User');
        }

    }
