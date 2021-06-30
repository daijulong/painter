<?php
/**
 * 示例 1： 简单绘图
 */
require __DIR__ . '/../vendor/autoload.php';

//$painter = new \Daijulong\Painter\Painter();
//
//$painter->canvas()->setWidth(750)->setHeight(1150)->setBackgroundColor("#cccccc");
//
//$painter->image(__DIR__ . '/resources/header_bg.png');
//$painter->image(__DIR__ . '/resources/card_pg1.png');
//
//$painter->output('abc.png');

$painter = new \Daijulong\Painter\Painter();

//$painter->canvas()->setWidth(750)->setHeight(500);
$painter->canvas()->setWidth(750)->autoHeight()->setBackgroundColor("#ff0000");

$painter->image(__DIR__ . '/resources/header_bg.png', 'a')->setY(20)->getBottomY();
$painter->image(__DIR__ . '/resources/header_bg.png')->setY($painter->getElement('a')->getBottomY() + 15);

$painter->output('def.png');


var_dump($painter->canvas()->getHeight());