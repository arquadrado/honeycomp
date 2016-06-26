<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Apiary;
use App\Beehive;
use App\Colony;
use Asset;

class AjaxController extends Controller
{
	public function postEditColony($id){
		if (request()->isMethod('post')){
           
            if (request('data')){
            	$colony = Colony::find($id);
            	$colony->population = request('data')['population'];
            	$colony->save();

            }

           return response()->json(['response' => 'This is post method']);
        }

        return response()->json(['response' => 'This is get method']);
	}
}