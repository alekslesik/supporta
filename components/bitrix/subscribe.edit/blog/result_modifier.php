<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;
use intec\constructor\models\Build;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arResult['CONSENT'] = [
    'SHOW' => false,
    'URL' => null
];

if (!Loader::includeModule('intec.core'))
    return;

$sHeaderText = ArrayHelper::getValue($arParams, 'HEADER_TEXT');
$sHeaderText = trim($sHeaderText);
$bHeaderShow = ArrayHelper::getValue($arParams, 'HEADER_SHOW');
$bHeaderShow = $bHeaderShow == 'Y' && !empty($sHeaderText);

$arResult['HEADER_BLOCK'] = [
    'SHOW' => $bHeaderShow,
    'POSITION' => ArrayHelper::getValue($arParams, 'HEADER_POSITION'),
    'TEXT' => Html::encode($sHeaderText)
];

$arSubscribeRubrics = array_filter(ArrayHelper::getValue($arParams, 'SUBSCRIBE_RUBRICS'));
$arSubscribeRubrics = !empty($arSubscribeRubrics) ? $arSubscribeRubrics : [0 => 0];

$arResult['SUBSCRIBE_RUBRICS'] = $arSubscribeRubrics;
$arResult['SUBSCRIBE_TYPE'] = ArrayHelper::getValue($arParams, 'SUBSCRIBE_TYPE');

$arConsent = [
    'SHOW' => false,
    'URL' => ArrayHelper::getValue($arParams, 'CONSENT_URL')
];

$oBuild = Build::getCurrent();

if (!empty($oBuild)) {
    $oPage = $oBuild->getPage();
    $oProperties = $oPage->getProperties();
    $arConsent['SHOW'] = $oProperties->get('base-consent');
}

if (!empty($arConsent['URL'])) {
    $arConsent['URL'] = StringHelper::replaceMacros($arConsent['URL'], ['SITE_DIR' => SITE_DIR]);
} else {
    $arConsent['SHOW'] = false;
}

$arResult['CONSENT'] = $arConsent;