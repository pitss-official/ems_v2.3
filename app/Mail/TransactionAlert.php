<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionAlert extends Mailable
{
    use Queueable, SerializesModels;
    protected $data=array();
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $param)
    {
        $this->data=$param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.Transaction.alert')
            ->subject($this->data['subject'])
            ->with($this->data)
            ->from('transaction-alert@megaminds.club')
            ->replyTo('support@megaminds.club');
    }
}
