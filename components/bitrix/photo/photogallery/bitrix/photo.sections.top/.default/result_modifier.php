<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

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

foreach ($arResult['SECTIONS'] as $sKey => $arSection) {
    /** Изображение раздела */
    $sSectionPicture = ArrayHelper::getValue($arSection, 'PICTURE');

    if (!empty($sSectionPicture)) {
        $sSectionPicturePath = CFile::GetPath($sSectionPicture);
        $arSection['PICTURE'] = $sSectionPicturePath;
    }

    /** Кол-во элементов раздела */
    $sItemsCount = count($arSection['ITEMS']);
    $arSection['ITEMS_COUNT'] = $sItemsCount;


    $arResult['SECTIONS'][$sKey] = $arSection;
}