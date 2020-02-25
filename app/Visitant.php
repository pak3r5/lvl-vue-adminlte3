<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitant extends Model
{
    public function matches()
    {
        return $this->morphMany(\App\Match::class, 'matchtable');
    }
}
