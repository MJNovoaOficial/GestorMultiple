<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockMail extends Mailable
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
                'Alerta de Inventario – Suministros con Stock Crítico'
            )
            ->view(
                'emails.supplies.low-stock'
            );
    }
}