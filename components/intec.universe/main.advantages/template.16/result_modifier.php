<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'PREVIEW_SHOW' => 'N',
    'PICTURE_POSITION' => 'top',
    'PICTURE_SHOW' => 'N',
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
    'PICTURE' => [
        'SHOW' => $arParams['PICTURE_SHOW'] === 'Y',
        'POSITION' => ArrayHelper::fromRange(['top', 'left'], $arParams['PICTURE_POSITION'])
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