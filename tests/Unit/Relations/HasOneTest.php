<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Relations;

use Anik\LaravelBackpack\Extension\Relations\BelongsTo;
use Anik\LaravelBackpack\Extension\Relations\HasOne;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class HasOneTest extends TestCase
{
    public function test_has_one_has_default_type_select()
    {
        $relation = HasOne::create('user');

        $this->assertSame('select', $relation->type());
    }
}
