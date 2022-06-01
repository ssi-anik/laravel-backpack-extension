<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Fields;

use Anik\LaravelBackpack\Extension\Fields\Field;
use Anik\LaravelBackpack\Extension\Relations\CustomRelation;
use Anik\LaravelBackpack\Extension\Relations\HasOne;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class FieldTest extends TestCase
{
    const NAME = 'name';
    const LABEL = 'label';

    protected function getDefaultAttributes(): array
    {
        return ['name' => self::NAME, 'attributes' => ['required' => 'required']];
    }

    protected function getFieldInstance(...$params): Field
    {
        return new Field(...$params);
    }

    public function getFieldInstanceUsingCreate(...$params): Field
    {
        return Field::create(...$params);
    }

    public function instantiateFieldDataProvider(): array
    {
        return [
            'only name' => [
                self::PARAM => [self::NAME],
                self::EXPECTED => ['name' => self::NAME, 'attributes' => ['required' => 'required']],
            ],
            'name and label' => [
                self::PARAM => [self::NAME, self::LABEL],
                self::EXPECTED => [
                    'name' => self::NAME,
                    'label' => self::LABEL,
                    'attributes' => ['required' => 'required'],
                ],
            ],
        ];
    }

    public function fieldSetAttributesDataProvider(): array
    {
        $cb = fn() => [];
        $wrapper = ['class' => 'class', 'element' => 'span'];
        $options = ['opt1' => 'opt1', 'opt2' => 'opt2'];
        $simpleRelated = HasOne::create('location');
        $customRelated = CustomRelation::create('text', 'categories', 'name')
                                       ->addAttribute('custom', 'custom')
                                       ->setValueResolver($cb);

        return [
            'can remove required attribute with optional method' => [
                self::METHODS => ['optional' => []],
                self::EXPECTED => ['name' => self::NAME, 'attributes' => []],
            ],
            'can set type' => [
                self::METHODS => ['setType' => ['text']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'text']),
            ],
            'can set related' => [
                self::METHODS => ['related' => [$simpleRelated]],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    [
                        'type' => $simpleRelated->type(),
                        'entity' => $simpleRelated->method(),
                    ]
                ),
            ],
            'can set related with complex related' => [
                self::METHODS => ['related' => [$customRelated]],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    [
                        'type' => $customRelated->type(),
                        'entity' => $customRelated->method(),
                        'attribute' => $customRelated->attribute(),
                        'custom' => 'custom',
                        'value' => $cb,
                    ]
                ),
            ],
            'can set relation type' => [
                self::METHODS => ['setRelationType' => ['user']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['relation_type' => 'user']),
            ],
            'can set entity with string' => [
                self::METHODS => ['setEntity' => ['categories']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['entity' => 'categories']),
            ],
            'can set entity boolean' => [
                self::METHODS => ['setEntity' => [false]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['entity' => false]),
            ],
            'can set attribute' => [
                self::METHODS => ['setAttribute' => ['name']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['attribute' => 'name']),
            ],
            'can set model' => [
                self::METHODS => ['setModel' => ['App\\Product']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['model' => 'App\\Product']),
            ],
            'can set base model' => [
                self::METHODS => ['setBaseModel' => ['App\\Product']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['baseModel' => 'App\\Product']),
            ],
            'can set showAsterisk using showAsterisk' => [
                self::METHODS => ['showAsterisk' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['showAsterisk' => true]),
            ],
            'can set showAsterisk using setShowAsterisk' => [
                self::METHODS => ['setShowAsterisk' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['showAsterisk' => true]),
            ],
            'can set allow multiple using allowsMultiple' => [
                self::METHODS => ['allowsMultiple' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['allows_multiple' => true]),
            ],
            'can set allow multiple using setMultiple' => [
                self::METHODS => ['setMultiple' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['allows_multiple' => true]),
            ],
            'can set pivot' => [
                self::METHODS => ['setPivot' => ['pivot']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['pivot' => 'pivot']),
            ],
            'can set subfields' => [
                self::METHODS => ['setSubfields' => [['field' => 'value']]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['subfields' => ['field' => 'value']]),
            ],
            'can set parentFieldName' => [
                self::METHODS => ['setParentFieldName' => ['user']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['parentFieldName' => 'user']),
            ],
            'can set prefix' => [
                self::METHODS => ['setPrefix' => ['prefix']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['prefix' => 'prefix']),
            ],
            'can set suffix' => [
                self::METHODS => ['setSuffix' => ['suffix']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['suffix' => 'suffix']),
            ],
            'can set default' => [
                self::METHODS => ['setDefault' => ['default']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['default' => 'default']),
            ],
            'can set value' => [
                self::METHODS => ['setValue' => [$cb]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['value' => $cb]),
            ],
            'can set value with string' => [
                self::METHODS => ['setValue' => ['value']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['value' => 'value']),
            ],
            'can set hint' => [
                self::METHODS => ['setHint' => ['hint']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['hint' => 'hint']),
            ],
            'can set inline' => [
                self::METHODS => ['setInline' => ['inline']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['inline' => 'inline']),
            ],
            'can set hidden' => [
                self::METHODS => ['hidden' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'hidden']),
            ],
            'can set checkbox' => [
                self::METHODS => ['checkbox' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'checkbox']),
            ],
            'can set radio' => [
                self::METHODS => ['radio' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'radio']),
            ],
            'can set number' => [
                self::METHODS => ['number' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'number']),
            ],
            'can set password' => [
                self::METHODS => ['password' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'password']),
            ],
            'can set placeholder' => [
                self::METHODS => ['setPlaceholder' => ['placeholder']],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    ['attributes' => ['placeholder' => 'placeholder']],
                    true
                ),
            ],
            'can set readonly' => [
                self::METHODS => ['isReadOnly' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['attributes' => ['readonly' => 'readonly']], true),
            ],
            'can set disabled' => [
                self::METHODS => ['isDisabled' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['attributes' => ['disabled' => 'disabled']], true),
            ],
            'can set class' => [
                self::METHODS => ['setClass' => ['col-md-12']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['attributes' => ['class' => 'col-md-12']], true),
            ],
            'can set custom additional attributes' => [
                self::METHODS => ['setAttributes' => [['range' => 10]]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['attributes' => ['range' => 10]], true),
            ],
            'can set wrapper' => [
                self::METHODS => ['setWrapper' => [$wrapper]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['wrapper' => $wrapper]),
            ],
            'can set fake' => [
                self::METHODS => ['setFake' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['fake' => true]),
            ],
            'can set stores_in' => [
                self::METHODS => ['setStoresIn' => ['employees']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['stores_in' => 'employees']),
            ],
            'can set options' => [
                self::METHODS => ['setOptions' => [$options]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['options' => $options]),
            ],
            'can set allow null using allowsNull' => [
                self::METHODS => ['allowsNull' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['allows_null' => true]),
            ],
            'can set allow null using setAllowsNull' => [
                self::METHODS => ['setAllowsNull' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['allows_null' => true]),
            ],
            'can set tab' => [
                self::METHODS => ['setTab' => ['tab-1']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['tab' => 'tab-1']),
            ],
            'can set all values at once' => [
                self::METHODS => [
                    'related' => [$customRelated],
                    'setRelationType' => ['user'],
                    'setModel' => ['App\\Product'],
                    'setBaseModel' => ['App\\Product'],
                    'showAsterisk' => [],
                    'allowsMultiple' => [],
                    'setPivot' => ['pivot'],
                    'setSubfields' => [['field' => 'value']],
                    'setParentFieldName' => ['user'],
                    'setPrefix' => ['prefix'],
                    'setSuffix' => ['suffix'],
                    'setDefault' => ['default'],
                    'setHint' => ['hint'],
                    'setInline' => ['inline'],
                    'setPlaceholder' => ['placeholder'],
                    'isReadOnly' => [],
                    'isDisabled' => [],
                    'setClass' => ['col-md-12'],
                    'setAttributes' => [['range' => 10], true],
                    'setWrapper' => [$wrapper],
                    'setFake' => [true],
                    'setStoresIn' => ['employees'],
                    'setOptions' => [$options],
                    'allowsNull' => [],
                    'setTab' => ['tab-1'],
                ],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    [
                        'type' => $customRelated->type(),
                        'entity' => $customRelated->method(),
                        'attribute' => $customRelated->attribute(),
                        'custom' => 'custom',
                        'value' => $cb,
                        'relation_type' => 'user',
                        'model' => 'App\\Product',
                        'baseModel' => 'App\\Product',
                        'showAsterisk' => true,
                        'allows_multiple' => true,
                        'pivot' => 'pivot',
                        'subfields' => ['field' => 'value'],
                        'parentFieldName' => 'user',
                        'prefix' => 'prefix',
                        'suffix' => 'suffix',
                        'default' => 'default',
                        'hint' => 'hint',
                        'inline' => 'inline',
                        'attributes' => [
                            'placeholder' => 'placeholder',
                            'readonly' => 'readonly',
                            'disabled' => 'disabled',
                            'class' => 'col-md-12',
                            'range' => 10,
                        ],
                        'wrapper' => $wrapper,
                        'fake' => true,
                        'stores_in' => 'employees',
                        'options' => $options,
                        'allows_null' => true,
                        'tab' => 'tab-1',
                    ],
                    true
                ),
            ],
        ];
    }

    /** @dataProvider instantiateFieldDataProvider */
    public function test_field_instantiation_using_constructor($param, $expected)
    {
        $field = $this->getFieldInstance(...$param);
        $this->assertEquals($expected, $field->toArray());
    }

    /** @dataProvider instantiateFieldDataProvider */
    public function test_field_instantiation_using_create_method($param, $expected)
    {
        $field = $this->getFieldInstanceUsingCreate(...$param);
        $this->assertSame($expected, $field->toArray());
    }

    /** @dataProvider fieldSetAttributesDataProvider */
    public function test_field_instance_can_modify_attributes($methods, $expected)
    {
        $field = $this->getFieldInstanceUsingCreate(self::NAME);
        $this->modifyAttributesUsingMethods($field, $methods);
        $this->assertSame($expected, $field->toArray());
    }
}
