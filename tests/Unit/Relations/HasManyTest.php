<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Relations;

use Anik\LaravelBackpack\Extension\Relations\BelongsToMany;
use Anik\LaravelBackpack\Extension\Relations\HasMany;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class HasManyTest extends TestCase
{
    public function test_has_many_has_default_type_select_multiple()
    {
        $relation = HasMany::create('user');

        $this->assertSame('select_multiple', $relation->type());
    }
}
