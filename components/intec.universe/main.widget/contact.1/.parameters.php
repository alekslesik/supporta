<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;

/**
 * @var array $arCurrentValues
 */

Loc::loadMessages(__FILE__);

if (!Loader::includeModule('intec.core'))
    return;

$arCurrentValues = ArrayHelper::merge([
    'MAP_VENDOR' => 'yandex'
], $arCurrentValues);

$arForms = [];
$arFormsTemplates = [];

if ($arCurrentValues['FORM_SHOW'] == 'Y') {
    $rsFormsTemplates = [];

    if (Loader::includeModule('form')) {
        include(__DIR__.'/parameters/base/forms.php');
    } elseif (Loader::includeModule('intec.startshop')) {
        include(__DIR__.'/parameters/lite/forms.php');
    }

    if (!empty($rsFormsTemplates))
        foreach ($rsFormsTemplates as $arTemplate)
            $arFormsTemplates[$arTemplate['NAME']] = $arTemplate['NAME'] . (!empty($arTemplate['TEMPLATE']) ? ' (' . $arTemplate['TEMPLATE'] . ')' : null);

    unset($rsFormsTemplates);
}

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX'
];

$arTemplateParameters['MAP_VENDOR'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_MAP_VENDOR'),
    'TYPE' => 'LIST',
    'VALUES' => [
        'google' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_MAP_VENDOR_GOOGLE'),
        'yandex' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_MAP_VENDOR_YANDEX'),
    ],
    'REFRESH' => 'Y',
    'DEFAULT' => 'yandex'
];

if ($arCurrentValues['MAP_VENDOR'] === 'yandex') {
    $arTemplateParameters['MAP_INIT_MAP_TYPE'] = null;
    $arTemplateParameters['INIT_MAP_TYPE'] = null;

    $arTemplateParameters = ArrayHelper::merge($arTemplateParameters, Component::getParameters(
        'bitrix:map.yandex.view',
        [
            '.default'
        ],
        $siteTemplate,
        $arCurrentValues,
        'MAP_',
        function ($sKey, $arParameter) {
            if ($sKey === 'MAP_WIDTH' || $sKey === 'MAP_HEIGHT')
                return false;

            return true;
        },
        Component::PARAMETERS_MODE_BOTH
    ));

    $arTemplateParameters['INIT_MAP_TYPE'] = $arTemplateParameters['MAP_INIT_MAP_TYPE'];

    unset($arTemplateParameters['MAP_INIT_MAP_TYPE']);
} else if ($arCurrentValues['MAP_VENDOR'] === 'google') {
    $arTemplateParameters['MAP_INIT_MAP_TYPE'] = null;
    $arTemplateParameters['INIT_MAP_TYPE'] = null;

    $arTemplateParameters = ArrayHelper::merge($arTemplateParameters, Component::getParameters(
        'bitrix:map.google.view',
        [
            '.default'
        ],
        $siteTemplate,
        $arCurrentValues,
        'MAP_',
        function ($sKey, $arParameter) {
            if ($sKey === 'MAP_WIDTH' || $sKey === 'MAP_HEIGHT')
                return false;

            return true;
        },
        Component::PARAMETERS_MODE_BOTH
    ));

    $arTemplateParameters['INIT_MAP_TYPE'] = $arTemplateParameters['MAP_INIT_MAP_TYPE'];

    unset($arTemplateParameters['MAP_INIT_MAP_TYPE']);
}

$arTemplateParameters['CONSENT_URL'] = [
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_CONSENT_URL'),
    'TYPE' => 'STRING'
];

$arTemplateParameters['WIDE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_WIDE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];

$arTemplateParameters['BLOCK_SHOW'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_BLOCK_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['BLOCK_SHOW'] == 'Y') {
    $arTemplateParameters['BLOCK_VIEW'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_BLOCK_VIEW'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'left' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_BLOCK_VIEW_LEFT'),
            'over' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_BLOCK_VIEW_OVER')
        ],
        'DEFAULT' => 'left'
    ];

    $arTemplateParameters['BLOCK_TITLE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_BLOCK_TITLE'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_BLOCK_TITLE_DEFAULT')
    ];

    $arTemplateParameters['ADDRESS_SHOW'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_ADDRESS_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['ADDRESS_SHOW'] == 'Y') {
        $arTemplateParameters['ADDRESS_CITY'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_ADDRESS_CITY'),
            'TYPE' => 'STRING'
        ];

        $arTemplateParameters['ADDRESS_STREET'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_ADDRESS_STREET'),
            'TYPE' => 'STRING'
        ];
    }

    $arTemplateParameters['PHONE_SHOW'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_PHONE_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['PHONE_SHOW'] == 'Y') {
        $arTemplateParameters['PHONE_VALUES'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_PHONE_VALUES'),
            'TYPE' => 'STRING',
            'MULTIPLE' => 'Y'
        ];
    }

    $arTemplateParameters['FORM_SHOW'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['FORM_SHOW'] == 'Y') {
        $arTemplateParameters['FORM_ID'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arForms,
            'ADDITIONAL_VALUES' => 'Y'
        ];

        $arTemplateParameters['FORM_TEMPLATE'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_TEMPLATE'),
            'TYPE' => 'LIST',
            'VALUES' => $arFormsTemplates,
            'ADDITIONAL_VALUES' => 'Y',
            'DEFAULT' => '.default'
        ];

        $arTemplateParameters['FORM_TITLE'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_TITLE'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_TITLE_DEFAULT')
        ];

        $arTemplateParameters['FORM_BUTTON_TEXT'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_BUTTON_TEXT'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_FORM_BUTTON_TEXT_DEFAULT')
        ];
    }

    $arTemplateParameters['EMAIL_SHOW'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_EMAIL_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['EMAIL_SHOW'] == 'Y') {
        $arTemplateParameters['EMAIL_VALUES'] = [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('C_MAIN_WIDGET_CONTACT_1_EMAIL_VALUES'),
            'TYPE' => 'STRING',
            'MULTIPLE' => 'Y'
        ];
    }
}