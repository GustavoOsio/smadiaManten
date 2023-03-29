<?php

namespace App\Mail;

use App\Models\Budget as Bud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Budget extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data=[], Bud $budget)
    {
        $this->budget = $budget;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contracts.budget', ['budget' => $this->budget])
            ->subject('Presupuesto Smadia Clinic')
            ->attachData($this->data["document"], "Presupuesto-Smadia-Clinic.pdf");
    }
}
