<?php

namespace App\Http\Controllers;

use App\League;
use App\Local;
use App\Match;
use App\Matchweek;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MatchweekController extends Controller
{
    public function index() {
        $leagues = League::all();
        $teams = Team::orderBy('name')->get();
        $matchweeks = Matchweek::with('league')->get();
        return compact('matchweeks', 'leagues','teams');
        //return League::all();
    }

    public function store(Request $request)
    {

        /*$start_date = Carbon::parse($request['start'],'America/Mexico_City');
        $end_date = Carbon::parse($request['end'],'America/Mexico_City');
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'league_id' => ['required', 'integer'],
            //'start' => ['required'],
            //'end' => ['required'],
        ])->validate();*/
        DB::beginTransaction();
        $matchweek = Matchweek::create([
            'name' => $request['name'],
            'league_id' => $request['league_id'],
            //'start' => $start_date,
            //'end' => $end_date,
        ]);

        foreach ($request['match.name'] as $key => $index){
            $matchToSave = Match::create([
                'name'=>$request['match.name'][$index],
                'matchweek_id'=> $matchweek->id,
                'result'=>-1
            ]);

            $matchToSave->matchs()->saveMany([
                new App\Local(['league_id'=> $request['match.local'][$index]]),
                new App\Visitan(['league_id'=> $request['match.visitant'][$index]]),
            ]);
        }

        DB::commit();
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request,$uuid)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'league_id' => ['required', 'integer'],
            'start' => ['required'],
            'end' => ['required'],
        ]);

        $country = Matchweek::findOrFail($uuid);

        $country->update($request->all());
    }

    public function destroy($uuid)
    {
        $country = Matchweek::findOrFail($uuid);
        $country->delete();
        return response()->json([
            'message' => 'Matchweek deleted successfully'
        ]);
    }
}
