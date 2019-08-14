<?php
/**
 * Created by IntelliJ IDEA.
 * User: maksim
 * Date: 2019-07-26
 * Time: 15:30
 */

namespace Umirode\Status\Test;


use PHPUnit\Framework\TestCase;
use Umirode\Status\Example\ProductStatus;

/**
 * Class ProductStatusTest
 *
 * @package Umirode\Status\Test
 */
final class ProductStatusTest extends TestCase
{
    public function testCreateActiveById(): void
    {
        $status = ProductStatus::create(1);

        $this->assertIsObject($status);
        $this->assertInstanceOf(ProductStatus::class, $status);

        $this->assertEquals(1, $status->getId());
        $this->assertEquals('Active', $status->getTitle());
    }

    public function testCreateInactiveById(): void
    {
        $status = ProductStatus::create(2);

        $this->assertIsObject($status);
        $this->assertInstanceOf(ProductStatus::class, $status);

        $this->assertEquals(2, $status->getId());
        $this->assertEquals('Inactive', $status->getTitle());
    }

    public function testCreateActive(): void
    {
        $status = ProductStatus::active();

        $this->assertIsObject($status);
        $this->assertInstanceOf(ProductStatus::class, $status);

        $this->assertEquals(1, $status->getId());
        $this->assertEquals('Active', $status->getTitle());
    }

    public function testCreateInactive(): void
    {
        $status = ProductStatus::inactive();

        $this->assertIsObject($status);
        $this->assertInstanceOf(ProductStatus::class, $status);

        $this->assertEquals(2, $status->getId());
        $this->assertEquals('Inactive', $status->getTitle());
    }

    public function testGetStatusesList(): void
    {
        $statuses = ProductStatus::getList();

        $this->assertIsArray($statuses);
    }

    public function testCheckActiveStatusType(): void
    {
        $status = ProductStatus::active();

        $this->assertTrue($status->isActive());
        $this->assertFalse($status->isInactive());
    }

    public function testCheckInactiveStatusType(): void
    {
        $status = ProductStatus::inactive();

        $this->assertTrue($status->isInactive());
        $this->assertFalse($status->isActive());
    }

    public function testStringId(): void
    {
        $status = ProductStatus::test();

        $this->assertTrue($status->isTest());
        $this->assertFalse($status->isActive());

        $this->assertEquals('test', $status->getId());
    }

    public function testGetSlug(): void
    {
        $status = ProductStatus::test();

        $this->assertTrue($status->isTest());
        $this->assertFalse($status->isActive());

        $this->assertEquals('test', $status->getSlug());
    }

    public function testStatusWithoutSlug(): void
    {
        $status = ProductStatus::test1();

        $this->assertTrue($status->isTest1());
        $this->assertFalse($status->isTest());
        $this->assertFalse($status->isActive());

        $this->assertEquals('test1', $status->getSlug());
    }

    public function testCreate(): void
    {
        $statusesIds = array_keys(ProductStatus::getList());

        foreach ($statusesIds as $statusId) {
            $status = ProductStatus::create($statusId);

            $this->assertNotEmpty($status->getId());
            $this->assertNotEmpty($status->getTitle());
            $this->assertNotEmpty($status->getSlug());
        }
    }
}
