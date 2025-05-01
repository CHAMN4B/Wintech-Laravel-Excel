<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\RegistersEventListeners;
use WintechLaravel\Excel\Concerns\WithEvents;

class ExportWithRegistersEventListeners implements WithEvents
{
    use Exportable, RegistersEventListeners;

    /**
     * @var callable
     */
    public static $beforeExport;

    /**
     * @var callable
     */
    public static $beforeWriting;

    /**
     * @var callable
     */
    public static $beforeSheet;

    /**
     * @var callable
     */
    public static $afterSheet;

    public static function beforeExport()
    {
        (static::$beforeExport)(...func_get_args());
    }

    public static function beforeWriting()
    {
        (static::$beforeWriting)(...func_get_args());
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
