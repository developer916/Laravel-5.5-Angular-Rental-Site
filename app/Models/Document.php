<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
 * App\Models\Document
 *
 * @property int $id
 * @property string $file
 * @property int|null $file_size
 * @property string|null $description
 * @property string $privacy
 * @property int|null $property_id
 * @property int|null $user_id
 * @property int $folder_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $model
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DocumentShares[] $shares
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Document onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document wherePrivacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Document withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Document withoutTrashed()
 * @mixin \Eloquent
 */
class Document extends Model {
        use SoftDeletes;

        const PRIVACY_PUBLIC = 'public';

        public function getModelAttribute () {
            return 'Document';
        }

        //protected $appends = ['model'];
        protected $guarded = ['model'];

        public function isPublic () {
            if ($this->privacy == self::PRIVACY_PUBLIC) {
                return TRUE;
            }
        }

        /**
         * Document shared with users
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function shares()
        {
            return $this->hasMany('App\Models\DocumentShares');
        }
    }
