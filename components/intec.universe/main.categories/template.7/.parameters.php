<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $arProperties = Arrays::fromDBResult(CIBlockProperty::GetList([], [
        'ACTIVE' => 'Y',
        'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID']
    ]))->indexBy('ID');

    $hPropertyText = function ($sKey, $arProperty) {
        if ($arProperty['PROPERTY_TYPE'] == 'S' && $arProperty['LIST_TYPE'] == 'L' && $arProperty['MULTIPLE'] === 'N')
            return [
                'key' => $arProperty['CODE'],
                'value' => '['.$arProperty['CODE'].'] '.$arProperty['NAME']
            ];

        return ['skip' => true];
    };

    $arPropertyText = $arProperties->asArray($hPropertyText);

    $arTemplateParameters['PROPERTY_STICKER'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_PROPERTY_STICKER'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyText,
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];
}

$arTemplateParameters['COLUMNS'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_COLUMNS'),
    'TYPE' => 'LIST',
    'VALUES' => [
        3 => '3',
        4 => '4',
        5 => '5',
    ],
    'DEFAULT' => 4
];

$arTemplateParameters['NAME_HORIZONTAL'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_NAME_HORIZONTAL'),
    'TYPE' => 'LIST',
    'VALUES' => [
        'left' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_HORIZONTAL_LEFT'),
        'center' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_HORIZONTAL_CENTER'),
        'right' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_HORIZONTAL_RIGHT')
    ],
    'DEFAULT' => 'left'
];
$arTemplateParameters['NAME_VERTICAL'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_NAME_VERTICAL'),
    'TYPE' => 'LIST',
    'VALUES' => [
        'top' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_VERTICAL_TOP'),
        'middle' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_VERTICAL_MIDDLE'),
        'bottom' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_VERTICAL_BOTTOM')
    ],
    'DEFAULT' => 'bottom'
];

if ($arCurrentValues['PROPERTY_STICKER']) {
    $arTemplateParameters['STICKER_SHOW'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_STICKER_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['STICKER_SHOW'] === 'Y') {
        $arTemplateParameters['STICKER_HORIZONTAL'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_STICKER_HORIZONTAL'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'left' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_HORIZONTAL_LEFT'),
                'center' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_HORIZONTAL_CENTER'),
                'right' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_HORIZONTAL_RIGHT')
            ],
            'DEFAULT' => 'left'
        ];
        $arTemplateParameters['STICKER_VERTICAL'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_STICKER_VERTICAL'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'top' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_VERTICAL_TOP'),
                'middle' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_VERTICAL_MIDDLE'),
                'bottom' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_VERTICAL_BOTTOM')
            ],
            'DEFAULT' => 'top'
        ];
    }
}

if (!empty($arCurrentValues['PROPERTY_LINK']) || $arCurrentValues['LINK_MODE'] === 'component') {
    $arTemplateParameters['LINK_USE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_LINK_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['LINK_USE'] === 'Y') {
        $arTemplateParameters['LINK_BLANK'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_MAIN_CATEGORIES_TEMPLATE_7_LINK_BLANK'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N'
        ];
    }
}