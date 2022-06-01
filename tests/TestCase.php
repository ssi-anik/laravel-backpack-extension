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

    protected function modifyAttributesUsingMethods($instance, $methods)
    {
        foreach ($methods as $method => $params) {
            $this->modifyAttributeUsingMethod($instance, $method, $params);
        }

        return $instance;
    }

    protected function modifyAttributeUsingMethod($instance, $method, $params)
    {
        return call_user_func_array([$instance, $method], $params);
    }

    protected function verifyThatResultsAreEqual($expected, $instance, bool $identical = false)
    {
        $firstKey = array_key_first($expected);
        $expected = in_array($firstKey, get_class_methods($instance)) ? $expected : ['toArray' => $expected,];

        foreach ($expected as $method => $result) {
            $this->verifyThatResultIsEqual($result, $instance, $method, $identical);
        }
    }

    protected function verifyThatResultIsEqual($expected, $instance, $method, bool $identical = false)
    {
        $identical
            ? $this->assertSame($expected, call_user_func([$instance, $method]))
            : $this->assertEquals($expected, call_user_func([$instance, $method,]));
    }
}
