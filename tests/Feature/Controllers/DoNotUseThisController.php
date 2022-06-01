<?php

namespace Anik\LaravelBackpack\Extension\Test\Feature\Controllers;

use Anik\LaravelBackpack\Extension\Buttons\Button;
use Anik\LaravelBackpack\Extension\Buttons\ModelFunctionButton;
use Anik\LaravelBackpack\Extension\Buttons\ViewButton;
use Anik\LaravelBackpack\Extension\Columns\Column;
use Anik\LaravelBackpack\Extension\Controllers\CrudController;
use Anik\LaravelBackpack\Extension\Fields\Field;
use Anik\LaravelBackpack\Extension\Fields\OptionalField;
use Anik\LaravelBackpack\Extension\Filters\AjaxFilter;
use Anik\LaravelBackpack\Extension\Filters\Filter;
use Anik\LaravelBackpack\Extension\Widgets\Script;
use Anik\LaravelBackpack\Extension\Widgets\Style;
use Anik\LaravelBackpack\Extension\Widgets\Widget;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class DoNotUseThisController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(
            (new class extends User {
                use CrudTrait;
            })::class
        );
    }

    public function setupRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/buttons', [
            'uses' => $controller . '@buttons',
            'operation' => 'list',
        ]);

        Route::get($segment . '/columns', [
            'uses' => $controller . '@columns',
            'operation' => 'list',
        ]);

        Route::get($segment . '/fields', [
            'uses' => $controller . '@fields',
            'operation' => 'list',
        ]);

        Route::get($segment . '/filters', [
            'uses' => $controller . '@filters',
            'operation' => 'list',
        ]);

        Route::get($segment . '/widgets', [
            'uses' => $controller . '@widgets',
            'operation' => 'list',
        ]);
    }

    protected function response(bool $success, array $messages): Response
    {
        return response()->json(['success' => $success, 'messages' => $messages], $success ? 200 : 400);
    }

    public function buttons(): Response
    {
        $success = true;
        $messages = [];

        $buttons = [
            Button::create('top_second')->onTop(),
            Button::create('top_first')->onTop()->beginning(),
            ModelFunctionButton::create('line_first')->inLine(),
            ViewButton::create('line_end')->inLine()->end(),
            ViewButton::create('bottom_first')->onBottom(),
            [],
        ];

        $this->registerButtons($buttons);

        $bottom = $this->crud->buttons()->where('stack', 'bottom');
        $top = $this->crud->buttons()->where('stack', 'top');
        $line = $this->crud->buttons()->where('stack', 'line');
        if (2 !== $top->count() || 2 !== $line->count() || 1 !== $bottom->count()) {
            $messages[] = 'Count mismatch.';
            $success = false;
        }

        // Top first because it's pushed "FIRST" using method
        if ($top->first()->content !== 'top_first') {
            $messages[] = 'Top button is not place correctly in first position.';
            $success = false;
        }

        if ($line->first()->type !== 'model_function') {
            $messages[] = 'Button type (model_function) is not set correctly.';
            $success = false;
        }

        if ($line->last()->type !== 'view') {
            $messages[] = 'Button type (view) is not set correctly.';
            $success = false;
        }

        return $this->response($success, $messages);
    }

    public function columns(): Response
    {
        $messages = [];
        $success = true;
        $columns = [
            Column::ID()->orderable(),
            Column::create('name', 'User name')->searchable()->setPrefix('prefix'),
            Column::create('email')->searchable()->setType('select'),
            [],
        ];
        $this->registerColumns($columns);

        $columns = $this->crud->columns();
        if (count($columns) !== 3) {
            $success = false;
            $messages[] = 'Registered column count mismatch.';
        }

        if (count(array_filter($columns, fn($column) => $column['orderable'] === true)) !== 1) {
            $success = false;
            $messages[] = 'Orderable count mismatch.';
        }

        if (count(array_filter($columns, fn($column) => $column['searchLogic'] === true)) !== 2) {
            $success = false;
            $messages[] = 'SearchLogic count mismatch.';
        }

        if (count(array_filter($columns, fn($column) => $column['type'] === 'select')) !== 1) {
            $success = false;
            $messages[] = 'Type count mismatch.';
        }

        if (count(array_filter($columns, fn($column) => $column['prefix'] ?? false)) !== 1) {
            $success = false;
            $messages[] = 'Prefix count mismatch.';
        }

        if ($columns['name']['label'] !== 'User name') {
            $success = false;
            $messages[] = 'Label is not set correctly.';
        }

        return $this->response($success, $messages);
    }

    public function fields(): Response
    {
        $success = true;
        $messages = [];

        $fields = [
            Field::create('name'),
            Field::create('email', 'Mail')->setPrefix('prefix')->setType('email'),
            OptionalField::create('csrf_token')->hidden(),
            [],
        ];
        $this->registerFields($fields);

        $fields = $this->crud->fields();
        if (count($fields) !== 3) {
            $success = false;
            $messages[] = 'Registered fields count mismatch.';
        }

        if (count(array_filter($fields, fn($field) => $field['attributes']['required'] ?? false)) !== 2) {
            $success = false;
            $messages[] = 'Field (Required) count mismatch.';
        }

        if (count(array_filter($fields, fn($field) => $field['type'] === 'email')) !== 1) {
            $success = false;
            $messages[] = 'setType count mismatch.';
        }

        if (count(array_filter($fields, fn($field) => $field['type'] === 'hidden')) !== 1) {
            $success = false;
            $messages[] = 'Hidden type count mismatch.';
        }

        if (count(array_filter($fields, fn($field) => $field['prefix'] ?? false)) !== 1) {
            $success = false;
            $messages[] = 'Prefix count mismatch';
        }

        if ($fields['email']['label'] !== 'Mail') {
            $success = false;
            $messages[] = 'Label is not set correctly.';
        }

        return $this->response($success, $messages);
    }

    public function filters(): Response
    {
        $success = true;
        $messages = [];
        if (!backpack_pro()) {
            return response()->json(['success' => $success, 'messages' => $messages], $success ? 200 : 400);
        }

        $filters = [
            Filter::create('account_id', 'Account')->setValues([1, 2, 3])->setViewNamespace('crud::test'),
            AjaxFilter::create('user_id', 'User', 'http://127.0.0.1/users/fetch')->setLogic(fn() => null),
            Filter::create('category_id', 'Category')->setType('range')->setFallbackLogic(fn() => null),
            [],
        ];
        $this->registerFilters($filters);

        $filters = $this->crud->filters();
        if ($filters instanceof Collection) {
            $filters = $filters->toArray();
        }

        if (count($filters) !== 3) {
            $success = false;
            $messages[] = 'Registered filters count mismatch.';
        }

        if (count(array_filter($filters, fn($filter) => $filter->logic ?? null)) !== 1) {
            $success = false;
            $messages[] = 'Filter logic count mismatch.';
        }

        if (count(array_filter($filters, fn($filter) => $filter->fallbackLogic ?? null)) !== 1) {
            $success = false;
            $messages[] = 'Filter fallback logic count mismatch.';
        }

        if (count(array_filter($filters, fn($filter) => $filter->type === 'range')) !== 1) {
            $success = false;
            $messages[] = 'Filter type count mismatch.';
        }

        if (count(array_filter($filters, fn($filter) => $filter->viewNamespace === 'crud::test')) !== 1) {
            $success = false;
            $messages[] = 'Filter view namespace count mismatch.';
        }

        if (count(array_filter($filters, fn($filter) => $filter->values ?? null)) !== 2) {
            $success = false;
            $messages[] = 'Filter values count mismatch.';
        }

        return $this->response($success, $messages);
    }

    public function widgets(): Response
    {
        $success = true;
        $messages = [];

        $widgets = [
            Style::create('assets/icons/favicon.ico')->setRel('icon'),
            Script::create('assets/scripts/common.js')->shouldBeFirst(),
            (new Widget(name: 'widget_name'))->setSection('after_breadcrumbs')->shouldBeLast(),
            [],
        ];
        $this->registerWidgets($widgets);

        $widgets = app('widgets');

        if ($widgets->count() !== 3) {
            $success = false;
            $messages[] = 'Registered filters count mismatch.';
        }

        if ($widgets->first()->get('type') !== 'script') {
            $success = false;
            $messages[] = 'Should be first doe not get considered.';
        }

        if ($widgets->last()->get('name') !== 'widget_name') {
            $success = false;
            $messages[] = 'Should be last doe not get considered.';
        }

        if ($widgets->where('type', 'style')->count() !== 1) {
            $success = false;
            $messages[] = 'Style type widget count mismatch.';
        }

        if ($widgets->where('type', 'script')->count() !== 1) {
            $success = false;
            $messages[] = 'Script type widget count mismatch.';
        }

        if ($widgets->where('name', 'widget_name')->count() !== 1) {
            $success = false;
            $messages[] = 'Widget name count mismatch.';
        }

        if ($widgets->where('section', 'after_breadcrumbs')->count() !== 1) {
            $success = false;
            $messages[] = 'Widget section count mismatch.';
        }

        if ($widgets->where('rel', 'icon')->count() !== 1) {
            $success = false;
            $messages[] = 'Style widget rel count mismatch.';
        }

        return $this->response($success, $messages);
    }
}
