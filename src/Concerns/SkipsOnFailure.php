<?php

namespace WintechLaravel\Excel\Concerns;

use WintechLaravel\Excel\Validators\Failure;

interface SkipsOnFailure
{
    /**
     * @param  Failure[]  $failures
     */
    public function onFailure(Failure ...$failures);
}
