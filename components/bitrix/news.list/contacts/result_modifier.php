<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\RegExp;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!CModule::IncludeModule('intec.core'))
    return;


$arParams = ArrayHelper::merge([
    'MAP_VENDOR' => 'google',
    'CONTACTS_TITLE_SHOW' => 'N',
    'CONTACTS_DESCRIPTION_SHOW' => 'N'
], $arParams);

if ($arParams['SETTINGS_USE'] == 'Y')
    include(__DIR__.'/parts/settings.php');

$arResult['TITLE'] = null;
$arParams['MAP_VENDOR'] = ArrayHelper::fromRange([
    'google',
    'yandex'
], $arParams['MAP_VENDOR']);

if ($arParams['TITLE_SHOW'] == 'Y') {
    $arResult['TITLE'] = (!empty($arParams['TITLE'])) ? $arParams['TITLE'] : GetMessage('N_L_CONTACTS_LIST_OFFICES');
}

$arResult['DESCRIPTION'] = null;

if ($arParams['DESCRIPTION_SHOW'] == 'Y') {
    $arResult['DESCRIPTION'] = (!empty($arParams['DESCRIPTION'])) ? $arParams['DESCRIPTION'] : GetMessage('N_L_CONTACTS_LIST_OFFICES_DESCRIPTION');
}

$mapId = $arParams['MAP_ID'];
$mapIdLength = StringHelper::length($mapId);
$mapIdExpression = new RegExp('^[A-Za-z_][A-Za-z01-9_]*$');

if ($mapIdLength <= 0 || $mapIdExpression->isMatch($mapId))
    $arParams['MAP_ID'] = 'MAP_'.RandString();

$sIBlockType = ArrayHelper::getValue($arParams, 'IBLOCK_TYPE');
$iIBlockId = ArrayHelper::getValue($arParams, 'IBLOCK_ID');

$arProperties = array(
    'PROPERTY_MAP' => 'MAP',
    'PROPERTY_ADDRESS' => 'ADDRESS',
    'PROPERTY_PHONE' => 'PHONE',
    'PROPERTY_PHONE_HELP' => 'PHONE_HELP',
    'PROPERTY_EMAIL' => 'EMAIL',
    'PROPERTY_WORK_TIME' => 'WORK_TIME',
    'PROPERTY_OPENING_HOURS' => 'OPENING_HOURS',
    'PROPERTY_STORE_ID' => 'STORE_ID'
);



$arSections = array();

if (!empty($sIBlockType) && !empty($iIBlockId)) {
    if ($arParams['SHOW_LIST'] != 'NONE') {
        $rsSections = CIBlockSection::GetList(array(
            'SORT' => 'ASC'
        ), array(
            'ACTIVE' => 'Y',
            'SECTION_ID' => false,
            'IBLOCK_TYPE' => $sIBlockType,
            'IBLOCK_ID' => $iIBlockId
        ));

        while ($arSection = $rsSections->Fetch()) {
            $arSection['ITEMS'] = array();
            $arSections[$arSection['ID']] = $arSection;
        }
    }
}

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['SYSTEM_PROPERTIES'] = [];

    foreach ($arProperties as $sPropertyKey => $sPropertyName) {
        $arItem['SYSTEM_PROPERTIES'][$sPropertyName] = null;

        $sPropertyParameter = ArrayHelper::getValue($arParams, $sPropertyKey);

        if (!empty($sPropertyParameter))
            if (ArrayHelper::keyExists($sPropertyParameter, $arItem['PROPERTIES']))
                $arItem['SYSTEM_PROPERTIES'][$sPropertyName] = ArrayHelper::getValue($arItem, ['PROPERTIES', $sPropertyParameter]);
    }

    if (!empty($arItem['SYSTEM_PROPERTIES']['PHONE']['VALUE'])) {
        $arItem['SYSTEM_PROPERTIES']['PHONE']['VALUE_CLEAN'] = StringHelper::replace(
            $arItem['SYSTEM_PROPERTIES']['PHONE']['VALUE'], [
                '-' => '',
                ' ' => '',
                '(' => '',
                ')' => ''
            ]
        );
    }

    if (!empty($arItem['SYSTEM_PROPERTIES']['PHONE_HELP']['VALUE'])) {
        $arItem['SYSTEM_PROPERTIES']['PHONE_HELP']['VALUE_CLEAN'] = StringHelper::replace(
            $arItem['SYSTEM_PROPERTIES']['PHONE_HELP']['VALUE'], [
                '-' => '',
                ' ' => '',
                '(' => '',
                ')' => ''
            ]
        );
    }

    if (ArrayHelper::keyExists($arItem['IBLOCK_SECTION_ID'], $arSections)) {
        $arSections[$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = &$arItem;
    }
}

unset($arItem);

$contact = null;
$contactId = $arParams['CONTACT_ID'];

if (!empty($contactId))
    foreach ($arResult['ITEMS'] as $contact)
        if ($contact['ID'] == $contactId) {
            $arResult['CONTACT'] = $contact;
            break;
        }

$arResult['CONTACT'] = $contact;
$arResult['SECTIONS'] = $arSections;
$arResult['WEB_FORM_CONSENT_URL'] = StringHelper::replaceMacros($arParams['WEB_FORM_CONSENT_URL'], [
    'SITE_DIR' => SITE_DIR
]);