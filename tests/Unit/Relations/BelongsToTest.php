<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Relations;

use Anik\LaravelBackpack\Extension\Relations\BelongsTo;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class BelongsToTest extends TestCase
{
    public function test_belongs_to_has_default_type_select()
    {
        $relation = BelongsTo::create('user');

        $this->assertSame('select', $relation->type());
    }
}
