<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Visitant extends Model
{

    use SoftDeletes;

    public $table = 'visitants';

    protected $dates = ['deleted_at'];

    public $fillable = [
        //'match_id',
        'team_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        //'match_id' => 'integer',
        'team_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function team()
    {
        return $this->belongsTo(\App\Team::class, 'team_id', 'id');
    }

    public function matches()
    {
        return $this->morphOne(\App\Match::class, 'matchtable');
    }


}
