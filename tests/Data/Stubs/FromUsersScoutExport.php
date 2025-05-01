<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Laravel\Scout\Builder as ScoutBuilder;
use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\FromQuery;
use WintechLaravel\Excel\Concerns\WithCustomChunkSize;
use WintechLaravel\Excel\Tests\Data\Stubs\Database\User;

class FromUsersScoutExport implements FromQuery, WithCustomChunkSize
{
    use Exportable;

    /**
     * @return Builder|EloquentBuilder|Relation|ScoutBuilder
     */
    public function query()
    {
        return new ScoutBuilder(new User, '');
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 10;
    }
}
