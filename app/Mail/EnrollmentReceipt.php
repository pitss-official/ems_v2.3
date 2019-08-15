<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnrollmentReceipt extends Mailable
{
    use Queueable, SerializesModels;
    protected $param=[];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->param=$params;
    }

    /**
     * @return EnrollmentReceipt
     */
    public function build()
    {
        return $this->view('mail.Enrollment.Receipts.Participant.event-'.$this->param['event']->id)
            ->subject($this->param['subject'])
            ->with($this->param)
            ->from('receipts@megaminds.club')
            ->replyTo('support@megaminds.club');
    }
}
