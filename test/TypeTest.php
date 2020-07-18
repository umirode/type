<?php declare(strict_types=1);


namespace Umirode\Type\Test;


use PHPUnit\Framework\TestCase;
use Umirode\Type\Type;

final class TypeTest extends TestCase
{
    public function testInvalidTYPESConst(): void
    {
        $this->expectExceptionMessage('Const TYPES must be not empty assoc array');
        new class('test') extends Type {
            public const TYPES = [];
        };
    }

    public function testInvalidTYPESConstNotAssoc(): void
    {
        $this->expectExceptionMessage('Const TYPES must be not empty assoc array');
        new class('test') extends Type {
            public const TYPES = ['test', 'test'];
        };
    }

    public function testInvalidType(): void
    {
        $this->expectExceptionMessage('Invalid type "test1", please define this type in TYPES const');
        new class('test1') extends Type {
            public const TYPES = [
                'test' => 'Test'
            ];
        };
    }

    public function testInvalidTYPESConstKeyCase(): void
    {
        $this->expectExceptionMessage('Keys for TYPES must be in snake_case, use "test_test" instead "testTest"');
        new class('test') extends Type {
            public const TYPES = [
                'testTest' => 'Test'
            ];
        };
    }

    public function testCreate(): void
    {
        $type = new class('test') extends Type {
            public const TYPES = [
                'test' => 'Test',
                'test2' => 'Test2',
            ];
        };

        self::assertTrue($type->isTest());
        self::assertFalse($type->isTest2());

        self::assertEquals('test', $type->getIdentifier());
        self::assertEquals('Test', $type->getValue());

        $type = new class('TestLong') extends Type {
            public const TYPES = [
                'test_long_name' => 'Test',
                'test_long' => 'Test2',
            ];
        };

        self::assertTrue($type->isTestLong());
        self::assertFalse($type->isTestLongName());

        self::assertEquals('test_long', $type->getIdentifier());
        self::assertEquals('Test2', $type->getValue());
    }

    public function testIsMethod(): void
    {
        $this->expectExceptionMessage('Invalid type "test3", please define this type in TYPES const');

        $type = new class('test') extends Type {
            public const TYPES = [
                'test' => 'Test',
                'test2' => 'Test2',
            ];
        };

        self::assertTrue($type->isTest());
        self::assertFalse($type->isTest2());

        $type->isTest3();
    }

}
