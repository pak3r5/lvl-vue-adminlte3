<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function index() {
        return Country::latest()->get();
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:3', 'unique:countries'],
        ])->validate();

        return Country::create([
            'name' => $request['name'],
            'short_name' => $request['short_name'],
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
            'short_name' => ['required', 'string', 'max:3',Rule::unique('countries','short_name')->ignore($uuid,'uuid')],
        ]);

        $country = Country::findOrFail($uuid);

        $country->update($request->all());
    }

    public function destroy($uuid)
    {
        $country = Country::findOrFail($uuid);
        $country->delete();
        return response()->json([
            'message' => 'Country deleted successfully'
        ]);
    }
}
