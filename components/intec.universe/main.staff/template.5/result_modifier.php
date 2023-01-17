<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'COLUMNS' => 2,
    'HIDING_USE' => 'N',
    'HIDING_VISIBLE' => 2
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR
];

$arResult['VISUAL']['COLUMNS'] = ArrayHelper::fromRange([1, 2], $arParams['COLUMNS']);
$arResult['VISUAL']['HIDING'] = [
    'USE' => $arParams['HIDING_USE'] === 'Y',
    'VISIBLE' => Type::toInteger($arParams['HIDING_VISIBLE'])
];

if ($arResult['VISUAL']['HIDING']['VISIBLE'] < 1)
    $arResult['VISUAL']['HIDING']['VISIBLE'] = 1;

if (count($arResult['ITEMS']) <= $arResult['VISUAL']['HIDING']['VISIBLE'] * $arResult['VISUAL']['COLUMNS'])
    $arResult['VISUAL']['HIDING']['USE'] = false;