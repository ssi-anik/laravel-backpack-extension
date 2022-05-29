<?php

namespace Anik\LaravelBackpack\Extension\Widgets;

class Style extends Widget
{
    public function rel(string $rel): self
    {
        return $this->addAttribute('rel', $rel);
    }

    public function href(string $href): self
    {
        return $this->addAttribute('href', $href);
    }

    public function content(string $content): self
    {
        return $this->href($content);
    }

    public function stack(string $stack): self
    {
        return $this->addAttribute('stack', $stack);
    }

    public static function create(string $href, ?string $name = null): static
    {
        return with(new static($name, 'style'), function (Style $style) use ($href) {
            return $style->href($href)->stack('after_styles');
        });
    }
}
