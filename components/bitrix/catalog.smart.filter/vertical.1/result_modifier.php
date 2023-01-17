<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'COLLAPSED' => 'N',
    'PRICES_EXPANDED' => [],
    'TYPE_A_PRECISION' => 2,
    'TYPE_F_VIEW' => 'default',
    'TYPE_G_VIEW' => 'default',
    'TYPE_G_SIZE' => 'default',
    'MOBILE' => 'N',
    'POPUP_USE' => 'Y'
], $arParams);

$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';

$arResult['VISUAL'] = [
    'DISPLAY' => false,
    'VIEW' => $arParams['FILTER_VIEW_MODE'],
    'COLLAPSED' => $arParams['COLLAPSED'] == 'Y',
    'TYPE' => [
        'A' => [
            'DATA' => 'track',
            'PRECISION' => $arParams['TYPE_A_PRECISION']
        ],
        'F' => [
            'VIEW' => ArrayHelper::fromRange(['default', 'block', 'tile'], $arParams['TYPE_F_VIEW']),
            'DATA' => 'checkbox'
        ],
        'G' => [
            'VIEW' => ArrayHelper::fromRange(['default', 'tile'], $arParams['TYPE_G_VIEW']),
            'SIZE' => ArrayHelper::fromRange(['default', 'big'], $arParams['TYPE_G_SIZE']),
            'DATA' => 'checkbox-picture'
        ],
        'H' => [
            'DATA' => 'checkbox-text-picture'
        ]
    ],
    'MOBILE' => $arParams['MOBILE'] === 'Y',
    'POPUP' => [
        'USE' => $arParams['POPUP_USE'] === 'Y'
    ]
];

if ($arResult['VISUAL']['MOBILE'])
    $arResult['VISUAL']['COLLAPSED'] = false;

if (Loader::includeModule('intec.startshop'))
    include(__DIR__.'/modifier/lite.php');

foreach ($arResult['ITEMS'] as $sKey => &$arItem) {
    if ($arItem['PRICE'] && ArrayHelper::isIn($sKey, $arParams['PRICES_EXPANDED']))
        $arItem['DISPLAY_EXPANDED'] = 'Y';

    if (!$arItem['PRICE'] && !empty($arItem['VALUES'])) {
        $arResult['VISUAL']['DISPLAY'] = true;
    } else if ($arItem['PRICE'] && $arItem['VALUES']['MIN']['VALUE'] !== $arItem['VALUES']['MAX']['VALUE']) {
        $arResult['VISUAL']['DISPLAY'] = true;
    }
}

unset($arItem);

if ($arResult['VISUAL']['COLLAPSED'])
    foreach ($arResult['ITEMS'] as $arItem)
        if ($arItem['DISPLAY_EXPANDED'] == 'Y') {
            $arResult['VISUAL']['COLLAPSED'] = false;
            break;
        }