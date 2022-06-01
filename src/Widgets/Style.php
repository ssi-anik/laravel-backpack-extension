<?php

namespace Anik\LaravelBackpack\Extension\Widgets;

class Style extends Widget
{
    public function setRel(string $rel): self
    {
        return $this->addAttribute('rel', $rel);
    }

    protected function setHref(string $href): self
    {
        return $this->addAttribute('href', $href);
    }

    public function setStack(string $stack): self
    {
        return $this->addAttribute('stack', $stack);
    }

    public static function create(string $href, ?string $name = null): static
    {
        return with(new static('style', $name), function (Style $style) use ($href) {
            return $style->setHref($href)->setStack('after_styles');
        });
    }
}
