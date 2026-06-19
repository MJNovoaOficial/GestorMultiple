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
    protected $signature = 'supplies:alerts';

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
        ->where(function ($query) {

            $query->whereNull(
                'last_critical_alert_at'
            )
            ->orWhere(
                'last_critical_alert_at',
                '<=',
                now()->subDays(3)->toDateTimeString()
            );

        })
        ->get();

        $outSupplies = Supply::where(
            'quantity',
            '<=',
            0
        )
        ->where(function ($query) {

            $query->whereNull(
                'last_out_alert_at'
            )
            ->orWhere(
                'last_out_alert_at',
                '<=',
                dd(
                    now()->subDays(3)->toDateTimeString()
                )
            );

        })
        ->get();

        if ($criticalSupplies->isNotEmpty()) {

            Mail::to([
                'berny.gatica@dimak.cl',
                'valeria.pinol@dimak.cl'
            ])->send(
                new LowStockMail(
                    $criticalSupplies
                )
            );

            foreach ($criticalSupplies as $supply) {

                $supply->update([
                    'last_critical_alert_at' => now()
                ]);

            }

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

            foreach ($outSupplies as $supply) {

                $supply->update([
                    'last_out_alert_at' => now()
                ]);
            }
        }
        $this->info('Alertas enviadas correctamente.');
    }
}
