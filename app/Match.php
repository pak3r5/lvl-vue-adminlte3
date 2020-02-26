<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Match extends Model
{
    use SoftDeletes;

    public $table = 'matches';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'matchweek_id',
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
        'matchweek_id' => 'integer',
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


    public function matchweek()
    {
        return $this->belongsTo(\App\League::class, 'matchweek_id', 'id');
    }

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function matchtable()
    {
        return $this->morphTo();
    }
}
