<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colony extends Model
{
    public function beehive()
    {
        return $this->belongsTo('App\Beehive');
    }
}