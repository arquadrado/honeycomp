<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Apiary;
use App\Beehive;
use App\Colony;
use Asset;
use Auth;

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

        Asset::json('token', csrf_token());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->prepareData();

        return view('home');
    }

    public function prepareData()
    {
        $apiaries = Apiary::where('user_id', Auth::user()->id)->get();

        if (!is_null($apiaries)){
            $currentApiary = !is_null(Apiary::find(session('current_apiary_id'))) ? Apiary::find(session('current_apiary_id')) : $apiaries->first();
            $currentBeehive = $currentApiary->containsBeehive(session('current_beehive_id'));

            Asset::json('apiaries_data', [
                'apiaries'        => $apiaries,
                'current_apiary'  => $currentApiary,
                'current_beehive' => $currentBeehive
            ]);

            return;
        }
        Asset::json('apiaries_data', [
            'apiaries'        => [],
            'current_apiary'  => null,
            'current_beehive' => null
        ]);
    }

    public function addApiary()
    {
        return view('apiary.create');
    }

    public function saveApiary(Request $request)
    {
        $data = [
            'user_id'        => $request->user()->id,
            'name'           => request('name'),
            'location'       => request('location'),
            'dominant_flora' => request('dominant_flora'), 
        ];

        $apiary = Apiary::create($data);

        session(['current_apiary_id' => $apiary->id]);

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
            if (isset($data['item_id'])){
                session([
                    'current_apiary_id' => $data['item_id'],
                    'current_beehive_id' => Apiary::find($data['item_id'])->beehives->first()
                ]);
                return response()->json(['response' => 'Apiary saved in session']);
            }
        }

        return response()->json(['response' => 'Apiary not saved in session']);
    }

    public function createBeehive($apiaryId)
    {
        $apiary = Apiary::find($apiaryId);

        $data = [
            'apiary_id'  => $apiary->id,
            'beehive' => null,
            'context' => 'create',
        ];

        return view('apiary.components.beehives.edit', ['data' => $data]);
    }

    public function editBeehive($beehiveId){
        $beehive = Beehive::find($beehiveId);
        $data = [
            'apiary_id'  => $beehive->apiary->id,
            'beehive' => $beehive,
            'context' => 'edit',
        ];
        
        return view('apiary.components.beehives.edit', ['data' => $data]);
    }

    public function postEditBeehive($apiaryId, $beehiveId = null)
    {
        $data = [
            'apiary_id'      => $apiaryId,
            'name'           => request('name'),
            'type'       => request('type'),
        ];

        if (is_null($beehiveId)){

            $beehive = Beehive::create([
                'apiary_id' => $apiaryId,
                'name'      => request('name'),
                'type'      => request('type'),
            ]);

            $colony = Colony::create([
                'beehive_id' => $beehive->id,
                'name'       => request('colony_name'),
                'population' => request('population'),
            ]);

            session([
                'current_apiary_id' => $apiaryId,
                'current_beehive_id' => $beehive->id,
            ]);

            return redirect()->route('home');
        }

        $beehive = Beehive::find($beehiveId);
        $beehive->name = request('name');
        $beehive->type = request('type');
        $beehive->colony->name = request('colony_name');
        $beehive->colony->population = request('population');
        $beehive->colony->save();
        $beehive->save();

        session([
            'current_apiary_id' => $apiaryId,
            'current_beehive_id' => $beehive->id,
        ]);

        return redirect()->route('home');
    }

    public function deleteBeehive()
    {
        if (request()->isMethod('post')){
            $data = request()->all();
            if (isset($data['item_id'])){
                Beehive::destroy($data['item_id']);
                //dd(Employee::find($data['resource_id']));
            }
            return response()->json(['response' => 'This is post method']);
        }

        return response()->json(['response' => 'This is get method']);
    }

}
