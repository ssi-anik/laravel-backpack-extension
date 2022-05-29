<?php

namespace Anik\LaravelBackpack\Extension\Filters;

class AjaxFilter extends Filter
{
    public static function create(
        string $name,
        ?string $label = null,
        ?string $url = null,
        ?string $method = null
    ): self {
        return with(
            new static($name, $label),
            function (AjaxFilter $instance) use ($url, $method) {
                $url ? $instance->setValues($url) : null;
                $method ? $instance->setMethod($method) : null;

                return $instance;
            }
        );
    }

    protected function setupDefaults(): void
    {
        parent::setupDefaults();

        $this->setType('select2_ajax');
    }

    public function setMinimumInputLength(int $length): self
    {
        return $this->addAttribute('minimum_input_length', $length);
    }

    public function setSelectKey(string $key): self
    {
        return $this->addAttribute('select_key', $key);
    }

    public function setSelectAttribute(string $attribute): self
    {
        return $this->addAttribute('select_attribute', $attribute);
    }

    public function setMethod(string $method): self
    {
        return $this->addAttribute('method', $method);
    }

    public function setQuietTime(int $time): self
    {
        return $this->addAttribute('quiet_time', $time);
    }
}
