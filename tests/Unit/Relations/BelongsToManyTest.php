<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Relations;

use Anik\LaravelBackpack\Extension\Relations\BelongsToMany;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class BelongsToManyTest extends TestCase
{
    public function test_belongs_to_many_has_default_type_select_multiple()
    {
        $relation = BelongsToMany::create('user');

        $this->assertSame('select_multiple', $relation->type());
    }
}
