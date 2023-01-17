<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

/** Коды свойств */
$arResult['PROPERTY_CODES'] = [
    'PRICE' => ArrayHelper::getValue($arParams, 'PROPERTY_PRICE')
];

/** Обработка настроенных параметров компонента */
$iLineCount = ArrayHelper::getValue($arParams, 'LINE_COUNT');

if ($iLineCount <= 1)
    $iLineCount = 1;

if ($iLineCount >= 2)
    $iLineCount = 2;

$arResult['VISUAL'] = [
    'LINE_COUNT' => $iLineCount,
    'LINK_USE' => ArrayHelper::getValue($arParams, 'LINK_USE') == 'Y',
    'DESCRIPTION_USE' => ArrayHelper::getValue($arParams, 'DESCRIPTION_USE') == 'Y',
    'DATE_SHOW' => ArrayHelper::getValue($arParams, 'DATE_SHOW') == 'Y'
];

$sDateFormat = $arParams['DATE_FORMAT'];

foreach ($arResult['ITEMS'] as &$arItem) {

    $sDateTo = $arItem['ACTIVE_TO'];
    $sDateFrom = $arItem['ACTIVE_FROM'];
    $arItem['DISPLAY_ACTIVE_TO'] = '';
    $arItem['DISPLAY_ACTIVE_FROM'] = '';

    if (!empty($sDateFormat)){
        if (!empty($sDateTo)) {
            $arItem['DISPLAY_ACTIVE_TO'] = CIBlockFormatProperties::DateFormat(
                $sDateFormat,
                MakeTimeStamp(
                    $sDateTo,
                    CSite::GetDateFormat()
                )
            );
        }
        if (!empty($sDateFrom)) {
            $arItem['DISPLAY_ACTIVE_FROM'] = CIBlockFormatProperties::DateFormat(
                $sDateFormat,
                MakeTimeStamp(
                    $sDateFrom,
                    CSite::GetDateFormat()
                )
            );
        }
    }

    if (!empty($arItem['PREVIEW_PICTURE'])) {
        $sImage = $arItem['PREVIEW_PICTURE'];
    } else if (!empty($arItem['DETAIL_PICTURE'])) {
        $sImage = $arItem['DETAIL_PICTURE'];
    }

    $sImage = CFile::ResizeImageGet($sImage, array(
        'width' => 600,
        'height' => 600
    ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

    $arItem['PREVIEW_PICTURE']['SRC'] = !empty($sImage['src']) ? $sImage['src'] : null;
}

/** Параметры кнопки "Показать все" */
$sFooterText = ArrayHelper::getValue($arParams, 'SEE_ALL_TEXT');
$sFooterText = trim($sFooterText);
$sListPage = ArrayHelper::getValue($arParams, 'LIST_PAGE_URL');

if (!empty($sListPage)) {
    $sListPage = trim($sListPage);
    $sListPage = StringHelper::replaceMacros($sListPage, $arMacros);
} else {
    $sListPage = ArrayHelper::getFirstValue($arResult['ITEMS']);
    $sListPage = $sListPage['LIST_PAGE_URL'];
}

$bFooterShow = ArrayHelper::getValue($arParams, 'SEE_ALL_SHOW');
$bFooterShow = $bFooterShow == 'Y' && !empty($sFooterText) && !empty($sListPage);

$arResult['FOOTER_BLOCK'] = [
    'SHOW' => $bFooterShow,
    'POSITION' => ArrayHelper::getValue($arParams, 'SEE_ALL_POSITION'),
    'TEXT' => $sFooterText,
    'LIST_PAGE' => $sListPage
];