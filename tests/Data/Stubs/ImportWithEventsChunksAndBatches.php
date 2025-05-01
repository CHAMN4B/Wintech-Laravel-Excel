<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Concerns\ToModel;
use WintechLaravel\Excel\Concerns\WithBatchInserts;
use WintechLaravel\Excel\Concerns\WithChunkReading;
use WintechLaravel\Excel\Events\AfterBatch;
use WintechLaravel\Excel\Events\AfterChunk;

class ImportWithEventsChunksAndBatches extends ImportWithEvents implements WithBatchInserts, ToModel, WithChunkReading
{
    /**
     * @var callable
     */
    public $afterBatch;

    /**
     * @var callable
     */
    public $afterChunk;

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return parent::registerEvents() + [
            AfterBatch::class => $this->afterBatch ?? function () {
            },
            AfterChunk::class => $this->afterChunk ?? function () {
            },
        ];
    }

    public function model(array $row)
    {
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
