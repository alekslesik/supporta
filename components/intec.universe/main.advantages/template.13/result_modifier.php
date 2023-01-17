<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'PICTURE_SHOW' => 'N',
    'PICTURE_SIZE' => '60',
    'PREVIEW_SHOW' => 'N',
    'NAME_SHOW' => 'Y',
    'NAME_SIZE' => 'middle',
    'NAME_MARGIN' => 'middle',
    'COLUMNS' => 5
], $arParams);

$arVisual = [
    'PICTURE' => [
        'SHOW' => $arParams['PICTURE_SHOW'] === 'Y',
        'SIZE' => ArrayHelper::fromRange([60, 80, 100], $arParams['PICTURE_SIZE'])
    ],
    'PREVIEW' => [
        'SHOW' => $arParams['PREVIEW_SHOW'] === 'Y'
    ],
    'NAME' => [
        'SHOW' => $arParams['NAME_SHOW'] === 'Y',
        'SIZE' => ArrayHelper::fromRange(['small', 'middle', 'big'], $arParams['NAME_SIZE']),
        'MARGIN' => ArrayHelper::fromRange(['small', 'middle', 'big'], $arParams['NAME_MARGIN'])
    ],
    'ELEMENT' => [
        'MARGIN' => ArrayHelper::fromRange(['small', 'middle', 'big'], $arParams['ELEMENT_MARGIN'])
    ]
];

$arResult['VISUAL']['COLUMNS'] = ArrayHelper::fromRange([2, 3, 4], $arParams['COLUMNS']);
$arResult['VISUAL'] = ArrayHelper::merge($arVisual, $arResult['VISUAL']);

unset($arVisual);