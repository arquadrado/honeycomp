<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colony extends Model
{
	protected $with = [];
	protected $visible = [
		'id',
		'beehive_id',
		'name',
		'population',
	];
	protected $appends = [];

	protected $fillable =  [
		'beehive_id',
		'name',
		'population',
	];

    public function beehive()
    {
        return $this->belongsTo('App\Beehive');
    }
}