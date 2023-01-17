<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

$arVisual = [
    'BODY' => [
        'TEXT' => Html::encode(ArrayHelper::getValue($arParams, 'BODY_TEXT')),
        'DESCRIPTION' => [
            'SHOW' => ArrayHelper::getValue($arParams, 'BODY_DESCRIPTION_SHOW') == 'Y',
            'TEXT' => Html::encode(ArrayHelper::getValue($arParams, 'BODY_DESCRIPTION_TEXT'))
        ]
    ],
    'BUTTON' => [
        'SHOW' => false,
        'TEXT' => ArrayHelper::getValue($arParams, 'BUTTON_TEXT'),
        'POSITION' => ArrayHelper::fromRange(['right', 'center'], ArrayHelper::getValue($arParams, 'BUTTON_POSITION')),
        'UNDER' => [
            'SHOW' => ArrayHelper::getValue($arParams, 'BUTTON_UNDER_SHOW'),
            'TEXT' => Html::decode(ArrayHelper::getValue($arParams, 'BUTTON_UNDER_TEXT'))
        ]
    ],
    'THEME' => ArrayHelper::fromRange(['dark', 'light'], ArrayHelper::getValue($arParams, 'THEME')),
    'BACKGROUND' => [
        'USE' => ArrayHelper::getValue($arParams, 'BACKGROUND_USE') == 'Y',
        'PATH' => StringHelper::replaceMacros(ArrayHelper::getValue($arParams, 'BACKGROUND_PATH'), $arMacros)
    ]
];

$arVisual['BODY']['DESCRIPTION']['SHOW'] = $arVisual['BODY']['DESCRIPTION']['SHOW'] && !empty($arVisual['BODY']['DESCRIPTION']['TEXT']);
$arVisual['BUTTON']['SHOW'] = !empty($arVisual['BUTTON']['TEXT']) && !empty($arResult['ID']);
$arVisual['BUTTON']['UNDER']['SHOW'] = $arVisual['BUTTON']['UNDER']['SHOW'] && !empty($arVisual['BUTTON']['UNDER']['TEXT']);
$arVisual['BACKGROUND']['USE'] = $arVisual['BACKGROUND']['USE'] && !empty($arVisual['BACKGROUND']['PATH']);

$arResult['VISUAL'] = $arVisual;