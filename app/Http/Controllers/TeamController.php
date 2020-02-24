<?php

namespace App\Http\Controllers;

use App\Country;
use App\League;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'league_id' => ['required', 'integer'],
        ])->validate();

        return Team::create([
            'name' => $request['name'],
            'league_id' => $request['league_id'],
        ]);
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
        ]);

        $country = Team::findOrFail($uuid);

        $country->update($request->all());
    }

    public function destroy($uuid)
    {
        $team = Team::findOrFail($uuid);
        $team->delete();
        return response()->json([
            'message' => 'Team deleted successfully'
        ]);
    }
    public function index() {
        $leagues = League::all();
        $teams = Team::with('league')->get();
        return compact('teams', 'leagues');
        //return League::all();
    }
}
