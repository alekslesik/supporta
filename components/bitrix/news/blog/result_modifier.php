<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Loader;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;
use intec\regionality\models\Region;

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

$arParams = ArrayHelper::merge([
    'LIST_NEWS_TOP_SHOW_IN' => null,
    'LIST_SUBSCRIBE_SHOW_IN' => null,
    'REGIONALITY_USE' => 'N',
    'REGIONALITY_FILTER_USE' => 'N',
    'REGIONALITY_FILTER_PROPERTY' => null,
    'REGIONALITY_FILTER_STRICT' => 'N'
], $arParams);

if (empty($arParams['FILTER_NAME']))
    $arParams['FILTER_NAME'] = 'arrBlogFilter';

$arIBlock = null;

if (!empty($arParams['IBLOCK_ID'])) {
    $oCache = Cache::createInstance();
    $arFilter = [
        'ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y'
    ];

    if ($oCache->initCache(36000, 'IBLOCK'.serialize($arFilter), '/iblock/blog')) {
        $arIBlock = $oCache->getVars();
    } else if ($oCache->startDataCache()) {
        $arIBlocks = Arrays::fromDBResult(CIBlock::GetList([], $arFilter));
        $arIBlock = $arIBlocks->getFirst();
        $oCache->endDataCache($arIBlock);
    }
}

$sNewTopShowIn = $arParams['LIST_NEWS_TOP_SHOW_IN'];

$bNewTopListShow = false;
$bNewTopDetailShow = false;

if ($sNewTopShowIn != 'detail') {
    $bNewTopListShow = true;
}

if ($sNewTopShowIn != 'list') {
    $bNewTopDetailShow = true;
}

$sSubscribeShowIn = $arParams['LIST_SUBSCRIBE_SHOW_IN'];

$bSubscribeListShow = false;
$bSubscribeDetailShow = false;

if ($sSubscribeShowIn != 'detail') {
    $bSubscribeListShow = true;
}

if ($sSubscribeShowIn != 'list') {
    $bSubscribeDetailShow = true;
}

$arResult['IBLOCK'] = $arIBlock;
$arResult['VIEW_PARAMETERS'] = [
    'LIST_TWO_COLUMNS' => ArrayHelper::getValue($arParams, 'LIST_TWO_COLUMNS') == 'Y',
    'LIST_TAG_CLOUD_SHOW' => ArrayHelper::getValue($arParams, 'LIST_TAG_CLOUD_SHOW') == 'Y',
    'LIST_NEWS_TOP_SHOW' => ArrayHelper::getValue($arParams, 'LIST_NEWS_TOP_SHOW') == 'Y',
    'LIST_NEWS_TOP_SHOW_IN_LIST' => $bNewTopListShow,
    'LIST_NEWS_TOP_SHOW_IN_DETAIL' => $bNewTopDetailShow,
    'LIST_SUBSCRIBE_SHOW' => ArrayHelper::getValue($arParams, 'LIST_SUBSCRIBE_SHOW') == 'Y',
    'LIST_SUBSCRIBE_SHOW_IN_LIST' => $bSubscribeListShow,
    'LIST_SUBSCRIBE_SHOW_IN_DETAIL' => $bSubscribeDetailShow,
    'DETAIL_TWO_COLUMNS' => ArrayHelper::getValue($arParams, 'DETAIL_TWO_COLUMNS') == 'Y'
];

$arResult['REGIONALITY'] = [
    'USE' => $arParams['REGIONALITY_USE'] === 'Y',
    'FILTER' => [
        'USE' => $arParams['REGIONALITY_FILTER_USE'] === 'Y',
        'PROPERTY' => $arParams['REGIONALITY_FILTER_PROPERTY'],
        'STRICT' => $arParams['REGIONALITY_FILTER_STRICT'] === 'Y'
    ]
];

if (empty($arIBlock) || !Loader::includeModule('intec.regionality'))
    $arResult['REGIONALITY']['USE'] = false;

if (empty($arResult['REGIONALITY']['FILTER']['PROPERTY']))
    $arResult['REGIONALITY']['FILTER']['USE'] = false;

if ($arResult['REGIONALITY']['USE']) {
    $oRegion = Region::getCurrent();

    if (!empty($oRegion)) {
        if ($arResult['REGIONALITY']['FILTER']['USE']) {
            if (!isset($GLOBALS[$arParams['FILTER_NAME']]) || !Type::isArray($GLOBALS[$arParams['FILTER_NAME']]))
                $GLOBALS[$arParams['FILTER_NAME']] = [];

            $arConditions = [
                'LOGIC' => 'OR',
                ['PROPERTY_'.$arResult['REGIONALITY']['FILTER']['PROPERTY'] => $oRegion->id]
            ];

            if (!$arResult['REGIONALITY']['FILTER']['STRICT'])
                $arConditions[] = ['PROPERTY_'.$arResult['REGIONALITY']['FILTER']['PROPERTY'] => false];

            $GLOBALS[$arParams['FILTER_NAME']][] = $arConditions;
        }
    }
}