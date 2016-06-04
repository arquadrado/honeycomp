<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apiary extends Model
{
	protected $with = [
		'beehives',
	];
	protected $visible = [
		'id',
		'user_id',
		'name',
		'location',
		'dominant_flora',
		'editor_route',
		'create_beehive_route',
		'beehives',
	];
	protected $appends = [
		'editor_route',
		'create_beehive_route',
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

    public function getCreateBeehiveRouteAttribute()
    {
    	return route('create.beehive', ['id' => $this->id]);
    }
}