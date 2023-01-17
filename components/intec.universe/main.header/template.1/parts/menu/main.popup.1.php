<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

$arMenu = $arResult['MENU']['MAIN'];
$arMenuParams = !empty($arMenuParams) ? $arMenuParams : [];

?>
<?php $APPLICATION->IncludeComponent(
    'bitrix:menu',
    'popup.1',
    ArrayHelper::merge([
        'ROOT_MENU_TYPE' => $arMenu['ROOT'],
        'CHILD_MENU_TYPE' => $arMenu['CHILD'],
        'MAX_LEVEL' => $arMenu['LEVEL'],
        'MENU_CACHE_TYPE' => 'N',
        'USE_EXT' => 'Y',
        'DELAY' => 'N',
        'ALLOW_MULTI_SELECT' => 'N',
        'LOGOTYPE_SHOW' => $arResult['LOGOTYPE']['SHOW'] ? 'Y' : 'N',
        'LOGOTYPE' => $arResult['LOGOTYPE']['PATH'],
        'LOGOTYPE_LINK' => SITE_DIR
    ], $arMenuParams),
    $this->getComponent()
); ?>
<?php unset($arMenu) ?>
