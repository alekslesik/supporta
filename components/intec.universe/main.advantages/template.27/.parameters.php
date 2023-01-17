<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

$arTemplateParameters = [];

$arTemplateParameters['THEME'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_ADVANTAGES_TEMPLATE_27_THEME'),
    'TYPE' => 'LIST',
    'VALUES' => [
        'white' => Loc::getMessage('C_MAIN_ADVANTAGES_TEMPLATE_27_THEME_WHITE'),
        'black' => Loc::getMessage('C_MAIN_ADVANTAGES_TEMPLATE_27_THEME_BLACK')
    ],
    'DEFAULT' => 'white'
];