<?php

namespace Anik\LaravelBackpack\Extension\Test;

use Backpack\CRUD\BackpackServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    const METHODS = 'methods';
    const PARAM = 'param';
    const EXPECTED = 'expected';

    protected function getDefaultAttributes(): array
    {
        return [];
    }

    protected function mergeAttributesWithDefault(array $attributes = [], bool $mergeRecursive = false): array
    {
        return call_user_func_array(
            $mergeRecursive ? 'array_merge_recursive' : 'array_merge',
            [$this->getDefaultAttributes(), $attributes]
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            BackpackServiceProvider::class,
        ];
    }
}
