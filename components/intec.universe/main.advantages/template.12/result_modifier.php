<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'PREVIEW_SHOW' => 'N',
    'NUMBER_SHOW' => 'N',
    'COLUMNS' => 2,
    'BACKGROUND_PATH' => null
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

$arVisual = [
    'PREVIEW' => [
        'SHOW' => $arParams['PREVIEW_SHOW'] === 'Y'
    ],
    'NUMBER' => [
        'SHOW' => $arParams['NUMBER_SHOW'] === 'Y'
    ],
    'BACKGROUND' => [
        'SRC' => $arParams['BACKGROUND_SRC']
    ],
];

$arResult['VISUAL']['BACKGROUND']['PATH'] = StringHelper::replaceMacros(
    $arParams['BACKGROUND_PATH'],
    $arMacros
);
$arResult['VISUAL']['COLUMNS'] = ArrayHelper::fromRange([2, 3], $arParams['COLUMNS']);
$arResult['VISUAL'] = ArrayHelper::merge($arVisual, $arResult['VISUAL']);

unset($arVisual);