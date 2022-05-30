<?php

namespace App\Extensions;

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

    public function setView(string $view): self
    {
        return $this->setContent($view);
    }
}
