<?php
/**
 * Created by IntelliJ IDEA.
 * User: maksim
 * Date: 2019-07-26
 * Time: 15:19
 */

namespace Umirode\Status;


use Assert\Assert;

/**
 * Class Status
 *
 * @package Umirode\Status
 */
abstract class Status
{
    /**
     * @var int|string
     */
    protected $id;

    /**
     * Status constructor.
     *
     * @param int|string $id
     */
    public function __construct($id)
    {
        $this->id = static::formatStringOrInt($id);
    }

    /**
     * [
     *  1 => ['Active', 'active']
     * ]
     *
     * @return array
     */
    abstract public static function getList(): array;

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        static::checkId($this->getId());

        $status = static::getList()[$this->getId()];

        return (string)(is_array($status) ? $status[0] : $status);
    }

    /**
     * @param $id
     *
     * @return static
     */
    public static function create($id)
    {
        static::checkId($id);

        return new static($id);
    }

    /**
     * @param $id
     */
    protected static function checkId($id): void
    {
        Assert::that(static::formatStringOrInt($id))->inArray(array_keys(static::getList()));
    }

    /**
     * @param $slug
     *
     * @return int|string
     * @throws \Exception
     */
    protected static function getIdBySlug($slug)
    {
        $slug = static::formatStringOrInt($slug);

        foreach (static::getList() as $key => $status) {
            $key = static::formatStringOrInt($key);

            if (($slug === $key) || (is_array($status) && $status[1] === $slug)) {
                return $key;
            }
        }

        throw new \Exception('Status not exists');
    }

    /**
     * @param $value
     *
     * @return int|string
     */
    protected static function formatStringOrInt($value)
    {
        return is_numeric($value) ? (int)$value : (string)$value;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        static::checkId($this->getId());

        $status = static::getList()[$this->getId()];

        return (string)(is_array($status) ? $status[1] : $this->getId());
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

            return $this->getId() === static::getIdBySlug($slug);
        }

        throw new \Exception('Method not exists');
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return Status
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        $id = static::getIdBySlug($name);
        if ($id) {
            return new static($id);
        }

        throw new \Exception('Method not exists');
    }
}
