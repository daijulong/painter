<?php

namespace Daijulong\Painter\Elements\TextBlock;

use Daijulong\Painter\Elements\Element;
use Daijulong\Painter\Elements\Text\Text;
use Daijulong\Painter\Resources\Fonts;
use ImagickDraw;

/**
 * 文本块
 *
 * 用于文本较长可能需要分行显示时
 *
 * @package Daijulong\Painter\Elements\Text
 */
class TextBlock extends Element
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
     * 分行的文本
     *
     * @var array
     */
    protected $textLines = [];

    /**
     * 行间距
     *
     * @var int
     */
    protected $lineSpacing = 0;

    /**
     * 字间距
     *
     * @var int
     */
    protected $charSpacing = 0;

    /**
     * 使用行数
     *
     * 当需要切分为多行显示时，最多显示多少行
     * 0 表示显示所有行
     *
     * @var int
     */
    protected $takeLines = 0;

    /**
     * 溢出时尾部填充内容
     *
     * @var string
     */
    protected $overflow = '';

    /**
     * 文本块宽度
     *
     * @var int
     */
    protected $width = 0;

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
     * 对齐方式
     *
     * @var string
     */
    protected $align = 'left';

    /**
     * TextBlock constructor.
     * @param $text
     * @param int $width
     * @throws \ImagickDrawException
     * @throws \ImagickException
     */
    public function __construct($text, int $width = 0)
    {
        $this->draw = new ImagickDraw();
        $this->text = $text;
        $this->width = $width;
        $this->font(Fonts::getDefaultFont());
    }

    /**
     * 贴图
     *
     * @return bool
     * @throws \ImagickDrawException
     * @throws \ImagickException
     * @throws \ImagickPixelException
     */
    public function paste()
    {
        $this->wrap();
        foreach ($this->textLines as $key => $textLine) {
            switch ($this->align) {
                case 'left':
                    $textLine->left($this->getX());
                    break;
                case 'right':
                    $textLine->right($this->canvas->getWidth() - $this->getX() - $this->getWidth());
                    break;
                case 'center':
                    $textLine->center();
                    break;
            }
            if (!$textLine->setY($this->y + ($key) * ($this->lineSpacing + $this->size))->paste()) {
                return false;
            }
        }
        return true;
    }

    /**
     * 文字居中对齐
     *
     * @return TextBlock
     */
    public function textAlignCenter(): self
    {
        $this->align = 'center';
        return $this;
    }

    /**
     * 文字居左对齐
     *
     * @param int $padding
     * @return TextBlock
     */
    public function textAlignLeft(int $padding = 0): self
    {
        $this->align = 'left';
        return $this;
    }

    /**
     * 文字居右对齐
     *
     * @param int $padding
     * @return TextBlock
     */
    public function textAlignRight(int $padding = 0): self
    {
        $this->align = 'right';
        return $this;
    }

    /**
     * 居左对齐
     *
     * @param int $padding
     * @return TextBlock
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
     * @return TextBlock
     */
    public function right(int $padding = 0): self
    {
        $x = intval($this->canvas->getWidth() - $this->width - $padding);
        $this->left($x);
        return $this;
    }

    /**
     * 居中对齐
     *
     * @return TextBlock
     */
    public function center(): self
    {
        $x = intval(($this->canvas->getWidth() - $this->width) / 2);
        $this->left($x);
        return $this;
    }

    /**
     * 销毁资源
     *
     * @return bool
     */
    public function destroy(): bool
    {
        foreach ($this->textLines as $textLine) {
            $textLine->destroy();
        }
        unset($this->textLines);
        return true;
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
        $this->wrap();
        //如果还未切分，则按单行文本计算
        if (empty($this->textLines)) {
            return $this->y + $this->size;
        }
        //切分后的根据字号和行距计算
        if (!empty($this->textLines)) {
            $this->height = count($this->textLines) * $this->size + (count($this->textLines) - 1) * $this->lineSpacing;
        }
        return $this->y + $this->height;
    }

    /**
     * 切分文本到多行
     *
     * 只会切分一次
     *
     * @return bool|void
     * @throws \ImagickDrawException
     * @throws \ImagickException
     * @throws \ImagickPixelException
     */
    protected function wrap()
    {
        if (!empty($this->textLines)) {
            return;
        }

        $draw = new ImagickDraw();
        if ($this->weight > 100 && $this->weight <= 900) {
            $draw->setFontWeight($this->weight);
        }
        if ($this->font != '') {
            $draw->setFont($this->font);
        }
        $draw->setTextInterWordSpacing($this->charSpacing);
        $draw->setTextAlignment(\Imagick::ALIGN_LEFT);
        $c = $draw->getTextInterWordSpacing();
        $blockWidth = $this->width > 0 ? $this->width : $this->canvas->getInnerWidth();
        //切割分行
        $charLength = mb_strlen($this->text);
        $lineText = '';
        $startPos = 0;
        $textLines = [];
        for ($i = $startPos; $i < $charLength; $i++) {
            //计算字符串的实际长度，需要用： (字体大小 / 字符宽度) * 文本整体宽度，其实就是一个字体大小和字符宽度有个比例
            $textTmp = mb_substr($this->text, $startPos, $i - $startPos + 1);
            $metrics = $this->canvas->getImage()->queryFontMetrics($draw, $textTmp);
            $textTmpWidth = intval(($this->size / $metrics['characterWidth']) * $metrics['textWidth']);
            if ($textTmpWidth <= $blockWidth) {
                $lineText = $textTmp;
            } else {
                $textLines[] = $lineText;
                $startPos = $i;
                $lineText = mb_substr($this->text, $startPos, $i - $startPos + 1);

            }
        }
        if ($lineText) {
            $textLines[] = $lineText;
        }
        //不全取，则要取的最后一行尾部需要被替换成指定的字符
        if (is_numeric($this->takeLines) && $this->takeLines >= 1) {
            $takeLines = intval($this->takeLines);
            if ($takeLines < count($textLines)) {
                $latestText = $textLines[$takeLines - 1];
                for ($j = mb_strlen($latestText); $j > 0; $j--) {
                    $latestTextTmp = mb_substr($latestText, 0, $j) . $this->overflow;
                    $metrics = $this->canvas->getImage()->queryFontMetrics($draw, $latestTextTmp, true);
                    if (intval(($this->size / $metrics['characterWidth']) * $metrics['textWidth']) <= $blockWidth) {
                        $textLines[$takeLines - 1] = $latestTextTmp;
                        break;
                    }
                }
            }
            $textLines = array_slice($textLines, 0, $takeLines);
        }
        $draw->destroy();

        foreach ($textLines as $textLine) {
            $lineTextElement = (new Text($textLine))->setCanvas($this->canvas);
            $lineTextElement->font($this->font)
                ->size($this->size)
                ->weight($this->weight)
                ->angle($this->angle)
                ->setCharSpacing($this->charSpacing)
                ->color($this->color)
                ->setX($this->x);
            $this->textLines[] = $lineTextElement;
        }

        return true;
    }

    /**
     * 设置字体
     *
     * @param string $font
     * @return TextBlock
     * @throws \ImagickDrawException
     * @throws \ImagickException
     */
    public function font(string $font): self
    {
        $this->font = Fonts::get($font) ?: $font;
        if (!empty($this->textLines)) {
            array_walk($this->textLines, function ($item) {
                $item->font($this->font);
            });
        }
        return $this;
    }

    /**
     * 设置字体大小
     *
     * @param float $size
     * @return TextBlock
     */
    public function size(float $size): self
    {
        $this->size = $size;
        if (!empty($this->textLines)) {
            array_walk($this->textLines, function ($item) {
                $item->size($this->size);
            });
        }
        return $this;
    }

    /**
     * 设置文字粗细
     *
     * @param int $weight
     * @return TextBlock
     */
    public function weight(int $weight): self
    {
        $this->weight = $weight;
        if (!empty($this->textLines)) {
            array_walk($this->textLines, function ($item) {
                $item->weight($this->weight);
            });
        }
        return $this;
    }

    /**
     * 设置文字倾斜角度
     *
     * @param int $angle
     * @return TextBlock
     */
    public function angle(int $angle): self
    {
        $this->angle = $angle;
        if (!empty($this->textLines)) {
            array_walk($this->textLines, function ($item) {
                $item->angle($this->angle);
            });
        }
        return $this;
    }

    /**
     * 颜色
     *
     * @param string $color
     * @return TextBlock
     */
    public function color(string $color): self
    {
        $this->color = $color;
        if (!empty($this->textLines)) {
            array_walk($this->textLines, function ($item) {
                $item->color($this->color);
            });
        }
        return $this;
    }

    /**
     * 设置词间距
     *
     * @param int $charSpacing
     * @return TextBlock
     */
    public function setWordSpacing(int $charSpacing): self
    {
        $this->charSpacing = $charSpacing;
        if (!empty($this->textLines)) {
            array_walk($this->textLines, function ($item) {
                $item->setTextInterWordSpacing($this->charSpacing);
            });
        }
        return $this;
    }

    /**
     * 设置行距
     *
     * @param int $lineSpacing
     * @return TextBlock
     */
    public function setLineSpacing(int $lineSpacing): self
    {
        $this->lineSpacing = $lineSpacing;
        return $this;
    }

    /**
     * 获取行数
     *
     * @param int $takeLines
     * @param string $overflow
     * @return TextBlock
     */
    public function takeLines(int $takeLines, string $overflow = ''): self
    {
        $this->takeLines = $takeLines;
        $this->overflow = $overflow;
        return $this;
    }
}