<?php

require_once dirname(dirname(__FILE__)) . '/securimage.php';

$img = new Securimage();

if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);


$img->image_bg_color                = new Securimage_Color("#8080f5");
$img->text_color                    = new Securimage_Color("#FFFFFF");
$img->line_color                    = new Securimage_Color("#6a6a6a");
$img->text_transparency_percentage  = 5;
$img->charset                       = "ABCDEFGHJKLMNPQRSTUVWXZY0123456789";
$img->show();
