<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'PROPERTY_PRICE' => null,
    'LINE_COUNT' => 3,
    'LINK_USE' => 'N',
    'DESCRIPTION_USE' => 'Y',
    'SLIDER_LOOP' => 'N',
    'SLIDER_AUTO_PLAY_USE' => 'N',
    'SLIDER_AUTO_PLAY_TIME' => 10000,
    'SLIDER_SLIDE_SPEED' => 500,
    'SLIDER_AUTO_PLAY_PAUSE' => 'Y',
    'LIST_PAGE_URL' => null,
    'FOOTER_SHOW' => 'N',
    'FOOTER_POSITION' => 'center',
    'FOOTER_BUTTON_SHOW' => 'N',
    'FOOTER_BUTTON_TEXT' => null
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

/** Обработка настроенных параметров компонента */
$iColumns = ArrayHelper::fromRange([2, 3, 4], $arParams['LINE_COUNT']);

$arResult['VISUAL'] = ArrayHelper::merge([
    'COLUMNS' => $iColumns,
    'LINK' => [
        'USE' => $arParams['LINK_USE'] === 'Y'
    ],
    'DESCRIPTION' => [
        'SHOW' => $arParams['DESCRIPTION_USE'] === 'Y'
    ],
    'SLIDER' => [
        'LOOP' => $arParams['SLIDER_LOOP'] === 'Y',
        'AUTO' => [
            'USE' => $arParams['SLIDER_AUTO_PLAY_USE'] === 'Y',
            'TIME' => $arParams['SLIDER_AUTO_PLAY_TIME'],
            'HOVER' => $arParams['SLIDER_AUTO_PLAY_PAUSE'] === 'Y',
        ],
        'SPEED' => $arParams['SLIDER_SLIDE_SPEED'],
    ]
], $arResult['VISUAL']);

/** FOOTER */
$arFooter = [
    'SHOW' => $arParams['FOOTER_SHOW'] === 'Y',
    'POSITION' => ArrayHelper::fromRange([
        'left',
        'center',
        'right'
    ], $arParams['FOOTER_POSITION']),
    'BUTTON' => [
        'SHOW' => $arParams['FOOTER_BUTTON_SHOW'] === 'Y',
        'TEXT' => $arParams['FOOTER_BUTTON_TEXT'],
        'LINK' => null
    ]
];

if (!empty($arParams['LIST_PAGE_URL']))
    $arFooter['BUTTON']['LINK'] = StringHelper::replaceMacros(
        $arParams['LIST_PAGE_URL'],
        $arMacros
    );

if (empty($arFooter['BUTTON']['TEXT']) || empty($arFooter['BUTTON']['LINK']))
    $arFooter['BUTTON']['SHOW'] = false;

if (!$arFooter['BUTTON']['SHOW'])
    $arFooter['SHOW'] = false;

$arResult['BLOCKS']['FOOTER'] = $arFooter;

unset($arFooter, $arMacros);