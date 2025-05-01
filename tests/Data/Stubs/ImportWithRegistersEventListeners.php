<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Concerns\Importable;
use WintechLaravel\Excel\Concerns\RegistersEventListeners;
use WintechLaravel\Excel\Concerns\WithEvents;

class ImportWithRegistersEventListeners implements WithEvents
{
    use Importable, RegistersEventListeners;

    /**
     * @var callable
     */
    public static $beforeImport;

    /**
     * @var callable
     */
    public static $beforeSheet;

    /**
     * @var callable
     */
    public static $afterSheet;

    public static function beforeImport()
    {
        (static::$beforeImport)(...func_get_args());
    }

    public static function beforeSheet()
    {
        (static::$beforeSheet)(...func_get_args());
    }

    public static function afterSheet()
    {
        (static::$afterSheet)(...func_get_args());
    }
}
