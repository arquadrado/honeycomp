<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beehive extends Model
{
    protected $with = [
        'colony',
    ];
	protected $fillable =  [
		'apiary_id',
		'name',
		'type',
	];

    protected $visible = [
        'id',
        'apiary_id',
        'name',
        'type',
        'colony',
        'editor_route',
        'delete_route',
    ];

    protected $appends = [
        'editor_route',
        'delete_route',
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

    public function getDeleteRouteAttribute()
    {
        return route('delete.beehive', ['id' => $this->id]);
    }
}