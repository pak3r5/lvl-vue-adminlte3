<?php

namespace App\Http\Controllers;

use App\League;
use App\Match;
use App\Matchweek;
use App\Participant;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ParticipantsController extends Controller
{
    public function find($uuid) {
        $matchweek = Matchweek::findOrFail($uuid);
        return Participant::where('matchweek_id','=',$matchweek->id)->get();
    }

    public function store(Request $request,$uuid)
    {
        if($uuid == $request['matchweek']){
            $matchweek = Matchweek::findOrFail($uuid);
            Validator::make($request->all(), [
                //'name' => ['required', 'string', 'max:32'],
                'phone' => ['required', 'string','min:10','max:10'],
            ])->validate();

            $code = $this->randomCode();

            return Participant::create([
                'code' => $code,
                'phone' => $request['phone'],
                'matchweek_id'=>$matchweek->id
            ]);
        }

    }

    public function update(Request $request,$uuid)
    {
        $this->validate($request, [
            //'name' => ['required', 'string', 'max:32'],
            'phone' => ['required', 'string','min:10','max:10'],
        ]);

        $participant = Participant::findOrFail($uuid);

        $participant->update($request->all());
    }

    public function destroy($uuid)
    {
        $participant = Participant::findOrFail($uuid);
        $participant->delete();
        return response()->json([
            'message' => 'Participant deleted successfully'
        ]);
    }

    private function randomCode($length = 8){

        $code = Str::random($length);

        $validator = Validator::make(['code'=>$code],['code'=>'unique:participants,code']);

        if($validator->fails()){
            return $this->randomId();
        }

        return $code;
    }
}
