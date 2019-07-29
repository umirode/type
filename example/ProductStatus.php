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
 *
 * @method static ProductStatus active()
 * @method static ProductStatus inactive()
 * @method static ProductStatus test()
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
        ];
    }
}
