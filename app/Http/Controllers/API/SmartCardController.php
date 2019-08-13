<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenrateSmartCardRequest;
use App\SmartCard;


class SmartCardController extends Controller{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function generateCardList(GenrateSmartCardRequest $request){
        $validatedData = $request->validatedAndSanitized();
        $event = Event::findOrFail($validatedData['eventID']);
        if($validatedData['value']<=$event->ticketPrice) {
            set_time_limit(0);
            return SmartCard::generateCards($validatedData['eventID'], $validatedData['numberPasses']);
        }
    }
}
