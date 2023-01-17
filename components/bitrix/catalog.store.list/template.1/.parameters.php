<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

$arTemplateParameters = [
    'MAP_ID' => [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('N_L_CONTACTS_PARAMETERS_API_KEY_MAP'),
        'TYPE' => 'STRING'
    ]
];