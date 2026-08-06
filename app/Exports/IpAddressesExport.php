<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class IpAddressesExport implements WithMultipleSheets
{
    protected array $subnets;
    protected array $columns;
    protected ?string $status;

    public function __construct(
        array $subnets,
        array $columns,
        ?string $status = null
    ) {
        $this->subnets = $subnets;
        $this->columns = $columns;
        $this->status = $status;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->subnets as $subnet) {

            $sheets[] = new IpAddressesSheet(
                $subnet,
                $this->columns,
                $this->status
            );

        }

        return $sheets;
    }
}