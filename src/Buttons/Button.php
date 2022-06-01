<?php

namespace Anik\LaravelBackpack\Extension\Buttons;

use Anik\LaravelBackpack\Extension\Contracts\Button as ButtonContract;
use Anik\LaravelBackpack\Extension\Extensions\Attributable;

class Button implements ButtonContract
{
    use Attributable;

    protected bool $shouldReplace = true;

    public function __construct(string $content, ?string $name = null, ?string $type = null)
    {
        $this->addAttribute('content', $content);

        if (!is_null($name)) {
            $this->addAttribute('name', $name);
        }

        if (!is_null($type)) {
            $this->setType($type);
        }

        $this->setupDefaults();
    }

    protected function setupDefaults()
    {
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

    public function shouldNotReplaceExisting(): self
    {
        $this->shouldReplace = false;

        return $this;
    }

    public function replaceExisting(): bool
    {
        return $this->shouldReplace;
    }

    public static function create(string $content, ?string $name = null): static
    {
        return new static($content, $name);
    }
}
