<?php

namespace Anik\LaravelBackpack\Extension\Contracts;

interface Relation
{
    public function type(): string;

    public function method(): string;

    public function attribute(): ?string;
}
