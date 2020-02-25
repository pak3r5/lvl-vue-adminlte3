<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    public function matches()
    {
        return $this->morphMany(\App\Match::class, 'matchtable');
    }
}
