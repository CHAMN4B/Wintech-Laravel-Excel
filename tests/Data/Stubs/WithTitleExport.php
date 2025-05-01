<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\WithTitle;

class WithTitleExport implements WithTitle
{
    use Exportable;

    /**
     * @return string
     */
    public function title(): string
    {
        return 'given-title';
    }
}
