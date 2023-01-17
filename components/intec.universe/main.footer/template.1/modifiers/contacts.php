<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global $APPLICATION
 */

$arParams = ArrayHelper::merge([
    'ADDRESS_SHOW' => 'N',
    'ADDRESS_VALUE' => null,
    'EMAIL_SHOW' => 'N',
    'EMAIL_VALUE' => null
], $arParams);

$arResult['ADDRESS'] = [
    'SHOW' => $arParams['ADDRESS_SHOW'] === 'Y',
    'VALUE' => $arParams['ADDRESS_VALUE']
];

if (empty($arResult['ADDRESS']['VALUE']))
    $arResult['ADDRESS']['SHOW'] = false;

$arResult['EMAIL'] = [
    'SHOW' => $arParams['EMAIL_SHOW'] === 'Y',
    'VALUE' => $arParams['EMAIL_VALUE']
];

if (empty($arResult['EMAIL']['VALUE']))
    $arResult['EMAIL']['SHOW'] = false;