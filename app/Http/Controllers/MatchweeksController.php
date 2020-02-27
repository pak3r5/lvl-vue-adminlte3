<?php

namespace App\Http\Controllers;

use App\League;
use App\Local;
use App\Match;
use App\Matchweek;
use App\Team;
use App\Visitant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchweeksController extends Controller
{
    public function index() {
        $leagues = League::all();
        $teams = Team::orderBy('name')->get();
        $matchweeks = Matchweek::with(['league','matches.local','matches.visitant'])->get();
        return compact('matchweeks', 'leagues','teams');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $matchweek = new Matchweek;
        $matchweek->name =$request['name'];
        $matchweek->league_id =$request['league_id'];
        $matchweek->save();

        foreach ($request['match'] as $key => $index){
            $match = new Match();
            $match->matchweek_id=$matchweek->uuid;
            $match->local_id=$request['match'][$key]['local'];
            $match->local=0;
            $match->visitant_id=$request['match'][$key]['visitant'];
            $match->visitant=0;
            $match->save();
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
