<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'COLUMNS' => 3,
    'PICTURE_SHOW' => 'N',
    'PREVIEW_SHOW' => 'N',
    'NAME_SHOW' => 'Y',
    'LINK_USE' => 'N',
    'LINK_BLANK' => 'N'
], $arParams);

$arVisual = [
    'COLUMNS' => ArrayHelper::fromRange([5, 4, 3, 2], $arParams['COLUMNS']),
    'LINK' => [
        'USE' => $arParams['LINK_USE'] === 'Y',
        'BLANK' => $arParams['LINK_BLANK'] === 'Y'
    ],
    'PICTURE' => [
        'SHOW' => $arParams['PICTURE_SHOW'] === 'Y'
    ],
    'PREVIEW' => [
        'SHOW' => $arParams['PREVIEW_SHOW'] === 'Y'
    ],
    'NAME' => [
        'SHOW' => $arParams['NAME_SHOW'] === 'Y'
    ]
];

$arResult['VISUAL'] = $arVisual;

unset($arVisual);