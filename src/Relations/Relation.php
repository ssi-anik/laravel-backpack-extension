<?php

namespace Anik\LaravelBackpack\Extension\Relations;

use Anik\LaravelBackpack\Extension\Contracts\ProvidesValue;
use Anik\LaravelBackpack\Extension\Contracts\Relation as RelationContract;
use Closure;

class Relation implements RelationContract, ProvidesValue
{
    protected ?Closure $valueResolver = null;

    public function __construct(protected string $type, protected string $method, protected ?string $attribute = null)
    {
    }

    public function type(): string
    {
        return $this->type;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function attribute(): ?string
    {
        return $this->attribute;
    }

    public function setValueResolver(Closure $resolver): self
    {
        $this->valueResolver = $resolver;

        return $this;
    }

    public function valueResolver(): ?Closure
    {
        return $this->valueResolver;
    }
}
