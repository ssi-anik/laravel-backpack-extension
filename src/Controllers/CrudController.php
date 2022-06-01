<?php

namespace Anik\LaravelBackpack\Extension\Controllers;

use Anik\LaravelBackpack\Extension\Contracts\Button;
use Anik\LaravelBackpack\Extension\Contracts\Column;
use Anik\LaravelBackpack\Extension\Contracts\Field;
use Anik\LaravelBackpack\Extension\Contracts\Filter;
use Anik\LaravelBackpack\Extension\Contracts\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController as BaseCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudButton;
use Backpack\CRUD\app\Library\Widget as LibraryWidget;

class CrudController extends BaseCrudController
{
    protected function registerColumns(array $columns): void
    {
        foreach ($columns as $column) {
            if (!$column instanceof Column) {
                continue;
            }

            $this->registerColumn($column);
        }
    }

    protected function registerColumn(Column $column): void
    {
        $this->crud->addColumn($column->toArray());
    }

    protected function registerFields(array $fields): void
    {
        foreach ($fields as $field) {
            if (!$field instanceof Field) {
                continue;
            }

            $this->registerField($field);
        }
    }

    protected function registerField(Field $field): void
    {
        $this->crud->addField($field->toArray());
    }

    protected function registerFilters(array $filters): void
    {
        foreach ($filters as $filter) {
            if (!$filter instanceof Filter) {
                continue;
            }

            $this->registerFilter($filter);
        }
    }

    protected function registerFilter(Filter $filter): void
    {
        $this->crud->addFilter(
            $filter->toArray(),
            $filter->getValues(),
            $filter->getLogic(),
            $filter->getFallbackLogic()
        );
    }

    protected function registerButtons(array $buttons): void
    {
        foreach ($buttons as $button) {
            if (!$button instanceof Button) {
                continue;
            }

            $this->registerButton($button);
        }
    }

    protected function registerButton(Button $button): CrudButton
    {
        $data = $button->toArray();

        return $this->crud->addButton(
            $data['stack'] ?? null,
            $data['name'] ?? null,
            $data['type'] ?? null,
            $data['content'] ?? null,
            $data['position'] ?? null,
            $button->replaceExisting()
        );
    }

    protected function registerWidgets(array $widgets): void
    {
        foreach ($widgets as $widget) {
            if (!$widget instanceof Widget) {
                continue;
            }

            $this->registerWidget($widget);
        }
    }

    protected function registerWidget(Widget $widget): void
    {
        $newWidget = call_user_func_array(
            [LibraryWidget::class, $widget->isHidden() ? 'make' : 'add'],
            [$widget->toArray()]
        );

        if ($widget->isFirst()) {
            $newWidget->makeFirst();
        } elseif ($widget->isLast()) {
            $newWidget->makeLast();
        }
    }
}
