<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'COLUMNS' => 2,
    'PICTURE_SHOW' => 'N',
    'PREVIEW_SHOW' => 'N',
    'LINK_USE' => 'N',
    'LINK_BLANK' => 'N',
], $arParams);

$arVisual = [
    'COLUMNS' => ArrayHelper::fromRange([1, 2], $arParams['COLUMNS']),
    'PICTURE' => [
        'SHOW' => $arParams['PICTURE_SHOW'] === 'Y'
    ],
    'PREVIEW' => [
        'SHOW' => $arParams['PREVIEW_SHOW'] === 'Y'
    ],
    'LINK' => [
        'USE' => $arParams['LINK_USE'] === 'Y',
        'BLANK' => $arParams['LINK_BLANK'] === 'Y'
    ]
];

$arResult['VISUAL'] = $arVisual;

unset($arVisual);