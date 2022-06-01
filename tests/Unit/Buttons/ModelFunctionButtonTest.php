<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Buttons;

use Anik\LaravelBackpack\Extension\Buttons\ModelFunctionButton;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class ModelFunctionButtonTest extends TestCase
{
    public function test_model_function_button_by_default_type_is_model_function()
    {
        $button = new ModelFunctionButton('content');
        $this->assertEquals('model_function', $button->toArray()['type']);

        $button = new ModelFunctionButton('content', 'name', 'view');
        $this->assertEquals('model_function', $button->toArray()['type']);
    }

    public function test_button_type_cannot_be_changed()
    {
        $button = new ModelFunctionButton('content');
        $button->setType('view');
        $this->assertArrayHasKey('type', $button->toArray());
        $this->assertEquals('model_function', $button->toArray()['type']);
    }
}
