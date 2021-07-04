<?php

namespace Daijulong\Painter\Contacts;

/**
 * 元素接口
 *
 * @package Daijulong\Painter\Contacts
 */
interface ElementContacts
{
    /**
     * 贴图
     *
     * @return mixed
     */
    public function paste();

    /**
     * 销毁资源
     *
     * @return bool
     */
    public function destroy(): bool;

    /**
     * 获取宽度
     *
     * @return int
     */
    public function getWidth(): int;

    /**
     * 获取高度
     *
     * @return int
     */
    public function getHeight(): int;

    /**
     * 获取 X 坐标
     *
     * @return int
     */
    public function getX(): int;

    /**
     * 获取 Y 坐标
     *
     * @return int
     */
    public function getY(): int;

    /**
     * 获取底部的 Y 坐标
     *
     * 可用于后一个元素追加高度（相对上一个元素相对高度）
     *
     * @return int
     */
    public function getBottomY(): int;

    /**
     * 居左对齐
     *
     * @param int $padding
     * @return mixed
     */
    public function left(int $padding = 0);

    /**
     * 居右对齐
     *
     * @param int $padding
     * @return $this
     */
    public function right(int $padding = 0);

    /**
     * 居中对齐
     *
     * @return $this
     */
    public function center();
}