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

// Web forms
if ($arCurrentValues['PROPERTY_SHOW_FORM'] == 'Y') {
    $webForms = CStartShopForm::GetList(array(), array());
    while ($form = $webForms->Fetch()) {
        $name = ArrayHelper::getValue($form, ['LANG', LANGUAGE_ID, 'NAME'], '');
        $webFormsList[$form['ID']] = '[' . $form['ID'] . '] ' . $name;
    }
    unset($webForms, $form);
}

$arTemplateParameters['ORDER_PRODUCT_WEB_FORM'] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('C_SHARE_ORDER_PRODUCT_WEB_FORM'),
    'TYPE' => 'LIST',
    'VALUES' => $webFormsList,
    'REFRESH' => 'Y'
);

if (!empty($arCurrentValues['ORDER_PRODUCT_WEB_FORM'])) {
    $arFormFields = array();
    $rsFormFields = CStartShopFormProperty::GetList(
        array(), array('FORM' => $arCurrentValues['ORDER_PRODUCT_WEB_FORM'])
    );

    while ($arFormField = $rsFormFields->GetNext()) {
        $arFormFields[$arFormField['ID']] = '['.$arFormField['ID'].'] '.$arFormField['LANG']['ru']['NAME'];
    }

    $arTemplateParameters['PROPERTY_FORM_ORDER_PRODUCT'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('C_SHARE_PROPERTY_FORM_ORDER_PRODUCT'),
        'VALUES' => $arFormFields,
        'ADDITIONAL_VALUES' => 'Y'
    );
}