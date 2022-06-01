<?php

namespace Anik\LaravelBackpack\Extension\Buttons;

class ModelFunctionButton extends Button
{
    protected function setupDefaults()
    {
        $this->setType('model_function');
    }

    public function setType(string $type): self
    {
        return parent::setType('model_function');
    }

    public function setFunctionName(string $function): self
    {
        return $this->setContent($function);
    }
}
