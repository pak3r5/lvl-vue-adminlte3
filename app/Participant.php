<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Participant extends Model
{
    use SoftDeletes;

    public $table = 'participants';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'matchweek_id',
        'name',
        'phone',
        'code'
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
        'name' => 'string',
        'phone' => 'string',
        'code' => 'string',
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
}
