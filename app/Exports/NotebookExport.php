<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Notebook;

class NotebookExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Notebook::with('brand')
            ->get()
            ->map(function ($notebook) {

                $notebook->brand_id =
                    $notebook->brand?->name ?? '';

                $notebook->status = match ($notebook->status) {
                    'available' => 'Disponible',
                    'assigned' => 'Asignado',
                    'retired' => 'Dado de baja',
                    default => $notebook->status,
                };

                return $notebook->only([
                    'user_name',
                    'user_rut',
                    'serial_number',
                    'model',
                    'brand_id',
                    'delivery_date',
                    'purchase_value',
                    'condition',
                    'status',
                    'position',
                    'company_name',
                    'observations',
                ]);
            });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Rut',
            'Número Serial',
            'Modelo',
            'Marca',
            'Fecha de Entrega',
            'Valor',
            'Condición',
            'Estado',
            'Cargo',
            'Empresa',
            'Observaciones',
        ];
    }
}
