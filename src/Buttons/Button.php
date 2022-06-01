<?php

namespace Anik\LaravelBackpack\Extension\Buttons;

use Anik\LaravelBackpack\Extension\Contracts\Button as ButtonContract;
use Anik\LaravelBackpack\Extension\Extensions\Attributable;

class Button implements ButtonContract
{
    use Attributable;

    protected bool $isFirst = false;
    protected bool $isLast = false;

    public function __construct(string $content, ?string $name = null, ?string $type = null)
    {
        $this->setContent($content);

        if (!is_null($name)) {
            $this->setName($name);
        }

        if (!is_null($type)) {
            $this->setType($type);
        }

        $this->setupDefaults();
    }

    protected function setupDefaults()
    {
    }

    public function setContent(string $content): self
    {
        return $this->addAttribute('content', $content);
    }

    public function setName(string $name): self
    {
        return $this->addAttribute('name', $name);
    }

    public function setType(string $type): self
    {
        return $this->addAttribute('type', $type);
    }

    public function setStack(string $stack): self
    {
        return $this->addAttribute('stack', $stack);
    }

    public function inLine(): self
    {
        return $this->setStack('line');
    }

    public function onTop(): self
    {
        return $this->setStack('top');
    }

    public function onBottom(): self
    {
        return $this->setStack('bottom');
    }

    public function setPosition(string $position): self
    {
        return $this->addAttribute('position', $position);
    }

    public function beginning(): self
    {
        return $this->setPosition('beginning');
    }

    public function end(): self
    {
        return $this->setPosition('end');
    }

    public function shouldBeFirst(): self
    {
        $this->isFirst = true;

        return $this;
    }

    public function isFirst(): bool
    {
        return $this->isFirst;
    }

    public function shouldBeLast(): self
    {
        $this->isLast = true;

        return $this;
    }

    public function isLast(): bool
    {
        return $this->isLast;
    }

    public static function create(string $content, ?string $name = null): static
    {
        return new static($content, $name);
    }
}
