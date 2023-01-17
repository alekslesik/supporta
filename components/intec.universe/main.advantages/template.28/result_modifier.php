<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'PICTURE_SHOW' => 'N',
    'HIDE' => 'N'
], $arParams);

$arVisual = [
    'PICTURE' => [
        'SHOW' => $arParams['PICTURE_SHOW'] === 'Y'
    ],
    'HIDE' => $arParams['HIDE'] === 'Y'
];

$arResult['VISUAL'] = $arVisual;

unset($arVisual);