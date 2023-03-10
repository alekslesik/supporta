<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arParams = ArrayHelper::merge([
    'ADAPTATION_USE' => 'Y',
    'ADAPTATION_MODE' => 'cover',
    'WIDTH' => 'parent',
    'HEIGHT' => 'parent'
], $arParams);

$arResult['ADAPTATION'] = [
    'USE' => $arParams['ADAPTATION_USE'] === 'Y',
    'MODE' => ArrayHelper::fromRange([
        'cover',
        'contain'
    ], $arParams['ADAPTATION_MODE'])
];

$arResult['WIDTH'] = $arParams['WIDTH'];
$arResult['HEIGHT'] = $arParams['HEIGHT'];

if (Type::isNumeric($arResult['WIDTH'])) {
    if ($arResult['WIDTH'] == Type::toInteger($arResult['WIDTH']))
        $arResult['WIDTH'] .= 'px';
} else {
    $arResult['WIDTH'] = '100%';
}

if (Type::isNumeric($arResult['HEIGHT'])) {
    if ($arResult['HEIGHT'] == Type::toInteger($arResult['HEIGHT']))
        $arResult['HEIGHT'] .= 'px';
} else {
    $arResult['HEIGHT'] = '100%';
}