<?php

namespace Anik\LaravelBackpack\Extension\Extensions;

trait Attributable
{
    protected array $attributes = [];

    public function addAttribute(string $key, mixed $value, bool $mergeRecursive = false): self
    {
        $this->attributes = call_user_func_array(
            $mergeRecursive ? 'array_merge_recursive' : 'array_merge',
            [$this->attributes, [$key => $value]]
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
        unset($this->attributes[$key]);

        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
