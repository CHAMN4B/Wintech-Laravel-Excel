<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\WithEvents;
use WintechLaravel\Excel\Events\AfterSheet;
use WintechLaravel\Excel\Events\BeforeExport;
use WintechLaravel\Excel\Events\BeforeSheet;
use WintechLaravel\Excel\Events\BeforeWriting;

class ExportWithEvents implements WithEvents
{
    use Exportable;

    /**
     * @var callable
     */
    public $beforeExport;

    /**
     * @var callable
     */
    public $beforeWriting;

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
            BeforeExport::class  => $this->beforeExport ?? function () {
            },
            BeforeWriting::class => $this->beforeWriting ?? function () {
            },
            BeforeSheet::class   => $this->beforeSheet ?? function () {
            },
            AfterSheet::class    => $this->afterSheet ?? function () {
            },
        ];
    }
}
