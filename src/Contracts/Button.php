<?php

namespace Anik\LaravelBackpack\Extension\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Button extends Arrayable
{
    public function replaceExisting(): bool;

    public function isFirst(): bool;

    public function isLast(): bool;
}
