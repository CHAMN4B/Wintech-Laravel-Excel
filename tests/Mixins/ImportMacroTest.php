<?php

namespace WintechLaravel\Excel\Tests\Mixins;

use WintechLaravel\Excel\Tests\Data\Stubs\Database\User;
use WintechLaravel\Excel\Tests\TestCase;

class ImportMacroTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);
    }

    public function test_can_import_directly_into_a_model()
    {
        User::query()->truncate();
        User::creating(function ($user) {
            $user->password = 'secret';
        });

        User::import('import-users-with-headings.xlsx');

        $this->assertCount(2, User::all());
        $this->assertEquals([
            'patrick@wintechlaravel.nl',
            'taylor@laravel.com',
        ], User::query()->pluck('email')->all());
    }
}
