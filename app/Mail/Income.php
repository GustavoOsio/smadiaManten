<?php

namespace App\Mail;

use App\Models\Income as Inc;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Income extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inc $income)
    {
        $this->income = $income;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.incomes.income_2', ['income' => $this->income])
            ->subject('Se ha generado un ingreso');
    }
}
