<?php
/**
 * Created by IntelliJ IDEA.
 * User: maksim
 * Date: 2020-02-17
 * Time: 11:50
 */

namespace Umirode\Type;


use Jawira\CaseConverter\Convert;

/**
 * Class Type
 *
 * @package Umirode\Type
 */
abstract class Type
{
    /**
     * @var array
     */
    protected $currentType;

    /**
     * @var array|null
     */
    protected static $formattedList;

    /**
     * @var array
     */
    protected static $typesCache = [];

    /**
     * @return array
     */
    abstract protected static function getList(): array;

    /**
     * NewType constructor.
     *
     * @param $identifier
     *
     * @throws \Exception
     */
    public function __construct($identifier)
    {
        $this->currentType = static::findType($identifier);
    }

    /**
     * @param $identifier
     *
     * @return static
     * @throws \Exception
     */
    public static function create($identifier) {
        return new static($identifier);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->currentType['id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->currentType['slug'] ?? null;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->currentType['title'];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @param $identifier
     *
     * @return array|null
     * @throws \Exception
     */
    private static function findType($identifier): ?array
    {
        $type = static::$typesCache[$identifier] ?? null;
        if ($type !== null) {
            return $type;
        }

        $list = static::getFormattedList();
        foreach ($list as $item) {
            if ($item['id'] === $identifier || $item['slug'] === $identifier) {
                static::$typesCache[$identifier] = $item;
                return $item;
            }
        }

        throw new \Exception('Type ' . $identifier . ' not exists');
    }

    /**
     * @return array
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    private static function getFormattedList(): array
    {
        if (static::$formattedList !== null) {
            return static::$formattedList;
        }

        static::$formattedList = [];

        $list = static::getList();
        foreach ($list as $key => $item) {
            $id = is_int($key) ? $key : null;
            $slug = is_string($key) ? $key : null;
            $title = $item;

            if (is_array($item) && count($item) === 2) {
                [$title, $slug] = $item;
            }

            $slug = (new Convert($slug))->toCamel();

            static::$formattedList [] = [
                'id' => $id,
                'slug' => $slug,
                'title' => $title,
            ];
        }

        return static::$formattedList;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return bool
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (preg_match('/is[A-Z]\w+/', $name)) {
            $slug = lcfirst(explode('is', $name)[1]);

            return $this->getSlug() === $slug;
        }

        throw new \Exception('Method not exists');
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return Type
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        return static::create($name);
    }
}