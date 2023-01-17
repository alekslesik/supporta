<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'WIDE' => 'N',
    'SLIDER_NAV' => 'Y',
    'SLIDER_LOOP' => 'N',
    'SLIDER_CENTER' => 'N',
    'SLIDER_AUTO_USE' => 'N',
    'SLIDER_AUTO_TIME' => '5000',
    'SLIDER_AUTO_HOVER' => 'N',
], $arParams);

$arVisual = [
    'WIDE' => $arParams['WIDE'] === 'Y',
    'SLIDER' => [
        'NAV' => $arParams['SLIDER_NAV'] === 'Y'
    ]
];

$arResult['VISUAL'] = ArrayHelper::merge($arVisual, $arResult['VISUAL']);

unset($arVisual);