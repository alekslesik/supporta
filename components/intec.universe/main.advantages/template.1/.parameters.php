<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

$arTemplateParameters = [
    'ELEMENTS_ROW_COUNT' => [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_MAIN_ADVANTAGES_TEMPLATE_1_ELEMENTS_ROW_COUNT'),
        'TYPE' => 'LIST',
        'DEFAULT' => 4,
        'VALUES' => [
            2 => 2,
            3 => 3,
            4 => 4
        ]
    ]
];