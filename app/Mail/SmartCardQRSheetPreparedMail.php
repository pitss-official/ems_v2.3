<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SmartCardQRSheetPreparedMail extends Mailable
{
    use Queueable, SerializesModels;
    private $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        //
        $this->link = $link;
        $this->subject('SmartCard Sheet Prepared - MegaMinds OMS');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.SmartCardSheetEmail',['link'=>$this->link]);
    }
}
