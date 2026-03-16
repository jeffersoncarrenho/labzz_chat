<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\RefreshDatabase;

trait RefreshDatabaseWithoutPassport
{
    use RefreshDatabase;

    protected function migrateFreshUsing()
    {
        return [
            '--path' => [
                'database/migrations'
            ],
            '--realpath' => true,
        ];
    }
}
