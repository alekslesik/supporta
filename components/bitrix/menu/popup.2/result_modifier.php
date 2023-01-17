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

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

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

$arResult['MENU']['ITEMS'] = $fBuild($arResult);


$arPhones = $arParams['PHONES'];
$arPhones['ADVANCED'] = ArrayHelper::getValue($arParams, 'PHONES_ADVANCED_MODE') === 'Y';

$arPhones['SHOW'] = !empty($arPhones['VALUES']);

if ($arPhones['ADVANCED']) {

    $sPhonePropertyCode = ArrayHelper::getValue($arParams, 'CONTACTS_PROPERTY_PHONE');
    $sAddressPropertyCode = ArrayHelper::getValue($arParams, 'CONTACTS_PROPERTY_ADDRESS');
    $sSchedulePropertyCode = ArrayHelper::getValue($arParams, 'CONTACTS_PROPERTY_SCHEDULE');
    $sEmailPropertyCode = ArrayHelper::getValue($arParams, 'CONTACTS_PROPERTY_EMAIL');

    $bShowAddress = $arParams['CONTACTS_SHOW_ADDRESS'] == 'Y' && !empty($sAddressPropertyCode);
    $bShowSchedule = $arParams['CONTACTS_SHOW_SCHEDULE'] == 'Y' && !empty($sSchedulePropertyCode);
    $bShowEmail = $arParams['CONTACTS_SHOW_EMAIL'] == 'Y' && !empty($sEmailPropertyCode);

    if (!empty($sPhonePropertyCode) || ($bShowAddress || $bShowSchedule || $bShowEmail)) {
        if (!Loader::includeModule('intec.core'))
            return;

        if (!Loader::includeModule('iblock'))
            return;

        $iContactsIBlockId = ArrayHelper::getValue($arParams, 'CONTACTS_IBLOCK_ID');
        $iContactId = ArrayHelper::getValue($arParams, 'CONTACTS_ELEMENT');
        $arContactsId = ArrayHelper::getValue($arParams, 'CONTACTS_ELEMENTS');

        if (!empty($iContactId) && !ArrayHelper::isIn($iContactId, $arContactsId))
            $arContactsId[] = $iContactId;

        $arSort = ['SORT' => 'ASC'];
        $arFilter = [
            'ID' => $arContactsId,
            'IBLOCK_ID' => $iContactsIBlockId
        ];

        $arContact = [];
        $arContacts = [];
        $rsContacts = CIBlockElement::GetList(
            $arSort,
            $arFilter
        );

        while ($rsContact = $rsContacts->GetNextElement()) {
            $arFields = $rsContact->GetFields();
            $arFields['PROPERTIES'] = $rsContact->GetProperties();

            $sPhone = ArrayHelper::getValue($arFields, ['PROPERTIES', $sPhonePropertyCode, 'VALUE']);
            $arPhone = [
                'DISPLAY' => $sPhone,
                'VALUE' => StringHelper::replace($sPhone, [
                    '(' => '',
                    ')' => '',
                    ' ' => '',
                    '-' => ''
                ])
            ];

            $arContactValue = [
                'NAME' => $arFields['NAME'],
                'PHONE' => $arPhone,
                'ADDRESS' => ArrayHelper::getValue($arFields, ['PROPERTIES', $sAddressPropertyCode, 'VALUE']),
                'SCHEDULE' => ArrayHelper::getValue($arFields, ['PROPERTIES', $sSchedulePropertyCode, 'VALUE']),
                'EMAIL' => ArrayHelper::getValue($arFields, ['PROPERTIES', $sEmailPropertyCode, 'VALUE'])
            ];

            if ($arFields['ID'] == $iContactId) {
                $arContact = $arContactValue;
            } else {
                $arContacts[] = $arContactValue;
            }
        }
    }
}

$arEmail = [
    'SHOW' => null,
    'VALUE' => ArrayHelper::getValue($arParams, 'EMAIL')
];

$arEmail['SHOW'] = !empty($arEmail['VALUE']);

$arAddress = [
    'SHOW' => null,
    'VALUE' => ArrayHelper::getValue($arParams, 'ADDRESS')
];

$arAddress['SHOW'] = !empty($arAddress['VALUE']);

$arFormsCall = [
    'SHOW' => ArrayHelper::getValue($arParams, 'FORMS_CALL_SHOW') == 'Y',
    'ID' => ArrayHelper::getValue($arParams, 'FORMS_CALL_ID'),
    'TEMPLATE' => ArrayHelper::getValue($arParams, 'FORMS_CALL_TEMPLATE'),
    'TITLE' => ArrayHelper::getValue($arParams, 'FORMS_CALL_TITLE')
];

if ($arFormsCall['SHOW'] && empty($arFormsCall['ID']))
    $arFormsCall['SHOW'] = false;

$arSearch = [
    'SHOW' => 'Y',
    'MODE' => ArrayHelper::getValue($arParams, 'SEARCH_MODE')
];

$arSearch['MODE'] = ArrayHelper::fromRange([
    'site',
    'catalog'
], $arSearch['MODE']);

$arUrl = [
    'SEARCH' => ArrayHelper::getValue($arParams, 'SEARCH_URL'),
    'CATALOG' => ArrayHelper::getValue($arParams, 'CATALOG_URL')
];

foreach ($arUrl as $sKey => $sUrl)
    $arUrl[$sKey] = StringHelper::replaceMacros(
        $sUrl,
        $arMacros
    );


$arResult['URL'] = $arUrl;
$arResult['PHONES'] = $arPhones;
$arResult['EMAIL'] = $arEmail;
$arResult['ADDRESS'] = $arAddress;
$arResult['FORMS'] = [];
$arResult['FORMS']['CALL'] = $arFormsCall;
$arResult['SEARCH'] = $arSearch;
$arResult['CONTACT'] = $arContact;
$arResult['CONTACTS'] = $arContacts;