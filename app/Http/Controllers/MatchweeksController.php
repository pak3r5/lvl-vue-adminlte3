<?php

namespace App\Http\Controllers;

use App\League;
use App\Matchweek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatchweeksController extends Controller
{
    public function index() {
        $leagues = League::all();
        $matchweeks = Matchweek::with('league')->get();
        return compact('matchweeks', 'leagues');
        //return League::all();
    }

    public function store(Request $request)
    {
        dd($request);
        $start_date = Carbon::parse($request['start'],'America/Mexico_City');
        $end_date = Carbon::parse($request['end'],'America/Mexico_City');
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'league_id' => ['required', 'integer'],
            'start' => ['required'],
            'end' => ['required'],
        ])->validate();

        $mathweek = Matchweek::create([
            'name' => $request['name'],
            'league_id' => $request['league_id'],
            'start' => $start_date,
            'end' => $end_date,
        ]);


        /*return Matchweek::create([
            'name' => $request['name'],
            'league_id' => $request['league_id'],
            'start' => $start_date,
            'end' => $end_date,
        ]);*/
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
