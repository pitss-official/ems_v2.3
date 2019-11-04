<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateSmartCardRequest;
use App\Http\Requests\GenrateSmartCardRequest;
use App\SmartCard;
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
            set_time_limit(0);
            $qrs= SmartCard::generateCards($validatedData['eventID'], $validatedData['numberPasses'],$validatedData['value']);
            $pdf = PDF::loadView('pdf.smartcard.printQRSheet',['qrs'=>array_chunk($qrs,7)]);
            $path='QRSheets/'.\App\System::randAlphaNum(200,false).'.pdf';
            $pdf->setPaper('a4', 'portrait')->save($path);
            $ret= array_merge([["id" => $validatedData['eventID'], "code" => $path, "value" => $validatedData['value']*$validatedData['numberPasses']]],$qrs);
            return $ret;
        }
    }
    public function activateCards(ActivateSmartCardRequest $request){
        $validatedData = $request->validatedAndSanitized();
        $this->authorize('activate',SmartCard::class);
    }
}
