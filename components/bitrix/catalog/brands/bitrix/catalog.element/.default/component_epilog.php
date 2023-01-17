<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use intec\Core;

/**
 * @var CMain $APPLICATION
 */

if (!empty($this->arResult['PREVIEW_TEXT']))
    $sPreviewText = $this->elements[0]['PREVIEW_TEXT'];
else
    $sPreviewText = null;

if (!empty($this->arResult['PREVIEW_PICTURE']))
    $sPreviewPicture = Core::$app->request->getHostInfo().$this->elements[0]['PREVIEW_PICTURE']['SRC'];
else
    $sPreviewPicture = null;

$APPLICATION->SetPageProperty('og:description', $sPreviewText);
$APPLICATION->SetPageProperty('og:image', $sPreviewPicture);