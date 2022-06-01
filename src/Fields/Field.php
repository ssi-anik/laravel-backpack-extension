<?php

namespace Anik\LaravelBackpack\Extension\Fields;

use Anik\LaravelBackpack\Extension\Contracts\Field as FieldContract;
use Anik\LaravelBackpack\Extension\Contracts\ProvidesAttribute;
use Anik\LaravelBackpack\Extension\Contracts\ProvidesValue;
use Anik\LaravelBackpack\Extension\Contracts\Relation;
use Anik\LaravelBackpack\Extension\Extensions\Attributable;

class Field implements FieldContract
{
    use Attributable;

    public function __construct(string $name, ?string $label = null)
    {
        $this->addAttribute('name', $name);
        if (!is_null($label)) {
            $this->addAttribute('label', $label);
        }

        $this->setupDefaults();
    }

    protected function setupDefaults()
    {
        $this->required();
    }

    public function required(): self
    {
        return $this->setAttributes(['required' => 'required']);
    }

    public function optional(): self
    {
        return $this->unset('attributes.required');
    }

    public function setType(string $type): self
    {
        return $this->addAttribute('type', $type);
    }

    public function related(Relation $relation, bool $mergeRecursive = false): self
    {
        $this->setType($relation->type());
        $this->setEntity($relation->method());

        if (!is_null($attribute = $relation->attribute())) {
            $this->setAttribute($attribute);
        }

        if ($relation instanceof ProvidesAttribute && !empty($attributes = $relation->attributes())) {
            $this->addAttributes($attributes, $mergeRecursive);
        }

        if ($relation instanceof ProvidesValue && !is_null($value = $relation->valueResolver())) {
            $this->setValue($value);
        }

        return $this;
    }

    public function setRelationType(string $type): self
    {
        return $this->addAttribute('relation_type', $type);
    }

    public function setEntity(bool|string $entity): self
    {
        return $this->addAttribute('entity', $entity);
    }

    public function setAttribute(mixed $attribute): self
    {
        return $this->addAttribute('attribute', $attribute);
    }

    public function setModel(string $model): self
    {
        return $this->addAttribute('model', $model);
    }

    public function setBaseModel(string $baseModel): self
    {
        return $this->addAttribute('baseModel', $baseModel);
    }

    public function showAsterisk(): self
    {
        return $this->setShowAsterisk(true);
    }

    public function setShowAsterisk(mixed $value): self
    {
        return $this->addAttribute('showAsterisk', $value);
    }

    public function allowsMultiple(): self
    {
        return $this->setMultiple(true);
    }

    public function setMultiple(mixed $multiple): self
    {
        return $this->addAttribute('allows_multiple', $multiple);
    }

    public function setPivot(mixed $pivot): self
    {
        return $this->addAttribute('pivot', $pivot);
    }

    public function setSubfields(mixed $subfields): self
    {
        return $this->addAttribute('subfields', $subfields);
    }

    public function setParentFieldName(mixed $value): self
    {
        return $this->addAttribute('parentFieldName', $value);
    }

    public function setPrefix(string $prefix): self
    {
        return $this->addAttribute('prefix', $prefix);
    }

    public function setSuffix(string $suffix): self
    {
        return $this->addAttribute('suffix', $suffix);
    }

    public function setDefault(mixed $default): self
    {
        return $this->addAttribute('default', $default);
    }

    public function setValue(mixed $value): self
    {
        return $this->addAttribute('value', $value);
    }

    public function setHint(string $hint): self
    {
        return $this->addAttribute('hint', $hint);
    }

    public function setInline(mixed $inline): self
    {
        return $this->addAttribute('inline', $inline);
    }

    public function hidden(): self
    {
        return $this->setType('hidden');
    }

    public function checkbox(): self
    {
        return $this->setType('checkbox');
    }

    public function radio(): self
    {
        return $this->setType('radio');
    }

    public function number(): self
    {
        return $this->setType('number');
    }

    public function password(): self
    {
        return $this->setType('password');
    }

    public function setPlaceholder(string $placeholder): self
    {
        return $this->setAttributes(['placeholder' => $placeholder]);
    }

    public function isReadOnly(): self
    {
        return $this->setAttributes(['readonly' => 'readonly']);
    }

    public function isDisabled(): self
    {
        return $this->setAttributes(['disabled' => 'disabled']);
    }

    public function setClass(string $class): self
    {
        return $this->setAttributes(['class' => $class]);
    }

    public function setAttributes(array $attributes, bool $mergeRecursive = true): self
    {
        return $this->addAttributes(['attributes' => $attributes], $mergeRecursive);
    }

    public function setWrapper(mixed $value, bool $mergeRecursive = true): self
    {
        return $this->addAttribute('wrapper', $value, $mergeRecursive);
    }

    public function setFake(bool $fake): self
    {
        return $this->addAttribute('fake', $fake);
    }

    public function setStoresIn(string $storesIn): self
    {
        return $this->addAttribute('stores_in', $storesIn);
    }

    public function setOptions(mixed $options, bool $mergeRecursive = true): self
    {
        return $this->addAttribute('options', $options, $mergeRecursive);
    }

    public function allowsNull(): self
    {
        return $this->setAllowsNull(true);
    }

    public function setAllowsNull(bool $allowNull): self
    {
        return $this->addAttribute('allows_null', $allowNull);
    }

    public function setTab(string $tab): self
    {
        return $this->addAttribute('tab', $tab);
    }

    public static function create(string $name, ?string $label = null): self
    {
        return new static($name, $label);
    }
}
