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
use Illuminate\Support\Facades\Validator;

class MatchweeksController extends Controller
{
    public function index() {
        $leagues = League::all();
        $teams = Team::orderBy('name')->get();
        $matchweeks = Matchweek::with(['league','matches'])->get();
        return compact('matchweeks', 'leagues','teams');
        //return League::all();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $matchweek = new Matchweek;
        $matchweek->name =$request['name'];
        $matchweek->league_id =$request['league_id'];
        $matchweek->save();

        foreach ($request['match'] as $key => $index){
            $locals[$key] = new Local;
            $locals[$key]->team_id = $request['match'][$key]['local'];

            $visitants[$key] = new Visitant;
            $visitants[$key]->team_id = $request['match'][$key]['visitant'];

            $local = Local::where('team_id', '=', $request['match'][$key]['local'])->first();
            if(!isset($local)) {
                $locals[$key]->save();
                $matches[$key] = $this->saveData($matchweek,$locals[$key]);
            }else{
                $matches[$key] = $this->saveData($matchweek,$local);
            }
            $visitant = Visitant::where('team_id', '=', $request['match'][$key]['visitant'])->first();
            if(!isset($visitant)) {
                $visitants[$key]->save();
                $matches[$key] = $this->saveData($matchweek,$visitants[$key]);
            }else{
                $matches[$key] = $this->saveData($matchweek,$visitant);
            }
        }
        DB::commit();
    }

    private function saveData($matchweek, $reference){
        $match = new Match;
        $match->result = -1;
        $match->matchweek_id = $matchweek->uuid;
        $match->matchtable()->associate($reference);
        return $match->save();
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
