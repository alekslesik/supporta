<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var array $arParams
 */

$sReadAlsoHeader = ArrayHelper::getValue($arParams, 'READ_ALSO_TITLE');
$sReadAlsoHeader = trim($sReadAlsoHeader);
$sPropertyReadAlso = ArrayHelper::getValue($arParams, 'PROPERTY_READ_ALSO');
$bReadAlsoShow = ArrayHelper::getValue($arParams, 'READ_ALSO_SHOW');
$bReadAlsoShow = $bReadAlsoShow == 'Y' && !empty($sPropertyReadAlso);
$sBackText = ArrayHelper::getValue($arParams, 'BACK_TEXT');
$sBackText = trim($sBackText);
$bBackShow = ArrayHelper::getValue($arParams, 'BACK_SHOW');
$bBackShow = $bBackShow == 'Y' && !empty($sBackText);

$arResult['VIEW_PARAMETERS'] = [
    'DATE_SHOW' => ArrayHelper::getValue($arParams, 'DATE_SHOW') == 'Y',
    'PREVIEW_SHOW' => ArrayHelper::getValue($arParams, 'PREVIEW_SHOW') == 'Y',
    'IMAGE_SHOW' => ArrayHelper::getValue($arParams, 'IMAGE_SHOW') == 'Y',
    'READ_ALSO_SHOW' => $bReadAlsoShow,
    'READ_ALSO_VIEW' => ArrayHelper::getValue($arParams, 'VIEW_READ_ALSO'),
    'READ_ALSO_HEADER' => Html::encode($sReadAlsoHeader),
    'TAG_SHOW' => ArrayHelper::getValue($arParams, 'TAG_SHOW'),
    'BACK_SHOW' => $bBackShow,
    'BACK_TEXT' => Html::encode($sBackText),
    'SOCIAL_SHOW' => ArrayHelper::getValue($arParams, 'SOCIAL_SHOW') == 'Y',
    'SOCIAL_LIST' => ArrayHelper::getValue($arParams, 'SOCIAL_LIST')
];

$sPropertyReadAlso = ArrayHelper::getValue($arParams, 'PROPERTY_READ_ALSO');

$arResult['PROPERTY_CODES'] = [
    'TAG' => ArrayHelper::getValue($arParams, 'PROPERTY_TAG'),
    'READ_ALSO' => $sPropertyReadAlso
];
$arResult['FILTER'] = [
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'ID' => ArrayHelper::getValue($arResult, ['PROPERTIES', $sPropertyReadAlso, 'VALUE'])
];
$arResult['FILTER'] = array_filter($arResult['FILTER']);

$this->__component->arResult['PREVIEW_TEXT'] = $arResult['PREVIEW_TEXT'];
$this->__component->arResult['PREVIEW_PICTURE'] = $arResult['PREVIEW_PICTURE']['SRC'];

$this->__component->SetResultCacheKeys(['PREVIEW_TEXT', 'PREVIEW_PICTURE']);