<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arParams = ArrayHelper::merge([
    'WIDE' => 'N',
    'HEIGHT' => 'auto',
    'ROUNDED' => 'N',
    'FADE' => 'N',
    'SHADOW_USE' => 'N',
    'SHADOW_MODE' => 'hover',
    'THEME' => 'light',
    'PARALLAX_USE' => 'N',
    'PARALLAX_RATIO' => 25
], $arParams);

$arVisual = [
    'WIDE' => $arParams['WIDE'] === 'Y',
    'HEIGHT' => $arParams['HEIGHT'] !== 'auto' ? Type::toInteger($arParams['HEIGHT']) : 'auto',
    'ROUNDED' => $arParams['ROUNDED'] === 'Y' && $arParams['WIDE'] !== 'Y',
    'FADE' => $arParams['FADE'] === 'Y',
    'SHADOW' => [
        'USE' => $arParams['SHADOW_USE'] === 'Y',
        'MODE' => ArrayHelper::fromRange(['hover', 'permanent'], $arParams['SHADOW_MODE'])
    ],
    'THEME' => ArrayHelper::fromRange(['light', 'dark'], $arParams['THEME']),
    'PARALLAX' => [
        'USE' => $arParams['PARALLAX_USE'] === 'Y',
        'RATIO' => Type::toInteger($arParams['PARALLAX_RATIO'])
    ]
];

if (!$arVisual['HEIGHT'] || $arVisual['HEIGHT'] < 300)
    $arVisual['HEIGHT'] = 'auto';

if ($arVisual['PARALLAX']['RATIO'] < 0) {
    $arVisual['PARALLAX']['USE'] = false;
    $arVisual['PARALLAX']['RATIO'] = 0;
} else if ($arVisual['PARALLAX']['RATIO'] > 100) {
    $arVisual['PARALLAX']['RATIO'] = 100;
}

$arVisual['PARALLAX']['RATIO'] = (100 - $arVisual['PARALLAX']['RATIO']) / 100;

$arResult['VISUAL'] = $arVisual;

unset($arVisual);