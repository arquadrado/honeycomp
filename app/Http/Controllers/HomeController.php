<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Apiary;
use App\Beehive;
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
        $currentApiary = !is_null(Apiary::find(session('current_apiary_id'))) ? Apiary::find(session('current_apiary_id')) : Apiary::first();
        $currentTab = session('current_tab', 'info');
        //dd($currentTab);
        Asset::json('token', csrf_token());
        Asset::json('current_apiary', $currentApiary);
        Asset::json('current_tab', $currentTab);
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

        return redirect()->route('home');
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
        if (request()->isMethod('post')){
            $data = request()->all();
            if (isset($data['item_id'])){
                Apiary::destroy($data['item_id']);
                //dd(Employee::find($data['resource_id']));
            }
            return response()->json(['response' => 'This is post method']);
        }

        return response()->json(['response' => 'This is get method']);
    }

    public function saveInSession()
    {
        if (request()->isMethod('post')){
            $data = request()->all();
            //dd($data);
            if (isset($data['item_id'])){
                session(['current_apiary_id' => $data['item_id']]);
                return response()->json(['response' => 'Apiary saved in session']);
            }

            if (isset($data['data']['tab'])){
                session(['current_tab' => $data['data']['tab']]);
            }
        }

        return response()->json(['response' => 'Apiary not saved in session']);
    }

    public function createBeehive($apiaryId)
    {
        $apiary = Apiary::find($apiaryId);
        return view('apiary.components.beehives.create', ['apiary' => $apiary]);
    }

    public function postCreateBeehive($apiaryId)
    {
        $data = [
            'apiary_id'      => $apiaryId,
            'name'           => request('name'),
            'type'       => request('type'),
        ];

        $beehive = Beehive::create($data);

        return redirect()->route('home');
    }
}
