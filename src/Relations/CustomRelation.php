<?php

namespace Anik\LaravelBackpack\Extension\Relations;

use Anik\LaravelBackpack\Extension\Contracts\ProvidesAttribute;
use Anik\LaravelBackpack\Extension\Extensions\Attributable;

class CustomRelation extends Relation implements ProvidesAttribute
{
    use Attributable;

    public static function create(string $type, string $method, ?string $attribute = null): self
    {
        return new static(type: $type, method: $method, attribute: $attribute);
    }

    public function attributes(): array
    {
        return $this->toArray();
    }
}
