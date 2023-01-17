<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\UnsetArrayValue;

$arReturn = [];

$arReturn['ADDRESS_SHOW'] = new UnsetArrayValue();
$arReturn['EMAIL_SHOW'] = new UnsetArrayValue();
$arReturn['TAGLINE_SHOW'] = new UnsetArrayValue();

$arReturn['SOCIAL_SHOW'] = [
    'PARENT' => 'VISUAL',
    'TYPE' => 'CHECKBOX',
    'NAME' => Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP9_SOCIAL_SHOW'),
    'REFRESH' => 'Y'
];

if ($arCurrentValues['SOCIAL_SHOW'] == 'Y') {
    $arReturn['SOCIAL_VK'] = [
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'STRING',
        'NAME' => Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP9_SOCIAL_VK')
    ];

    $arReturn['SOCIAL_INSTAGRAM'] = [
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'STRING',
        'NAME' => Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP9_SOCIAL_INSTAGRAM')
    ];

    $arReturn['SOCIAL_FACEBOOK'] = [
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'STRING',
        'NAME' => Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP9_SOCIAL_FACEBOOK')
    ];

    $arReturn['SOCIAL_TWITTER'] = [
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'STRING',
        'NAME' => Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP9_SOCIAL_TWITTER')
    ];
}

return $arReturn;