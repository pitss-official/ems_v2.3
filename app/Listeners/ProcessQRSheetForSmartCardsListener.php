<?php

namespace App\Listeners;

use App\Mail\SmartCardQRSheetPreparedMail;
use App\System;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessQRSheetForSmartCardsListener implements ShouldQueue
{
    public $timeout = 1800;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        set_time_limit(0);
        $pdf = PDF::loadView('pdf.smartcard.printQRSheet',['qrs'=>array_chunk($event->QRArray,7)]);
        $path='/QRSheets/'.\App\System::randAlphaNum(150,false).'.pdf';
        $pdf->setPaper('a4', 'portrait')->save(public_path().$path);
        System::mailer($event->email,new SmartCardQRSheetPreparedMail(asset($path)));
    }
}
