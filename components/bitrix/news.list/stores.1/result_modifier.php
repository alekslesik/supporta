<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\RegExp;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!CModule::IncludeModule('intec.core'))
    return;

$arParams = ArrayHelper::merge([
    'PROPERTY_MAP' => null,
    'PROPERTY_ADDRESS' => null,
    'PROPERTY_PHONE' => null,
    'PROPERTY_EMAIL' => null,
    'PROPERTY_SCHEDULE' => null,
    'MAP_VENDOR' => 'yandex',
    'CONTACTS_TITLE_SHOW' => 'N',
    'CONTACTS_DESCRIPTION_SHOW' => 'N'
], $arParams);

if ($arParams['SETTINGS_USE'] == 'Y')
    include(__DIR__.'/parts/settings.php');

$arResult['MAP']['SHOW'] = ArrayHelper::getValue($arParams, 'SHOW_MAP') == 'Y';
$arResult['MAP']['VENDOR'] = ArrayHelper::getValue($arParams, 'MAP_VENDOR');

$arParams['MAP_VENDOR'] = ArrayHelper::fromRange([
    'google',
    'yandex'
], $arParams['MAP_VENDOR']);

$arResult['DESCRIPTION'] = null;

if ($arParams['DESCRIPTION_SHOW'] == 'Y') {
    $arResult['DESCRIPTION'] = (!empty($arParams['PREVIEW_TEXT'])) ? $arParams['PREVIEW_TEXT'] : null;
}

$sMapId = $arParams['MAP_ID'];
$iMapIdLength = StringHelper::length($sMapId);
$oMapIdExpression = new RegExp('^[A-Za-z_][A-Za-z01-9_]*$');

if ($iMapIdLength <= 0 || $oMapIdExpression->isMatch($sMapId))
    $arParams['MAP_ID'] = 'MAP_'.RandString();

$arResult['PLACEMARKS'] = [];

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['ADDRESS'] = ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_ADDRESS'], 'VALUE']);
    $arItem['EMAIL'] = ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_EMAIL'], 'VALUE']);
    $arItem['SCHEDULE'] = ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_SCHEDULE'], 'VALUE']);

    $arItem['PHONE'] = [];
    $arItem['PHONE']['DISPLAY'] = ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_PHONE'], 'VALUE']);
    $arItem['PHONE']['VALUE'] = StringHelper::replace(
        $arItem['PHONE']['DISPLAY'], [
            '-' => '',
            ' ' => '',
            '(' => '',
            ')' => ''
        ]
    );

    $sMap = ArrayHelper::getValue($arItem, ['PROPERTIES', $arParams['PROPERTY_MAP'], 'VALUE']);
    $arCoordinates = StringHelper::explode($sMap);

    if (!empty($arCoordinates) && count($arCoordinates) == 2) {
        $fLon = Type::toFloat($arCoordinates[1]);
        $fLat = Type::toFloat($arCoordinates[0]);
        $arResult['PLACEMARKS'][] = [
            'LON' => $fLon,
            'LAT' => $fLat,
            'TEXT' => $arItem['NAME']
        ];

        $arResult['POSITION']['LATITUDE'] = $fLat;
        $arResult['POSITION']['LONGITUDE'] = $fLon;
    }
}

unset($arItem);