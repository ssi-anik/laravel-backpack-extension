<?php

namespace Anik\LaravelBackpack\Extension\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Widget extends Arrayable
{
    public function isHidden(): bool;

    public function isFirst(): bool;

    public function isLast(): bool;
}
