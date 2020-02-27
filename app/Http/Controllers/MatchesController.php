<?php

namespace App\Http\Controllers;

use App\Local;
use App\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatchesController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        return Local::create([
            'name' => $request['name'],
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
        ]);

        $match = Match::findOrFail($uuid);

        $match->update($request->all());
    }

    public function destroy($uuid)
    {
        $match = Match::findOrFail($uuid);
        $match->delete();
        return response()->json([
            'message' => 'Match deleted successfully'
        ]);
    }
    public function index() {
        //$countries = Country::all();
        //$leagues = League::with('country')->get();
        //return compact('leagues', 'countries');
        return Match::select('name')->with(['locals','visitants'])->get();
        return Match::with('matchtable')->get();
    }
}
