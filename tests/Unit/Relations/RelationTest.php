<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Relations;

use Anik\LaravelBackpack\Extension\Relations\Relation;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class RelationTest extends TestCase
{
    public function test_relation_class_instantiation_with_minimum_params()
    {
        $relation = new Relation('select', 'users');

        $this->assertSame('select', $relation->type());
        $this->assertSame('users', $relation->method());
        $this->assertNull($relation->attribute());
    }

    public function test_relation_class_instantiation_with_attribute()
    {
        $relation = new Relation('select', 'users', 'email');

        $this->assertSame('select', $relation->type());
        $this->assertSame('users', $relation->method());
        $this->assertSame('email', $relation->attribute());
    }

    public function test_relation_class_can_provide_value_resolver()
    {
        $relation = new Relation('select', 'users');
        $this->assertNull($relation->valueResolver());

        $relation->setValueResolver($cb = fn() => []);
        $this->assertSame($cb, $relation->valueResolver());
    }
}
