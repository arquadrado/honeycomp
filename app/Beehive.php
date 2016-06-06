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

    protected $visible = [
        'apiary_id',
        'name',
        'type',
        'editor_route',
    ];

    protected $appends = [
        'editor_route',
    ];

    public function apiary()
    {
        return $this->belongsTo('App\Apiary');
    }

    public function colony()
    {
        return $this->hasOne('App\Colony');
    }

    public function getEditorRouteAttribute()
    {
        return route('edit.beehive', ['id' => $this->id]);
    }
}