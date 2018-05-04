<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Cviebrock\EloquentSluggable\SluggableInterface;
//use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Auth;

/**
 * App\Models\Property
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $title
 * @property string|null $unit
 * @property int|null $property_type_id
 * @property string $plan
 * @property int $is_pro
 * @property int $is_autoshare
 * @property int|null $country_id
 * @property string|null $slug
 * @property string $address
 * @property int $street_no
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $post_code
 * @property float $lng
 * @property float $lat
 * @property int $status
 * @property int|null $user_id
 * @property string|null $internal_id
 * @property string|null $media
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyAmenity[] $amenities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $announcements
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read \App\User|null $landlord
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyPhoto[] $photos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyTenant[] $tenants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant[] $tenantsAsUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyTransaction[] $transactions
 * @property-read \App\Models\PropertyType|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Property[] $units
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property findSimilarSlugs($attribute, $config, $slug)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Property onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereInternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereIsAutoshare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereIsPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePropertyTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereStreetNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Property withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Property withoutTrashed()
 * @mixin \Eloquent
 */
class Property extends Model
{

    use SoftDeletes;
//    use SluggableTrait;
    use Sluggable;
//    protected $sluggable = array(
//        'build_from' => 'title',
//        'on_update' => true,
//    );

    public function sluggable(){
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ],

        ];
    }

    protected $guarded = ['id', 'delete_at'];

       /**
     * Get the post's language.
     *
     * @return Language
     */
    public function language()
    {
//        return $this->belongsTo('App\Language');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\PropertyType','property_type_id');
    }

    /**
     * Property photos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany('App\Models\PropertyPhoto');
    }

    /**
     * Property documents
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

    /**
     * Property tenants
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tenants()
    {
        return $this->hasMany('App\Models\PropertyTenant');
    }

    /**
     * Get the User objects of related Tenants
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tenantsAsUsers()
    {
        return $this->belongsToMany('\App\Models\Tenant', 'property_tenants', 'property_id', 'user_id');
    }


    /**
     * Property transaction
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\PropertyTransaction');
    }

    /**
     * Property amenitis
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function amenities()
    {
        return $this->hasMany('App\Models\PropertyAmenity');
    }

    /**
     * Property transaction
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units()
    {
        return $this->hasMany('App\Models\Property','parent_id');
    }


    public function landlord(){
        return $this->belongsTo('App\User','user_id');
    }

    /**
     * Retrieve the announcements for the current property.
     */
    public function announcements() {
        return $this->belongsToMany('App\Models\Message');
    }

    public function rentcomponent() {
        return $this->hasOne('App\Models\RentComponent');
    }
}
