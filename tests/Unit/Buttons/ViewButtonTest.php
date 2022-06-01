<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Buttons;

use Anik\LaravelBackpack\Extension\Buttons\ViewButton;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class ViewButtonTest extends TestCase
{
    public function test_view_button_by_default_type_is_view()
    {
        $button = new ViewButton('content');
        $this->assertEquals('view', $button->toArray()['type']);

        $button = new ViewButton('content', 'name', 'model_function');
        $this->assertEquals('view', $button->toArray()['type']);
    }

    public function test_button_type_cannot_be_changed()
    {
        $button = new ViewButton('content');
        $button->setType('model_function');

        $this->assertArrayHasKey('type', $button->toArray());
        $this->assertEquals('view', $button->toArray()['type']);
    }
}
