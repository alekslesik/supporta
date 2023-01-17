<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'THEME' => 'light',
    'ICON_SHOW' => 'N',
    'BACKGROUND_USE' => 'N',
    'BACKGROUND_PATH' => '#TEMPLATE_PATH#images/background.png'
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/',
    'TEMPLATE_PATH' => $this->GetFolder().'/'
];

$arResult['VISUAL']['THEME'] = ArrayHelper::fromRange([
    'dark',
    'light'
], $arParams['THEME']);

$arResult['VISUAL']['ICON'] = [
    'SHOW' => $arParams['ICON_SHOW'] === 'Y'
];

$arResult['VISUAL']['BACKGROUND'] = [
    'USE' => $arParams['BACKGROUND_USE'] === 'Y',
    'PATH' => $arParams['BACKGROUND_PATH']
];

if (!empty($arResult['VISUAL']['BACKGROUND']['PATH'])) {
    $arResult['VISUAL']['BACKGROUND']['PATH'] = StringHelper::replaceMacros(
        $arResult['VISUAL']['BACKGROUND']['PATH'],
        $arMacros
    );
} else {
    $arResult['VISUAL']['BACKGROUND']['USE'] = false;
}