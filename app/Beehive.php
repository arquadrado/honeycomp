<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beehive extends Model
{
	protected $fillable =  [
		'apiary_id',
		'name',
		'type',
	];

    public function apiary()
    {
        return $this->belongsTo('App\Apiary');
    }

    public function colony()
    {
        return $this->hasOne('App\Colony');
    }
}