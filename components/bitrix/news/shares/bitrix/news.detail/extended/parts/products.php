<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 * @var array $products
 */

$GLOBALS['arrFilter'] = array(
    'ID' => $products
);

?>
<div class="share-header-block"><?= GetMessage('GOODS_OF_SHARE') ?></div>
<?php $APPLICATION->IncludeComponent(
    'bitrix:catalog.section',
    'catalog.tile.1',
    array(
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE_FOR_SALE'],
        'IBLOCK_ID' => $arParams['IBLOCK_TYPE_ID_SALE'],
        'SHOW_ALL_WO_SECTION' => 'Y',
        'PRICE_CODE' => $arParams['PROPERTY_PRICE_CODE_SALE'],
        'SHOW_PRICE_COUNT' => '1',
        'FILTER_NAME' => 'arrFilter',
        'TITLE' => GetMessage('RECOMENDATIONS'),
        'BASKET_URL' => $arParams['PROPERTY_BASKET_URL'],
        'USE_COMMON_CURRENCY' => $arParams['USE_COMMON_CURRENCY'],
        'CURRENCY' => $arParams['CURRENCY'],
        'ORDER_PRODUCT_WEB_FORM' => $arParams['ORDER_PRODUCT_WEB_FORM'],
        'PROPERTY_FORM_ORDER_PRODUCT' => $arParams['PROPERTY_FORM_ORDER_PRODUCT'],
        'USE_BASKET' => $arParams['USE_BASKET'],
        'ACTION' => $arParams['ACTION'],
        'DELAY_USE' => $arParams['DELAY_USE'],
        'USE_COMPARE' => $arParams['USE_COMPARE'],
        'COMPARE_NAME' => $arParams['COMPARE_NAME'],
        'OFFERS_USE' => 'N',
        'COLUMNS' => 4
    ),
    $component
); ?>
