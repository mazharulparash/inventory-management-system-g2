<?php

namespace Tests;

use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Run the role seeder before each test
        // Check if the roles table is empty before seeding
        if (Role::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'RolesAndAdminSeeder']);
        }
    }
}
