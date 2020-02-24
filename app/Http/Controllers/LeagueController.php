<?php

namespace App\Http\Controllers;

use App\Country;
use App\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LeagueController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer'],
        ])->validate();

        return League::create([
            'name' => $request['name'],
            'country_id' => $request['country_id'],
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
            'country_id' => ['required', 'integer'],
        ]);

        $country = League::findOrFail($uuid);

        $country->update($request->all());
    }

    public function destroy($uuid)
    {
        $league = League::findOrFail($uuid);
        $league->delete();
        return response()->json([
            'message' => 'League deleted successfully'
        ]);
    }
    public function index() {
        $countries = Country::all();
        $leagues = League::with('country')->get();
        return compact('leagues', 'countries');
        //return League::all();
    }
}
