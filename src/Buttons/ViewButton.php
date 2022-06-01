<?php

namespace Anik\LaravelBackpack\Extension\Buttons;

class ViewButton extends Button
{
    protected function setupDefaults()
    {
        $this->setType('view');
    }

    public function setType(string $type): self
    {
        return parent::setType('view');
    }
}
