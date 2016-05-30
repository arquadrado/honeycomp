<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Apiary;
use Asset;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiaries = Apiary::all();
        
        Asset::json('apiaries', $apiaries);

        return view('home');
    }

    public function addApiary()
    {
        return view('apiary.create');
    }

    public function saveApiary(Request $request)
    {
        //dd($request->user()->id);

        $data = [
            'user_id'        => $request->user()->id,
            'name'           => request('name'),
            'location'       => request('location'),
            'dominant_flora' => request('dominant_flora'), 
        ];

        $apiary = Apiary::create($data);

        return redirect('home');
    }

    public function editApiary($id)
    {
        $apiary = Apiary::find($id);

        return view('apiary.edit', ['apiary' => $apiary]);
    }

    public function postEditApiary($id)
    {
        $apiary = Apiary::find($id);
        $apiary->name = request('name');
        $apiary->location = request('location');
        $apiary->dominant_flora = request('dominant_flora');
        $apiary->save();
        return redirect('home');
    }

    public function deleteApiary()
    {
        dd('putas e vinho verde');
    }
}
