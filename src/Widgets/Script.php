<?php

namespace Anik\LaravelBackpack\Extension\Widgets;

class Script extends Widget
{
    public function src(string $src): self
    {
        return $this->addAttribute('src', $src);
    }

    public function content(string $src): self
    {
        return $this->src($src);
    }

    public function stack(string $stack): self
    {
        return $this->addAttribute('stack', $stack);
    }

    public static function create(string $src, ?string $name = null): static
    {
        return with(new static($name, 'script'), function (Script $script) use ($src) {
            return $script->src($src)->stack('after_scripts');
        });
    }
}
