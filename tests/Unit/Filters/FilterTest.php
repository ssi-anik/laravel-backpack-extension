<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Filters;

use Anik\LaravelBackpack\Extension\Filters\Filter;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class FilterTest extends TestCase
{
    const NAME = 'test_filter';

    protected function getDefaultAttributes(): array
    {
        return ['name' => self::NAME, 'type' => 'dropdown',];
    }

    private function getFilterInstance(...$params): Filter
    {
        return new Filter(...$params);
    }

    public function getFilterInstanceUsingCreate(...$params): Filter
    {
        return Filter::create(...$params);
    }

    public function filterInstantiationDataProvider(): array
    {
        return [
            'only name' => [
                self::PARAM => [self::NAME],
                self::EXPECTED => $this->mergeAttributesWithDefault(),
            ],
            'name and null label' => [
                self::PARAM => [self::NAME, null],
                self::EXPECTED => $this->mergeAttributesWithDefault(),
            ],
            'name and valid label' => [
                self::PARAM => [self::NAME, 'test_label'],
                self::EXPECTED => $this->mergeAttributesWithDefault(['label' => 'test_label',]),
            ],
        ];
    }

    public function filterInstanceSetAttributes(): array
    {
        return [
            'can set type' => [
                self::METHODS => ['setType' => ['test_type']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'test_type']),
            ],
            'can set view namespace' => [
                self::METHODS => ['setViewNamespace' => ['viewNamespace']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['viewNamespace' => 'viewNamespace']),
            ],
            'can set placeholder' => [
                self::METHODS => ['setPlaceholder' => ['Placeholder']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['placeholder' => 'Placeholder']),
            ],
            'can set all values at once' => [
                self::METHODS => [
                    'setType' => ['test_type'],
                    'setViewNamespace' => ['viewNamespace'],
                    'setPlaceholder' => ['Placeholder'],
                ],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    [
                        'type' => 'test_type',
                        'viewNamespace' => 'viewNamespace',
                        'placeholder' => 'Placeholder',
                    ]
                ),
            ],
        ];
    }

    public function filterValues(): array
    {
        return [
            'string url as value' => [self::PARAM => 'http://127.0.0.1', self::EXPECTED => 'http://127.0.0.1'],
            'array as value' => [self::PARAM => [1, 2, 3], self::EXPECTED => [1, 2, 3]],
            'callable as value' => [self::PARAM => $cb = fn() => [], self::EXPECTED => $cb,],
        ];
    }

    public function filterLogics(): array
    {
        return [
            'no logic is provided' => [self::PARAM => null, self::EXPECTED => null],
            'callable as logic' => [self::PARAM => $cb = fn() => [], self::EXPECTED => $cb,],
        ];
    }

    public function test_filter_instance_is_by_default_dropdown_type()
    {
        $filter = $this->getFilterInstance(self::NAME);
        $this->assertEquals($this->mergeAttributesWithDefault(), $filter->toArray());
    }

    /** @dataProvider filterInstantiationDataProvider */
    public function test_filter_instantiate_pushes_provided_param_to_attribute($param, $expected)
    {
        $filter = $this->getFilterInstance(...$param);
        $this->assertEquals($expected, $filter->toArray());
    }

    /** @dataProvider filterInstantiationDataProvider */
    public function test_filter_instantiate_with_create_method_pushes_provided_param_to_attribute($param, $expected)
    {
        $filter = $this->getFilterInstanceUsingCreate(...$param);
        $this->assertEquals($expected, $filter->toArray());
    }

    /** @dataProvider filterInstanceSetAttributes */
    public function test_filter_instance_can_modify_attributes($methods, $expected)
    {
        $filter = $this->getFilterInstanceUsingCreate(self::NAME);
        $this->modifyAttributesUsingMethods($filter, $methods);
        /*$this->verifyThatResultsAreEqual($expected, $filter);*/
        $this->assertEquals($expected, $filter->toArray());
    }

    /** @dataProvider filterValues */
    public function test_filter_can_have_values($param, $expected)
    {
        $filter = $this->getFilterInstanceUsingCreate(self::NAME);
        $filter->setValues($param);
        $this->assertSame($expected, $filter->getValues());
    }

    /** @dataProvider filterLogics */
    public function test_filter_can_have_logic($param, $expected)
    {
        $filter = $this->getFilterInstanceUsingCreate(self::NAME);
        !is_null($param) ? $filter->setLogic($param) : null;
        $this->assertSame($expected, $filter->getLogic());
    }

    /** @dataProvider filterLogics */
    public function test_filter_can_have_fallback_logic($param, $expected)
    {
        $filter = $this->getFilterInstanceUsingCreate(self::NAME);
        !is_null($param) ? $filter->setFallbackLogic($param) : null;
        $this->assertSame($expected, $filter->getFallbackLogic());
    }
}
