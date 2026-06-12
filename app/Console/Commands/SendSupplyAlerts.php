<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Supply;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockMail;
use App\Mail\OutOfStockMail;

class SendSupplyAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-supply-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $criticalSupplies = Supply::whereColumn(
            'quantity',
            '<=',
            'minimum_stock'
        )
        ->where('quantity', '>', 0)
        ->get();

        $outSupplies = Supply::where(
            'quantity',
            '<=',
            0
        )->get();

        if ($criticalSupplies->isNotEmpty()) {

            Mail::to([
                'berny.gatica@dimak.cl',
                'valeria.pinol@dimak.cl'
            ])->send(
                new LowStockMail(
                    $criticalSupplies
                )
            );

        }

        if ($outSupplies->isNotEmpty()) {

            Mail::to([
                'berny.gatica@dimak.cl',
                'valeria.pinol@dimak.cl'
            ])->send(
                new OutOfStockMail(
                    $outSupplies
                )
            );

        }

        $this->info('Alertas enviadas correctamente.');
    }
}
