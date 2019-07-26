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
     * @var int
     */
    protected $id;

    /**
     * Status constructor.
     *
     * @param int $id
     */
    protected function __construct(int $id)
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        static::checkId($this->id);

        return static::getList()[$this->id][0];
    }

    /**
     * @param int $id
     *
     * @return static
     */
    public static function create(int $id)
    {
        static::checkId($id);

        return new static($id);
    }

    /**
     * @param int $id
     */
    protected static function checkId(int $id): void
    {
        Assert::that($id)->inArray(array_keys(static::getList()));
    }

    /**
     * @param $slug
     *
     * @return int
     * @throws \Exception
     */
    protected static function getIdBySlug($slug): int
    {
        foreach (static::getList() as $key => $status) {
            if ($status[1] === $slug) {
                return $key;
            }
        }

        throw new \Exception('Status not exists');
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
            $slug = strtolower(explode('is', $name)[1]);

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
