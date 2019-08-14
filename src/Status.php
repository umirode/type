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
        $this->id = $id;
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
        return is_numeric($this->id) ? (int)$this->id : $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        static::checkId($this->id);

        $status = static::getList()[$this->id];

        return is_array($status) ? $status[0] : (string)$status;
    }

    /**
     * @param int|string $id
     *
     * @return static
     */
    public static function create($id)
    {
        static::checkId($id);

        return new static($id);
    }

    /**
     * @param int|string $id
     */
    protected static function checkId(&$id): void
    {
        $id = is_numeric($id) ? (int)$id : $id;
        Assert::that($id)->inArray(array_keys(static::getList()));
    }

    /**
     * @param $slug
     *
     * @return int|string
     * @throws \Exception
     */
    protected static function getIdBySlug($slug)
    {
        foreach (static::getList() as $key => $status) {
            if (is_array($status) && $status[1] === $slug) {
                return $key;
            }
            if ($slug === $key || (int)$slug === $key) {
                return $key;
            }
        }

        throw new \Exception('Status not exists');
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        static::checkId($this->id);

        $status = static::getList()[$this->id];

        return is_array($status) ? $status[1] : (string)$this->id;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return Status|bool
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (preg_match('/is[A-Z]\w+/', $name)) {
            $slug = lcfirst(explode('is', $name)[1]);

            return $this->id === static::getIdBySlug($slug);
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
