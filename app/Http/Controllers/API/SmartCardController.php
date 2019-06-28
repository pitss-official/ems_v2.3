<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Team;
use App\Enrollment;
use App\User;
use App\SmartCard;
use function GuzzleHttp\Promise\exception_for;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SmartCardController extends Controller{

    public function generateCardList(Request $request){
        $validatedData = $request->validate([
            'numberPasses'=>'bail|required|integer|min:1|max:100',
            'eventID'=>'bail|required|numeric|min:0|exists:events,id',
            'value'=>'bail|required|numeric|min:0',
        ]);
        $event = Event::findOrFail($validatedData['eventID']);
        if($validatedData['value']<=$event->ticketPrice) {
            set_time_limit(0);
            return SmartCard::generateCards($validatedData['eventID'], $validatedData['numberPasses']);
        }

    }
}
