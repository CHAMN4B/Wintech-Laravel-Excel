<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use WintechLaravel\Excel\Concerns\Importable;
use WintechLaravel\Excel\Concerns\ToModel;
use WintechLaravel\Excel\Concerns\WithChunkReading;
use WintechLaravel\Excel\Tests\Data\Stubs\Database\Group;

class QueuedImportWithRetryUntil implements ShouldQueue, ToModel, WithChunkReading
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

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        throw new \Exception('Job reached retryUntil method');

        return now()->addSeconds(5);
    }
}
