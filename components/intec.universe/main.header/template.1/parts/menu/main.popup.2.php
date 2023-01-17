<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

$arMenu = $arResult['MENU']['MAIN'];
$arMenuParams = !empty($arMenuParams) ? $arMenuParams : [];

?>
<?php $APPLICATION->IncludeComponent(
    'bitrix:menu',
    'popup.2',
    ArrayHelper::merge([
        'ROOT_MENU_TYPE' => $arMenu['ROOT'],
        'CHILD_MENU_TYPE' => $arMenu['CHILD'],
        'MAX_LEVEL' => $arMenu['LEVEL'],
        'MENU_CACHE_TYPE' => 'N',
        'USE_EXT' => 'Y',
        'DELAY' => 'N',
        'ALLOW_MULTI_SELECT' => 'N',
        'LOGOTYPE_SHOW' => $arResult['LOGOTYPE']['SHOW'] ? 'Y' : 'N',
        'LOGOTYPE' => $arResult['LOGOTYPE']['PATH'],
        'LOGOTYPE_LINK' => SITE_DIR,
        'PHONES' => $arResult['PHONES'],
        'PHONES_ADVANCED_MODE' => $arParams['PHONES_ADVANCED_MODE'],
        'CONTACTS_PROPERTY_PHONE' => $arParams['CONTACTS_PROPERTY_PHONE'],
        'EMAIL' => $arParams['EMAIL'],
        'CONTACTS_PROPERTY_ADDRESS' => $arParams['CONTACTS_PROPERTY_ADDRESS'],
        'ADDRESS' => $arParams['ADDRESS'],
        'CONTACTS_PROPERTY_SCHEDULE' => $arParams['CONTACTS_PROPERTY_SCHEDULE'],
        'CONTACTS_PROPERTY_EMAIL' => $arParams['CONTACTS_PROPERTY_EMAIL'],
        'CONTACTS_SHOW_ADDRESS' => $arParams['CONTACTS_ADDRESS_SHOW'],
        'CONTACTS_SHOW_SCHEDULE' => $arParams['CONTACTS_SCHEDULE_SHOW'],
        'CONTACTS_SHOW_EMAIL' => $arParams['CONTACTS_EMAIL_SHOW'],
        'CONTACTS_IBLOCK_ID' => $arParams['CONTACTS_IBLOCK_ID'],
        'CONTACTS_ELEMENT' => $arParams['CONTACTS_ELEMENT'],
        'CONTACTS_ELEMENTS' => $arParams['CONTACTS_ELEMENTS'],
        'FORMS_CALL_SHOW' => $arParams['FORMS_CALL_SHOW'],
        'FORMS_CALL_ID' => $arParams['FORMS_CALL_ID'],
        'FORMS_CALL_TEMPLATE' => $arParams['FORMS_CALL_TEMPLATE'],
        'FORMS_CALL_TITLE' => $arParams['FORMS_CALL_TITLE'],
        'SEARCH_MODE' => $arParams['SEARCH_MODE'],
        'SEARCH_URL' => $arParams['SEARCH_URL'],
        'CATALOG_URL' => $arParams['CATALOG_URL'],
    ], $arMenuParams),
    $this->getComponent()
); ?>
<?php unset($arMenu) ?>
