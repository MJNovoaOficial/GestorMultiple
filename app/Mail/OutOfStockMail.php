<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OutOfStockMail extends Mailable
{
    use Queueable, SerializesModels;

    public $supplies;

    public function __construct($supplies)
    {
        $this->supplies = $supplies;
    }

    public function build()
    {
        return $this->subject(
                'Acción Requerida – Suministros Sin Stock'
            )
            ->view(
                'emails.supplies.out-of-stock'
            );
    }
}