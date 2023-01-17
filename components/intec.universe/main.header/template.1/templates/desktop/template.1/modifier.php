<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\component\InnerTemplate;
use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arData
 * @var InnerTemplate $this
 */

$arResult['CONTACTS']['POSITION'] = ArrayHelper::fromRange([
    'bottom',
    'top'
], ArrayHelper::getValue($arParams, 'PHONES_POSITION'));

$arResult['MENU']['MAIN']['POSITION'] = ArrayHelper::fromRange([
    'bottom',
    'top'
], ArrayHelper::getValue($arParams, 'MENU_MAIN_POSITION'));

$arResult['MENU']['MAIN']['TRANSPARENT'] =
    ArrayHelper::getValue($arParams, 'MENU_MAIN_TRANSPARENT') == 'Y' &&
    $arResult['MENU']['MAIN']['POSITION'] == 'bottom';

$arResult['MENU']['INFO'] = [
    'SHOW' => ArrayHelper::getValue($arParams, 'MENU_INFO_SHOW') == 'Y',
    'ROOT' => ArrayHelper::getValue($arParams, 'MENU_INFO_ROOT'),
    'CHILD' => ArrayHelper::getValue($arParams, 'MENU_INFO_CHILD'),
    'LEVEL' => ArrayHelper::getValue($arParams, 'MENU_INFO_LEVEL')
];

$arResult['SOCIAL'] = [
    'SHOW' => ArrayHelper::getValue($arParams, 'SOCIAL_SHOW') == 'Y',
    'POSITION' => ArrayHelper::getValue($arParams, 'SOCIAL_POSITION'),
    'ITEMS' => []
];

$arResult['SOCIAL']['POSITION'] = ArrayHelper::fromRange([
    'left',
    'center'
], $arResult['SOCIAL']['POSITION']);

$bSocialShow = false;

foreach ([
    'VK',
    'INSTAGRAM',
    'FACEBOOK',
    'TWITTER'
] as $sSocial) {
    $sValue = ArrayHelper::getValue($arParams, 'SOCIAL_'.$sSocial);
    $arSocial = [
        'SHOW' => !empty($sValue),
        'VALUE' => $sValue
    ];

    $bSocialShow = $bSocialShow || $arSocial['SHOW'];
    $arResult['SOCIAL']['ITEMS'][$sSocial] = $arSocial;
}

$arResult['SOCIAL']['SHOW'] = $arResult['SOCIAL']['SHOW'] && $bSocialShow;