<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\RadioFrequency;

class RadioFrequencyExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RadioFrequency::with('branch')
        ->get()
        ->map(function ($radio) {

            $radio->branch_id =
                $radio->branch?->name ?? '';
            
            $radio->status = match ($radio->status) {
                'operative' => 'Operativa',
                'repair' => 'En reparación',
                'retired' => 'Dada de baja',
                default => $radio->status,
            };

            return $radio->only([
                'number',
                'area',
                'status',
                'branch_id',
            ]);
        });
        
    }

    public function headings(): array
    {
        return [
            'Número',
            'Área',
            'Estado',
            'Sucursal',
        ];
    }
}
