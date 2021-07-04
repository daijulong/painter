<?php

namespace Daijulong\Painter\Elements\Text;

use Daijulong\Painter\Elements\Element;
use Daijulong\Painter\Resources\Fonts;
use ImagickDraw;

/**
 * 单行文本
 *
 * @package Daijulong\Painter\Elements\Text
 */
class Text extends Element
{

    /**
     * @var ImagickDraw
     */
    protected $draw;

    /**
     * 文本
     *
     * @var string
     */
    protected $text = '';

    /**
     * 溢出时尾部填充内容
     *
     * @var string
     */
    protected $overflow = '';

    /**
     * 字体
     *
     * @var string
     */
    protected $font = '';

    /**
     * 文字倾斜角度
     */
    protected $angle = 0;

    /**
     * 字体大小
     *
     * @var int
     */
    protected $size = 20;

    /**
     * 颜色
     *
     * @var string
     */
    protected $color = '';

    /**
     * 粗细
     *
     * 仅支持 100 ~ 900
     *
     * @var int
     */
    protected $weight = 0;

    /**
     * 字间距
     *
     * @var int
     */
    protected $charSpacing = 0;

    /**
     * Text constructor.
     * @param $text
     */
    public function __construct($text)
    {
        $this->draw = new ImagickDraw();
        $this->text = $text;
        $this->draw->setTextAlignment(\Imagick::ALIGN_LEFT);
    }

    /**
     * 贴图
     *
     * @return bool
     * @throws \ImagickException
     */
    public function paste()
    {
        return $this->canvas->getImage()->annotateImage($this->draw, $this->getX(), $this->getY(), $this->angle, $this->text);
    }

    /**
     * 居左对齐
     *
     * @param int $padding
     * @return Text
     */
    public function left(int $padding = 0): Text
    {
        $this->setX($padding);
        return $this;
    }

    /**
     * 居右对齐
     *
     * @param int $padding
     * @return Text
     * @throws \ImagickException
     */
    public function right(int $padding = 0): Text
    {
        $x = $this->canvas->getWidth() - $this->getTextWidth() - $padding;
        $this->left($x);
        return $this;
    }

    /**
     * 居中对齐
     *
     * @return Text
     * @throws \ImagickException
     */
    public function center(): Text
    {
        $x = intval(($this->canvas->getWidth() - $this->getTextWidth()) / 2);
        $this->left($x);
        return $this;
    }

    /**
     * 获取文本实际宽度
     *
     * @return int
     * @throws \ImagickException
     */
    protected function getTextWidth(): int
    {
        $metrics = $this->canvas->getImage()->queryFontMetrics($this->draw, $this->text, true);
        return intval(($this->size / $metrics['characterWidth']) * $metrics['textWidth']);
    }

    /**
     * 销毁资源
     *
     * @return bool
     */
    public function destroy(): bool
    {
        return $this->draw->destroy();
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
        return $this->y + $this->size;
    }

    /**
     * 设置字体
     *
     * @param string $font
     * @return Text
     * @throws \ImagickDrawException
     * @throws \ImagickException
     */
    public function font(string $font): self
    {
        $this->font = Fonts::get($font) ?: $font;
        $this->draw->setFont($this->font);
        return $this;
    }

    /**
     * 设置字体大小
     *
     * @param float $size
     * @return Text
     */
    public function size(float $size): self
    {
        $this->size = $size;
        $this->draw->setFontSize($this->size);
        return $this;
    }

    /**
     * 设置文字粗细
     *
     * 仅支持 100 ~ 900
     *
     * @param int $weight
     * @return Text
     * @throws \ImagickDrawException
     */
    public function weight(int $weight): self
    {
        if ($weight >= 100 && $weight <= 900) {
            $this->weight = $weight;
            $this->draw->setFontWeight($this->weight);
        }
        return $this;
    }

    /**
     * 设置文字倾斜角度
     *
     * @param int $angle
     * @return self
     */
    public function angle(int $angle): self
    {
        $this->angle = $angle;
        return $this;
    }

    /**
     * 设置颜色
     *
     * @param string $color
     * @return Text
     * @throws \ImagickDrawException
     * @throws \ImagickPixelException
     */
    public function color(string $color): self
    {
        $this->color = $color;
        $this->draw->setFillColor(new \ImagickPixel($color));
        return $this;
    }

    /**
     * 设置字间距
     *
     * @param int $charSpacing
     * @return Text
     */
    public function setCharSpacing(int $charSpacing): self
    {
        $this->charSpacing = $charSpacing;
        $this->draw->setTextInterWordSpacing($charSpacing);
        return $this;
    }

}