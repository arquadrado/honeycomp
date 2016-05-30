<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apiary extends Model
{

	protected $visible = [
		'user_id',
		'name',
		'location',
		'dominant_flora',
		'editor_route',
	];
	protected $appends = [
		'editor_route',
	];

	protected $fillable =  [
		'user_id',
		'name',
		'location',
		'dominant_flora'
	];

    public function beehives()
    {
        return $this->hasMany('App\Beehive');
    }

    public function getEditorRouteAttribute()
    {
    	return route('edit.apiary', ['id' => $this->id]);
    }
}