<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'PROPERTY_PRICE' => null,
    'PROPERTY_CURRENCY' => null,
    'PROPERTY_LIST' => null,
    'ORDER_USE' => 'N',
    'ORDER_FORM_ID' => null,
    'ORDER_FORM_TEMPLATE' => null,
    'ORDER_FORM_FIELD' => null,
    'ORDER_FORM_TITLE' => null,
    'ORDER_FORM_CONSENT' => null,
    'ORDER_BUTTON' => null
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR
];

$arVisual = [
    'PRICE' => [
        'SHOW' => $arParams['PRICE_SHOW'] === 'Y'
    ]
];

$arResult['VISUAL'] = ArrayHelper::merge($arVisual, $arResult['VISUAL']);

unset($arVisual);

$arResult['PROPERTIES'] = [];

if (!empty($arParams['PROPERTY_LIST'])) {
    $arProperties = ArrayHelper::getFirstValue($arResult['ITEMS']);

    foreach ($arProperties['DISPLAY_PROPERTIES'] as $arProp)
        if (!empty($arProp['CODE']))
            if (ArrayHelper::isIn($arProp['CODE'], $arParams['PROPERTY_LIST'])) {
                $bPropEmpty = true;
                foreach ($arResult['ITEMS'] as $arItem) {
                    $arPropertyValue = ArrayHelper::getValue($arItem, ['DISPLAY_PROPERTIES', $arProp['CODE'], 'DISPLAY_VALUE']);
                    if (!empty($arPropertyValue)) {
                        $bPropEmpty = false;
                        continue;
                    }
                }

                if (!$bPropEmpty)
                    $arResult['PROPERTIES'][] = $arProp;
            }
}

usort($arResult['PROPERTIES'], function($a, $b) {
    return $a['SORT'] - $b['SORT'];
});

unset($arProperties);

$arForm = [
    'USE' => $arParams['ORDER_USE'] === 'Y',
    'ID' => $arParams['ORDER_FORM_ID'],
    'TEMPLATE' => $arParams['ORDER_FORM_TEMPLATE'],
    'FIELD' => $arParams['ORDER_FORM_FIELD'],
    'TITLE' => $arParams['ORDER_FORM_TITLE'],
    'CONSENT' => $arParams['ORDER_FORM_CONSENT'],
    'BUTTON' => $arParams['ORDER_BUTTON']
];

if ($arForm['USE'])
    if (empty($arForm['ID']) || empty($arForm['TEMPLATE']))
        $arForm['USE'] = false;

$arResult['FORM'] = $arForm;

unset($arForm);

$bPriceEmpty = true;

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['DATA'] = [
        'PRICE' => null,
        'CURRENCY' => null
    ];

    if (!empty($arParams['PROPERTY_PRICE'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_PRICE'],
            'VALUE'
        ]);

        if (!Type::isArray($arProperty))
            $arItem['DATA']['PRICE'] = $arProperty;
        else
            $arItem['DATA']['PRICE'] = ArrayHelper::getFirstValue($arProperty);

        if (!empty($arItem['DATA']['PRICE']))
            $bPriceEmpty = false;
    }

    if (!empty($arParams['PROPERTY_CURRENCY'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_CURRENCY'],
            'VALUE'
        ]);

        if (!Type::isArray($arProperty))
            $arItem['DATA']['CURRENCY'] = $arProperty;
        else
            $arItem['DATA']['CURRENCY'] = ArrayHelper::getFirstValue($arProperty);
    }
}

if ($arResult['VISUAL']['PRICE']['SHOW'] && !$bPriceEmpty) {
    $arResult['VISUAL']['PRICE']['SHOW'] = true;
} else {
    $arResult['VISUAL']['PRICE']['SHOW'] = false;
}