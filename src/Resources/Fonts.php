<?php

namespace Daijulong\Painter\Resources;

/**
 * 字体
 *
 * @package Daijulong\Painter\Resources
 */
class Fonts
{
    /**
     * 字体
     *
     * @var array
     */
    protected static $fonts = [];

    /**
     * 默认字体
     *
     * @var string
     */
    protected static $default = '';

    /**
     * 添加字体
     *
     * @param string $name
     * @param string $file
     */
    public static function register(string $name, string $file)
    {
        self::$fonts[$name] = $file;
        if (self::$default == '') {
            self::setDefaultFont($name);
        }
    }

    /**
     * 获取字段文件
     *
     * @param string $name
     * @return false|mixed
     */
    public static function get(string $name)
    {
        return self::$fonts[$name] ?? false;
    }

    /**
     * 设置默认字体
     *
     * @param string $font
     */
    public static function setDefaultFont(string $font)
    {
        self::$default = self::$fonts[$font] ?? $font;
    }

    /**
     * 获取默认字体
     *
     * @return string
     */
    public static function getDefaultFont()
    {
        return self::$default;
    }

}
