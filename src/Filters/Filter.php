<?php

namespace Anik\LaravelBackpack\Extension\Filters;

use Anik\LaravelBackpack\Extension\Contracts\Filter as FilterContract;
use Anik\LaravelBackpack\Extension\Extensions\Attributable;

class Filter implements FilterContract
{
    use Attributable;

    protected mixed $values = null;
    protected mixed $logic = null;
    protected mixed $fallbackLogic = null;

    public function __construct(string $name, ?string $label = null)
    {
        $this->addAttribute('name', $name);
        if (!is_null($label)) {
            $this->addAttribute('label', $label);
        }

        $this->setupDefaults();
    }

    protected function setupDefaults(): void
    {
        $this->setType('dropdown');
    }

    public function setType(string $type): self
    {
        return $this->addAttribute('type', $type);
    }

    public function setViewNamespace(string $namespace): self
    {
        return $this->addAttribute('viewNamespace', $namespace);
    }

    public function setPlaceholder(string $placeholder): self
    {
        return $this->addAttribute('placeholder', $placeholder);
    }

    public function setValues(string|array|callable $values): self
    {
        $this->values = $values;

        return $this;
    }

    public function getValues(): mixed
    {
        return $this->values;
    }

    public function setLogic(callable $logic): self
    {
        $this->logic = $logic;

        return $this;
    }

    public function getLogic(): ?callable
    {
        return $this->logic;
    }

    public function setFallbackLogic(callable $fallbackLogic): self
    {
        $this->fallbackLogic = $fallbackLogic;

        return $this;
    }

    public function getFallbackLogic(): ?callable
    {
        return $this->fallbackLogic;
    }

    public static function create(string $name, ?string $label = null): self
    {
        return new static($name, $label);
    }
}
