<?php
/**
 * Created by IntelliJ IDEA.
 * User: maksim
 * Date: 2019-07-26
 * Time: 15:30
 */

namespace Umirode\Type\Test;


use PHPUnit\Framework\TestCase;
use Umirode\Type\Example\ProductType;

/**
 * Class ProductTypeTest
 *
 * @package Umirode\Type\Test
 */
final class ProductTypeTest extends TestCase
{
    public function testCreateActiveById(): void
    {
        $type = ProductType::create(1);

        $this->assertIsObject($type);
        $this->assertInstanceOf(ProductType::class, $type);

        $this->assertEquals(1, $type->getId());
        $this->assertEquals('Active', $type->getTitle());
    }

    public function testCreateInactiveById(): void
    {
        $type = ProductType::create(2);

        $this->assertIsObject($type);
        $this->assertInstanceOf(ProductType::class, $type);

        $this->assertEquals(2, $type->getId());
        $this->assertEquals('Inactive', $type->getTitle());
    }

    public function testCreateActive(): void
    {
        $type = ProductType::active();

        $this->assertIsObject($type);
        $this->assertInstanceOf(ProductType::class, $type);

        $this->assertEquals(1, $type->getId());
        $this->assertEquals('Active', $type->getTitle());
    }

    public function testCreateInactive(): void
    {
        $type = ProductType::inactive();

        $this->assertIsObject($type);
        $this->assertInstanceOf(ProductType::class, $type);

        $this->assertEquals(2, $type->getId());
        $this->assertEquals('Inactive', $type->getTitle());
    }

    public function testGetStatusesList(): void
    {
        $types = ProductType::getList();

        $this->assertIsArray($types);
    }

    public function testCheckActiveStatusType(): void
    {
        $type = ProductType::active();

        $this->assertTrue($type->isActive());
        $this->assertFalse($type->isInactive());
    }

    public function testCheckInactiveStatusType(): void
    {
        $type = ProductType::inactive();

        $this->assertTrue($type->isInactive());
        $this->assertFalse($type->isActive());
    }

    public function testStringId(): void
    {
        $type = ProductType::test();

        $this->assertTrue($type->isTest());
        $this->assertFalse($type->isActive());

        $this->assertEquals('test', $type->getSlug());
    }

    public function testGetSlug(): void
    {
        $type = ProductType::test();

        $this->assertTrue($type->isTest());
        $this->assertFalse($type->isActive());

        $this->assertEquals('test', $type->getSlug());
    }

    public function testStatusWithoutSlug(): void
    {
        $type = ProductType::test1();

        $this->assertTrue($type->isTest1());
        $this->assertFalse($type->isTest());
        $this->assertFalse($type->isActive());

        $this->assertEquals('test1', $type->getSlug());
    }

    public function testCreate(): void
    {
        $typesIds = array_keys(ProductType::getList());
        foreach ($typesIds as $typeId) {
            $type = ProductType::create($typeId);

            $this->assertNotEmpty($type->getSlug());
        }
    }
}
