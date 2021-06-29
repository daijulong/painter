<?php

namespace Daijulong\Painter;

use Daijulong\Painter\Canvas\Canvas;
use Daijulong\Painter\Contacts\ElementContacts;

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
     * @var array
     */
    protected $elements = [];

    /**
     * 获取画布实例
     *
     * @return Canvas
     */
    public function getCanvas()
    {
        return $this->canvas;
    }

    public function startOnBlankCanvas()
    {
        $this->canvas = new Canvas();
    }

    public function startOnBackgroundImage()
    {

    }

    public function paste()
    {

    }

    public function output($output, $type = null)
    {

    }

    public function addElement(ElementContacts $element, $index = '')
    {
        if (is_string($index) && trim($index) != '') {
            $this->elements[trim($index)] = $element;
        } else {
            $this->elements[] = $element;
        }
    }

    public function getElement($index)
    {
        return $this->elements[$index] ?? null;
    }

    public function getFirstElement()
    {
        return reset($this->elements);
    }

    public function getLatestElement()
    {
        return end($this->elements);
    }

}
