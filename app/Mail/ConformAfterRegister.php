<?php

namespace App\Mail;

use Carbon\Traits\Serialization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConformAfterRegister extends Mailable
{

    use Queueable, Serialization;
    public $contact;

    public function __construct($contact)
    {
        //
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->view('mail.acitve-user')->subject("[MissionX Form] Registration for Active account");
    }
}
