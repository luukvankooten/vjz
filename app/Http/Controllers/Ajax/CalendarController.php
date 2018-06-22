<?php

namespace App\Http\Controllers\Ajax;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'can:calender']);
        $this->middleware('can:create-appointments')->only('show');
    }

    public function appointments(Request $request)
    {
        if (!$request->has('date')) {
            return ['message' => 'No date defined'];
        }

        return [
            'date' => $request->get('date'),
            'time' => '10:28',
            'place' => 'Goes 1234AC schaapstraat 23',
            'title' => 'test',
            'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
            'creator' => 'Admin',
        ];
    }

    public function show(Request $request) {
        if (!$request->has(['user', 'date', 'time'])) {
            return;
        }
    }
}
