<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

$iItemLineCount = 2;
$sItemLineCount = ArrayHelper::getValue($arParams, 'LINE_ELEMENT_COUNT');
if (Type::isNumber($sItemLineCount)){
    $iItemLineCount = $sItemLineCount;
    if ($iItemLineCount > 5) $iItemLineCount = 5;
    if ($iItemLineCount < 2) $iItemLineCount = 2;
}

$arResult['VIEW_PARAMETERS'] = [
    'LINE_ELEMENT_COUNT' => $iItemLineCount
];
