<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arParams = ArrayHelper::merge([
    'ARROW_SHOW' => 'N',
    'BACKGROUND_SIZE' => 'cover'
], $arParams);

$arResult['VISUAL']['ARROW'] = [
    'SHOW' => $arParams['ARROW_SHOW'] === 'Y'
];

$arResult['VISUAL']['BACKGROUND'] = [
    'SIZE' => ArrayHelper::fromRange([
        'cover',
        'contain'
    ], $arParams['BACKGROUND_SIZE'])
];