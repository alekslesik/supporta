<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'THEME' => 'white',
    'IN_BLOCK' => 'N'
], $arParams);

$arVisual = [
    'THEME' => ArrayHelper::fromRange(['white', 'black', 'gray'], $arParams['THEME']),
    'IN_BLOCK' => $arParams['IN_BLOCK'] === 'Y'
];

$arResult['VISUAL'] = $arVisual;