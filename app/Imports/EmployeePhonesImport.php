<?php

namespace App\Imports;

use App\Models\EmployeePhone;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeePhonesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return EmployeePhone::updateOrCreate(

            [
                'imei' => isset($row['imei'])
                    ? (string) $row['imei']
                    : null,
            ],

            [

                'phone_number' => isset($row['numero'])
                    ? '+56' . (string) $row['numero']
                    : null,

                'first_name' => isset($row['nombre'])
                    ? (string) $row['nombre']
                    : null,

                'last_name' => isset($row['apellido'])
                    ? (string) $row['apellido']
                    : null,

                'phone_model' => isset($row['modelo'])
                    ? (string) $row['modelo']
                    : null,

                'delivery_date' => isset($row['fecha_entrega'])
                    ? \Carbon\Carbon::parse($row['fecha_entrega'])->format('Y-m-d')
                    : null,

                'position' => isset($row['cargo'])
                    ? (string) $row['cargo']
                    : null,

                'department' => isset($row['departamento'])
                    ? (string) $row['departamento']
                    : null,

                'vendor_code' => isset($row['codigo'])
                    ? (string) $row['codigo']
                    : null,

                'company_name' => isset($row['nombre_empresa'])
                    ? (string) $row['nombre_empresa']
                    : null,

                'rut' => isset($row['rut'])
                    ? (string) $row['rut']
                    : null,

                'email' => isset($row['correo'])
                    ? (string) $row['correo']
                    : null,

                'observations' => isset($row['observaciones'])
                    ? (string) $row['observaciones']
                    : null,

                'status' => 'active',
            ]
        );
    }
}