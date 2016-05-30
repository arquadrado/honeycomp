<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beehive extends Model
{
    public function apiary()
    {
        return $this->belongsTo('App\Apiary');
    }

    public function colony()
    {
        return $this->hasOne('App\Colony');
    }
}