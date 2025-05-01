<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Transactions\TransactionHandler;

class CustomTransactionHandler implements TransactionHandler
{
    public function __invoke(callable $callback)
    {
        return $callback();
    }
}
