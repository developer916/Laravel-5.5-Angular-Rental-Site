<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property string $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property string|null $website
 * @property string|null $bio
 * @property string|null $avatar
 * @property int $visibility
 * @property string|null $notifications
 * @property int|null $user_id
 * @property int|null $currency_id
 * @property int|null $vat
 * @property string|null $swift
 * @property string|null $iban
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Currency|null $currency
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereSwift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereWebsite($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    /**
     * Currency
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }
}
