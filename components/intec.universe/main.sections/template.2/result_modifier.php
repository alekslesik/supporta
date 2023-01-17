<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'LINE_COUNT' => 4,
    'SUB_SECTIONS_SHOW' => 'N',
    'SUB_SECTIONS_MAX' => 3
], $arParams);

$arResult['VISUAL']['COLUMNS'] = ArrayHelper::fromRange([5, 4, 3], $arParams['LINE_COUNT']);
$arResult['VISUAL']['CHILDREN'] = [
    'SHOW' => $arParams['SUB_SECTIONS_SHOW'] === 'Y',
    'COUNT' => Type::toInteger($arParams['SUB_SECTIONS_MAX'])
];

if (empty($arResult['VISUAL']['CHILDREN']['COUNT']) && !Type::isNumeric($arResult['VISUAL']['CHILDREN']['COUNT']))
    $arResult['VISUAL']['CHILDREN']['COUNT'] = null;