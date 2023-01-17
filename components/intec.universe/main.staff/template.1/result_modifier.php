<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'LINE_COUNT' => 4,
    'POSITION_SHOW' => 'N',
    'SOCIALS_SHOW' => 'N',
    'PROPERTY_POSITION' => null,
    'PROPERTY_LINK_VKONTAKTE' => null,
    'PROPERTY_LINK_FACEBOOK' => null,
    'PROPERTY_LINK_INSTAGRAM' => null,
    'PROPERTY_LINK_TWITTER' => null
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR
];

$arResult['VISUAL']['COLUMNS'] = ArrayHelper::fromRange([3, 4, 5], $arParams['LINE_COUNT']);
$arResult['VISUAL']['POSITION'] = [
    'SHOW' => $arParams['POSITION_SHOW'] === 'Y'
];

$arResult['VISUAL']['SOCIALS'] = [
    'SHOW' => $arParams['SOCIALS_SHOW'] === 'Y',
    'LIST' => [
        'VKONTAKTE' => [],
        'FACEBOOK' => [],
        'INSTAGRAM' => [],
        'TWITTER' => []
    ]
];

foreach ($arResult['VISUAL']['SOCIALS']['LIST'] as $sCode => &$arSocial) {
    $arSocial['CODE'] = $sCode;
    $arSocial['NAME'] = Loc::getMessage('C_MAIN_STAFF_TEMPLATE_1_SOCIALS_'.$sCode);
    $arSocial['ICON'] = null;
}

unset($sCode);
unset($arSocial);

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['POSITION'] = ArrayHelper::getValue($arItem, [
        'PROPERTIES',
        $arParams['PROPERTY_POSITION'],
        'VALUE'
    ]);

    $arItem['SOCIALS'] = [];

    foreach ($arResult['VISUAL']['SOCIALS']['LIST'] as $arSocial) {
        $sProperty = $arParams['PROPERTY_LINK_'.$arSocial['CODE']];
        $arItem['SOCIALS'][$arSocial['CODE']] = null;

        if (!empty($sProperty))
            $arItem['SOCIALS'][$arSocial['CODE']] = ArrayHelper::getValue($arItem, [
                'PROPERTIES',
                $sProperty,
                'VALUE'
            ]);
    }

    unset($sProperty);
}

unset($arItem);