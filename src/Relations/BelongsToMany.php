<?php

namespace Anik\LaravelBackpack\Extension\Relations;

class BelongsToMany extends Relation
{
    public static function create(string $method, ?string $attribute = null): self
    {
        return new static(type: 'select_multiple', method: $method, attribute: $attribute);
    }
}
