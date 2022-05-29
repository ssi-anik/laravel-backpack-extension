<?php

namespace Anik\LaravelBackpack\Extension\Columns;

use Anik\LaravelBackpack\Extension\Contracts\ProvidesValue;
use Anik\LaravelBackpack\Extension\Contracts\Relation;
use Closure;

class Column
{
    protected array $attributes = [];

    public function __construct(string $name, ?string $label = null)
    {
        $this->addAttribute('name', $name);
        if (!is_null($label)) {
            $this->addAttribute('label', $label);
        }

        $this->setupDefaults();
    }

    protected function setupDefaults(): self
    {
        $this->setOrderable(false);
        $this->setSearchLogic(false);

        return $this;
    }

    public function addAttribute(string $key, mixed $value, bool $mergeRecursive = false): self
    {
        $this->attributes = call_user_func_array(
            $mergeRecursive ? 'array_merge_recursive' : 'array_merge',
            [$this->attributes, [$key => $value]]
        );

        return $this;
    }

    public function addAttributes(array $attributes, bool $mergeRecursive = false): self
    {
        foreach ($attributes as $k => $v) {
            $this->addAttribute($k, $v, $mergeRecursive);
        }

        return $this;
    }

    public function orderable(): self
    {
        return $this->setOrderable(true);
    }

    public function setOrderable(bool $orderable): self
    {
        return $this->addAttribute('orderable', $orderable);
    }

    public function searchable(): self
    {
        return $this->setSearchLogic(true);
    }

    public function setSearchLogic(bool|Closure $logic): self
    {
        return $this->addAttribute('searchLogic', $logic);
    }

    public function setKey(string $key): self
    {
        return $this->addAttribute('key', $key);
    }

    public function setType(string $type): self
    {
        return $this->addAttribute('type', $type);
    }

    public function setEntity(string $entity): self
    {
        return $this->addAttribute('entity', $entity);
    }

    public function setAttribute(string $attribute): self
    {
        return $this->addAttribute('attribute', $attribute);
    }

    public function setModel(string $model): self
    {
        return $this->addAttribute('model', $model);
    }

    public function setPriority(int $priority): self
    {
        return $this->addAttribute('priority', $priority);
    }

    public function shouldNotEscape(): self
    {
        return $this->setEscaped(false);
    }

    public function setEscaped(bool $escape): self
    {
        return $this->addAttribute('escaped', $escape);
    }

    public function setValue(mixed $value): self
    {
        return $this->addAttribute('value', $value);
    }

    public function setLimit(int $limit): self
    {
        return $this->addAttribute('limit', $limit);
    }

    public function setDefault(mixed $default): self
    {
        return $this->addAttribute('default', $default);
    }

    public function setPrefix(mixed $prefix): self
    {
        return $this->addAttribute('prefix', $prefix);
    }

    public function setSuffix(mixed $prefix): self
    {
        return $this->addAttribute('suffix', $prefix);
    }

    public function addWrapper(mixed $wrapper, bool $mergeRecursive = false): self
    {
        return $this->addAttribute('wrapper', $wrapper, $mergeRecursive);
    }

    public function addOptions(mixed $options): self
    {
        return $this->addAttribute('options', $options);
    }

    public function isExportOnlyField(): self
    {
        return $this->addAttribute('exportOnlyField', true);
    }

    public function isNotExportOnlyField(): self
    {
        return $this->addAttribute('exportOnlyField', false);
    }

    public function shouldBeVisibleInTable(): self
    {
        return $this->addAttribute('visibleInTable', true);
    }

    public function shouldNotBeVisibleInTable(): self
    {
        return $this->addAttribute('visibleInTable', false);
    }

    public function shouldBeVisibleInModal(): self
    {
        return $this->addAttribute('visibleInModal', true);
    }

    public function shouldNotBeVisibleInModal(): self
    {
        return $this->addAttribute('visibleInModal', false);
    }

    public function isTableColumn(): self
    {
        return $this->setTableColumn(true);
    }

    public function isNotTableColumn(): self
    {
        return $this->setTableColumn(false);
    }

    public function setTableColumn(bool $tableColumn): self
    {
        return $this->addAttribute('tableColumn', $tableColumn);
    }

    public function related(Relation $relation): self
    {
        $this->setType($relation->type());
        $this->setEntity($relation->method());
        $this->setAttribute($relation->attribute());

        if ($relation instanceof ProvidesValue) {
            $this->setValue($relation->valueResolver());
        }

        return $this;
    }

    public static function ID(?string $label = null): self
    {
        return static::create('id', $label ?? '#');
    }

    public function unset(string $key): self
    {
        unset($this->attributes[$key]);

        return $this;
    }

    public static function create(string $name, ?string $label = null): self
    {
        return new static($name, $label);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}