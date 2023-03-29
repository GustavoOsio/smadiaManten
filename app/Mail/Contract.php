<?php

namespace App\Mail;

use App\Models\Contract as Contr;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contract extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data=[], Contr $contract)
    {
        $this->contract = $contract;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contracts.contract', ['contract' => $this->contract])
            ->subject('Contrato Smadia Clinic')
            ->attachData($this->data["document"], "Contrato-Smadia-Clinic.pdf");
    }
}
