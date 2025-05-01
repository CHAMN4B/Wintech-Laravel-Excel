<?php

namespace WintechLaravel\Excel\Middleware;

abstract class CellMiddleware
{
    /**
     * @param  mixed  $value
     * @return mixed
     */
    abstract public function __invoke($value, callable $next);
}
