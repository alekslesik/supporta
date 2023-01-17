<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('subscribe'))
    return;

$rsRubrics = CRubric::GetList();
$arRubrics = [];

while ($arRubric = $rsRubrics->GetNext()) {
    $arRubrics[$arRubric['ID']] = '['.$arRubric['ID'].'] '.$arRubric['NAME'];
}

$arTemplateParameters = [
    'CONSENT_URL' => [
        'PARENT' => 'URL_TEMPLATES',
        'TYPE' => 'STRING',
        'NAME' => Loc::getMessage('SE_DEFAULT_CONSENT_URL')
    ],
    'HEADER_SHOW' => [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_HEADER_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ]
];

$arTemplateParameters['SUBSCRIBE_RUBRICS'] = [
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_SUBSCRIBE_RUBRICS'),
    'TYPE' => 'LIST',
    'VALUES' => $arRubrics,
    'MULTIPLE' => 'Y',
    'ADDITIONAL_VALUES' => 'Y'
];
$arTemplateParameters['SUBSCRIBE_TYPE'] = [
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_SUBSCRIBE_TYPE'),
    'TYPE' => 'LIST',
    'VALUES' => [
        'html' => 'HTML',
        'text' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_SUBSCRIBE_TYPE_DEFAULT')
    ],
    'DEFAULT' => 'html'
];

if ($arCurrentValues['HEADER_SHOW'] == 'Y') {
    $arTemplateParameters['HEADER_POSITION'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_HEADER_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'left' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_HEADER_POSITION_LEFT'),
            'center' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_HEADER_POSITION_CENTER'),
            'right' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_HEADER_POSITION_RIGHT')
        ],
        'DEFAULT' => 'center'
    ];
    $arTemplateParameters['HEADER_TEXT'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_HEADER_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_SUBSCRIBE_TEMP_BLOG_HEADER_TEXT_DEFAULT')
    ];
}