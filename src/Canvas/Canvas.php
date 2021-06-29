<?php

namespace Daijulong\Painter\Canvas;

use Daijulong\Painter\Traits\Coordinate;

class Canvas
{
    use Coordinate;

    /**
     * 宽度
     *
     * @var int
     */
    protected $with;

    /**
     * 初始高度
     *
     * 如果高度自适应，则该数值会变化
     *
     * @var int
     */
    protected $height;

    /**
     * 是否自适应高度
     *
     * @var bool
     */
    protected $autoHeight = false;

    /**
     * 设置为自适应高度
     */
    public function autoHeight(): Canvas
    {
        $this->autoHeight = true;
        return $this;
    }

    /**
     * 设置为固定高度
     *
     * @return $this
     */
    public function fixedHeight($height = null): Canvas
    {
        $this->autoHeight = false;
        if (is_int($height)) {
            return $this->setHeight($height);
        }
        return $this;
    }

    /**
     * 获取画布宽度
     *
     * @return int
     */
    public function getWith(): int
    {
        return $this->with;
    }

    /**
     * 设置画布宽度
     *
     * @param int $with
     * @return Canvas
     */
    public function setWith(int $with): Canvas
    {
        $this->with = max($with, 0);
        return $this;
    }

    /**
     * 获取画布高度
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * 设置画布高度
     *
     * @param int $height
     * @return Canvas
     */
    public function setHeight(int $height): Canvas
    {
        $this->height = max($height, 0);
        return $this;
    }

    /**
     * 增加画布高度
     *
     * @param int $i
     * @return Canvas
     */
    public function addHeight(int $i): Canvas
    {
        $this->height = max($this->height + $i, 0);
        return $this;
    }
}