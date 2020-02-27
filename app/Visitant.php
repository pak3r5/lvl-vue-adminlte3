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

    public function matches()
    {
        return $this->morphMany(\App\Match::class, 'matchtable');
    }


    /*public function match()
    {
        return $this->belongsTo(\App\Match::class, 'match_id', 'id');
    }*/

}
