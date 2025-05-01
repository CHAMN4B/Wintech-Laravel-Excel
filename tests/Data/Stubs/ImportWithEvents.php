<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Concerns\Importable;
use WintechLaravel\Excel\Concerns\WithEvents;
use WintechLaravel\Excel\Events\AfterImport;
use WintechLaravel\Excel\Events\AfterSheet;
use WintechLaravel\Excel\Events\BeforeImport;
use WintechLaravel\Excel\Events\BeforeSheet;

class ImportWithEvents implements WithEvents
{
    use Importable;

    /**
     * @var callable
     */
    public $beforeImport;

    /**
     * @var callable
     */
    public $afterImport;

    /**
     * @var callable
     */
    public $beforeSheet;

    /**
     * @var callable
     */
    public $afterSheet;

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => $this->beforeImport ?? function () {
            },
            AfterImport::class => $this->afterImport ?? function () {
            },
            BeforeSheet::class => $this->beforeSheet ?? function () {
            },
            AfterSheet::class => $this->afterSheet ?? function () {
            },
        ];
    }
}
