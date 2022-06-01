<?php

namespace Anik\LaravelBackpack\Extension\Test\Feature\Controllers;

use Anik\LaravelBackpack\Extension\Test\TestCase;
use Illuminate\Testing\TestResponse;

class CrudControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('database.default', 'testbench');
        $this->app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->app['router']->crud($this->baseRoute(), DoNotUseThisController::class);

        $this->loadLaravelMigrations();

        $this->artisan('migrate', ['--database' => 'testbench'])->run();

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback', ['--database' => 'testbench'])->run();
        });
    }

    protected function baseRoute(): string
    {
        return '__test';
    }

    public function buttonsRoute(): string
    {
        return sprintf('%s/buttons', rtrim($this->baseRoute(), '/'));
    }

    public function columnsRoute(): string
    {
        return sprintf('%s/columns', rtrim($this->baseRoute(), '/'));
    }

    public function fieldsRoute(): string
    {
        return sprintf('%s/fields', rtrim($this->baseRoute(), '/'));
    }

    public function widgetsRoute(): string
    {
        return sprintf('%s/widgets', rtrim($this->baseRoute(), '/'));
    }

    public function filtersRoute(): string
    {
        return sprintf('%s/filters', rtrim($this->baseRoute(), '/'));
    }

    public function makeHttpCall(string $url): TestResponse
    {
        return $this->get($url);
    }

    public function routesDataProvider(): array
    {
        return [
            'buttons' => [$this->buttonsRoute()],
            'columns' => [$this->columnsRoute()],
            'fields' => [$this->fieldsRoute()],
            'filters' => [$this->filtersRoute()],
            'widgets' => [$this->widgetsRoute()],
        ];
    }

    /** @dataProvider routesDataProvider */
    public function test_controller_should_register_things_correctly($route)
    {
        $response = $this->makeHttpCall($route);
        // It will show the messages why it's failing
        $this->assertEquals([], $response->json('messages'));
    }
}
