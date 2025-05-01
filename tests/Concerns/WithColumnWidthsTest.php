<?php

namespace WintechLaravel\Excel\Tests\Concerns;

use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\FromArray;
use WintechLaravel\Excel\Concerns\WithColumnWidths;
use WintechLaravel\Excel\Tests\TestCase;

class WithColumnWidthsTest extends TestCase
{
    public function test_can_set_column_width()
    {
        $export = new class implements FromArray, WithColumnWidths
        {
            use Exportable;

            public function columnWidths(): array
            {
                return [
                    'A' => 55,
                ];
            }

            public function array(): array
            {
                return [
                    ['AA'],
                    ['BB'],
                ];
            }
        };

        $export->store('with-column-widths.xlsx');

        $spreadsheet = $this->read(__DIR__ . '/../Data/Disks/Local/with-column-widths.xlsx', 'Xlsx');

        $this->assertEquals(55, $spreadsheet->getActiveSheet()->getColumnDimension('A')->getWidth());
    }
}
