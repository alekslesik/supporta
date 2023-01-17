<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('iblock'))
    return;

/** Получение свойств инфоблока для выбора свойства цены услуги */
$arProperties = [];

/** Параметры шаблона */
$arTemplateParameters['LINE_COUNT'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_TEMP2_LINE_COUNT'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        2 => '2',
        3 => '3',
        4 => '4'
    ),
    'DEFAULT' => 3,
    'REFRESH' => 'Y'
);
if ($arCurrentValues['LINE_COUNT'] == '2') {
    $arTemplateParameters['DESCRIPTION_USE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP2_DESCRIPTION_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}
$arTemplateParameters['LINK_USE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_TEMP2_LINK_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
];

$arTemplateParameters['SLIDER_LOOP'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_TEMP2_SLIDER_LOOP'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);
$arTemplateParameters['SLIDER_AUTO_PLAY_USE'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_TEMP2_SLIDER_AUTO_PLAY_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['SLIDER_AUTO_PLAY_USE'] == 'Y') {
    $arTemplateParameters['SLIDER_AUTO_PLAY_TIME'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP2_SLIDER_AUTO_PLAY_TIME'),
        'TYPE' => 'STRING',
        'DEFAULT' => '10000'
    );
    $arTemplateParameters['SLIDER_SLIDE_SPEED'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP2_SLIDER_SLIDE_SPEED'),
        'TYPE' => 'STRING',
        'DEFAULT' => '500'
    );
    $arTemplateParameters['SLIDER_AUTO_PLAY_PAUSE'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP2_SLIDER_AUTO_PLAY_PAUSE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    );
}

$arTemplateParameters['SEE_ALL_SHOW'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_TEMP2_SEE_ALL_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['SEE_ALL_SHOW'] == 'Y') {
    $arTemplateParameters['SEE_ALL_POSITION'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP2_SEE_ALL_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'left' => Loc::getMessage('C_NEWS_TEMP2_POSITION_LEFT'),
            'center' => Loc::getMessage('C_NEWS_TEMP2_POSITION_CENTER'),
            'right' => Loc::getMessage('C_NEWS_TEMP2_POSITION_RIGHT')
        ),
        'DEFAULT' => 'center'
    );
    $arTemplateParameters['SEE_ALL_TEXT'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_TEMP2_SEE_ALL_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_NEWS_TEMP2_SEE_ALL_TEXT_DEFAULT')
    );
}