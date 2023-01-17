<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
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

/** Вид отображения */
$arResult['VIEW'] = ArrayHelper::getValue($arParams, 'VIEW');

/** Заголовок блока */
$sTitle = ArrayHelper::getValue($arParams, 'TITLE');
$sTitle = trim($sTitle);
$sTitle = !empty($sTitle) ? $sTitle : Loc::getMessage('C_FORM_TEMP1_TITLE_DEFAULT');
$arResult['TITLE'] = [
    'TEXT' => $sTitle
];

/** Описание блока */
$sDescription = ArrayHelper::getValue($arParams, 'DESCRIPTION');
$sDescription = trim($sDescription);
$bDescriptionShow = ArrayHelper::getValue($arParams, 'DESCRIPTION_SHOW');
$bDescriptionShow = $bDescriptionShow == 'Y' && !empty($sDescription);
$arResult['DESCRIPTION'] = [
    'SHOW' => $bDescriptionShow,
    'TEXT' => $sDescription
];

/** Фоновое изображение */
$sImgPath = ArrayHelper::getValue($arParams, 'IMAGE');
$sImgPath = trim($sImgPath);
$sImgPath = StringHelper::replaceMacros($sImgPath, $arMacros);
$bImgShow = !empty($sImgPath);

$arResult['IMAGE'] = [
    'SHOW' => $bImgShow,
    'SRC' => $sImgPath,
];

/** Кнопка */
$arResult['BUTTON_ONE'] = [
    'TEXT' => ArrayHelper::getValue($arParams, 'BUTTON1_TEXT')
];
$arResult['BUTTON_TWO'] = [
    'TEXT' => ArrayHelper::getValue($arParams, 'BUTTON2_TEXT'),
];