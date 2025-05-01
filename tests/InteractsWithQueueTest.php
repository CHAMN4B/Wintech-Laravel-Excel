<?php

namespace WintechLaravel\Excel\Tests;

use Illuminate\Queue\InteractsWithQueue;
use WintechLaravel\Excel\Jobs\AppendDataToSheet;
use WintechLaravel\Excel\Jobs\AppendQueryToSheet;
use WintechLaravel\Excel\Jobs\AppendViewToSheet;
use WintechLaravel\Excel\Jobs\ReadChunk;

class InteractsWithQueueTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_read_chunk_job_can_interact_with_queue()
    {
        $this->assertContains(InteractsWithQueue::class, class_uses(ReadChunk::class));
    }

    public function test_append_data_to_sheet_job_can_interact_with_queue()
    {
        $this->assertContains(InteractsWithQueue::class, class_uses(AppendDataToSheet::class));
    }

    public function test_append_query_to_sheet_job_can_interact_with_queue()
    {
        $this->assertContains(InteractsWithQueue::class, class_uses(AppendQueryToSheet::class));
    }

    public function test_append_view_to_sheet_job_can_interact_with_queue()
    {
        $this->assertContains(InteractsWithQueue::class, class_uses(AppendViewToSheet::class));
    }
}
