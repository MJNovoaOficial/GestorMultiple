<?php

namespace App\Exports;

use App\Models\IpAddress;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class IpAddressesSheet implements FromCollection, WithHeadings, WithTitle
{
    protected string $subnet;

    protected array $columns;

    protected ?string $status;

    public function __construct(
        string $subnet,
        array $columns,
        ?string $status = null
    ) {
        $this->subnet = $subnet;
        $this->columns = $columns;
        $this->status = $status;
    }

    /**
     * Nombre de la pestaña.
     */
    public function title(): string
    {
        return $this->subnet . '.x';
    }

    /**
     * Datos.
     */
    public function collection(): Collection
    {
        return $this->query()
            ->get()
            ->map(function ($ip) {

                $row = [];

                foreach ($this->columns as $column) {

                    switch ($column) {

                        case 'ip':

                            $row[] = $ip->ip_address;
                            break;

                        case 'status':

                            $row[] = $ip->ipStatus?->name;
                            break;

                        case 'user':

                            $row[] = $ip->user_assigned;
                            break;

                        case 'device':

                            $row[] = $ip->deviceType?->name;
                            break;

                        case 'branch':

                            $row[] = $ip->branch?->name;
                            break;

                        case 'department':

                            $row[] = $ip->department?->name;
                            break;
                    }
                }

                return $row;
            });
    }

    /**
     * Encabezados.
     */
    public function headings(): array
    {
        $titles = [];

        foreach ($this->columns as $column) {

            switch ($column) {

                case 'ip':

                    $titles[] = 'IP';
                    break;

                case 'status':

                    $titles[] = 'Estado';
                    break;

                case 'user':

                    $titles[] = 'Usuario Responsable';
                    break;

                case 'device':

                    $titles[] = 'Dispositivo';
                    break;

                case 'branch':

                    $titles[] = 'Sucursal';
                    break;

                case 'department':

                    $titles[] = 'Departamento';
                    break;
            }
        }

        return $titles;
    }

    /**
     * Consulta principal.
     */
    protected function query()
    {
        $query = IpAddress::with([
            'branch',
            'department',
            'deviceType',
            'ipStatus'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filtrar por rama
        |--------------------------------------------------------------------------
        */

        $query->where(
            'ip_address',
            'like',
            $this->subnet . '.%'
        );

        /*
        |--------------------------------------------------------------------------
        | Filtrar por estado
        |--------------------------------------------------------------------------
        */

        if (!empty($this->status)) {

            $query->whereHas('ipStatus', function ($query) {

                $query->whereRaw(
                    'LOWER(name) = ?',
                    [strtolower($this->status)]
                );

            });

        }

        return $query->orderByRaw("
            CAST(PARSENAME(ip_address, 4) AS BIGINT),
            CAST(PARSENAME(ip_address, 3) AS BIGINT),
            CAST(PARSENAME(ip_address, 2) AS BIGINT),
            CAST(PARSENAME(ip_address, 1) AS BIGINT)
        ");
    }
}