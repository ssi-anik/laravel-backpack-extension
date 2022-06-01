<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Relations;

use Anik\LaravelBackpack\Extension\Relations\CustomRelation;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class CustomRelationTest extends TestCase
{
    public function test_create_method_returns_a_custom_relation()
    {
        $relation = CustomRelation::create('table', 'phones');

        $this->assertSame('table', $relation->type());
        $this->assertSame('phones', $relation->method());
        $this->assertNull($relation->attribute());
    }

    public function test_relation_can_provide_attributes()
    {
        $relation = CustomRelation::create('select', 'users', 'email')->addAttribute('new', 'value');

        $this->assertSame(['new' => 'value'], $relation->attributes());
    }
}
