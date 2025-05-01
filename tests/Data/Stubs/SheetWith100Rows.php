<?php

namespace WintechLaravel\Excel\Tests\Data\Stubs;

use Illuminate\Support\Collection;
use WintechLaravel\Excel\Concerns\Exportable;
use WintechLaravel\Excel\Concerns\FromCollection;
use WintechLaravel\Excel\Concerns\RegistersEventListeners;
use WintechLaravel\Excel\Concerns\ShouldAutoSize;
use WintechLaravel\Excel\Concerns\WithEvents;
use WintechLaravel\Excel\Concerns\WithTitle;
use WintechLaravel\Excel\Events\BeforeWriting;
use WintechLaravel\Excel\Tests\TestCase;
use WintechLaravel\Excel\Writer;

class SheetWith100Rows implements FromCollection, WithTitle, ShouldAutoSize, WithEvents
{
    use Exportable, RegistersEventListeners;

    /**
     * @var string
     */
    private $title;

    /**
     * @param  string  $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $collection = new Collection;
        for ($i = 0; $i < 100; $i++) {
            $row = new Collection();
            for ($j = 0; $j < 5; $j++) {
                $row[] = $this->title() . '-' . $i . '-' . $j;
            }

            $collection->push($row);
        }

        return $collection;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @param  BeforeWriting  $event
     */
    public static function beforeWriting(BeforeWriting $event)
    {
        TestCase::assertInstanceOf(Writer::class, $event->writer);
    }
}
