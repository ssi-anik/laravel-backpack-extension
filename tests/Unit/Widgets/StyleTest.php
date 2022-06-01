<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Widgets;

use Anik\LaravelBackpack\Extension\Test\TestCase;
use Anik\LaravelBackpack\Extension\Widgets\Style;

class StyleTest extends TestCase
{
    const HREF = 'assets/css/common.css';

    protected function getStyleInstance(?string $href = null): Style
    {
        return Style::create($href ?? self::HREF);
    }

    public function test_href_is_set_when_instance_is_created()
    {
        $style = $this->getStyleInstance();

        $this->assertSame(self::HREF, $style->toArray()['href']);
    }

    public function test_type_is_style()
    {
        $style = $this->getStyleInstance();

        $this->assertSame('style', $style->toArray()['type']);
    }

    public function test_stack_by_default_set_to_after_styles()
    {
        $style = $this->getStyleInstance();

        $this->assertSame('after_styles', $style->toArray()['stack']);
    }

    public function test_stack_can_be_changed()
    {
        $style = $this->getStyleInstance()->setStack('before_styles');

        $this->assertSame('before_styles', $style->toArray()['stack']);
    }

    public function test_rel_can_be_set()
    {
        $style = $this->getStyleInstance()->setRel('icon');

        $this->assertSame('icon', $style->toArray()['rel']);
    }
}
