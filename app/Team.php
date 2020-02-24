<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Team extends Model
{
    use SoftDeletes;

    public $table = 'teams';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'league_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'league_id' => 'integer',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function league()
    {
        return $this->belongsTo(\App\League::class, 'league_id', 'id');
    }
}
