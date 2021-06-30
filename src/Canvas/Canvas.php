<?php

namespace Daijulong\Painter\Canvas;

use Daijulong\Painter\Drivers\Imagick;

class Canvas
{

    /**
     * 宽度
     *
     * @var int
     */
    protected $width;

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
     * 背景色
     *
     * @var string
     */
    protected $backgroundColor = '';

    /**
     * 背景图
     *
     * @var string
     */
    protected $backgroundImage = '';

    /**
     * 透明度
     *
     * @var string
     */
    protected $transparent = '';

    /**
     * 画布图像对象
     *
     * @var \Imagick
     */
    protected $image;

    /**
     * Canvas constructor.
     */
    public function __construct()
    {
        $this->image = new \Imagick();
    }

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
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * 设置画布宽度
     *
     * @param int $width
     * @return Canvas
     */
    public function setWidth(int $width): Canvas
    {
        $this->width = max($width, 0);
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

    /**
     * 获取背景色
     *
     * @return string
     */
    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    /**
     * 设置背景色
     *
     * @param string $backgroundColor
     */
    public function setBackgroundColor(string $backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * 获取背景图
     *
     * @return string
     */
    public function getBackgroundImage(): string
    {
        return $this->backgroundImage;
    }

    /**
     * 设置背景图
     *
     * @param string $backgroundImage
     */
    public function setBackgroundImage(string $backgroundImage)
    {
        $this->backgroundImage = $backgroundImage;
    }

    /**
     * 获取透明度
     *
     * @return string
     */
    public function getTransparent(): string
    {
        return $this->transparent;
    }

    /**
     * 设置透明度
     *
     * @param string $transparent
     */
    public function setTransparent(string $transparent)
    {
        $this->transparent = $transparent;
    }

    public function draw()
    {
        $this->image->newImage($this->width, $this->height, $this->backgroundColor);
    }

    /**
     * 是否自动高度
     *
     * @return bool
     */
    public function isAutoHeight(): bool
    {
        return $this->autoHeight;
    }

    /**
     * 写入图片到文件
     *
     * @param null|string $filename
     * @return bool
     * @throws \ImagickException
     */
    public function writeImage($filename = null)
    {
        return $this->image->writeImage($filename);
    }

    /**
     * @return \Imagick
     */
    public function getImage(): \Imagick
    {
        return $this->image;
    }
}