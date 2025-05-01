<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use Illuminate\Support\Collection;
use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\FromCollection;
use WintechLaravel\Excel\Concerns\WithMapping;

class WithMappingExport implements FromCollection, WithMapping
{
    use Exportable;

    /**
     * @return Collection
     */
    public function collection()
    {
        return collect([
            ['A1', 'B1', 'C1'],
            ['A2', 'B2', 'C2'],
        ]);
    }

    /**
     * @param  mixed  $row
     * @return array
     */
    public function map($row): array
    {
        return [
            'mapped-' . $row[0],
            'mapped-' . $row[1],
            'mapped-' . $row[2],
        ];
    }
}
