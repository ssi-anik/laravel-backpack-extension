<?php

namespace Anik\LaravelBackpack\Extension\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Filter extends Arrayable
{
    public function getValues(): mixed;

    public function getLogic(): ?callable;

    public function getFallbackLogic(): ?callable;
}
