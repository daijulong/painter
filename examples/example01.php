<?php
/**
 * 示例 1： 简单绘图
 */
require __DIR__ . '/../vendor/autoload.php';

$painter = new \Daijulong\Painter\Painter();
//注册需要使用到的字体
\Daijulong\Painter\Resources\Fonts::register('medium', __DIR__ . '/resources/fonts/SourceHanSansSC-Medium.otf');
\Daijulong\Painter\Resources\Fonts::register('regular', __DIR__ . '/resources/fonts/SourceHanSansSC-Regular.otf');
//画布
$painter->canvas()->width(750)->autoHeight()->setBackgroundColor("#ffffff")->setBackgroundImage(__DIR__ . '/resources/body_bg_repeat.png');
//头部背景图
$painter->image(__DIR__ . '/resources/header_bg.png');
//头像背景
$painter->image(__DIR__ . '/resources/body_bg_avatar.png')->setY(229);
//头像
$painter->image(__DIR__ . '/resources/avatar.jpg')->circle(90)->setCoordinate(285, 240);

$painter->text('神秘人')->font('medium')->size(36)->color('#333')->setY(466)->center();
$painter->text('CEO')->font('medium')->size(36)->color('#333')->setY(513)->center();
$painter->text('上海某某科技有限公司', 'company')->font('regular')->size(24)->color('#666')->setY(575)->center()->addX(40);
$companyX = $painter->getElement('company')->getX();
$painter->image(__DIR__ . '/resources/logo.png')->square(30)->setX($companyX - 40)->setY(551);
//介绍，整个图片高度会随文本行数自动调整
//$intro = '上海某某科技有限公司是一家集互联网开发、网络运营 、互联网服务于一体的网络科技公司。其主要专注于技术创新、寄情于网络IT、投身于互联网事业。拥有全新的服务理念，服务社会。这是一家快速成长、锐意进取的年轻网络科技公司。公司以人为本，以客户为中心，以需求为导向，以服务为宗旨；以创新、专业、求实、诚信、和谐为经营理念。创新科技，最专业的技术。现以成为整个行业技术较专业的网络公司。迅速发展成为网络科技领域的后起之秀。';
$intro = '上海某某科技有限公司是一家集互联网开发、网络运营 、互联网服务于一体的网络科技公司。这是一家快速成长、锐意进取的年轻网络科技公司。公司以人为本，以客户为中心，以需求为导向，以服务为宗旨；以创新、专业、求实、诚信、和谐为经营理念。创新科技，最专业的技术。';
//$intro = 'Life is full of confusing and disordering Particular time,a particular location,Do the arranged thing of ten million time in the brain,Step by step ,the life is hard to avoid delicacy and stiffness No enthusiasm forever,No unexpected happening of surprising and pleasing So,only silently ask myself in mind Next happiness,when will come?';
$painter->textBlock($intro, 'intro', 600)->takeLines(4, '...........')->font('regular')->size(26)->color('#666')->setY(651)->center()->textAlignLeft()->setLineSpacing(10);
$y = $painter->getElement('intro')->getBottomY();

$painter->image(__DIR__ . '/resources/qrcode.png', 'qrcode')->square(240)->setY($y + 10)->center();
$y = $painter->getElement('qrcode')->getBottomY();
$painter->text('扫码联系作者')->font('regular')->size(26)->color('#666')->setY($y + 50)->center();
$y = $painter->getLatestElement()->getBottomY();
//包底
$painter->image(__DIR__ . '/resources/body_bg_bottom.png')->setY($y)->setX(0);
//输出图片
$painter->output(__DIR__ . '/output/example01.png');