<?php

namespace WintechLaravel\Excel\Concerns;

use WintechLaravel\Excel\Row;

interface OnEachRow
{
    /**
     * @param  Row  $row
     */
    public function onRow(Row $row);
}
