<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;
use intec\regionality\platform\iblock\properties\RegionProperty;

/**
 * @var array $arCurrentValues
 * @var string $siteTemplate
 */

$arIBlocksTypes = CIBlockParameters::GetIBlockTypes();
$arIBlock = null;
$arFilter = [
    'ACTIVE' => 'Y'
];

if (!empty($arCurrentValues['CONTACTS_IBLOCK_TYPE']))
    $arFilter['TYPE'] = $arCurrentValues['CONTACTS_IBLOCK_TYPE'];

$arIBlocks = Arrays::fromDBResult(CIBlock::GetList([
    'SORT' => 'ASC'
], $arFilter))->indexBy('ID');

if (!empty($arCurrentValues['CONTACTS_IBLOCK_ID']))
    $arIBlock = $arIBlocks->get($arCurrentValues['CONTACTS_IBLOCK_ID']);

$arReturn = [];

if (Loader::includeModule('intec.regionality')) {
    $arReturn['REGIONALITY_USE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_REGIONALITY_USE'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'Y'
    ];
}

$arReturn['CONTACTS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_USE'),
    'TYPE' => 'CHECKBOX',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['CONTACTS_USE'] === 'Y') {
    $arReturn['PHONE_SHOW'] = ['HIDDEN' => 'Y'];
    $arReturn['PHONE_VALUE'] = ['HIDDEN' => 'Y'];
    $arReturn['ADDRESS_SHOW'] = ['HIDDEN' => 'Y'];
    $arReturn['ADDRESS_VALUE'] = ['HIDDEN' => 'Y'];

    $arReturn['CONTACTS_IBLOCK_TYPE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_IBLOCK_TYPE'),
        'TYPE' => 'LIST',
        'VALUES' => $arIBlocksTypes,
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];

    $arReturn['CONTACTS_IBLOCK_ID'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_IBLOCK_ID'),
        'TYPE' => 'LIST',
        'VALUES' => $arIBlocks->asArray(function ($iId, $arIBlock) {
            return [
                'key' => $arIBlock['ID'],
                'value' => '['.$arIBlock['ID'].'] '.$arIBlock['NAME']
            ];
        }),
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];

    if (!empty($arIBlock)) {
        $arProperties = Arrays::fromDBResult(CIBlockProperty::GetList([
            'SORT' => 'ASC'
        ], [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $arIBlock['ID']
        ]));

        $hPropertyString = function ($iIndex, $arProperty) {
            if (empty($arProperty['CODE']))
                return ['skip' => true];

            if (
                $arProperty['MULTIPLE'] === 'Y' ||
                $arProperty['PROPERTY_TYPE'] !== 'S' ||
                $arProperty['USER_TYPE'] !== null
            ) return ['skip' => true];

            return [
                'key' => $arProperty['CODE'],
                'value' => '['.$arProperty['CODE'].'] '.$arProperty['NAME']
            ];
        };

        $hPropertyRegion = function ($iIndex, $arProperty) {
            if (empty($arProperty['CODE']))
                return ['skip' => true];

            if (
                $arProperty['PROPERTY_TYPE'] !== RegionProperty::PROPERTY_TYPE ||
                $arProperty['USER_TYPE'] !== RegionProperty::USER_TYPE
            ) return ['skip' => true];

            return [
                'key' => $arProperty['CODE'],
                'value' => '['.$arProperty['CODE'].'] '.$arProperty['NAME']
            ];
        };

        $arReturn['CONTACTS_ADDRESS_SHOW'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_ADDRESS_SHOW'),
            'TYPE' => 'CHECKBOX'
        ];

        if ($arCurrentValues['CONTACTS_ADDRESS_SHOW'] === 'Y')
            $arReturn['CONTACTS_PROPERTY_ADDRESS'] = [
                'PARENT' => 'DATA_SOURCE',
                'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_PROPERTY_ADDRESS'),
                'TYPE' => 'LIST',
                'VALUES' => $arProperties->asArray($hPropertyString),
                'ADDITIONAL_VALUES' => 'Y',
                'REFRESH' => 'Y'
            ];

        $arReturn['CONTACTS_PHONE_SHOW'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_PHONE_SHOW'),
            'TYPE' => 'CHECKBOX',
            'REFRESH' => 'Y'
        ];

        if ($arCurrentValues['CONTACTS_PHONE_SHOW'] === 'Y')
            $arReturn['CONTACTS_PROPERTY_PHONE'] = [
                'PARENT' => 'DATA_SOURCE',
                'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_PROPERTY_PHONE'),
                'TYPE' => 'LIST',
                'VALUES' => $arProperties->asArray($hPropertyString),
                'ADDITIONAL_VALUES' => 'Y'
            ];

        if ($arCurrentValues['REGIONALITY_USE'] === 'Y' && Loader::includeModule('intec.regionality')) {
            $arReturn['CONTACTS_REGIONALITY_USE'] = [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_REGIONALITY_USE'),
                'TYPE' => 'CHECKBOX',
                'REFRESH' => 'Y'
            ];

            if ($arCurrentValues['CONTACTS_REGIONALITY_USE'] === 'Y') {
                $arReturn['CONTACTS_REGIONALITY_STRICT'] = [
                    'PARENT' => 'BASE',
                    'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_REGIONALITY_STRICT'),
                    'TYPE' => 'CHECKBOX'
                ];

                $arReturn['CONTACTS_PROPERTY_REGION'] = [
                    'PARENT' => 'DATA_SOURCE',
                    'NAME' => Loc::getMessage('C_FOOTER_TEMPLATE_1_VIEW_6_CONTACTS_PROPERTY_REGION'),
                    'TYPE' => 'LIST',
                    'VALUES' => $arProperties->asArray($hPropertyRegion),
                    'ADDITIONAL_VALUES' => 'Y'
                ];
            }
        }
    }
}

return $arReturn;