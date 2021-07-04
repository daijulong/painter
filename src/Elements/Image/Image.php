<?php

namespace Daijulong\Painter\Elements\Image;

use Daijulong\Painter\Elements\Element;

/**
 * 图片
 *
 * @package Daijulong\Painter\Elements\Image
 */
class Image extends Element
{

    /**
     * @var \Imagick
     */
    protected $image;

    /**
     * Image constructor.
     * @param null $file
     * @throws \ImagickException
     */
    public function __construct($file = null)
    {
        $this->image = new \Imagick($file);
    }

    /**
     * 贴图
     *
     * @return bool
     * @throws \ImagickException
     */
    public function paste(): bool
    {
        return $this->canvas->getImage()->compositeImage($this->image, \Imagick::COMPOSITE_OVER, $this->getX(), $this->getY(), \Imagick::CHANNEL_ALL);
    }

    /**
     * 销毁资源
     *
     * @return bool
     */
    public function destroy(): bool
    {
        return $this->image->destroy();
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

    /**
     * 缩略图
     *
     * @param int $width 宽
     * @param int $height 高
     * @param bool $bestfit 是否按比例缩放
     * @param bool $fill 是否填充，按比例缩放时，将短边填充到指定长度
     * @return $this
     * @throws \ImagickException
     */
    public function thumbnail(int $width, int $height, bool $bestfit = false, bool $fill = false): self
    {
        $this->image->thumbnailImage($width, $height, $bestfit, $fill);
        return $this;
    }

    /**
     * 缩放并裁剪得到一个正方形
     *
     * @param int $length 边长
     * @return $this
     * @throws \ImagickException
     */
    public function square(int $length): self
    {
        $this->image->cropThumbnailImage($length, $length);
        return $this;
    }

    /**
     * 缩放并裁剪到指定尺寸
     *
     * @param int $width
     * @param int $height
     * @return $this
     * @throws \ImagickException
     */
    public function resize(int $width, int $height): self
    {
        $this->image->cropThumbnailImage($width, $height);
        return $this;
    }

    /**
     * 绽放并裁剪得到圆形
     *
     * @param int $r 半径
     * @return $this
     * @throws \ImagickDrawException
     * @throws \ImagickException
     */
    public function circle(int $r = 0): self
    {
        //如未指定半径，则取图像短边的一半
        if ($r == 0) {
            $r = intval(min($this->image->getImageWidth(), $this->image->getImageHeight()) / 2);
        }
        //将图像裁切为正方形
        $this->square($r * 2);

        //正方形
        $size = 2 * $r;
        $circle = new \Imagick();
        $circle->newImage($size, $size, 'none');
        $circle->setimageformat('png');
        $circle->setimagematte(true);

        //在正方形上画一个白色圆
        $draw = new \ImagickDraw();
        $draw->setfillcolor('#fff');
        $draw->circle($r, $r, $r, $size);
        $circle->drawimage($draw);

        //裁剪头像成圆形
        $this->image->setImageFormat('png');
        $this->image->setimagematte(true);
        $this->image->compositeimage($circle, \Imagick::COMPOSITE_COPYOPACITY, 0, 0);

        $circle->destroy();
        $draw->destroy();

        return $this;
    }

    /**
     * 居左对齐
     *
     * @param int $padding
     * @return Image
     */
    public function left(int $padding = 0): self
    {
        $this->setX($padding);
        return $this;
    }

    /**
     * 居右对齐
     *
     * @param int $padding
     * @return Image
     * @throws \ImagickException
     */
    public function right(int $padding = 0): self
    {
        $width = $this->image->getImageWidth();
        $x = $this->canvas->getWidth() - $width - $padding;
        $this->left($x);
        return $this;
    }

    /**
     * 居中对齐
     *
     * @return Image
     * @throws \ImagickException
     */
    public function center(): self
    {
        $width = $this->image->getImageWidth();
        $x = intval(($this->canvas->getWidth() - $width) / 2);
        $this->left($x);
        return $this;
    }

}
