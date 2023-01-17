<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'COLUMNS' => 5,
    'PICTURE_SHOW' => 'N',
    'PREVIEW_SHOW' => 'N'
], $arParams);

$arVisual = [
    'COLUMNS' => ArrayHelper::fromRange([5, 6, 7, 4], $arParams['COLUMNS']),
    'PICTURE' => [
        'SHOW' => $arParams['PICTURE_SHOW'] === 'Y'
    ]
];

$arResult['VISUAL'] = $arVisual;

unset($arVisual);