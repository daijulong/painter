<?php


namespace Daijulong\Painter\Elements;

use Daijulong\Painter\Canvas\Canvas;
use Daijulong\Painter\Contacts\ElementContacts;
use Daijulong\Painter\Traits\Coordinate;

abstract class Element implements ElementContacts
{
    use Coordinate;

    /**
     * 宽度
     *
     * @var int
     */
    protected $width;

    /**
     * 高度
     *
     * @var int
     */
    protected $height;

    /**
     * 画布
     *
     * @var Canvas
     */
    protected $canvas;

    /**
     * 获取宽度
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * 获取高度
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * 设置宽度
     *
     * @param int $width
     * @return self
     */
    public function setWidth(int $width): self
    {
        $this->width = max($width, 0);
        return $this;
    }

    /**
     * 设置高度
     *
     * @param int $height
     * @return self
     */
    public function setHeight(int $height): self
    {
        $this->height = max($height, 0);
        return $this;
    }

    /**
     * 增加宽度
     *
     * @param int $i
     * @return self
     */
    public function addWidth(int $i): self
    {
        $this->width = max($this->width + $i, 0);
        return $this;
    }

    /**
     * 增加高度
     *
     * @param int $i
     * @return self
     */
    public function addHeight(int $i): self
    {
        $this->height = max($this->height + $i, 0);
        return $this;
    }

    /**
     * 注入画布
     *
     * @param Canvas $canvas
     * @return self
     */
    public function setCanvas(Canvas &$canvas): self
    {
        $this->canvas = $canvas;
        return $this;
    }

    /**
     * 获取画布对象
     *
     * @return \Imagick
     */
    public function getCanvas(): \Imagick
    {
        return $this->canvas;
    }

}