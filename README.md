anik/laravel-backpack-extension
[![codecov](https://codecov.io/gh/ssi-anik/laravel-backpack-extension/branch/main/graph/badge.svg?token=3TGZ9FUKL6)](https://codecov.io/gh/ssi-anik/laravel-backpack-extension)
[![PHP Version Require](http://poser.pugx.org/anik/laravel-backpack-extension/require/php)](//packagist.org/packages/anik/laravel-backpack-extension)
[![Latest Stable Version](https://poser.pugx.org/anik/laravel-backpack-extension/v)](//packagist.org/packages/anik/laravel-backpack-extension)
===

In the table view of [backpack/crud](https://packagist.org/packages/backpack/crud) list operation, if a column exists in
database table, it's by default
[searchable and orderable](https://github.com/Laravel-Backpack/CRUD/blob/e488a93661220c64259df96665e095b98372f138/src/app/Library/CrudPanel/Traits/Columns.php#L380-L381)
unless instructed otherwise. Also, to add a **column** or **field** to the operation, it is required to pass an array. In PHP,
array keys are case-sensitive and this make it tedious when adding a field or column. This package allows class based
imperative approach over passing the array. So no more tedious, repetitive typing game matching the exact array keys. 
**BE FORGETFUL** sometimes? 🤷

# Documentation

## Installation

To install the package, run
> composer require anik/laravel-backpack-extension

## Usage

### Extending controller

Instead of extending the `\Backpack\CRUD\app\Http\Controllers\CrudController`,
use `\Anik\LaravelBackpack\Extension\Controllers\CrudController` in your controllers.

---

### Adding Column

To instantiate a **Column**

- `new \Anik\LaravelBackpack\Extension\Columns\Column(string $name, [?string $label = null])`
- `\Anik\LaravelBackpack\Extension\Columns\Column::create(string $name, [?string $label = null])`
- `\Anik\LaravelBackpack\Extension\Columns\Column::ID([?string $label = null], [?string $name = null])` - To create an
  ID type column

To add the column(s) from the controller

- For a single column, `$this->registerColumn($column)`
- For multiple columns, `$this->registerColumns($columns)`

By default, all Column instances are **not orderable** and **not searchable**.

#### Example

```php
use Anik\LaravelBackpack\Extension\Columns\Column;
use Anik\LaravelBackpack\Extension\Controllers\CrudController;

class AccountCrudController extends CrudController 
{
    public function setupListOperation () {
        $columns = [
            Column::ID()->orderable(), // Only this column will be orderable
            Column::create('email')->searchable(), // Makes this field searchable
            Column::create('name')->searchable(
                fn ($q, $column, $term) => strlen($term = trim($term)) >= 3 ? $q->where('name', 'LIKE', sprintf('%%%s%%', $term)) : null)
            ), // Also makes this field searchable with custom logic
        ];
        
        $this->registerColumns($columns);
        $this->registerColumn((new Column('is_verified', 'Verified'))->setType('boolean'));
    }
}
```

#### Available methods

- `orderable()` - Make the column orderable
- `setOrderable(bool $orderable)`
- `searchable()` - Make the column searchable
- `setSearchLogic(bool|Closure $logic)` - Make the column searchable with logic or not searchable
- `setKey(string $key)`
- `setType(string $type)` - Set column type
- `setEntity(bool|string $entity)`
- `setAttribute(string $attribute)`
- `setModel(string $model)`
- `setPriority(int $priority)`
- `shouldNotEscape()` - Do not escape the value in the view `{!! $value !!}`
- `setEscaped(bool $escape)`
- `setValue(mixed $value)`
- `setLimit(int $limit)`
- `setDefault(mixed $default)`
- `setPrefix(mixed $prefix)`
- `setSuffix(mixed $prefix)`
- `setWrapper(mixed $wrapper, bool $mergeRecursive = false)`
- `setOptions(mixed $options, bool $mergeRecursive = false)`
- `isExportOnlyField()`
- `isNotExportOnlyField()`
- `shouldBeVisibleInTable()`
- `shouldNotBeVisibleInTable()`
- `shouldBeVisibleInModal()`
- `shouldNotBeVisibleInModal()`
- `isTableColumn()`
- `isNotTableColumn()`
- `setTableColumn(bool $tableColumn)`
- `related(Relation $relation, bool $mergeRecursive = false)` - Check [Relation](#relation) section

Column class uses `\Anik\LaravelBackpack\Extension\Extensions\Attributable` trait.
Check [Attributable](#attributable-trait) section.

---

### Adding Field

To instantiate a **Field**

- `new \Anik\LaravelBackpack\Extension\Fields\Field(string $name, [?string $label = null])`
- `\Anik\LaravelBackpack\Extension\Fields\Field::create(string $name, [?string $label = null])`

Or to create an **OptionalField**

- `new \Anik\LaravelBackpack\Extension\Fields\OptionalField(string $name, [?string $label = null])`
- `\Anik\LaravelBackpack\Extension\Fields\OptionalField::create(string $name, [?string $label = null])`

To add the field(s) from the controller

- For a single field, `$this->registerField($field)`
- For multiple fields, `$this->registerFields($fields)`

By default, all the **Field** instances are **required**.

#### Example

```php
use Anik\LaravelBackpack\Extension\Controllers\CrudController;
use Anik\LaravelBackpack\Extension\Fields\Field;

class AccountCrudController extends CrudController 
{
    public function setupCreateOperation () {
        $fields = [
            Field::create('email')->setType('email'),
            Field::create('is_admin')->checkbox(),
        ];
        
        $this->registerFields($fields);
        $this->registerField((new Field('csrf_token'))->hidden());
    }
}
```

#### Available methods

- `required()` - Make field required
- `optional()` - Make field optional
- `setType(string $type)` - Set field type
- `related(Relation $relation, bool $mergeRecursive = false)` - Check [Relation](#relation) section
- `setRelationType(string $type)`
- `setEntity(bool|string $entity)`
- `setAttribute(mixed $attribute)`
- `setModel(string $model)`
- `setBaseModel(string $baseModel)`
- `showAsterisk()`
- `setShowAsterisk(mixed $value)`
- `allowsMultiple()`
- `setMultiple(mixed $multiple)`
- `setPivot(mixed $pivot)`
- `setSubfields(mixed $subfields)`
- `setParentFieldName(mixed $value)`
- `setPrefix(string $prefix)`
- `setSuffix(string $suffix)`
- `setDefault(mixed $default)`
- `setValue(mixed $value)`
- `setHint(string $hint)`
- `setInline(mixed $inline)`
- `hidden()` - Make hidden type field
- `checkbox()` - Make checkbox type field
- `radio()` - Make radio type field
- `number()` - Make number type field
- `password()` - Make password type field
- `setPlaceholder(string $placeholder)`
- `isReadOnly()` - Make field readonly
- `isDisabled()` - Make field disabled
- `setClass(string $class)` - Set field element css class
- `setAttributes(array $attributes, bool $mergeRecursive = true)` - Add additional attribute for field element
- `setWrapper(mixed $value, bool $mergeRecursive = true)`
- `setFake(bool $fake)`
- `setStoresIn(string $storesIn)`
- `setOptions(mixed $options, bool $mergeRecursive = true)`
- `allowsNull()`
- `setAllowsNull(bool $allowNull)`
- `setTab(string $tab)`

Field class uses `\Anik\LaravelBackpack\Extension\Extensions\Attributable` trait.
Check [Attributable](#attributable-trait) section.

---

### Adding Filter

To instantiate a **Filter**

- `new \Anik\LaravelBackpack\Extension\Filters\Filter(string $name, [?string $label = null])`
- `\Anik\LaravelBackpack\Extension\Filters\Filter::create(string $name, [?string $label = null])`
- `\Anik\LaravelBackpack\Extension\Filters\AjaxFilter::create(string $name, [?string $label = null], [?string $url = null], [?string $method = null])`

To add the filters(s) from the controller

- For a single filter, `$this->registerFilter($filter)`
- For multiple filters, `$this->registerFilters($filters)`

#### Example

```php
use Anik\LaravelBackpack\Extension\Controllers\CrudController;
use Anik\LaravelBackpack\Extension\Filters\Filter;
use Anik\LaravelBackpack\Extension\Filters\AjaxFilter;

class AccountCrudController extends CrudController 
{
    public function setupListOperation () {
        $filters = [
            Filter::create('status')
                ->setValues([1 => 'Draft', 2 => 'Pending', 3 => 'Published',])
                ->setLogic(fn($status) => $this->crud->query->where('status', $status)),
            AjaxFilter::create('user_id'),
        ];
        
        $this->registerFilters($filters);
        $this->registerFilter((new Filter('is_deleted'))->setValues([0, 1]));
    }
}
```

#### Available methods

- `setType(string $type)` - Set filter type
- `setViewNamespace(string $namespace)`
- `setPlaceholder(string $placeholder)`
- `setValues(string|array|callable $values)`
- `setLogic(callable $logic)`
- `setFallbackLogic(callable $fallbackLogic)`

Filter class uses `\Anik\LaravelBackpack\Extension\Extensions\Attributable` trait.
Check [Attributable](#attributable-trait) section.

---

### Adding Widget

To instantiate a **Widget**

- `new \Anik\LaravelBackpack\Extension\Widgets\Widget([?string $type = null], [?string $name = null], [?string $section = null])`
- `\Anik\LaravelBackpack\Extension\Widgets\Script::create(string $src, [?string $name = null])`
- `\Anik\LaravelBackpack\Extension\Widgets\Style::create(string $href, [?string $name = null])`
- `new \Anik\LaravelBackpack\Extension\Widgets\Hidden([?string $type = null], [?string $name = null], [?string $section = null])`

To add the widget(s) from the controller

- For a single widget, `$this->registerWidget($widget)`
- For multiple widgets, `$this->registerWidgets($widgets)`

#### Example

```php
use Anik\LaravelBackpack\Extension\Controllers\CrudController;
use Anik\LaravelBackpack\Extension\Widgets\Script;
use Anik\LaravelBackpack\Extension\Widgets\Style;
use Anik\LaravelBackpack\Extension\Widgets\Widget;

class AccountCrudController extends CrudController 
{
    public function setupListOperation () {
        $widgets = [
            Script::create('assets/js/common.js'),
            Style::create('assets/css/common.css'),
        ];
        
        $this->registerWidgets($widgets);
        $this->registerWidget((new Widget('script'))->setContent('assets/js/another_common.js'));
    }
}
```

#### Available methods

- `setSection(string $section)`
- `setContent(mixed $content)`
- `setViewNamespace(string $namespace)`
- `shouldBeHidden()`
- `shouldBeFirst()`
- `shouldBeLast()`

- `Script::setSrc(string $src)`
- `Script::setStack(string $stack)`

- `Style::setRel(string $rel)`
- `Style::setHref(string $href)`
- `Style::setStack(string $stack)`

Widget class uses `\Anik\LaravelBackpack\Extension\Extensions\Attributable` trait.
Check [Attributable](#attributable-trait) section.

---

### Relation

If a Column or Field points to an Eloquent relationship, then you can
use `Anik\LaravelBackpack\Extension\Relations\Relation`.

To instantiate a **Relation**

- `new \Anik\LaravelBackpack\Extension\Relations\Relation(stirng $type, string $method, [?string $attribute = null])`
- `new \Anik\LaravelBackpack\Extension\Relations\CustomRelation::create(string $type, string $method, [?string $attribute = null])`
- `new \Anik\LaravelBackpack\Extension\Relations\BelongsTo::create(string $method, [?string $attribute = null])`
- `new \Anik\LaravelBackpack\Extension\Relations\HasOne::create(string $method, [?string $attribute = null])`
- `new \Anik\LaravelBackpack\Extension\Relations\BelongsTo::BelongsToMany(string $method, [?string $attribute = null])`
- `new \Anik\LaravelBackpack\Extension\Relations\HasOne::HasMany(string $method, [?string $attribute = null])`

Parameters:

- `$method` - The method name of the relationship in the **eloquent model**.
- `$attribute` - The **field/column/attribute** of the related eloquent model.
- `$type` - Used by backpack to pick the **view** to show the value calculated from the relationship.

The package provides 4 relations out-of-the-box which uses the **type** suggested by Backpack.

- `HasOne`, `BelongsTo` - Type: **select**
- `HasMany`, `BelongsToMany` - Type: **select_multiple**

If you want a customized Relationship, you can use `\Anik\LaravelBackpack\Extension\Relations\CustomRelation`.

#### Example

```php
use Anik\LaravelBackpack\Extension\Columns\Column;
use Anik\LaravelBackpack\Extension\Controllers\CrudController;
use Anik\LaravelBackpack\Extension\Fields\Field;
use Anik\LaravelBackpack\Extension\Relations\BelongsTo;
use Anik\LaravelBackpack\Extension\Relations\HasMany;

class AccountCrudController extends CrudController 
{
    public function setupListOperation () {
        $columns = [
            // Other columns
            Column::create('phone')->related(HasMany::create('phones', 'number')),
        ];
        
        $this->registerColumns($columns);
    }
    
    public function setupCreateOperation() {
        $fields = [
            // Other fields
            Field::create('country_id', 'Country')->related(BelongsTo::create('country', 'name')),
        ];
        
        $this->registerFields($fields);
    }
}
```

#### Available methods

- `setValueResolver(Closure $resolver)` - Set a closure which will be responsible to calculate the value for
  field/column

Only **CustomRelation** class uses `\Anik\LaravelBackpack\Extension\Extensions\Attributable` trait.
Check [Attributable](#attributable-trait) section.

---

### Attributable trait

The **Attributable** trait allows classes to save and retrieve attributes in array format. Classes that use the trait
will have access to the following methods.

- `addAttribute(string $key, mixed $value, bool $mergeRecursive = false)`
- `addAttributes(array $attributes, bool $mergeRecursive = false)`
- `unset(string $key)`
- `toArray(): array`

- `$mergeRecursive` indicates to if merge should be done using **array_merge** vs **array_merge_recursive**.
- `addAttribute`, `addAttributes`, `unset` methods allows **dot notation** based keys when **adding** or **unset**ting values.
#### Example

```php

use Anik\LaravelBackpack\Extension\Fields\Field;

$field = Field::create('name');

$field->addAttribute('attributes.readonly', 'readonly'); // ['attributes' => ['readonly' => 'readonly']]
// $field->addAttribute('attributes.disabled', 'disabled');  // w/o the parameter [mergeRecursive: true] -> ['attributes' => ['disabled' => 'disabled']]
$field->addAttribute('attributes.disabled', 'disabled', true);  // ['attributes' => ['readonly' => 'readonly', 'disabled' => 'disabled']]
$field->addAttributes(['wrapper.class' => 'col-md-12'], true);

$field->addAttributes(['wrapper' => ['another' => ['key' => 'value']]], true);
// $field->addAttributes(['wrapper.another.key' => 'value'], true); // Alternative implementation of the above line
/**
 * STRUCTURE: $field->toArray();
 * 
 * [
 *      'attributes' => [
 *          'readonly' => 'readonly', 
 *          'disabled' => 'disabled'
 *      ], 
 *      'wrapper' => [
 *          'class' => 'col-md-12',
 *          'another' => [
 *              'key' => 'value'
 *          ]
 *      ]
 * ]
 */

$field->unset('wrapper.another'); 
/**
 * STRUCTURE: $field->toArray();
 * 
 * [
 *      'attributes' => [
 *          'readonly' => 'readonly', 
 *          'disabled' => 'disabled'
 *      ], 
 *      'wrapper' => [
 *          'class' => 'col-md-12'
 *      ]
 * ]
 */
```
