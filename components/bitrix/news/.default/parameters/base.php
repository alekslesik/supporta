<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

$arRubrics = [];

if ($arCurrentValues['RIGHT_COLUMN_SUBSCRIBE_SHOW'] == 'Y') {
    $rsRubrics = CRubric::GetList();

    while ($arRubric = $rsRubrics->GetNext()) {
        $arRubrics[$arRubric['ID']] = '[' . $arRubric['ID'] . '] ' . $arRubric['NAME'];
    }
}

$arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_SHOW'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['RIGHT_COLUMN_SUBSCRIBE_SHOW'] == 'Y') {
    $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_SHOW_IN'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_SHOW_IN'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'list' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_LIST'),
            'detail' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_DETAIL'),
            'both' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_TWO_COLUMN_IN_BOTH')
        ),
        'DEFAULT' => 'all'
    );
    $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_RUBRICS'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_RUBRICS'),
        'TYPE' => 'LIST',
        'VALUES' => $arRubrics,
        'MULTIPLE' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );
    $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_TYPE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_TYPE'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'html' => 'HTML',
            'text' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_TYPE_TEXT')
        ],
        'DEFAULT' => 'html'
    ];
    $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_ALLOW_ANONYMOUS'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_ALLOW_ANONYMOUS'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    );
    $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_CONSENT'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_CONSENT'),
        'TYPE' => 'STRING'
    );
    $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_HEADER_SHOW'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_HEADER_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    );

    if ($arCurrentValues['RIGHT_COLUMN_SUBSCRIBE_HEADER_SHOW'] == 'Y') {
        $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_HEADER_POSITION'] = array(
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_HEADER_POSITION'),
            'TYPE' => 'LIST',
            'VALUES' => array(
                'left' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_POSITION_LEFT'),
                'center' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_POSITION_CENTER'),
                'right' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_POSITION_RIGHT')
            ),
            'DEFAULT' => 'center'
        );
        $arTemplateParameters['RIGHT_COLUMN_SUBSCRIBE_HEADER_TEXT'] = array(
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_HEADER_TEXT'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('C_NEWS_TEMP_DEFAULT_RIGHT_COLUMN_SUBSCRIBE_HEADER_TEXT_DEFAULT')
        );
    }
}