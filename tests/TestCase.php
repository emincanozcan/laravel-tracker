<?php

namespace Emincan\Tracker\Tests;

use Emincan\Tracker\TrackerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  protected function setUp(): void
  {
    parent::setUp();
    $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
  }

  protected function getPackageProviders($app)
  {
    return [
      TrackerServiceProvider::class
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    $app['config']->set('database.default', 'testbench');
    $app['config']->set('database.connections.testbench', [
      'driver'   => 'sqlite',
      'database' => ':memory:',
      'prefix'   => '',
    ]);
  }
}
