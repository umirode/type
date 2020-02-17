<?php
/**
 * Created by IntelliJ IDEA.
 * User: maksim
 * Date: 2019-07-26
 * Time: 15:26
 */

namespace Umirode\Type\Example;


use Umirode\Type\Type;

/**
 * Class ProductType
 *
 * @package Umirode\Type\Example
 *
 * @method bool isActive()
 * @method bool isInactive()
 * @method bool isTest()
 * @method bool isTest1()
 *
 * @method static ProductType active()
 * @method static ProductType inactive()
 * @method static ProductType test()
 * @method static ProductType test1()
 */
final class ProductType extends Type
{
    /**
     * @return array
     */
    public static function getList(): array
    {
        return [
            1 => ['Active', 'active'],
            2 => ['Inactive', 'inactive'],
            'test' => ['Test', 'test'],
            'test1' => 'Test1',
        ];
    }
}
