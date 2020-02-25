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
        'start',
        'result',
        'matchweek_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start' => 'date',
        'result' => 'integer',
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
    public function matchweek()
    {
        return $this->belongsTo(\App\Matchweek::class, 'matchweek_id', 'id');
    }

    public function matchtable()
    {
        return $this->morphTo();
    }
}
