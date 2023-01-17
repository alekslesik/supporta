<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use intec\core\bitrix\component\InnerTemplate;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\regionality\models\Region;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arData
 * @var InnerTemplate $this
 */

$arParams = ArrayHelper::merge([
    'REGIONALITY_USE' => 'N',
    'CONTACTS_USE' => 'N',
    'CONTACTS_IBLOCK_TYPE' => null,
    'CONTACTS_IBLOCK_ID' => null,
    'CONTACTS_ELEMENTS' => null,
    'CONTACTS_ADDRESS_SHOW' => null,
    'CONTACTS_PHONE_SHOW' => null,
    'CONTACTS_PROPERTY_ADDRESS' => null,
    'CONTACTS_PROPERTY_PHONE' => null,
    'CONTACTS_REGIONALITY_USE' => 'N',
    'CONTACTS_REGIONALITY_STRICT' => 'N',
    'CONTACTS_PROPERTY_REGION' => null
], $arParams);

$arResult['REGIONALITY'] = [
    'USE' => $arParams['REGIONALITY_USE'] === 'Y' && Loader::includeModule('intec.regionality')
];

$arResult['CONTACTS'] = [
    'USE' => $arParams['CONTACTS_USE'] === 'Y' && !empty($arParams['CONTACTS_IBLOCK_ID']),
    'ITEMS' => []
];

if ($arResult['CONTACTS']['USE']) {
    $arParams['ADDRESS_SHOW'] = 'N';
    $arParams['PHONE_SHOW'] = 'N';
    $arResult['ADDRESS']['SHOW'] = false;
    $arResult['PHONE']['SHOW'] = false;

    $arFilter = [
        'ACTIVE' => 'Y',
        'ID' => $arParams['CONTACTS_IBLOCK_ID']
    ];

    if (!empty($arParams['CONTACTS_IBLOCK_TYPE']))
        $arFilter['TYPE'] = $arParams['CONTACTS_IBLOCK_TYPE'];

    $arIBlock = CIBlock::GetList([], $arFilter)->GetNext();

    if (!empty($arIBlock)) {
        $arFilter = [
            'IBLOCK_ID' => $arIBlock['ID'],
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            'MIN_PERMISSION' => 'R',
            'CHECK_PERMISSIONS' => 'Y'
        ];

        if (!ArrayHelper::isEmpty($arParams['CONTACTS_ELEMENTS']))
            $arFilter['ID'] = $arParams['CONTACTS_ELEMENTS'];

        if ($arResult['REGIONALITY']['USE'] && $arParams['CONTACTS_REGIONALITY_USE'] === 'Y' && !empty($arParams['CONTACTS_PROPERTY_REGION'])) {
            $oRegion = Region::getCurrent();

            if (!empty($oRegion)) {
                $arConditions = [
                    'LOGIC' => 'OR',
                    ['PROPERTY_'.$arParams['CONTACTS_PROPERTY_REGION'] => $oRegion->id]
                ];

                if ($arParams['CONTACTS_REGIONALITY_STRICT'] !== 'Y')
                    $arConditions[] = ['PROPERTY_'.$arParams['CONTACTS_PROPERTY_REGION'] => false];

                $arFilter[] = $arConditions;

                unset($arConditions);
            }
        }

        $rsContacts = CIBlockElement::GetList([
            'SORT' => 'ASC'
        ], $arFilter);

        while ($rsContact = $rsContacts->GetNextElement()) {
            $arContact = $rsContact->GetFields();
            $arContact['PROPERTIES'] = $rsContact->GetProperties();

            $arContact = [
                'ID' => $arContact['ID'],
                'CODE' => $arContact['CODE'],
                'NAME' => $arContact['NAME'],
                'ADDRESS' => ArrayHelper::getValue($arContact, [
                    'PROPERTIES',
                    $arParams['CONTACTS_PROPERTY_ADDRESS'],
                    'VALUE'
                ]),
                'PHONE' => ArrayHelper::getValue($arContact, [
                    'PROPERTIES',
                    $arParams['CONTACTS_PROPERTY_PHONE'],
                    'VALUE'
                ])
            ];

            if ($arParams['CONTACTS_ADDRESS_SHOW'] !== 'Y')
                $arContact['ADDRESS'] = null;

            if ($arParams['CONTACTS_PHONE_SHOW'] !== 'Y')
                $arContact['PHONE'] = null;

            if (!empty($arContact['PHONE'])) {
                $arContact['PHONE'] = [
                    'DISPLAY' => $arContact['PHONE'],
                    'LINK' => StringHelper::replace($arContact['PHONE'], [
                        '(' => '',
                        ')' => '',
                        ' ' => '',
                        '-' => ''
                    ])
                ];
            }

            if (
                empty($arContact['ADDRESS']) &&
                empty($arContact['PHONE'])
            ) continue;

            $arResult['CONTACTS']['ITEMS'][$arContact['ID']] = $arContact;
        }

        unset($arContact);
        unset($rsContact);
        unset($rsContacts);
    }

    if (empty($arResult['CONTACTS']['ITEMS']))
        $arResult['CONTACTS']['USE'] = false;

    unset($arFilter);
    unset($arIBlock);
}