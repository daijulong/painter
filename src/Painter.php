<?php

namespace Daijulong\Painter;

use Daijulong\Painter\Canvas\Canvas;
use Daijulong\Painter\Contacts\ElementContacts;
use Daijulong\Painter\Elements\Image\Image;
use Daijulong\Painter\Elements\Text\Text;
use Daijulong\Painter\Elements\TextBlock\TextBlock;

class Painter
{
    /**
     * 画布
     *
     * @var Canvas
     */
    protected $canvas;

    /**
     * 所有元素
     *
     * @var ElementContacts
     */
    protected $elements = [];

    /**
     * Painter constructor.
     */
    public function __construct()
    {
        $this->canvas = new Canvas();
    }

    /**
     * 获取画布实例
     *
     * @return Canvas
     */
    public function canvas(): Canvas
    {
        return $this->canvas;
    }

    /**
     * 渲染图像
     *
     * @return Canvas
     */
    public function paint(): Canvas
    {
        //如果为自动高度的，需要先计算一下合成后的最大高度
        if ($this->canvas->isAutoHeight()) {
            $maxHeight = 0;
            foreach ($this->elements as $element) {
                $maxHeight = max($maxHeight, $element->getBottomY());
            }
            $this->canvas->setHeight($maxHeight);
        }
        $this->canvas->draw();
        //合成
        foreach ($this->elements as $element) {
            $element->paste();
            $element->destroy();
        }

        return $this->canvas;
    }

    /**
     * 渲染
     *
     * @param $filename
     * @return bool
     * @throws \ImagickException
     */
    public function output($filename)
    {
        $this->paint();
        return $this->canvas->writeImage($filename);
    }

    /**
     * 创建一个图片元素
     *
     * @param null $file
     * @param string $index
     * @return Image
     * @throws \ImagickException
     */
    public function image($file = null, string $index = ''): Image
    {
        $this->addElement((new Image($file))->setCanvas($this->canvas), $index);
        return $this->getLatestElement();
    }

    /**
     * 创建一个文本元素
     *
     * @param string $text
     * @param string $index
     * @return Text
     */
    public function text(string $text, string $index = ''): Text
    {
        $this->addElement((new Text($text))->setCanvas($this->canvas), $index);
        return $this->getLatestElement();
    }

    /**
     * 创建一个文本块元素
     *
     * @param string $text
     * @param string $index
     * @param int $width 文本块宽度
     * @return TextBlock
     * @throws \ImagickDrawException
     * @throws \ImagickException
     */
    public function textBlock(string $text, string $index = '', int $width = 0): TextBlock
    {
        $this->addElement((new TextBlock($text, $width))->setCanvas($this->canvas), $index);
        return $this->getLatestElement();
    }

    /**
     * 添加一个元素
     *
     * @param ElementContacts $element
     * @param string $index
     */
    public function addElement(ElementContacts $element, string $index = '')
    {
        if (is_string($index) && trim($index) != '') {
            $this->elements[trim($index)] = $element;
        } else {
            $this->elements[] = $element;
        }
    }

    /**
     * 获取指定元素
     *
     * @param string|int $index
     * @return ElementContacts|null
     */
    public function getElement($index = '')
    {
        return $this->elements[$index] ?? null;
    }

    /**
     * 获取首个元素
     *
     * @return false|ElementContacts
     */
    public function getFirstElement()
    {
        return reset($this->elements);
    }

    /**
     * 获取最后一个元素
     *
     * @return false|ElementContacts
     */
    public function getLatestElement()
    {
        return end($this->elements);
    }

}
