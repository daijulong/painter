<?php

namespace Daijulong\Painter\Elements\Text;

use Daijulong\Painter\Elements\Element;

class Text extends Element
{
    public function __construct($text)
    {
    }

    public function paste()
    {

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
        return 0;
    }
}