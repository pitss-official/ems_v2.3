<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Events\PrepareQRSheetForSmartCardsEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateSmartCardRequest;
use App\Http\Requests\GenrateSmartCardRequest;
use App\SmartCard;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;


class SmartCardController extends Controller{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function generateCardList(GenrateSmartCardRequest $request){
        $validatedData = $request->validatedAndSanitized();
        $this->authorize('create',SmartCard::class);
        $event = Event::findOrFail($validatedData['eventID']);
        if($validatedData['value']<=$event->ticketPrice) {
            $qrs= SmartCard::generateCards($validatedData['eventID'], $validatedData['numberPasses'],$validatedData['value']);
            \event(new PrepareQRSheetForSmartCardsEvent($qrs,User::getCurrentAPIUser()['email']));
            return $qrs;
        }
    }
    public function activateCards(ActivateSmartCardRequest $request){
        $validatedData = $request->validatedAndSanitized();
        $this->authorize('activate',SmartCard::class);
    }
}
