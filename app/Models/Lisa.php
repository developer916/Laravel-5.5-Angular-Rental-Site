<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\URL;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
 * App\Models\Lisa
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lisa onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lisa withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lisa withoutTrashed()
 * @mixin \Eloquent
 */
class Lisa extends Model {

        use SoftDeletes;

        protected $table = 'lisa';

        protected $dates = ['deleted_at'];
    }
