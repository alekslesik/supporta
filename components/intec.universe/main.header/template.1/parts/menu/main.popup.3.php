<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

$arMenu = $arResult['MENU']['MAIN'];
$arMenuParams = !empty($arMenuParams) ? $arMenuParams : [];

?>
<?php $APPLICATION->IncludeComponent(
    'bitrix:menu',
    'popup.3',
    ArrayHelper::merge([
        'ROOT_MENU_TYPE' => $arMenu['ROOT'],
        'CHILD_MENU_TYPE' => $arMenu['CHILD'],
        'MAX_LEVEL' => $arMenu['LEVEL'],
        'MENU_CACHE_TYPE' => 'N',
        'USE_EXT' => 'Y',
        'DELAY' => 'N',
        'ALLOW_MULTI_SELECT' => 'N',
        'THEME' => 'dark',
        'BACKGROUND' => 'color',
        'BACKGROUND_COLOR' => '#303030',
        'BACKGROUND_PICTURE' => '/bitrix/templates/universe_s1/components/bitrix/menu/popup.3/images/instagram.png',
        'LOGOTYPE_SHOW' => $arResult['LOGOTYPE']['SHOW'] ? 'Y' : 'N',
        'LOGOTYPE' => $arResult['LOGOTYPE']['PATH'],
        'LOGOTYPE_LINK' => SITE_DIR,
        'CONTACTS_SHOW' => $arResult['CONTACTS']['SHOW']['DESKTOP'],
        'CONTACTS_CITY' => $arContact['NAME'],
        'CONTACTS_ADDRESS' => $arContact['ADDRESS'],
        'CONTACTS_SCHEDULE' => $arContact['SCHEDULE'],
        'CONTACTS_PHONE' => $arContact['PHONE']['DISPLAY'],
        'CONTACTS_EMAIL' => $arContact['EMAIL'],
        'FORMS_CALL_SHOW' => $arResult['FORMS']['CALL']['SHOW'],
        'FORMS_CALL_ID' => $arResult['FORMS']['CALL']['ID'],
        'FORMS_CALL_TEMPLATE' => $arResult['FORMS']['CALL']['TEMPLATE'],
        'FORMS_CALL_TITLE' => $arResult['FORMS']['CALL']['TITLE'],
        'CONSENT_URL' => $arResult['URL']['CONSENT'],
        'SOCIAL_SHOW' => $arResult['SOCIAL']['SHOW'],
        'SOCIAL_FIRST_LINK' => $arResult['SOCIAL']['ITEMS']['VK']['VALUE'],
        'SOCIAL_FIRST_ICON_PATH' => '/bitrix/templates/universe_s1/components/bitrix/menu/popup.3/images/vk.png',
        'SOCIAL_SECOND_LINK' => $arResult['SOCIAL']['ITEMS']['INSTAGRAM']['VALUE'],
        'SOCIAL_SECOND_ICON_PATH' => '/bitrix/templates/universe_s1/components/bitrix/menu/popup.3/images/instagram.png',
        'SOCIAL_THIRD_LINK' => $arResult['SOCIAL']['ITEMS']['FACEBOOK']['VALUE'],
        'SOCIAL_THIRD_ICON_PATH' => '/bitrix/templates/universe_s1/components/bitrix/menu/popup.3/images/facebook.png',
        'SOCIAL_FOURTH_LINK' => $arResult['SOCIAL']['ITEMS']['TWITTER']['VALUE'],
        'SOCIAL_FOURTH_ICON_PATH' => '/bitrix/templates/universe_s1/components/bitrix/menu/popup.3/images/twitter.png',
    ], $arMenuParams),
    $this->getComponent()
); ?>
<?php unset($arMenu) ?>
