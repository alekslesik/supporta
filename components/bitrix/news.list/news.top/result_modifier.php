<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var array $arParams
 */

/** Коды свойств */
$sTag = ArrayHelper::getValue($arParams, 'PROPERTY_TAG');

$arResult['PROPERTY_CODES'] = [
    'TAG' => $sTag
];

/** Параметры заголовка */
$sHeaderText = ArrayHelper::getValue($arParams, 'HEADER_TEXT');
$sHeaderText = trim($sHeaderText);
$bHeaderShow = ArrayHelper::getValue($arParams, 'HEADER_SHOW');
$bHeaderShow = $bHeaderShow == 'Y' && !empty($sHeaderText);

$arResult['HEADER_BLOCK'] = [
    'SHOW' => $bHeaderShow,
    'TEXT' => Html::encode($sHeaderText)
];

/** Параметры отображения шаблона */
$arResult['VIEW_PARAMETERS'] = [
    'DATE_SHOW' => ArrayHelper::getValue($arParams, 'DATE_SHOW') == 'Y',
    'TAG_SHOW' => ArrayHelper::getValue($arParams, 'TAG_SHOW') == 'Y',
    'TAG_DISABLED' => ArrayHelper::getValue($arParams, 'TAG_DISABLED') == 'Y'
];

/** Название переменной, для хранения тегов */
$sVariableName = ArrayHelper::getValue($arParams, 'TAG_VARIABLE_NAME');
$sVariableName = trim($sVariableName);
$sVariableName = !empty($sVariableName) ? $sVariableName : 'tag';

$arResult['VARIABLE_TAG'] = $sVariableName;

/** Обработка данных */
$sLengthText = ArrayHelper::getValue($arParams, 'PREVIEW_TRUNCATE_LEN');

$arTags = [];

foreach ($arResult['ITEMS'] as $iKey => $arItem) {
    /** Обработка текста */
    $sPreviewText = ArrayHelper::getValue($arItem, 'PREVIEW_TEXT');

    if (!empty($sPreviewText) && empty($sLengthText)) {
        $sPreviewText = TruncateText($sPreviewText, 90);
        $arItem['PREVIEW_TEXT'] = $sPreviewText;
    }

    /** Обработка даты */
    $sDate = ArrayHelper::getValue($arItem, 'DATE_CREATE');
    $arItem['DATE_PRINT'] = FormatDate($arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($sDate));

    /** Обработка тегов */
    $arPropertyTag = ArrayHelper::getValue($arItem, ['PROPERTIES', $sTag]);

    if (!empty($arPropertyTag['VALUE_ENUM_ID'])) {
        foreach ($arPropertyTag['VALUE_ENUM_ID'] as $iKeyValue => $sValue) {
            $arTags[$sValue] = [
                'VALUE_SORT' => $arPropertyTag['VALUE_SORT'][$iKeyValue],
                'VALUE' => '#' . $arPropertyTag['VALUE'][$iKeyValue],
                'DESCRIPTION' => $arPropertyTag['DESCRIPTION'][$iKeyValue],
                'VALUE_XML_ID' => $arPropertyTag['VALUE_XML_ID'][$iKeyValue],
                'VALUE_ENUM' => $arPropertyTag['VALUE_ENUM'][$iKeyValue],
                'VALUE_ENUM_ID' => $arPropertyTag['VALUE_ENUM_ID'][$iKeyValue]
            ];
        }
    }

    $arResult['ITEMS'][$iKey] = $arItem;
}

$arResult['TAGS'] = $arTags;