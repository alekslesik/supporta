<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\template\Properties;

$arParams['DETAIL_GALLERY_ZOOM'] = ArrayHelper::isIn(
    'zoom',
    Properties::get('catalog-detail-gallery-modes')
) ? 'Y' : 'N';

$arParams['DETAIL_GALLERY_POPUP'] = ArrayHelper::isIn(
    'popup',
    Properties::get('catalog-detail-gallery-modes')
) ? 'Y' : 'N';

$arParams['LIST_VIEW'] = Properties::get('catalog-products-view-mode');
$arParams['MENU_VIEW'] = Properties::get('catalog-menu-view');
$arParams['DETAIL_PANEL_SHOW'] = Properties::get('catalog-detail-panel-show') ? 'Y' : 'N';
$arParams['SECTIONS_ROOT_MENU_SHOW'] = Properties::get('catalog-root-menu-show') ? 'Y' : 'N';
$arParams['SECTIONS_CHILDREN_MENU_SHOW'] = Properties::get('catalog-sections-menu-show') ? 'Y' : 'N';
$arParams['DETAIL_MENU_SHOW'] = Properties::get('catalog-detail-menu-show') ? 'Y' : 'N';
$arParams['SECTIONS_ROOT_TEMPLATE'] = Properties::get('catalog-root-template');
$arParams['SECTION_TOP_DEPTH'] = 2;

if ($arParams['SECTIONS_ROOT_TEMPLATE'] === 'tile.1') {
    $arParams['SECTIONS_ROOT_BORDERS'] = 'Y';
    $arParams['SECTIONS_ROOT_COLUMNS'] = 3;
    $arParams['SECTIONS_ROOT_CHILDREN_SHOW'] = 'Y';
    $arParams['SECTIONS_ROOT_CHILDREN_COUNT'] = 0;
    $arParams['SECTIONS_ROOT_PICTURE_SHOW'] = 'Y';
    $arParams['SECTIONS_ROOT_PICTURE_SIZE'] = 'large';
    $arParams['SECTIONS_ROOT_DESCRIPTION_SHOW'] = 'Y';
} else if ($arParams['SECTIONS_ROOT_TEMPLATE'] === 'list.1') {
    $arParams['SECTIONS_ROOT_TEMPLATE'] = 'tile.1';
    $arParams['SECTIONS_ROOT_BORDERS'] = 'Y';
    $arParams['SECTIONS_ROOT_COLUMNS'] = 2;
    $arParams['SECTIONS_ROOT_CHILDREN_SHOW'] = 'Y';
    $arParams['SECTIONS_ROOT_CHILDREN_COUNT'] = 0;
    $arParams['SECTIONS_ROOT_PICTURE_SHOW'] = 'Y';
    $arParams['SECTIONS_ROOT_PICTURE_SIZE'] = 'small';
    $arParams['SECTIONS_ROOT_DESCRIPTION_SHOW'] = 'Y';
} else if ($arParams['SECTIONS_ROOT_TEMPLATE'] === 'tile.2') {
    $arParams['SECTIONS_ROOT_BORDERS'] = 'Y';
    $arParams['SECTIONS_ROOT_COLUMNS'] = 5;
} else if ($arParams['SECTIONS_ROOT_TEMPLATE'] === 'tile.3') {
    $arParams['SECTIONS_ROOT_COLUMNS'] = 4;
    $arParams['SECTIONS_ROOT_CHILDREN_SHOW'] = 'Y';
    $arParams['SECTIONS_ROOT_CHILDREN_COUNT'] = 0;
}

$arParams['SECTIONS_CHILDREN_TEMPLATE'] = Properties::get('catalog-sections-template');

if ($arParams['SECTIONS_CHILDREN_TEMPLATE'] === 'tile.1') {
    $arParams['SECTIONS_CHILDREN_BORDERS'] = 'Y';
    $arParams['SECTIONS_CHILDREN_COLUMNS'] = 2;
    $arParams['SECTIONS_CHILDREN_CHILDREN_SHOW'] = 'Y';
    $arParams['SECTIONS_CHILDREN_CHILDREN_COUNT'] = 0;
    $arParams['SECTIONS_CHILDREN_PICTURE_SHOW'] = 'Y';
    $arParams['SECTIONS_CHILDREN_PICTURE_SIZE'] = 'small';
    $arParams['SECTIONS_CHILDREN_DESCRIPTION_SHOW'] = 'Y';
} else if ($arParams['SECTIONS_CHILDREN_TEMPLATE'] === 'list.1') {
    $arParams['SECTIONS_CHILDREN_TEMPLATE'] = 'tile.1';
    $arParams['SECTIONS_CHILDREN_BORDERS'] = 'Y';
    $arParams['SECTIONS_CHILDREN_COLUMNS'] = 2;
    $arParams['SECTIONS_CHILDREN_CHILDREN_SHOW'] = 'Y';
    $arParams['SECTIONS_CHILDREN_CHILDREN_COUNT'] = 0;
    $arParams['SECTIONS_CHILDREN_PICTURE_SHOW'] = 'Y';
    $arParams['SECTIONS_CHILDREN_PICTURE_SIZE'] = 'small';
    $arParams['SECTIONS_CHILDREN_DESCRIPTION_SHOW'] = 'Y';
} else if ($arParams['SECTIONS_CHILDREN_TEMPLATE'] === 'tile.2') {
    $arParams['SECTIONS_CHILDREN_BORDERS'] = 'Y';
    $arParams['SECTIONS_CHILDREN_COLUMNS'] = 4;
} else if ($arParams['SECTIONS_CHILDREN_TEMPLATE'] === 'tile.3') {
    $arParams['SECTIONS_CHILDREN_COLUMNS'] = 3;
    $arParams['SECTIONS_CHILDREN_CHILDREN_SHOW'] = 'N';
    $arParams['SECTIONS_CHILDREN_CHILDREN_COUNT'] = 0;
}

$arParams['FILTER_AJAX'] = Properties::get('catalog-filter-ajax') ? 'Y' : 'N';
$arParams['FILTER_TEMPLATE'] = Properties::get('catalog-filter-template');

switch ($arParams['FILTER_TEMPLATE']) {
    case 'vertical.1':
        $arParams['FILTER_TYPE'] = 'vertical';
        $arParams['FILTER_TEMPLATE'] = 1;
        break;
    case 'horizontal.1':
        $arParams['FILTER_TYPE'] = 'horizontal';
        $arParams['FILTER_TEMPLATE'] = 1;
        break;
}

$arParams['LIST_TEXT_TEMPLATE'] = Properties::get('catalog-elements-text-template');
$arParams['LIST_LIST_TEMPLATE'] = Properties::get('catalog-elements-list-template');
$arParams['LIST_TILE_TEMPLATE'] = Properties::get('catalog-elements-tile-template');
$arParams['LIST_TILE_COLUMNS'] = 3;

switch ($arParams['LIST_TILE_TEMPLATE']) {
    case 'tile.1': break;
    case 'tile.1.columns.4':
        $arParams['LIST_TILE_TEMPLATE'] = 'tile.1';
        $arParams['LIST_TILE_COLUMNS'] = 4;
        break;
    case 'tile.2': break;
    case 'tile.2.columns.4':
        $arParams['LIST_TILE_TEMPLATE'] = 'tile.2';
        $arParams['LIST_TILE_COLUMNS'] = 4;
        break;
    case 'tile.3': break;
}

$arParams['DETAIL_TEMPLATE'] = Properties::get('catalog-detail-template');

switch ($arParams['DETAIL_TEMPLATE']) {
    case 'default.1.wide':
        $arParams['DETAIL_TEMPLATE'] = 'default.1';
        $arParams['DETAIL_VIEW'] = 'wide';
        break;
    case 'default.1.tabs.top':
        $arParams['DETAIL_TEMPLATE'] = 'default.1';
        $arParams['DETAIL_VIEW'] = 'tabs';
        $arParams['DETAIL_VIEW_TABS_POSITION'] = 'top';
        break;
    case 'default.1.tabs.right':
        $arParams['DETAIL_TEMPLATE'] = 'default.1';
        $arParams['DETAIL_VIEW'] = 'tabs';
        $arParams['DETAIL_VIEW_TABS_POSITION'] = 'right';
        break;
    case 'default.2.wide':
        $arParams['DETAIL_TEMPLATE'] = 'default.2';
        $arParams['DETAIL_VIEW'] = 'wide';
        break;
    case 'default.2.narrow':
        $arParams['DETAIL_TEMPLATE'] = 'default.2';
        $arParams['DETAIL_VIEW'] = 'narrow';
        break;
    case 'default.2.tabs.top':
        $arParams['DETAIL_TEMPLATE'] = 'default.2';
        $arParams['DETAIL_VIEW'] = 'tabs';
        $arParams['DETAIL_VIEW_TABS_POSITION'] = 'top';
        break;
    case 'default.3.wide':
        $arParams['DETAIL_TEMPLATE'] = 'default.3';
        break;
}

switch ($arParams['DETAIL_TEMPLATE']) {
    case 'default.1':
    case 'default.2': {
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_TEMPLATE'] = '1';
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_BORDERS'] = 'Y';
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_COLUMNS'] = '4';
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_POSITION'] = 'left';
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_SIZE'] = 'small';
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_SLIDER_USE'] = 'N';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_TEMPLATE'] = '1';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_BORDERS'] = 'Y';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_COLUMNS'] = '4';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_POSITION'] = 'left';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_SIZE'] = 'small';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_SLIDER_USE'] = 'N';
        break;
    }
    case 'default.3': {
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_TEMPLATE'] = '2';
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_BORDERS'] = 'Y';
        $arParams['DETAIL_PRODUCTS_ASSOCIATED_NAME_ALIGN'] = 'left';
		$arParams['DETAIL_PRODUCTS_ASSOCIATED_PRICE_ALIGN'] = 'left';
		$arParams['DETAIL_PRODUCTS_ASSOCIATED_ACTION'] = 'buy';
		$arParams['DETAIL_PRODUCTS_ASSOCIATED_COUNTER_SHOW'] = 'Y';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_TEMPLATE'] = '2';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_BORDERS'] = 'Y';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_NAME_ALIGN'] = 'left';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_PRICE_ALIGN'] = 'left';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_ACTION'] = 'buy';
        $arParams['DETAIL_PRODUCTS_RECOMMENDED_COUNTER_SHOW'] = 'Y';
        break;
    }
}

$arParams['QUICK_VIEW_USE'] = Properties::get('catalog-quick-view-use') ? 'Y' : 'N';
$arParams['QUICK_VIEW_TEMPLATE'] = Properties::get('catalog-quick-view-template');

if (Properties::get('basket-use')) {
    $arParams['LIST_TEXT_ACTION'] = 'buy';
    $arParams['LIST_LIST_ACTION'] = 'buy';
    $arParams['LIST_TILE_ACTION'] = 'buy';
    $arParams['DETAIL_ACTION'] = 'buy';
    $arParams['QUICK_VIEW_ACTION'] = 'buy';
} else {
    $arParams['LIST_TEXT_ACTION'] = 'order';
    $arParams['LIST_LIST_ACTION'] = 'order';
    $arParams['LIST_TILE_ACTION'] = 'order';
    $arParams['DETAIL_ACTION'] = 'order';
    $arParams['QUICK_VIEW_ACTION'] = 'detail';
}

$arParams['DELAY_USE'] = (!Properties::get('basket-delay-use') || !Properties::get('basket-use')) ? 'N' : 'Y';

$arParams['USE_COMPARE'] = (!Properties::get('basket-compare-use')) ? 'N' : 'Y';