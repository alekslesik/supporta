<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

/**
 * @var array $arCurrentValues
 * @var array $arTemplateParameters
 */

use Bitrix\Main\Localization\Loc;

$rsTemplates = null;
$arForms = [];
$arTemplates = [];

if ($arCurrentValues['FORM_CALL_SHOW'] == 'Y') {
    if (Loader::includeModule('form')) {
        $rsForms = CForm::GetList(
            $by = 'sort',
            $order = 'asc',
            [],
            $filtered = false
        );

        while ($arForm = $rsForms->Fetch())
            $arForms[$arForm['ID']] = '['.$arForm['ID'].'] '.$arForm['NAME'];

        unset($rsForms);

        $rsTemplates = CComponentUtil::GetTemplatesList('bitrix:form.result.new', $siteTemplate);
    } else if (Loader::includeModule('intec.startshop')) {
        $rsForms = CStartShopForm::GetList();

        while ($arForm = $rsForms->Fetch())
            $arForms[$arForm['ID']] = '['.$arForm['ID'].'] '.(!empty($arForm['LANG'][LANGUAGE_ID]['NAME']) ? $arForm['LANG'][LANGUAGE_ID]['NAME'] : $arForm['CODE']);

        unset($rsForms);

        $rsTemplates = CComponentUtil::GetTemplatesList('intec:startshop.forms.result.new', $siteTemplate);
    } else {
        return;
    }

    foreach ($rsTemplates as $arTemplate) {
        $arTemplates[$arTemplate['NAME']] = $arTemplate['NAME'].(!empty($arTemplate['TEMPLATE']) ? ' ('.$arTemplate['TEMPLATE'].')' : null);
    }
}

$arTemplateParameters = [];

$arTemplateParameters['THEME'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MENU_POPUP_3_THEME'),
    'TYPE' => 'LIST',
    'VALUES' => [
        'light' => Loc::getMessage('C_MENU_POPUP_3_THEME_LIGHT'),
        'dark' => Loc::getMessage('C_MENU_POPUP_3_THEME_DARK')
    ]
];

$arTemplateParameters['BACKGROUND'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MENU_POPUP_3_BACKGROUND'),
    'TYPE' => 'LIST',
    'REFRESH' => 'Y',
    'VALUES' => [
        'none' => Loc::getMessage('C_MENU_POPUP_3_BACKGROUND_NONE'),
        'color' => Loc::getMessage('C_MENU_POPUP_3_BACKGROUND_COLOR'),
        'picture' => Loc::getMessage('C_MENU_POPUP_3_BACKGROUND_PICTURE')
    ],
    'DEFAULT' => 'none'
];

if ($arCurrentValues['BACKGROUND'] == 'color') {
    $arTemplateParameters['BACKGROUND_COLOR'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_BACKGROUND_COLOR_PICK'),
        "TYPE" => 'COLORPICKER',
        "DEFAULT" => '#FFFFFF'
    ];
} else if ($arCurrentValues['BACKGROUND'] == 'picture') {
    $arTemplateParameters['BACKGROUND_PICTURE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_BACKGROUND_PICTURE_URL'),
        'TYPE' => 'STRING'
    ];
}

$arTemplateParameters['LOGOTYPE_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MENU_POPUP_3_LOGOTYPE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['LOGOTYPE_SHOW'] == 'Y') {
    $arTemplateParameters['LOGOTYPE'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_LOGOTYPE'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['LOGOTYPE_LINK'] = [
        'PARENT' => 'URL_TEMPLATES',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_LOGOTYPE_LINK'),
        'TYPE' => 'STRING'
    ];
}

$arTemplateParameters['CONTACTS_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MENU_POPUP_3_CONTACTS_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['CONTACTS_SHOW'] == 'Y') {

    $arTemplateParameters['CONTACTS_CITY'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_CONTACTS_CITY'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['CONTACTS_ADDRESS'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_CONTACTS_ADDRESS'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['CONTACTS_SCHEDULE'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_CONTACTS_SCHEDULE'),
        'TYPE' => 'STRING',
        'MULTIPLE' => 'Y'
    ];

    $arTemplateParameters['CONTACTS_PHONE'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_CONTACTS_PHONE'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['CONTACTS_EMAIL'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_CONTACTS_EMAIL'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['FORMS_CALL_SHOW'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_FORMS_CALL_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['FORMS_CALL_SHOW'] == 'Y') {
        $arTemplateParameters['FORMS_CALL_ID'] = [
            'PARENT' => 'DATA_SOURCE',
            'NAME' => Loc::getMessage('C_MENU_POPUP_3_FORMS_CALL_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arForms,
            'ADDITIONAL_VALUES' => 'Y'
        ];
        $arTemplateParameters['FORMS_CALL_TEMPLATE'] = [
            'PARENT' => 'DATA_SOURCE',
            'NAME' => Loc::getMessage('C_MENU_POPUP_3_FORMS_CALL_TEMPLATE'),
            'TYPE' => 'LIST',
            'VALUES' => $arTemplates,
            'DEFAULT' => '.default',
            'ADDITIONAL_VALUES' => 'Y'
        ];
        $arTemplateParameters['FORMS_CALL_TITLE'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_MENU_POPUP_3_FORMS_CALL_TITLE'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('C_MENU_POPUP_3_FORMS_CALL_TITLE_DEFAULT')
        ];
        $arTemplateParameters['CONSENT_URL'] = [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => Loc::getMessage('C_MENU_POPUP_3_CONSENT_URL'),
            'TYPE' => 'STRING'
        ];
    }
}

$arTemplateParameters['SOCIAL_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['SOCIAL_SHOW'] == 'Y') {

    $arTemplateParameters['SOCIAL_FIRST_LINK'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_LINK'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['SOCIAL_FIRST_ICON_PATH'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_ICON_PATH'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['SOCIAL_SECOND_LINK'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_LINK'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['SOCIAL_SECOND_ICON_PATH'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_ICON_PATH'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['SOCIAL_THIRD_LINK'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_LINK'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['SOCIAL_THIRD_ICON_PATH'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_ICON_PATH'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['SOCIAL_FOURTH_LINK'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_LINK'),
        'TYPE' => 'STRING'
    ];

    $arTemplateParameters['SOCIAL_FOURTH_ICON_PATH'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MENU_POPUP_3_SOCIAL_ICON_PATH'),
        'TYPE' => 'STRING'
    ];
}