<?php

namespace Anik\LaravelBackpack\Extension\Contracts;

use Closure;

interface ProvidesValue
{
    public function valueResolver(): ?Closure;
}
