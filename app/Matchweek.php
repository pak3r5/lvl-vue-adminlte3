<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Matchweek extends Model
{
    use SoftDeletes;

    public $table = 'matchweeks';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'league_id',
        'name',
        //'start',
        //'end'
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
        'uuid' => 'uuid',
        //'start'=>'date',
        //'end'=>'date',
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

    public function league()
    {
        return $this->belongsTo(\App\League::class, 'league_id', 'id');
    }

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function matches()
    {
        return $this->hasMany(\App\Match::class, 'matchweek_id', 'id');
    }
}
