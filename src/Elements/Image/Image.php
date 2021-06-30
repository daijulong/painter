<?php

namespace Daijulong\Painter\Elements\Image;

use Daijulong\Painter\Canvas\Canvas;
use Daijulong\Painter\Elements\Element;

class Image extends Element
{

    /**
     * @var \Imagick
     */
    protected $image;

    public function __construct($file = null)
    {
        $this->image = new \Imagick($file);
    }

    public function paste(): bool
    {
        return $this->canvas->getImage()->compositeImage($this->image, \Imagick::COMPOSITE_OVER, $this->x, $this->y, \Imagick::CHANNEL_ALL);
    }

    /**
     * 获取底部 Y 坐标
     *
     * 用于计算贴图后实际画布需要的高度
     *
     * @return int
     * @throws \ImagickException
     */
    public function getBottomY(): int
    {
        return $this->image->getImageHeight() + $this->y;
    }


}