<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * CBitrixComponentTemplate $this
 */

/**
 * @param array $arResult
 * @return array
 */

if (!Loader::includeModule('iblock'))
    return;

$arParams = ArrayHelper::merge([
    'THEME' => 'light',
    'BACKGROUND' => 'none',
    'BACKGROUND_COLOR' => null,
    'BACKGROUND_PICTURE' => null,
    'LOGOTYPE_SHOW' => 'N',
    'LOGOTYPE' => null,
    'LOGOTYPE_LINK' => null,
    'CONTACTS_SHOW' => 'N',
    'CONTACTS_CITY' => null,
    'CONTACTS_ADDRESS' => null,
    'CONTACTS_SCHEDULE' => null,
    'CONTACTS_PHONE' => null,
    'CONTACTS_EMAIL' => null,
    'FORMS_CALL_SHOW' => 'N',
    'FORMS_CALL_ID' => null,
    'FORMS_CALL_TEMPLATE' => null,
    'FORMS_CALL_TITLE' => null,
    'CONSENT_URL' => null,
    'SOCIAL_SHOW' => 'N',
    'SOCIAL_FIRST_LINK' => null,
    'SOCIAL_FIRST_ICON_PATH' => null,
    'SOCIAL_SECOND_LINK' => null,
    'SOCIAL_SECOND_ICON_PATH' => null,
    'SOCIAL_THIRD_LINK' => null,
    'SOCIAL_THIRD_ICON_PATH' => null,
    'SOCIAL_FOURTH_LINK' => null,
    'SOCIAL_FOURTH_ICON_PATH' => null,
], $arParams);


$sPageUrl = $APPLICATION->GetCurPage();

foreach ($arResult as &$arItem) {
    $arItem['ACTIVE'] = false;

    if ($arItem['LINK'] == $sPageUrl)
        $arItem['ACTIVE'] = true;

    unset($arItem);
}

$fBuild = function ($arResult) {
    $bFirst = true;

    if (empty($arResult))
        return [];

    $fBuild = function () use (&$fBuild, &$bFirst, &$arResult) {
        $iLevel = null;
        $arItems = array();
        $arItem = null;

        if ($bFirst) {
            $arItem = reset($arResult);
            $bFirst = false;
        }

        while (true) {
            if ($arItem === null) {
                $arItem = next($arResult);

                if (empty($arItem))
                    break;
            }

            if ($iLevel === null)
                $iLevel = $arItem['DEPTH_LEVEL'];

            if ($arItem['DEPTH_LEVEL'] < $iLevel) {
                prev($arResult);
                break;
            }

            if ($arItem['IS_PARENT'] === true)
                $arItem['ITEMS'] = $fBuild();

            $arItems[] = $arItem;
            $arItem = null;
        }

        return $arItems;
    };

    return $fBuild();
};

$arResult = $fBuild($arResult);

if (!empty($arParams['CONTACTS_PHONE']))
    $arParams['CONTACTS_PHONE'] = [
        'DISPLAY' => $arParams['CONTACTS_PHONE'],
        'VALUE' => StringHelper::replace($arParams['CONTACTS_PHONE'], [
            '(' => '',
            ')' => '',
            ' ' => '',
            '-' => ''
        ])
    ];

$arResult['VISUAL'] = [
    'THEME' => ArrayHelper::getValue($arParams, 'THEME'),
    'BACKGROUND' => [
        'TYPE' => ArrayHelper::getValue($arParams, 'BACKGROUND'),
        'COLOR' => ArrayHelper::getValue($arParams, 'BACKGROUND_COLOR'),
        'URL' => ArrayHelper::getValue($arParams, 'BACKGROUND_PICTURE')
    ]
];

$arResult['CONTACTS'] = [
    'SHOW' => ArrayHelper::getValue($arParams, 'CONTACTS_SHOW') == 'Y',
    'CITY' => ArrayHelper::getValue($arParams, 'CONTACTS_CITY'),
    'ADDRESS' => ArrayHelper::getValue($arParams, 'CONTACTS_ADDRESS'),
    'SCHEDULE' => ArrayHelper::getValue($arParams, 'CONTACTS_SCHEDULE'),
    'PHONE' => ArrayHelper::getValue($arParams, 'CONTACTS_PHONE'),
    'EMAIL' => ArrayHelper::getValue($arParams, 'CONTACTS_EMAIL')
];

$arResult['FORMS'] = [
    'CALL' => [
        'SHOW' => ArrayHelper::getValue($arParams, 'FORMS_CALL_SHOW'),
        'ID' => ArrayHelper::getValue($arParams, 'FORMS_CALL_ID'),
        'TEMPLATE' => ArrayHelper::getValue($arParams, 'FORMS_CALL_TEMPLATE'),
        'TITLE' => ArrayHelper::getValue($arParams, 'FORMS_CALL_TITLE')
    ],
    'CONSENT_URL' => ArrayHelper::getValue($arParams, 'CONSENT_URL')
];

$arResult['SOCIAL'] = [
    'SHOW' => ArrayHelper::getValue($arParams, 'SOCIAL_SHOW') == 'Y',
    'ITEMS' => [
        'FIRST' => [
            'LINK' => ArrayHelper::getValue($arParams, 'SOCIAL_FIRST_LINK'),
            'ICON_URL' => ArrayHelper::getValue($arParams, 'SOCIAL_FIRST_ICON_PATH')
        ],
        'SECOND' => [
            'LINK' => ArrayHelper::getValue($arParams, 'SOCIAL_SECOND_LINK'),
            'ICON_URL' => ArrayHelper::getValue($arParams, 'SOCIAL_SECOND_ICON_PATH')
        ],
        'THIRD' => [
            'LINK' => ArrayHelper::getValue($arParams, 'SOCIAL_THIRD_LINK'),
            'ICON_URL' => ArrayHelper::getValue($arParams, 'SOCIAL_THIRD_ICON_PATH')
        ],
        'FOURTH' => [
            'LINK' => ArrayHelper::getValue($arParams, 'SOCIAL_FOURTH_LINK'),
            'ICON_URL' => ArrayHelper::getValue($arParams, 'SOCIAL_FOURTH_ICON_PATH')
        ],
    ]
];