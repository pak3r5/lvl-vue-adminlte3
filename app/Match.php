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
        'local_id',
        'visitant_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'uuid',
        'matchweek_id' => 'integer',
        'local_id' => 'integer',
        'local' => 'integer',
        'visitant_id' => 'integer',
        'visitant' => 'integer',

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
        return $this->belongsTo(\App\Matchweek::class, 'matchweek_id', 'id');
    }

    public function locals()
    {
        return $this->belongsTo(\App\Team::class, 'local_id', 'id');
    }

    public function visitants()
    {
        return $this->belongsTo(\App\Team::class, 'visitant_id', 'id');
    }
}
