<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Fields;

use Anik\LaravelBackpack\Extension\Fields\OptionalField;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class OptionalFieldTest extends TestCase
{
    public function test_field_cannot_be_made_required()
    {
        $field = OptionalField::create('name');
        $this->assertArrayNotHasKey('required', $field->toArray()['attributes'] ?? []);

        $field->required();
        $this->assertArrayNotHasKey('required', $field->toArray()['attributes'] ?? []);
    }
}
