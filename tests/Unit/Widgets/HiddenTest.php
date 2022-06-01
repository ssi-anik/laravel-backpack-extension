<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Widgets;

use Anik\LaravelBackpack\Extension\Test\TestCase;
use Anik\LaravelBackpack\Extension\Widgets\Hidden;

class HiddenTest extends TestCase
{
    public function test_widget_is_always_hidden()
    {
        $hidden = new Hidden();
        $this->assertTrue($hidden->isHidden());
    }
}
