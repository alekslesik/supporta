<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var array $webFormsList
 * @var array $arPricesTypes
 * @var array $arCurrencies
 */

// Price types
$dbPricesTypes = CStartShopPrice::GetList(array('SORT' => 'ASC'));
while ($priceType = $dbPricesTypes->Fetch()) {
    $name = ArrayHelper::getValue($priceType, ['LANG', LANGUAGE_ID, 'NAME'], '-');
    $arPricesTypes[$priceType['CODE']] = '[' . $priceType['CODE'] . '] ' . $name;
}
unset($dbPricesTypes);


// Currencies
$dbCurrencies = CStartShopCurrency::GetList();
while ($currency = $dbCurrencies->Fetch()) {
    $name = ArrayHelper::getValue($currency, ['LANG', LANGUAGE_ID, 'NAME'], '-');
    $arCurrencies[$currency['CODE']] = '[' . $currency['CODE'] . '] ' . $name;
}
unset($dbCurrencies);

$arTemplateParameters['USE_COMMON_CURRENCY'] = array(
    'PARENT' => 'BASE',
    'NAME' => GetMessage('SH_C_USE_COMMON_CURRENCY'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);
if ($arCurrentValues['USE_COMMON_CURRENCY'] == 'Y') {
    $arTemplateParameters['CURRENCY'] = array(
        'PARENT' => 'BASE',
        'NAME' => GetMessage('C_CATALOG_CURRENCY'),
        'TYPE' => 'LIST',
        'VALUES' => $arCurrencies
    );
}