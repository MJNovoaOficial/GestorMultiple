<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\EmployeePhone;

class EmployeePhonesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         return EmployeePhone::select([
            'phone_number',
            'first_name',
            'last_name',
            'rut',
            'vendor_code',
            'phone_model',
            'delivery_date',
            'imei',
            'position',
            'department',
            'company_name',
            'email',
            'status',
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Número',
            'Nombre',
            'Apellido',
            'RUT',
            'Código',
            'Modelo',
            'Fecha Entrega',
            'IMEI',
            'Cargo',
            'Área',
            'Empresa',
            'Correo',
            'Estado',
        ];
    }
}
