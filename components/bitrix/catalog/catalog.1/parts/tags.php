<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arParams = ArrayHelper::merge([
    'TAGS_USE' => 'N',
    'TAGS_TEMPLATE' => null,
    'TAGS_PROPERTY' => null,
    'TAGS_COUNT' => 'Y',
    'TAGS_VARIABLE_TAGS' => 'tags'
], $arParams);

$arTags = [
    'USE' => $arParams['TAGS_USE'] === 'Y',
    'SHOW' => false,
    'TEMPLATE' => $arParams['TAGS_TEMPLATE'],
    'PROPERTY' => $arParams['TAGS_PROPERTY'],
    'PARAMETERS' => []
];

if (empty($arTags['TEMPLATE']))
    $arTags['USE'] = false;

if (empty($arTags['PROPERTY']))
    $arTags['USE'] = false;

$arTags['SHOW'] = $arTags['USE'];

if ($arTags['SHOW']) {
    $sPrefix = 'TAGS_';

    foreach ($arParams as $sKey => $mValue) {
        if (!StringHelper::startsWith($sKey, $sPrefix))
            continue;

        $sKey = StringHelper::cut(
            $sKey,
            StringHelper::length($sPrefix)
        );

        if ($sKey === 'TEMPLATE')
            continue;

        $arTags['PARAMETERS'][$sKey] = $mValue;
    }

    foreach ($arResult['PARAMETERS']['COMMON'] as $sProperty)
        $arTags['PARAMETERS'][$sProperty] = ArrayHelper::getValue($arParams, $sProperty);

    $arTags['PARAMETERS'] = ArrayHelper::merge($arTags['PARAMETERS'], [
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'SECTION_ID' => !empty($arSection) ? $arSection['ID'] : false,
        'SECTION_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
        'PROPERTY' => $arTags['PROPERTY'],
        'COUNT' => $arParams['TAGS_COUNT'],
        'USED' => 'Y',
        'FILTER_NAME' => $arParams['FILTER_NAME'],
        'VARIABLE_TAGS' => $arParams['TAGS_VARIABLE_TAGS'],
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME']
    ]);
}