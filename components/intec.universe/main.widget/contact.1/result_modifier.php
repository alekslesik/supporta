<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'MAP_VENDOR' => 'yandex',
    'CONSENT_URL' => null,
    'WIDE' => 'N',
    'BLOCK_SHOW' => 'N',
    'BLOCK_VIEW' => 'left',
    'ADDRESS_SHOW' => 'N',
    'EMAIL_SHOW' => 'N',
    'FORM_SHOW' => 'N',
    'PHONE_SHOW' => 'N'
], $arParams);

$arResult['BLOCK'] = [
    'SHOW' => $arParams['BLOCK_SHOW'],
    'TITLE' => ArrayHelper::getValue($arParams, 'BLOCK_TITLE'),
    'VIEW' => ArrayHelper::fromRange([
        'left',
        'over'
    ], $arParams['BLOCK_VIEW'])
];

$arResult['ADDRESS'] = [
    'SHOW' => $arParams['ADDRESS_SHOW'] === 'Y',
    'CITY' => ArrayHelper::getValue($arParams, 'ADDRESS_CITY'),
    'STREET' => ArrayHelper::getValue($arParams, 'ADDRESS_STREET')
];

if (empty($arResult['ADDRESS']['CITY']) && empty($arResult['ADDRESS']['STREET']))
    $arResult['ADDRESS']['SHOW'] = false;

$arResult['EMAIL'] = [
    'SHOW' => $arParams['EMAIL_SHOW'] === 'Y',
    'VALUES' => []
];

if (!empty($arParams['EMAIL_VALUES']) && Type::isArray($arParams['EMAIL_VALUES'])) {
    foreach ($arParams['EMAIL_VALUES'] as $sEmail) {
        if (empty($sEmail))
            continue;

        $arResult['EMAIL']['VALUES'][] = $sEmail;
    }

    unset($sEmail);
}

if (empty($arResult['EMAIL']['VALUES']))
    $arResult['EMAIL']['SHOW'] = false;

$arResult['FORM'] = [
    'SHOW' => $arParams['FORM_SHOW'] === 'Y',
    'ID' => ArrayHelper::getValue($arParams, 'FORM_ID'),
    'TEMPLATE' => ArrayHelper::getValue($arParams, 'FORM_TEMPLATE'),
    'TITLE' => ArrayHelper::getValue($arParams, 'FORM_TITLE'),
    'BUTTON' => [
        'TEXT' => ArrayHelper::getValue($arParams, 'FORM_BUTTON_TEXT')
    ]
];

if (empty($arResult['FORM']['TITLE']))
    $arResult['FORM']['TITLE'] = Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_TITLE_DEFAULT');

if (empty($arResult['FORM']['BUTTON']['TEXT']))
    $arResult['FORM']['BUTTON']['TEXT'] = Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_BUTTON_TEXT_DEFAULT');

if (empty($arResult['FORM']['ID']))
    $arResult['FORM']['SHOW'] = false;

$arResult['PHONE'] = [
    'SHOW' => $arParams['PHONE_SHOW'] === 'Y',
    'VALUES' => []
];

if (!empty($arParams['PHONE_VALUES']) && Type::isArray($arParams['PHONE_VALUES'])) {
    foreach ($arParams['PHONE_VALUES'] as $sPhone) {
        if (empty($sPhone))
            continue;

        $sValue = StringHelper::replace($sPhone, [
            '(' => '',
            ')' => '',
            ' ' => '',
            '-' => ''
        ]);

        if (empty($sValue))
            continue;

        $arResult['PHONE']['VALUES'][] = [
            'VALUE' => $sValue,
            'DISPLAY' => $sPhone
        ];
    }

    unset($sValue);
    unset($sPhone);
}

if (empty($arResult['PHONE']['VALUES']))
    $arResult['PHONE']['SHOW'] = false;

$arResult['MAP'] = [];
$sPrefix = 'MAP_';

foreach ($arParams as $sKey => $sValue)
    if (StringHelper::startsWith($sKey, $sPrefix)) {
        $sValue = ArrayHelper::getValue($arParams, '~'.$sKey);
        $sKey = StringHelper::cut($sKey, StringHelper::length($sPrefix));
        $arResult['MAP'][$sKey] = $sValue;
    }

$arResult['MAP']['MAP_WIDTH'] = '100%';
$arResult['MAP']['MAP_HEIGHT'] = '100%';

$arResult['MAP']['INIT_MAP_TYPE'] = ArrayHelper::getValue($arParams, 'INIT_MAP_TYPE');
$arResult['WIDE'] = $arParams['WIDE'] === 'Y';

unset($sValue);
unset($sKey);
unset($sPrefix);

if (!$arResult['BLOCK']['SHOW']) {
    $arResult['ADDRESS']['SHOW'] = false;
    $arResult['EMAIL']['SHOW'] = false;
    $arResult['PHONE']['SHOW'] = false;
} else if (
    !$arResult['ADDRESS']['SHOW'] &&
    !$arResult['EMAIL']['SHOW'] &&
    !$arResult['PHONE']['SHOW']
) {
    $arResult['BLOCK']['SHOW'] = false;
}

/*$sAddressCity = ArrayHelper::getValue($arParams, 'ADDRESS_CITY');
$sAddressCity = trim($sAddressCity);
$sAddressCity = !empty($sAddressCity) ? $sAddressCity : null;
$sAddressStreet = ArrayHelper::getValue($arParams, 'ADDRESS_STREET');
$sAddressStreet = trim($sAddressStreet);
$bAddressShow = ArrayHelper::getValue($arParams , 'ADDRESS_SHOW');
$bAddressShow = $bAddressShow == 'Y' && (!empty($sAddressCity) || !empty($sAddressStreet));

$arPhoneNumber = ArrayHelper::getValue($arParams, 'PHONE_NUMBER');
$arPhoneNumber = array_filter($arPhoneNumber);
$bPhoneShow = ArrayHelper::getValue($arParams, 'PHONE_SHOW');
$bPhoneShow = $bPhoneShow == 'Y' && !empty($arPhoneNumber);

foreach ($arPhoneNumber as $iKey => $sPhone) {
    $arPhone = [
        'PRINT' => $sPhone,
        'HREF' => StringHelper::replace($sPhone, [
            '(' => '',
            ')' => '',
            ' ' => '',
            '-' => ''
        ])
    ];

    $arPhoneNumber[$iKey] = $arPhone;
}

$arEmailAddress = ArrayHelper::getValue($arParams, 'EMAIL_ADDRESS');
$arEmailAddress = array_filter($arEmailAddress);
$bEmailAddressShow = ArrayHelper::getValue($arParams, 'EMAIL_SHOW');
$bEmailAddressShow = $bEmailAddressShow == 'Y' && !empty($arEmailAddress);

$bInfoShow = ArrayHelper::getValue($arParams, 'INFO_SHOW');
$bInfoShow = $bInfoShow == 'Y' && ($bAddressShow || $bPhoneShow || $bEmailAddressShow);
$sInfoTitle = ArrayHelper::getValue($arParams, 'INFO_TITLE');
$sInfoTitle = trim($sInfoTitle);

$sOrderCallConsent = ArrayHelper::getValue($arParams, 'ORDER_CALL_CONSENT');
$sOrderCallConsent = trim($sOrderCallConsent);
$sOrderCallConsent = StringHelper::replaceMacros($sOrderCallConsent, ['SITE_SIR' => SITE_DIR]);
$sOrderCallForm = ArrayHelper::getValue($arParams, 'ORDER_CALL_FORM');
$sOrderCallFormTemplate = ArrayHelper::getValue($arParams, 'ORDER_CALL_FORM_TEMPLATE');
$sOrderCallTitle = ArrayHelper::getValue($arParams, 'ORDER_CALL_TITLE');
$sOrderCallTitle = trim($sOrderCallTitle);
$sOrderCallText = ArrayHelper::getValue($arParams, 'ORDER_CALL_TEXT');
$sOrderCallText = trim($sOrderCallText);
$sOrderCallText = !empty($sOrderCallText) ? $sOrderCallText : Loc::getMessage('T_MGV_TEMP1_FORM_CALL_TEXT_DEFAULT');
$bOrderCallShow = ArrayHelper::getValue($arParams, 'ORDER_CALL_SHOW');
$bOrderCallShow = $bOrderCallShow == 'Y' && !empty($sOrderCallForm);

$sMapComponent = ($arParams['MAP_VENDOR'] == 'google') ? "bitrix:map.google.view" : "bitrix:map.yandex.view";

$arResult['VIEW_PARAMETERS'] = [
    'WIDTH' => ArrayHelper::getValue($arParams, 'WIDTH') == 'Y',
    'INFO_SHOW' => $bInfoShow,
    'BLOCK_INFO_POSITION' => ArrayHelper::getValue($arParams, 'BLOCK_INFO_VIEW'),
    'INFO_TITLE' => Html::encode($sInfoTitle),
    'ADDRESS_SHOW' => $bAddressShow,
    'ADDRESS_CITY' => $sAddressCity,
    'ADDRESS_STREET' => $sAddressStreet,
    'PHONE_SHOW' => $bPhoneShow,
    'PHONE_NUMBER' => $arPhoneNumber,
    'ORDER_CALL_SHOW' => $bOrderCallShow,
    'ORDER_CALL_FORM' => $sOrderCallForm,
    'ORDER_CALL_FORM_TEMPLATE' => $sOrderCallFormTemplate,
    'ORDER_CALL_CONSENT' => $sOrderCallConsent,
    'ORDER_CALL_TITLE' => Html::encode($sOrderCallTitle),
    'ORDER_CALL_TEXT' => Html::encode($sOrderCallText),
    'EMAIL_SHOW' => $bEmailAddressShow,
    'EMAIL_ADDRESS' => $arEmailAddress,
    'MAP_VENDOR' => $sMapComponent
];*/