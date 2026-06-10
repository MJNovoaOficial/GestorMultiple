<?php

namespace App\Imports;

use App\Models\EmployeePhone;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeePhonesImport implements ToModel, WithHeadingRow
{
    public int $imported = 0;

    public int $skipped = 0;

    public int $duplicates = 0;

    public function model(array $row)
    {

        /*
        |--------------------------------------------------------------------------
        | Normalizar datos
        |--------------------------------------------------------------------------
        */

        $numero = preg_replace('/\D/', '', (string) ($row['numero'] ?? ''));

        if (str_starts_with($numero, '56')) {

            $numero = substr($numero, 2);
        }

        $email = trim(
            strtolower(
                (string) ($row['correo'] ?? '')
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Validar vacíos
        |--------------------------------------------------------------------------
        */

        if (
            empty(trim((string) ($row['numero'] ?? ''))) ||
            empty(trim((string) ($row['nombre'] ?? ''))) ||
            empty(trim((string) ($row['apellido'] ?? ''))) ||
            empty(trim((string) ($row['modelo'] ?? ''))) ||
            empty(trim((string) ($row['fecha_entrega'] ?? ''))) ||
            empty(trim((string) ($row['imei'] ?? ''))) ||
            empty(trim((string) ($row['cargo'] ?? ''))) ||
            empty(trim((string) ($row['departamento'] ?? ''))) ||
            empty(trim((string) ($row['codigo'] ?? ''))) ||
            empty(trim((string) ($row['nombre_empresa'] ?? ''))) ||
            empty(trim((string) ($row['rut'] ?? ''))) 
            
        ) {

            $this->skipped++;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Validar email
        |--------------------------------------------------------------------------
        */

        if (
            !empty($email) &&
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            $this->skipped++;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Validar teléfono chileno
        |--------------------------------------------------------------------------
        */

        if (!preg_match('/^9\d{8}$/', $numero)) {

            $this->skipped++;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Validar duplicados
        |--------------------------------------------------------------------------
        */

        $imei = trim((string) $row['imei']);

        $exists = EmployeePhone::where('imei', $imei)
            ->orWhere('phone_number', '+56' . $numero)
            ->exists();

        if ($exists) {

            $this->duplicates++;

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Crear registro
        |--------------------------------------------------------------------------
        */

        $this->imported++;
 
        try {

            $deliveryDate = is_numeric($row['fecha_entrega'])

                ? Date::excelToDateTimeObject(
                    $row['fecha_entrega']
                )->format('Y-m-d')

                : Carbon::createFromFormat(
                    'd-m-Y',
                    trim($row['fecha_entrega'])
                )->format('Y-m-d');

        } catch (\Exception $e) {

            $this->skipped++;

            return null;
        }

        return new EmployeePhone([

            'phone_number' => '+56' . $numero,

            'first_name' => trim((string) $row['nombre']),

            'last_name' => trim((string) $row['apellido']),

            'phone_model' => trim((string) $row['modelo']),

            'delivery_date' => $deliveryDate,

            'imei' => $imei,

            'position' => trim((string) $row['cargo']),

            'department' => trim((string) $row['departamento']),

            'vendor_code' => trim((string) $row['codigo']),

            'company_name' => trim((string) $row['nombre_empresa']),

            'rut' => trim((string) $row['rut']),

            'email' => $email,

            'observations' => trim(
                (string) ($row['observaciones'] ?? '')
            ),

            'status' => 'active',
        ]);
    }
}