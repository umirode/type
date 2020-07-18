<?php declare(strict_types=1);


namespace Umirode\Type;


use Assert\Assertion;
use Jawira\CaseConverter\CaseConverterException;
use Jawira\CaseConverter\Convert;

/**
 * Class Type
 * @package Umirode\Type
 */
abstract class Type
{
    public const TYPES = [];

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Type constructor.
     * @param string $identifier
     * @throws CaseConverterException
     */
    final public function __construct(string $identifier)
    {
        $this->identifier = $this->convertToSnakeCase($identifier);

        $this->validateTypes();
        $this->validateIdentifier($this->identifier);

        $this->value = static::TYPES[$this->identifier];
    }

    /**
     * @return string
     */
    final public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return mixed
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return string
     * @throws CaseConverterException
     */
    private function convertToSnakeCase(string $value): string
    {
        return (new Convert($value))->toSnake();
    }

    /**
     * @throws CaseConverterException
     */
    private function validateTypes(): void
    {
        $errorMessage = 'Const TYPES must be not empty assoc array';

        Assertion::true($this->isAssocArray(static::TYPES), $errorMessage);
        Assertion::notEmpty(static::TYPES, $errorMessage);

        foreach (static::TYPES as $type => $value) {
            $convertedType = $this->convertToSnakeCase($type);

            Assertion::true(
                $convertedType === $type,
                'Keys for TYPES must be in snake_case, use "' . $convertedType . '" instead "' . $type . '"'
            );
        }
    }

    /**
     * @param string $identifier
     */
    private function validateIdentifier(string $identifier): void
    {
        Assertion::inArray(
            $identifier,
            array_keys(static::TYPES),
            'Invalid type "' . $identifier . '", please define this type in TYPES const'
        );
    }

    /**
     * @param array $array
     * @return bool
     */
    private function isAssocArray(array $array): bool
    {
        if ([] === $array) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return bool
     * @throws CaseConverterException
     */
    final public function __call(string $name, array $arguments = []): bool
    {
        Assertion::notEq(false, preg_match('/is[A-Za-z]\w+/', $name), 'Invalid method "' . $name . '"');

        $identifier = $this->convertToSnakeCase(lcfirst(explode('is', $name)[1]));
        $this->validateIdentifier($identifier);

        return $this->identifier === $identifier;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return static
     * @throws CaseConverterException
     */
    final public static function __callStatic(string $name, array $arguments = []): self
    {
        return new static($name);
    }
}
