<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use WintechLaravel\Excel\Concerns\Importable;
use WintechLaravel\Excel\Concerns\ToModel;
use WintechLaravel\Excel\Concerns\WithChunkReading;
use WintechLaravel\Excel\Tests\Data\Stubs\Database\Group;

class QueuedImportWithMiddleware implements ShouldQueue, ToModel, WithChunkReading
{
    use Importable;

    /**
     * @param  array  $row
     * @return Model|null
     */
    public function model(array $row)
    {
        return new Group([
            'name' => $row[0],
        ]);
    }

    public function middleware()
    {
        return [function () {
            throw new \Exception('Job reached middleware method');
        }];
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }
}
