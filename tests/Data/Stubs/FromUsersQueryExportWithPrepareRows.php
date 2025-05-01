<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\FromQuery;
use WintechLaravel\Excel\Concerns\WithCustomChunkSize;
use WintechLaravel\Excel\Tests\Data\Stubs\Database\User;

class FromUsersQueryExportWithPrepareRows implements FromQuery, WithCustomChunkSize
{
    use Exportable;

    /**
     * @return Builder|EloquentBuilder|Relation
     */
    public function query()
    {
        return User::query();
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 10;
    }

    /**
     * @param  iterable  $rows
     * @return iterable
     */
    public function prepareRows($rows)
    {
        return (new Collection($rows))->map(function ($user) {
            $user->name .= '_prepared_name';

            return $user;
        })->toArray();
    }
}
