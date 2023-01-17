<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

/** Параметры отображения шаблона */
$sColumn = ArrayHelper::getValue($arParams, 'COLUMN');
$sColumn = !empty($sColumn) ? $sColumn : 'N';
$sView = ArrayHelper::getValue($arParams, 'VIEW');
$sGrid = ArrayHelper::getValue($arParams, 'GRID');

if ($sView == 'big-block') {
    if ($sColumn == 'Y') {
        $sGrid = 3;
    } else {
        $sGrid = 4;
    }
}

$arResult['VIEW_PARAMETERS'] = [
    'VIEW' => $sView,
    'GRID' => $sGrid,
    'DATE_SHOW' => ArrayHelper::getValue($arParams, 'DATE_SHOW') == 'Y',
    'TAG_SHOW' => ArrayHelper::getValue($arParams, 'TAG_SHOW') == 'Y',
    'DESCRIPTION_SHOW' => ArrayHelper::getValue($arParams, 'DESCRIPTION_SHOW') == 'Y'
];

/** Коды свойств */
$sTag = ArrayHelper::getValue($arParams, 'PROPERTY_TAG');

$arResult['PROPERTY_CODES'] = [
    'TAG' => $sTag
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
    $sDate = ArrayHelper::getValue($arItem, 'ACTIVE_FROM');

    if (empty($sDate))
    $sDate = ArrayHelper::getValue($arItem, 'DATE_CREATE');

    $arItem['DATE_PRINT'] = FormatDate($arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($sDate));

    /** Обработка картинок */
    $arPreviewPicture = ArrayHelper::getValue($arItem, 'PREVIEW_PICTURE');
    $arDetailPicture = ArrayHelper::getValue($arItem, 'DETAIL_PICTURE');
    $sNoImage = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

    if (empty($arPreviewPicture) && !empty($arDetailPicture)) {
        $arPreviewPicture = $arDetailPicture;
    }

    if (!empty($arPreviewPicture)) {
        $arPicture = CFile::ResizeImageGet(
            $arPreviewPicture,
            array(
                'width' => 800,
                'height' => 800
            ),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT
        );

        $arItem['PREVIEW_PICTURE']['SRC'] = $arPicture['src'];
    } else {
        $arItem['PREVIEW_PICTURE']['SRC'] = $sNoImage;
    }

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