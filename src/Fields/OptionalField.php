<?php

namespace Anik\LaravelBackpack\Extension\Fields;

class OptionalField extends Field
{
    public function required(): self
    {
        return $this;
    }
}
