<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Filters;

use Anik\LaravelBackpack\Extension\Filters\AjaxFilter;
use Anik\LaravelBackpack\Extension\Filters\Filter;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class AjaxFilterTest extends TestCase
{
    const NAME = 'test_filter';

    protected function getDefaultAttributes(): array
    {
        return ['name' => self::NAME, 'type' => 'select2_ajax',];
    }

    public function getFilterInstanceUsingCreate(...$params): Filter
    {
        return AjaxFilter::create(...$params);
    }

    public function filterInstantiationDataProvider(): array
    {
        return [
            'only name' => [
                self::PARAM => [self::NAME],
                self::EXPECTED => ['toArray' => $this->mergeAttributesWithDefault()],
            ],
            'name and method' => [
                self::PARAM => [self::NAME, null, null, 'POST'],
                self::EXPECTED => ['toArray' => $this->mergeAttributesWithDefault(['method' => 'POST'])],
            ],
            'name and url as value' => [
                self::PARAM => [self::NAME, null, 'http://127.0.0.1'],
                self::EXPECTED => ['toArray' => $this->mergeAttributesWithDefault(), 'getValues' => 'http://127.0.0.1'],
            ],
            'everything' => [
                self::PARAM => [self::NAME, 'test_label', 'http://127.0.0.1', 'GET'],
                self::EXPECTED => [
                    'toArray' => $this->mergeAttributesWithDefault(['label' => 'test_label', 'method' => 'GET']),
                    'getValues' => 'http://127.0.0.1',
                ],
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
            'can set minimum input length' => [
                self::METHODS => ['setMinimumInputLength' => [5]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['minimum_input_length' => 5]),
            ],
            'can set select key' => [
                self::METHODS => ['setSelectKey' => ['sk']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['select_key' => 'sk']),
            ],
            'can set select attribute' => [
                self::METHODS => ['setSelectAttribute' => ['attrib']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['select_attribute' => 'attrib']),
            ],
            'can set method' => [
                self::METHODS => ['setMethod' => ['POST']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['method' => 'POST']),
            ],
            'can set quiet time' => [
                self::METHODS => ['setQuietTime' => [10]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['quiet_time' => 10]),
            ],
            'can set all values at once' => [
                self::METHODS => [
                    'setType' => ['test_type'],
                    'setMinimumInputLength' => [5],
                    'setSelectKey' => ['sk'],
                    'setSelectAttribute' => ['attrib'],
                    'setMethod' => ['POST'],
                    'setQuietTime' => [10],
                ],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    [
                        'type' => 'test_type',
                        'minimum_input_length' => 5,
                        'select_key' => 'sk',
                        'select_attribute' => 'attrib',
                        'method' => 'POST',
                        'quiet_time' => 10,
                    ]
                ),
            ],
        ];
    }

    public function test_filter_instance_is_by_default_select2_ajax_type()
    {
        $filter = new AjaxFilter(self::NAME);
        $this->assertEquals($this->mergeAttributesWithDefault(), $filter->toArray());
    }

    /** @dataProvider filterInstantiationDataProvider */
    public function test_filter_instantiate_with_create_method_pushes_provided_param_to_attribute($param, $expected)
    {
        $filter = $this->getFilterInstanceUsingCreate(...$param);
        foreach ($expected as $method => $result) {
            $this->assertEquals($result, call_user_func([$filter, $method]));
        }
    }

    /** @dataProvider filterInstanceSetAttributes */
    public function test_filter_instance_can_modify_attributes($methods, $expected)
    {
        $filter = $this->getFilterInstanceUsingCreate(self::NAME);
        $this->modifyAttributesUsingMethods($filter, $methods);
        $this->assertEquals(
            $expected,
            $filter->toArray()
        );
    }
}
