<?php

namespace App\Http\Controllers\Ajax;

use Carbon\Carbon;
use App\{
    Calendar, User
};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'can:agenda']);
        $this->middleware('can:afspraken')->only('check');
    }

    public function appointments(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'date' => 'required|date_format:Y-n-j',
        ]);

        if ($v->fails()) {
            return $v->errors();
        }

        $appointments = Calendar::where([
            ['user_id', auth()->user()->id],
            ['datetime', 'LIKE', (Carbon::parse($request->date))->toDateString().'%'],
        ])->orderBy('datetime', 'ASC')->get();
        if (count($appointments) === 0) {
            return;
        }

        $data = [];

        foreach ($appointments as $appointment) {
            $date = Carbon::parse($appointment->datetime);
            $place =  $appointment->practitioner->address->first();
            array_push($data, [
                'date' => $date->toDateString(),
                'time' => $date->toTimeString(),
                'place' => ($place) ? $place->only('establishment', 'zip', 'street', 'number', 'addition') : null,
                'title' => $appointment->title,
                'description' => $appointment->description,
                'creator' => $appointment->practitioner->name,
            ]);
        }

        return $data;
    }

    public function check(Request $request) {
        if (!$request->has(['user', 'date', 'time'])) {
            return;
        }

        $user = User::whereName($request->user)->first()->id;
        $date = new Carbon($request->date . $request->time);
        return Calendar::where([['user_id', $user], ['datetime', $date]])->exists() ? 'true' : null;

    }
}
