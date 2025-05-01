<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Concerns\Importable;
use WintechLaravel\Excel\Concerns\ShouldQueueWithoutChain;
use WintechLaravel\Excel\Concerns\ToModel;
use WintechLaravel\Excel\Concerns\WithChunkReading;
use WintechLaravel\Excel\Concerns\WithEvents;
use WintechLaravel\Excel\Events\AfterImport;
use WintechLaravel\Excel\Events\BeforeImport;
use WintechLaravel\Excel\Reader;
use WintechLaravel\Excel\Tests\Data\Stubs\Database\User;
use PHPUnit\Framework\Assert;

class QueueImportWithoutJobChaining implements ToModel, WithChunkReading, WithEvents, ShouldQueueWithoutChain
{
    use Importable;

    public $queue;
    public $before = false;
    public $after  = false;

    /**
     * @param  array  $row
     * @return Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row[0],
            'email'    => $row[1],
            'password' => 'secret',
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                Assert::assertInstanceOf(Reader::class, $event->reader);
                $this->before = true;
            },
            AfterImport::class  => function (AfterImport $event) {
                Assert::assertInstanceOf(Reader::class, $event->reader);
                $this->after = true;
            },
        ];
    }
}
