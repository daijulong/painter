<?php

namespace Daijulong\Painter\Traits;

/**
 * 坐标
 *
 * @package Daijulong\Painter\Traits
 */
trait Coordinate
{

    /**
     * X 坐标
     *
     * @var int
     */
    protected $x = 0;

    /**
     * Y 坐标
     *
     * @var int
     */
    protected $y = 0;

    /**
     * 设置 X 坐标
     *
     * @param int $x
     * @return Coordinate
     */
    public function setX(int $x): Coordinate
    {
        $this->x = $x;
        return $this;
    }

    /**
     * 设置 Y 坐标
     *
     * @param int $y
     * @return Coordinate
     */
    public function setY(int $y): Coordinate
    {
        $this->y = $y;
        return $this;
    }

    /**
     * 将 X 坐标右移
     *
     * @param int $i
     * @return Coordinate
     */
    public function addX(int $i): Coordinate
    {
        return $this->setX(max($this->x + $i, 0));
    }

    /**
     * 将 Y 坐标下移
     *
     * @param int $i
     * @return Coordinate
     */
    public function addY(int $i): Coordinate
    {
        return $this->setY(max($this->y + $i, 0));
    }

    /**
     * 将 X 坐标左移
     *
     * 最多移动到 0
     *
     * @param int $i
     * @return Coordinate
     */
    public function subX(int $i): Coordinate
    {
        return $this->setX(max($this->x - $i, 0));
    }

    /**
     * 将 Y 坐标上移
     *
     * 最多移动到 0
     *
     * @param int $i
     * @return Coordinate
     */
    public function subY(int $i): Coordinate
    {
        return $this->setY(max($this->y - $i, 0));
    }

    /**
     * 设置 X,Y 坐标
     *
     * @param int $x
     * @param int $y
     * @return Coordinate
     */
    public function setCoordinate(int $x, int $y): Coordinate
    {
        return $this->setX($x)->setY($y);
    }

    /**
     * 获取 X 坐标
     *
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * 获取 Y 坐标
     *
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

}