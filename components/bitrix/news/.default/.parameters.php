<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

if (!CModule::IncludeModule('iblock'))
    return;

$iIBlockId = $arCurrentValues['IBLOCK_ID'];

$arTemplateParameters = array(
    'USE_LIST_DATE_FILTER' => array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_USE_DATE_FILTER'),
        'TYPE' => 'CHECKBOX'
    ),
    'DISPLAY_LIST_PICTURE' => array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_DISPLAY_PICTURE'),
        'TYPE' => 'CHECKBOX'
    ),
    'DISPLAY_LIST_PREVIEW_TEXT' => array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_DISPLAY_PREVIEW_TEXT'),
        'TYPE' => 'CHECKBOX'
    ),
    'DISPLAY_DETAIL_PICTURE' => array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_DISPLAY_PICTURE'),
        'TYPE' => 'CHECKBOX'
    ),
    'DISPLAY_DETAIL_PREVIEW_TEXT' => array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_DISPLAY_PREVIEW_TEXT'),
        'TYPE' => 'CHECKBOX'
    ),
    'DISPLAY_DETAIL_DATE' => array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_DISPLAY_DATE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
    ),
    'DISPLAY_DETAIL_READ_ALSO' => array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_DISPLAY_READ_ALSO'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    )
);

$arTemplateParameters['TWO_COLUMNS_USE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMNS_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['TWO_COLUMNS_USE'] == 'Y') {
    $arTemplateParameters['TWO_COLUMNS_IN'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMNS_IN'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'list' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_LIST'),
            'detail' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_DETAIL'),
            'both' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_BOTH')
        ],
        'DEFAULT' => 'list'
    ];

    $arTemplateParameters['RIGHT_COLUMN_TOP_NEWS_SHOW'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_TOP_NEWS_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['RIGHT_COLUMN_TOP_NEWS_SHOW'] == 'Y') {
        $arTemplateParameters['RIGHT_COLUMN_TOP_NEWS_SHOW_IN'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_TOP_NEWS_SHOW_IN'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'list' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_LIST'),
                'detail' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_DETAIL'),
                'both' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_BOTH')
            ],
            'DEFAULT' => 'list'
        ];
        $arTemplateParameters['RIGHT_COLUMN_TOP_NEWS_LINE_COUNT'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_TOP_NEWS_LINE_COUNT'),
            'TYPE' => 'LIST',
            'VALUES' => [
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5'
            ],
            'DEFAULT' => 4
        ];
        $arTemplateParameters['RIGHT_COLUMN_TOP_NEWS_HEADER_SHOW'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_TOP_NEWS_HEADER_SHOW'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
            'REFRESH' => 'Y'
        ];

        if ($arCurrentValues['RIGHT_COLUMN_TOP_NEWS_HEADER_SHOW'] == 'Y') {
            $arTemplateParameters['RIGHT_COLUMN_TOP_NEWS_HEADER_TEXT'] = [
                'PARENT' => 'VISUAL',
                'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_TOP_NEWS_HEADER_TEXT'),
                'TYPE' => 'STRING',
                'DEFAULT' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_TOP_NEWS_HEADER_TEXT_DEFAULT')
            ];
        }

        $arTemplateParameters['RIGHT_COLUMN_TOP_NEWS_DATE_SHOW'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_TOP_NEWS_DATE_SHOW'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N'
        ];
    }

    if (Loader::includeModule('subscribe'))
        include(__DIR__.'/parameters/base.php');
}

if ($arCurrentValues['USE_LIST_DATE_FILTER'] == 'Y') {
    $arTemplateParameters['PARAMETER_LIST_DATE_FILTER'] = array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_PARAMETER_DATE_FILTER'),
        'TYPE' => 'STRING',
        'DEFAULT' => 'date'
    );
}

if ($arCurrentValues['DISPLAY_DETAIL_READ_ALSO'] == 'Y') {
    if (!empty($iIBlockId)) {
        $arProperties = array();
        $arPropertiesElements = array();
        $rsProperties = CIBlockProperty::GetList(array('SORT' => 'ASC'), array(
            'IBLOCK_ID' => $iIBlockId,
            'ACTIVE' => 'Y'
        ));

        while ($arProperty = $rsProperties->Fetch()) {
            if (empty($arProperty['CODE']))
                continue;

            $sPropertyName = '['.$arProperty['CODE'].'] '.$arProperty['NAME'];
            $arProperties[$arProperty['CODE']] = $arProperty;

            if ($arProperty['PROPERTY_TYPE'] == 'E') {
                $arPropertiesElements[$arProperty['CODE']] = $sPropertyName;
            }
        }

        $arTemplateParameters['PROPERTY_DETAIL_READ_ALSO'] = array(
            'PARENT' => 'DETAIL_SETTINGS',
            'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_PROPERTY_READ_ALSO'),
            'TYPE' => 'LIST',
            'VALUES' => $arPropertiesElements,
            'ADDITIONAL_VALUES' => 'Y'
        );
    }

    $arTemplateParameters['VIEW_DETAIL_READ_ALSO'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_READ_ALSO'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'tile' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_READ_ALSO_TILE'),
            'blocks' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_READ_ALSO_BLOCKS')
        )
    );
}

$arTemplateParameters['VIEW_LIST'] = array(
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW'),
    'TYPE' => 'LIST',
    'REFRESH' => 'Y',
    'VALUES' => array(
        'settings' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_SETTINGS'),
        'news.tile' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_TILE'),
        'news.list' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_LIST'),
        'news.blocks.2' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_BLOCKS')
    )
);

if ($arCurrentValues['VIEW_LIST'] == 'news.tile' || $arCurrentValues['VIEW_LIST'] == 'news.blocks.2') {
    $arLineCounts = array();
    $iLineCount = 0;

    if ($arCurrentValues['VIEW_LIST'] == 'news.tile') {
        $arLineCounts[3] = 3;
        $arLineCounts[4] = 4;
        $iLineCount = 4;
    } else {
        $arLineCounts[4] = 4;
        $arLineCounts[5] = 5;
        $iLineCount = 5;
    }

    $arTemplateParameters['VIEW_LIST_LINE_COUNT'] = array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => GetMessage('N_DEFAULT_N_D_DEFAULT_PARAMETERS_VIEW_LINE_COUNT'),
        'TYPE' => 'LIST',
        'VALUES' => $arLineCounts,
        'DEFAULT' => $iLineCount
    );
}

include(__DIR__.'/parameters/regionality.php');