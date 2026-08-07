<?php

namespace App\Exports;

use App\Models\Dvr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Crypt;

class DvrExport implements FromCollection, WithHeadings
{
    protected array $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function collection()
    {
        return Dvr::with('branch')
            ->get()
            ->map(function ($dvr) {

                $password = '';

                if ($dvr->password) {
                    try {
                        $password = Crypt::decryptString($dvr->password);
                    } catch (\Exception $e) {
                        $password = '[Error al desencriptar]';
                    }
                }

                $row = [
                    'nombre'    => $dvr->nombre,
                    'branch_id' => $dvr->branch?->name ?? '',
                    'tipo'      => $dvr->tipo,
                    'modelo'    => $dvr->modelo,
                    'mp'        => $dvr->mp,
                    'hdd'       => $dvr->hdd,
                    'sn'        => $dvr->sn,
                    'ip'        => $dvr->ip,
                    'password'  => $dvr->password,
                ];

                return collect($row)
                    ->only($this->columns)
                    ->toArray();
            });
    }

    public function headings(): array
    {
        $headings = [
            'nombre'    => 'Nombre',
            'branch_id' => 'Sucursal',
            'tipo'      => 'Tipo',
            'modelo'    => 'Modelo',
            'mp'        => 'MP',
            'hdd'       => 'HDD',
            'sn'        => 'SN',
            'ip'        => 'IP',
            'password'  => 'Contraseña',
        ];

        return collect($headings)
            ->only($this->columns)
            ->values()
            ->toArray();
    }
}
