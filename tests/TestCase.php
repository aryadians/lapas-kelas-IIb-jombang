<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        // Force testing environment
        putenv('APP_ENV=testing');
        $_ENV['APP_ENV'] = 'testing';
        $_SERVER['APP_ENV'] = 'testing';

        // Manually load .env.testing
        if (file_exists(__DIR__.'/../.env.testing')) {
            $dotenv = \Dotenv\Dotenv::createMutable(__DIR__.'/../', '.env.testing');
            $dotenv->load();
        }
        
        parent::setUp();
    }
}
