<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Buttons;

use Anik\LaravelBackpack\Extension\Buttons\Button;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class ButtonTest extends TestCase
{
    const NAME = 'btn_name';
    const CONTENT = 'btn_content';

    protected function getDefaultAttributes(): array
    {
        return ['content' => self::CONTENT];
    }

    protected function getButtonInstance(...$params): Button
    {
        return new Button(...$params);
    }

    public function getButtonInstanceUsingCreate(...$params): Button
    {
        return Button::create(...$params);
    }

    public function instantiateButtonUsingConstructorDataProvider(): array
    {
        return [
            'only content' => [
                self::PARAM => [self::CONTENT],
                self::EXPECTED => ['content' => self::CONTENT],
            ],
            'content and name' => [
                self::PARAM => [self::CONTENT, self::NAME],
                self::EXPECTED => ['content' => self::CONTENT, 'name' => self::NAME],
            ],
            'content, name, type' => [
                self::PARAM => [self::CONTENT, self::NAME, 'view'],
                self::EXPECTED => ['content' => self::CONTENT, 'name' => self::NAME, 'type' => 'view'],
            ],
        ];
    }

    public function instantiateButtonUsingCreateDataProvider(): array
    {
        return [
            'only content' => [
                self::PARAM => [self::CONTENT],
                self::EXPECTED => $this->mergeAttributesWithDefault(),
            ],
            'content and name' => [
                self::PARAM => [self::CONTENT, self::NAME],
                self::EXPECTED => $this->mergeAttributesWithDefault(['name' => self::NAME]),
            ],
        ];
    }

    public function buttonSetAttributesDataProvider(): array
    {
        return [
            'can set type' => [
                self::METHODS => ['setType' => ['model_function']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'model_function']),
            ],
            'can set stack' => [
                self::METHODS => ['setStack' => ['top']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['stack' => 'top']),
            ],
            'can set stack with inLine' => [
                self::METHODS => ['inLine' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['stack' => 'line']),
            ],
            'can set stack with onTop' => [
                self::METHODS => ['onTop' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['stack' => 'top']),
            ],
            'can set stack with onBottom' => [
                self::METHODS => ['onBottom' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['stack' => 'bottom']),
            ],
            'can set position' => [
                self::METHODS => ['setPosition' => ['beginning']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['position' => 'beginning']),
            ],
            'can set position with beginning' => [
                self::METHODS => ['beginning' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['position' => 'beginning']),
            ],
            'can set position with end' => [
                self::METHODS => ['end' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['position' => 'end']),
            ],
            'can set all values at once' => [
                self::METHODS => [
                    'setType' => ['model_function'],
                    'setStack' => ['top'],
                    'setPosition' => ['beginning'],
                ],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    [
                        'type' => 'model_function',
                        'stack' => 'top',
                        'position' => 'beginning',
                    ]
                ),
            ],
        ];
    }

    /** @dataProvider instantiateButtonUsingConstructorDataProvider */
    public function test_button_instantiation_using_constructor($param, $expected)
    {
        $btn = $this->getButtonInstance(...$param);
        $this->assertEquals($expected, $btn->toArray());
    }

    /** @dataProvider instantiateButtonUsingCreateDataProvider */
    public function test_button_instantiation_using_create_method($param, $expected)
    {
        $button = $this->getButtonInstanceUsingCreate(...$param);
        $this->assertSame($expected, $button->toArray());
    }

    /** @dataProvider buttonSetAttributesDataProvider */
    public function test_button_instance_can_modify_attributes($methods, $expected)
    {
        $button = $this->getButtonInstanceUsingCreate(self::CONTENT);
        $this->modifyAttributesUsingMethods($button, $methods);
        $this->assertEquals($expected, $button->toArray());
    }

    public function test_button_can_be_put_in_first_or_last()
    {
        $button = $this->getButtonInstance('content');
        $this->assertFalse($button->isFirst());
        $this->assertFalse($button->isLast());
        $button->shouldBeFirst()->shouldBeLast();
        $this->assertTrue($button->isFirst());
        $this->assertTrue($button->isLast());
    }
}
