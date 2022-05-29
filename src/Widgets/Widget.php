<?php

namespace Anik\LaravelBackpack\Extension\Widgets;

use Anik\LaravelBackpack\Extension\Contracts\Widget as WidgetContract;
use Anik\LaravelBackpack\Extension\Extensions\Attributable;

class Widget implements WidgetContract
{
    use Attributable;

    private bool $isHidden = false;
    private bool $makeFirst = false;
    private bool $makeLast = false;

    public function __construct(?string $name = null, ?string $type = null, ?string $section = null)
    {
        if (!is_null($name)) {
            $this->setName($name);
        }

        if (!is_null($type)) {
            $this->setType($type);
        }

        if (!is_null($section)) {
            $this->setSection($section);
        }
    }

    public function setName(string $name): self
    {
        return $this->addAttribute('name', $name);
    }

    public function setType(string $type): self
    {
        return $this->addAttribute('type', $type);
    }

    public function setSection(string $section): self
    {
        return $this->addAttribute('section', $section);
    }

    public function setContent(mixed $content): self
    {
        return $this->addAttribute('content', $content, true);
    }

    public function setViewNamespace(string $namespace): self
    {
        return $this->addAttribute('viewNamespace', $namespace);
    }

    public function shouldBeHidden(): self
    {
        $this->isHidden = true;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    public function shouldBeFirst(): self
    {
        $this->makeFirst = true;

        return $this;
    }

    public function isFirst(): bool
    {
        return $this->makeFirst;
    }

    public function shouldBeLast(): self
    {
        $this->makeLast = true;

        return $this;
    }

    public function isLast(): bool
    {
        return $this->makeLast;
    }
}
