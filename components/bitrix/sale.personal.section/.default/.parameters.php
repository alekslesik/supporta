<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arTemplateParameters = [];

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_SALE_PERSONAL_SECTION_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y'
];