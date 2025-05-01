<?php

namespace WintechLaravel\Excel\Concerns;

use WintechLaravel\Excel\Events\AfterBatch;
use WintechLaravel\Excel\Events\AfterChunk;
use WintechLaravel\Excel\Events\AfterImport;
use WintechLaravel\Excel\Events\AfterSheet;
use WintechLaravel\Excel\Events\BeforeExport;
use WintechLaravel\Excel\Events\BeforeImport;
use WintechLaravel\Excel\Events\BeforeSheet;
use WintechLaravel\Excel\Events\BeforeWriting;
use WintechLaravel\Excel\Events\ImportFailed;

trait RegistersEventListeners
{
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        $listenersClasses = [
            BeforeExport::class  => 'beforeExport',
            BeforeWriting::class => 'beforeWriting',
            BeforeImport::class  => 'beforeImport',
            AfterImport::class   => 'afterImport',
            AfterBatch::class    => 'afterBatch',
            AfterChunk::class    => 'afterChunk',
            ImportFailed::class  => 'importFailed',
            BeforeSheet::class   => 'beforeSheet',
            AfterSheet::class    => 'afterSheet',
        ];
        $listeners = [];

        foreach ($listenersClasses as $class => $name) {
            // Method names are case insensitive in php
            if (method_exists($this, $name)) {
                // Allow methods to not be static
                $listeners[$class] = [$this, $name];
            }
        }

        return $listeners;
    }
}
