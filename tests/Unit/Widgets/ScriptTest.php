<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Widgets;

use Anik\LaravelBackpack\Extension\Test\TestCase;
use Anik\LaravelBackpack\Extension\Widgets\Script;

class ScriptTest extends TestCase
{
    const SRC = 'assets/js/common.js';

    protected function getScriptInstance(?string $src = null): Script
    {
        return Script::create($src ?? self::SRC);
    }

    public function test_src_is_set_when_instance_is_created()
    {
        $script = $this->getScriptInstance();

        $this->assertSame(self::SRC, $script->toArray()['src']);
    }

    public function test_type_is_script()
    {
        $script = $this->getScriptInstance();

        $this->assertSame('script', $script->toArray()['type']);
    }

    public function test_stack_by_default_set_to_after_scripts()
    {
        $script = $this->getScriptInstance();

        $this->assertSame('after_scripts', $script->toArray()['stack']);
    }

    public function test_stack_can_be_changed()
    {
        $script = $this->getScriptInstance()->setStack('before_scripts');

        $this->assertSame('before_scripts', $script->toArray()['stack']);
    }
}
