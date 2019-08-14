<?php
/**
 * Created by IntelliJ IDEA.
 * User: maksim
 * Date: 2019-07-26
 * Time: 15:26
 */

namespace Umirode\Status\Example;


use Umirode\Status\Status;

/**
 * Class ProductStatus
 *
 * @package Umirode\Status\Example
 *
 * @method bool isActive()
 * @method bool isInactive()
 * @method bool isTest()
 * @method bool isTest1()
 *
 * @method static ProductStatus active()
 * @method static ProductStatus inactive()
 * @method static ProductStatus test()
 * @method static ProductStatus test1()
 */
final class ProductStatus extends Status
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
