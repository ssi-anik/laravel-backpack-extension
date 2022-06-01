<?php

namespace Anik\LaravelBackpack\Extension\Test\Unit\Columns;

use Anik\LaravelBackpack\Extension\Columns\Column;
use Anik\LaravelBackpack\Extension\Relations\CustomRelation;
use Anik\LaravelBackpack\Extension\Relations\HasOne;
use Anik\LaravelBackpack\Extension\Test\TestCase;

class ColumnTest extends TestCase
{
    const NAME = 'name';
    const LABEL = 'label';

    protected function getDefaultAttributes(): array
    {
        return ['name' => self::NAME, 'orderable' => false, 'searchLogic' => false];
    }

    protected function getColumnInstance(...$params): Column
    {
        return new Column(...$params);
    }

    public function getColumnInstanceUsingCreate(...$params): Column
    {
        return Column::create(...$params);
    }

    public function instantiateColumnDataProvider(): array
    {
        return [
            'only name' => [
                self::PARAM => [self::NAME],
                self::EXPECTED => ['name' => self::NAME, 'orderable' => false, 'searchLogic' => false],
            ],
            'name and label' => [
                self::PARAM => [self::NAME, self::LABEL],
                self::EXPECTED => [
                    'name' => self::NAME,
                    'label' => self::LABEL,
                    'orderable' => false,
                    'searchLogic' => false,
                ],
            ],
        ];
    }

    public function columnSetAttributesDataProvider(): array
    {
        $cb = fn() => [];
        $wrapper = ['class' => 'class', 'element' => 'span'];
        $options = ['opt1' => 'opt1', 'opt2' => 'opt2'];
        $simpleRelated = HasOne::create('location');
        $customRelated = CustomRelation::create('text', 'categories', 'name')
                                       ->addAttribute('custom', 'custom')
                                       ->setValueResolver($cb);

        return [
            'can set orderable using orderable' => [
                self::METHODS => ['orderable' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['orderable' => true]),
            ],
            'can set orderable using setOrderable' => [
                self::METHODS => ['setOrderable' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['orderable' => true]),
            ],
            'can set searchLogic using searchable' => [
                self::METHODS => ['searchable' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['searchLogic' => true]),
            ],
            'can set searchLogic using setSearchLogic' => [
                self::METHODS => ['setSearchLogic' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['searchLogic' => true]),
            ],
            'can set searchLogic using setSearchLogic with callback' => [
                self::METHODS => ['setSearchLogic' => [$cb]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['searchLogic' => $cb]),
            ],
            'can set key' => [
                self::METHODS => ['setKey' => ['key']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['key' => 'key']),
            ],
            'can set type' => [
                self::METHODS => ['setType' => ['boolean']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['type' => 'boolean']),
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
            'can set priority' => [
                self::METHODS => ['setPriority' => [10]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['priority' => 10]),
            ],
            'can set escaped' => [
                self::METHODS => ['setEscaped' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['escaped' => true]),
            ],
            'can set escaped with should not escape method' => [
                self::METHODS => ['shouldNotEscape' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['escaped' => false]),
            ],
            'can set value' => [
                self::METHODS => ['setValue' => [$cb]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['value' => $cb]),
            ],
            'can set limit' => [
                self::METHODS => ['setLimit' => [60]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['limit' => 60]),
            ],
            'can set default' => [
                self::METHODS => ['setDefault' => ['default']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['default' => 'default']),
            ],
            'can set prefix' => [
                self::METHODS => ['setPrefix' => ['prefix']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['prefix' => 'prefix']),
            ],
            'can set suffix' => [
                self::METHODS => ['setSuffix' => ['suffix']],
                self::EXPECTED => $this->mergeAttributesWithDefault(['suffix' => 'suffix']),
            ],
            'can set wrapper' => [
                self::METHODS => ['setWrapper' => [$wrapper]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['wrapper' => $wrapper]),
            ],
            'can set options' => [
                self::METHODS => ['setOptions' => [$options]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['options' => $options]),
            ],
            'can set export only field' => [
                self::METHODS => ['isExportOnlyField' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['exportOnlyField' => true]),
            ],
            'can set if not export only field' => [
                self::METHODS => ['isNotExportOnlyField' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['exportOnlyField' => false]),
            ],
            'can set if visible in table' => [
                self::METHODS => ['shouldBeVisibleInTable' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['visibleInTable' => true]),
            ],
            'can set if not visible in table' => [
                self::METHODS => ['shouldNotBeVisibleInTable' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['visibleInTable' => false]),
            ],
            'can set if visible in modal' => [
                self::METHODS => ['shouldBeVisibleInModal' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['visibleInModal' => true]),
            ],
            'can set if not visible in modal' => [
                self::METHODS => ['shouldNotBeVisibleInModal' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['visibleInModal' => false]),
            ],
            'can set table column' => [
                self::METHODS => ['setTableColumn' => [true]],
                self::EXPECTED => $this->mergeAttributesWithDefault(['tableColumn' => true]),
            ],
            'can set table column using isTableColumn' => [
                self::METHODS => ['isTableColumn' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['tableColumn' => true]),
            ],
            'can set table column using isNotTableColumn' => [
                self::METHODS => ['isNotTableColumn' => []],
                self::EXPECTED => $this->mergeAttributesWithDefault(['tableColumn' => false]),
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
            'can set all values at once' => [
                self::METHODS => [
                    'orderable' => [],
                    'setSearchLogic' => [$cb],
                    'setKey' => ['key'],
                    'setType' => ['boolean'],
                    'setEntity' => [false],
                    'setAttribute' => ['name'],
                    'setModel' => ['App\\Product'],
                    'setPriority' => [10],
                    'shouldNotEscape' => [],
                    'setLimit' => [60],
                    'setDefault' => ['default'],
                    'setPrefix' => ['prefix'],
                    'setSuffix' => ['suffix'],
                    'setWrapper' => [$wrapper],
                    'setOptions' => [$options],
                    'isExportOnlyField' => [],
                    'shouldBeVisibleInTable' => [],
                    'shouldBeVisibleInModal' => [],
                    'setTableColumn' => [true],
                    'related' => [$customRelated],
                ],
                self::EXPECTED => $this->mergeAttributesWithDefault(
                    [
                        'orderable' => true,
                        'searchLogic' => $cb,
                        'key' => 'key',
                        'type' => 'boolean',
                        'entity' => false,
                        'attribute' => 'name',
                        'model' => 'App\\Product',
                        'priority' => 10,
                        'escaped' => false,
                        'limit' => 60,
                        'default' => 'default',
                        'prefix' => 'prefix',
                        'suffix' => 'suffix',
                        'wrapper' => $wrapper,
                        'options' => $options,
                        'exportOnlyField' => true,
                        'visibleInTable' => true,
                        'visibleInModal' => true,
                        'tableColumn' => true,
                        'type' => $customRelated->type(),
                        'entity' => $customRelated->method(),
                        'attribute' => $customRelated->attribute(),
                        'custom' => 'custom',
                        'value' => $cb,
                    ]
                ),
            ],
        ];
    }

    /** @dataProvider instantiateColumnDataProvider */
    public function test_column_instantiation_using_constructor($param, $expected)
    {
        $column = $this->getColumnInstance(...$param);
        $this->assertEquals($expected, $column->toArray());
    }

    /** @dataProvider instantiateColumnDataProvider */
    public function test_column_instantiation_using_create_method($param, $expected)
    {
        $column = $this->getColumnInstanceUsingCreate(...$param);
        $this->assertSame($expected, $column->toArray());
    }

    public function test_column_instantiation_using_id_method()
    {
        $column = Column::ID();
        $this->assertSame(
            ['name' => 'id', 'label' => '#', 'orderable' => false, 'searchLogic' => false],
            $column->toArray()
        );

        $column = Column::ID('LABEL');
        $this->assertSame(
            ['name' => 'id', 'label' => 'LABEL', 'orderable' => false, 'searchLogic' => false],
            $column->toArray()
        );
    }

    /** @dataProvider columnSetAttributesDataProvider */
    public function test_column_instance_can_modify_attributes($methods, $expected)
    {
        $column = $this->getColumnInstanceUsingCreate(self::NAME);
        $this->modifyAttributesUsingMethods($column, $methods);
        $this->assertSame($expected, $column->toArray());
    }
}
