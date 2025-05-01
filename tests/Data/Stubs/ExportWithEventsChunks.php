<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\FromQuery;
use WintechLaravel\Excel\Concerns\WithCustomChunkSize;
use WintechLaravel\Excel\Concerns\WithEvents;
use WintechLaravel\Excel\Events\AfterChunk;
use WintechLaravel\Excel\Tests\Data\Stubs\Database\User;
use PHPUnit\Framework\Assert;

class ExportWithEventsChunks implements WithEvents, FromQuery, ShouldQueue, WithCustomChunkSize
{
    use Exportable;

    public static $calledEvent = 0;

    public function registerEvents(): array
    {
        return [
            AfterChunk::class => function (AfterChunk $event) {
                ExportWithEventsChunks::$calledEvent++;
                Assert::assertInstanceOf(ExportWithEventsChunks::class, $event->getConcernable());
            },
        ];
    }

    public function query(): Builder
    {
        return User::query();
    }

    public function chunkSize(): int
    {
        return 1;
    }
}
