<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Country
 * @package App\Models\Country
 * @version February 9, 2020, 4:43 am UTC
 *
 * @property string short_name
 * @property string name
 */
class Country extends Model
{
    use SoftDeletes;

    public $table = 'countries';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'short_name',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'short_name' => 'string',
        'name' => 'string',
        'uuid' => 'uuid'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getKeyName()
    {
        return 'uuid';
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) (string) Str::uuid();
        });
    }

}

