<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Extensions;

use Anik\LaravelBackpack\Extension\Extensions\Attributable;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class AttributableTraitTest extends TestCase
{
    public function getAttributableInstance(): object
    {
        return new class {
            use Attributable;
        };
    }

    public function test_can_add_attribute()
    {
        $cls = $this->getAttributableInstance();

        $cls->addAttribute('a', 'a');

        $this->assertSame(['a' => 'a'], $cls->toArray());
    }

    public function test_can_add_attribute_using_dot_notation()
    {
        $cls = $this->getAttributableInstance();

        $cls->addAttribute('a.b.c', 'd');

        $this->assertSame(['a' => ['b' => ['c' => 'd']]], $cls->toArray());
    }

    public function test_can_add_attribute_recursively()
    {
        $cls = $this->getAttributableInstance();

        $cls->addAttribute('a', 'a');
        $cls->addAttribute('a', 'c', true);

        $this->assertSame(['a' => ['a', 'c']], $cls->toArray());
    }

    public function test_can_add_multiple_attributes_at_once()
    {
        $cls = $this->getAttributableInstance();

        $cls->addAttribute('a', 'a');
        $cls->addAttributes(['b' => 'b', 'c' => 'c']);

        $this->assertSame(['a' => 'a', 'b' => 'b', 'c' => 'c'], $cls->toArray());
    }

    public function test_can_add_multiple_attributes_at_once_recursively()
    {
        $cls = $this->getAttributableInstance();

        $cls->addAttribute('a', 'a');
        $cls->addAttributes(['a' => ['b', 'c']], true);

        $this->assertSame(['a' => ['a', 'b', 'c']], $cls->toArray());
    }

    public function test_can_unset_attribute()
    {
        $cls = $this->getAttributableInstance();

        $cls->addAttribute('a', 'a');
        $cls->addAttribute('b', 'b');
        $cls->addAttribute('c', 'c');
        $cls->addAttribute('d', 'd');

        $cls->unset('b');

        $this->assertSame(['a' => 'a', 'c' => 'c', 'd' => 'd'], $cls->toArray());
    }

    public function test_can_unset_attribute_using_dot_notation()
    {
        $cls = $this->getAttributableInstance();

        $cls->addAttribute('a.b.c.d', 'f');
        $cls->addAttribute('a.b.c.e', 'g', true);

        $cls->unset('a.b.c.e');
        $this->assertSame(['a' => ['b' => ['c' => ['d' => 'f']]]], $cls->toArray());
    }
}
