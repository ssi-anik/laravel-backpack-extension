<?php

namespace Anik\LaravelBackpack\Extension\Extensions;

use Illuminate\Support\Arr;

trait Attributable
{
    protected array $attributes = [];

    public function addAttribute(string $key, mixed $value, bool $mergeRecursive = false): self
    {
        $attributes = Arr::add([], $key, $value);
        $this->attributes = call_user_func_array(
            $mergeRecursive ? 'array_merge_recursive' : 'array_merge',
            [$this->attributes, $attributes]
        );

        return $this;
    }

    public function addAttributes(array $attributes, bool $mergeRecursive = false): self
    {
        foreach ($attributes as $k => $v) {
            $this->addAttribute($k, $v, $mergeRecursive);
        }

        return $this;
    }

    public function unset(string $key): self
    {
        Arr::forget($this->attributes, $key);

        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
