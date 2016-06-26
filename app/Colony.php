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
		'editor_route',
	];
	protected $appends = [
		'editor_route',
	];

	protected $fillable =  [
		'beehive_id',
		'name',
		'population',
	];

    public function beehive()
    {
        return $this->belongsTo('App\Beehive');
    }

    public function getEditorRouteAttribute()
    {
    	return route('post.edit.colony', $this->id);
    }
}