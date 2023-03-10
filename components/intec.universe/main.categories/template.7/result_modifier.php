<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'PROPERTY_STICKER' => null,
    'COLUMNS' => 4,
    'NAME_HORIZONTAL' => 'left',
    'NAME_VERTICAL' => 'bottom',
    'STICKER_SHOW' => 'N',
    'STICKER_HORIZONTAL' => 'left',
    'STICKER_VERTICAL' => 'top',
    'LINK_USE' => 'N',
    'LINK_BLANK' => 'N'
], $arParams);

$arVisual = [
    'COLUMNS' => ArrayHelper::fromRange([4, 3, 5], $arParams['COLUMNS']),
    'LINK' => [
        'USE' => $arParams['LINK_USE'] === 'Y',
        'BLANK' => $arParams['LINK_BLANK'] === 'Y'
    ],
    'NAME' => [
        'HORIZONTAL' => ArrayHelper::fromRange(['left', 'center', 'right'], $arParams['NAME_HORIZONTAL']),
        'VERTICAL' => ArrayHelper::fromRange(['bottom', 'middle', 'top'], $arParams['NAME_VERTICAL'])
    ],
    'STICKER' => [
        'SHOW' => !empty($arParams['PROPERTY_STICKER']) && $arParams['STICKER_SHOW'] === 'Y',
        'HORIZONTAL' => ArrayHelper::fromRange(['left', 'center', 'right'], $arParams['STICKER_HORIZONTAL']),
        'VERTICAL' => ArrayHelper::fromRange(['top', 'middle', 'bottom'], $arParams['STICKER_VERTICAL'])
    ]
];

$arResult['VISUAL'] = $arVisual;

unset($arVisual);

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['DATA'] = [];

    if (!empty($arParams['PROPERTY_STICKER'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_STICKER']
        ]);

        if (!empty($arProperty['VALUE'])) {
            $arProperty = CIBlockFormatProperties::GetDisplayValue(
                $arItem,
                $arProperty,
                false
            );

            if (Type::isArray($arProperty['DISPLAY_VALUE']))
                $arProperty['DISPLAY_VALUE'] = ArrayHelper::getFirstValue($arProperty['DISPLAY_VALUE']);

            $arItem['DATA']['STICKER'] = $arProperty['DISPLAY_VALUE'];
        }

        unset($arProperty);
    }
}

unset($arItem);