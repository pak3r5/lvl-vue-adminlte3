<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Local extends Model
{

    use SoftDeletes;

    public $table = 'locals';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'match_id',
        'league_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'match_id' => 'integer',
        'league_id' => 'integer',
        'uuid' => 'uuid',
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

    public function matches()
    {
        return $this->morphMany(\App\Match::class, 'matchtable');
    }

    public function match()
    {
        return $this->belongsTo(\App\Match::class, 'match_id', 'id');
    }
}
