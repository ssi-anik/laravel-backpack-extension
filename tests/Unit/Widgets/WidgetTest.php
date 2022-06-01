<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Widgets;

use Anik\LaravelBackpack\Extension\Test\TestCase;
use Anik\LaravelBackpack\Extension\Widgets\Widget;

class WidgetTest extends TestCase
{
    protected function getWidgetInstance(...$params): Widget
    {
        return new Widget(...$params);
    }

    public function widgetInstantiationDataProvider(): array
    {
        return [
            'nothing' => [
                self::PARAM => [],
                self::EXPECTED => [],
            ],
            'type' => [
                self::PARAM => ['script'],
                self::EXPECTED => ['type' => 'script'],
            ],
            'type, name' => [
                self::PARAM => ['script', 'script_tag'],
                self::EXPECTED => ['type' => 'script', 'name' => 'script_tag'],
            ],
            'type, name, section' => [
                self::PARAM => ['script', 'script_tag', 'before_breadcrumbs'],
                self::EXPECTED => ['type' => 'script', 'name' => 'script_tag', 'section' => 'before_breadcrumbs'],
            ],
        ];
    }

    public function widgetSetAttributesDataProvider(): array
    {
        return [
            'can set section' => [
                self::METHODS => ['setSection' => ['before_breadcrumbs']],
                self::EXPECTED => ['section' => 'before_breadcrumbs'],
            ],
            'can set content' => [
                self::METHODS => ['setContent' => ['assets/js/common.js']],
                self::EXPECTED => ['content' => 'assets/js/common.js'],
            ],
            'can set viewNamespace' => [
                self::METHODS => ['setViewNamespace' => ['crud::widgets']],
                self::EXPECTED => ['viewNamespace' => 'crud::widgets'],
            ],
            'everything' => [
                self::METHODS => [
                    'setSection' => ['before_breadcrumbs'],
                    'setContent' => ['assets/js/common.js'],
                    'setViewNamespace' => ['crud::widgets'],
                ],
                self::EXPECTED => [
                    'section' => 'before_breadcrumbs',
                    'content' => 'assets/js/common.js',
                    'viewNamespace' => 'crud::widgets',
                ],
            ],
        ];
    }

    /** @dataProvider widgetInstantiationDataProvider */
    public function test_instantiation_pushes_params_to_attribute($param, $expected)
    {
        $widget = $this->getWidgetInstance(...$param);
        $this->assertSame($expected, $widget->toArray());
    }

    /** @dataProvider widgetSetAttributesDataProvider */
    public function test_widget_can_modify_attributes($methods, $expected)
    {
        $widget = $this->getWidgetInstance();
        $this->modifyAttributesUsingMethods($widget, $methods);
        $this->assertEquals($expected, $widget->toArray());
    }

    public function test_if_hidden()
    {
        $widget = $this->getWidgetInstance();
        $this->assertFalse($widget->isHidden());

        $widget->shouldBeHidden();
        $this->assertTrue($widget->isHidden());
    }

    public function test_if_first()
    {
        $widget = $this->getWidgetInstance();
        $this->assertFalse($widget->isFirst());

        $widget->shouldBeFirst();
        $this->assertTrue($widget->isFirst());
    }

    public function test_if_last()
    {
        $widget = $this->getWidgetInstance();
        $this->assertFalse($widget->isLast());

        $widget->shouldBeLast();
        $this->assertTrue($widget->isLast());
    }
}
