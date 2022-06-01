<?php

namespace Anik\LaravelBackpack\Extension\Widgets;

class Script extends Widget
{
    protected function setSrc(string $src): self
    {
        return $this->addAttribute('src', $src);
    }

    public function setStack(string $stack): self
    {
        return $this->addAttribute('stack', $stack);
    }

    public static function create(string $src, ?string $name = null): static
    {
        return with(new static('script', $name), function (Script $script) use ($src) {
            return $script->setSrc($src)->setStack('after_scripts');
        });
    }
}
