<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class SendContactOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $infoRequest;
    public function __construct($infoRequest)
    {
        $this->infoRequest = $infoRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails/send_contact_order')
                    ->subject('【YenFood】RẮC CƠM DINH DƯỠNG YEN FOOD')
                    ->with([
                        'infoRequest' => $this->infoRequest
                    ]);
    }
}