<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);

$arElements = [];
$arElements['SHOW'] = true;
$arElements['ID'] = null;
$arElements['TEMPLATE'] = ArrayHelper::getValue($arParams, 'LIST_TEMPLATE');
$arElements['PARAMETERS'] = [];

if (empty($arElements['TEMPLATE']))
    $arElements['SHOW'] = false;

if ($arElements['SHOW']) {
    $sPrefix = 'LIST_';

    foreach ($arParams as $sKey => $mValue) {
        if (!StringHelper::startsWith($sKey, $sPrefix))
            continue;

        $sKey = StringHelper::cut(
            $sKey,
            StringHelper::length($sPrefix)
        );

        if ($sKey === 'TEMPLATE')
            continue;

        $arElements['PARAMETERS'][$sKey] = $mValue;
    }

    $arElements['PARAMETERS'] = ArrayHelper::merge($arElements['PARAMETERS'], [
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
        'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
        'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
        'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
        'PAGE_ELEMENT_COUNT' => $arParams['PAGE_ELEMENT_COUNT'],
        'SECTION_URL' => $arParams['SECTION_URL'],
        'DETAIL_URL' => $arParams['DETAIL_URL'],
        'BASKET_URL' => $arParams['BASKET_URL'],
        'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
        'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
        'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
        'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
        'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
        'PRICE_CODE' => $arParams['PRICE_CODE'],
        'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
        'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
        'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
        'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
        'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
        'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
        'PAGER_TITLE' => $arParams['PAGER_TITLE'],
        'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
        'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
        'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
        'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
        'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
        'FILTER_NAME' => 'arrCatalogSearchFilter',
        'SECTION_ID' => '',
        'SECTION_CODE' => '',
        'SECTION_USER_FIELDS' => array(),
        'INCLUDE_SUBSECTIONS' => 'Y',
        'SHOW_ALL_WO_SECTION' => 'Y',
        'META_KEYWORDS' => '',
        'META_DESCRIPTION' => '',
        'BROWSER_TITLE' => '',
        'ADD_SECTIONS_CHAIN' => 'N',
        'SET_TITLE' => 'N',
        'SET_STATUS_404' => 'N',
        'CACHE_FILTER' => 'N',
        'CACHE_GROUPS' => 'N',

        'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
        'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
        'PRODUCT_DISPLAY_MODE' => 'Y',
        'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
        'OFFERS_USE' => 'Y',
        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
        'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
        'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
        'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],
        'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
        'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
        'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
        'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
        'OFFERS_LIMIT' => $arParams['OFFERS_LIMIT'],

        'USE_COMPARE' => $arParams['USE_COMPARE'],
        'COMPARE_NAME' => $arParams['COMPARE_NAME'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH'],

        'WIDE' => $arParams['WIDE']
    ]);
}

?>
<div class="catalog-search">
	<?php $arElements['ID'] = $APPLICATION->IncludeComponent(
		'bitrix:search.page',
		'catalog',
		[
			'RESTART' => $arParams['RESTART'],
			'NO_WORD_LOGIC' => $arParams['NO_WORD_LOGIC'],
			'USE_LANGUAGE_GUESS' => $arParams['USE_LANGUAGE_GUESS'],
			'CHECK_DATES' => $arParams['CHECK_DATES'],
			'arrFILTER' => ['iblock_'.$arParams['IBLOCK_TYPE']],
			'arrFILTER_iblock_'.$arParams['IBLOCK_TYPE'] => [$arParams['IBLOCK_ID']],
			'USE_TITLE_RANK' => 'N',
			'DEFAULT_SORT' => 'rank',
			'FILTER_NAME' => '',
			'SHOW_WHERE' => 'N',
			'arrWHERE' => [],
			'SHOW_WHEN' => 'N',
			'PAGE_RESULT_COUNT' => 999,
			'DISPLAY_TOP_PAGER' => 'N',
			'DISPLAY_BOTTOM_PAGER' => 'N',
			'PAGER_TITLE' => '',
			'PAGER_SHOW_ALWAYS' => 'N',
			'PAGER_TEMPLATE' => 'N',
		],
		$component,
		['HIDE_ICONS' => 'N']
	) ?>
	<?php

	if (!Type::isArray($arElements['ID']))
		$arElements['ID'] = [];

	if (empty($arElements['ID']))
		$arElements['SHOW'] = false;
	?>
	<?php if ($arElements['SHOW']) { ?>
		<?php $GLOBALS['arrCatalogSearchFilter'] = ['=ID' => $arElements['ID']] ?>
		<?php $APPLICATION->IncludeComponent(
			'bitrix:catalog.section',
			$arElements['TEMPLATE'],
			$arElements['PARAMETERS'],
			$component,
			['HIDE_ICONS' => 'Y']
		) ?>
	<?php } else { ?>
        <div class="catalog-search-message">
		    <?= Loc::getMessage('C_CATALOG_SEARCH_DEFAULT_NOT_FOUND') ?>
        </div>
	<?php } ?>
</div>