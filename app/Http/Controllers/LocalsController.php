<?php

namespace App\Http\Controllers;

use App\Country;
use App\League;
use App\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocalsController extends Controller
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

        $local = Local::findOrFail($uuid);

        $local->update($request->all());
    }

    public function destroy($uuid)
    {
        $local = Local::findOrFail($uuid);
        $local->delete();
        return response()->json([
            'message' => 'Local deleted successfully'
        ]);
    }
    public function index() {
        //$countries = Country::all();
        //$leagues = League::with('country')->get();
        //return compact('leagues', 'countries');
        return Local::all();
    }
}
