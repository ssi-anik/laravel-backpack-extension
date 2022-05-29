<?php

namespace Anik\LaravelBackpack\Extension\Relations;

class BelongsTo extends Relation
{
    public static function create(string $method, ?string $attribute = null): self
    {
        return new static(type: 'select', method: $method, attribute: $attribute);
    }
}
