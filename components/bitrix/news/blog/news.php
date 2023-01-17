<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\Core;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arResult
 * @var array $arParams
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

/** Подписка */
$bSubscribe = false;

if (Loader::includeModule('subscribe'))
    $bSubscribe = true;

/** Параметры облака тегов */
$request = Core::$app->request;
$arTags = $request->get($arParams['TAG_VARIABLE_NAME']);
$arTagsFilter = [];
$arFilter = [];

if (!empty($GLOBALS[$arParams['FILTER_NAME']]))
    $arFilter = $GLOBALS[$arParams['FILTER_NAME']];

if (!Type::isArray($arFilter))
    $arFilter = [];

if (empty($arTags))
    $arTags = array();

foreach ($arTags as $iKey => $sTag) {
    if ($sTag == 'Y') {
        $arTagsFilter[] = $iKey;
    }
}

$arFilter['PROPERTY_'.$arParams['PROPERTY_TAG']] = $arTagsFilter;
$GLOBALS[$arParams['FILTER_NAME']] = $arFilter;

/** Параметры отображения */
$arViewParams = ArrayHelper::getValue($arResult, 'VIEW_PARAMETERS');

$bSubscribeShow = $arViewParams['LIST_SUBSCRIBE_SHOW'] && $arViewParams['LIST_SUBSCRIBE_SHOW_IN_LIST'] && $bSubscribe;
$bNewsTopShow = $arViewParams['LIST_NEWS_TOP_SHOW'] && $arViewParams['LIST_NEWS_TOP_SHOW_IN_LIST'];

$sNofFullView = !$bSubscribeShow || !$bNewsTopShow ? true : false;

?>
<div class="intec-content">
    <div class="intec-content-wrapper">

        <div class="ns-bitrix c-news c-news-blog<?= $arViewParams['LIST_TWO_COLUMNS'] ? ' two-columns' : null ?>">
            <?php if ($arViewParams['LIST_TAG_CLOUD_SHOW']) { ?>
                <div class="news-tags-cloud-wrap position-top">
                    <?php $APPLICATION->IncludeComponent(
                        'intec.universe:tags.cloud',
                        'template.1',
                        array(
                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                            'PROPERTY_TAG' => $arParams['PROPERTY_TAG'],
                            'TAG_VARIABLE_NAME' => $arParams['TAG_VARIABLE_NAME']
                        ),
                        $component
                    ); ?>
                </div>
            <?php } ?>
            <?php if ($arParams['USE_DATE_FILTER'] == 'Y' && !empty($arParams['IBLOCK_ID'])) { ?>
                <?php
                $arYears = array();
                $sParameter = $arParams['DATE_FILTER'];
                $rsElements = CIBlockElement::GetList(array('SORT' => 'ASC'), array(
                    'IBLOCK_ID' => $arParams['IBLOCK_ID']
                ));

                if (empty($sParameter))
                    $sParameter = 'date';

                $sValue = Core::$app->request->get($sParameter);

                if (!empty($sValue)) {
                    if (!Type::isArray($arFilter))
                        $arFilter = array();

                    $sFormat = CDatabase::DateFormatToPHP(CSite::GetDateFormat('SHORT'));
                    $arFilter['>=DATE_ACTIVE_FROM'] = date($sFormat, strtotime($sValue.'-01-01'));
                    $arFilter['<=DATE_ACTIVE_FROM'] = date($sFormat, strtotime($sValue.'-12-31'));
                }

                while ($arElement = $rsElements->Fetch()) {
                    if (empty($arElement['ACTIVE_FROM']))
                        continue;

                    $arDate = StringHelper::explode($arElement['ACTIVE_FROM'], ' ');
                    $arDate = ArrayHelper::getValue($arDate, 0);

                    if (empty($arDate))
                        continue;

                    $arDate = StringHelper::explode($arDate, '.');
                    $iYear = ArrayHelper::getValue($arDate, 2);
                    $iYear = Type::toInteger($iYear);

                    if (empty($iYear))
                        continue;

                    if (!ArrayHelper::isIn($iYear, $arYears))
                        $arYears[] = $iYear;
                }

                usort($arYears, function ($iYear1, $iYear2) {
                    if ($iYear1 > $iYear2) return -1;
                    if ($iYear1 < $iYear2) return 1;
                    return 0;
                });
                ?>
                <?php if (!empty($arYears)) { ?>
                    <div class="news-year-filter">
                        <div class="news-year-filter-wrapper">
                            <a class="news-year-filter-button<?= empty($sValue) ? ' intec-cl-text' : null ?>" href="<?= $APPLICATION->GetCurPageParam('', array($sParameter)) ?>">
                                <?= Loc::getMessage('C_NEWS_FILTER_DATE_ALL') ?>
                            </a>
                            <?php foreach ($arYears as $iYear) { ?>
                                <a class="news-year-filter-button<?= $iYear == $sValue ? ' intec-cl-text' : null ?>" href="<?= $APPLICATION->GetCurPageParam($sParameter.'='.$iYear, array($sParameter)) ?>">
                                    <?= $iYear ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <?php $GLOBALS[$arParams['FILTER_NAME']] = $arFilter ?>
            <div class="intec-grid intec-grid-wrap intec-grid-i-h-25">
                <div class="intec-grid-item intec-grid-item-1000-1 news-elements-content<?= $arViewParams['LIST_TWO_COLUMNS'] ? ' main-column' : null ?>">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "blog",
                        array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                            "SORT_BY1" => $arParams["SORT_BY1"],
                            "SORT_ORDER1" => $arParams["SORT_ORDER1"],
                            "SORT_BY2" => $arParams["SORT_BY2"],
                            "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                            "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                            "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                            "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                            "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                            "SET_TITLE" => $arParams["SET_TITLE"],
                            "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                            "MESSAGE_404" => $arParams["MESSAGE_404"],
                            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                            "SHOW_404" => $arParams["SHOW_404"],
                            "FILE_404" => $arParams["FILE_404"],
                            "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                            "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                            "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                            "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                            "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                            "DISPLAY_NAME" => $arParams['DISPLAY_NAME'],
                            "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                            "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                            "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                            "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                            "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                            "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                            "FILTER_NAME" => $arParams['FILTER_NAME'],
                            "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                            "CHECK_DATES" => $arParams["CHECK_DATES"],
                            'VIEW' => $arParams['LIST_VIEW'],
                            'GRID' => $arParams['LIST_GRID'],
                            'DATE_SHOW' => $arParams['LIST_DATE_SHOW'],
                            'TAG_SHOW' => $arParams['LIST_TAG_SHOW'],
                            'DESCRIPTION_SHOW' => $arParams['LIST_DESCRIPTION_SHOW'],
                            'PROPERTY_TAG' => $arParams['PROPERTY_TAG'],
                            'TAG_VARIABLE_NAME' => $arParams['TAG_VARIABLE_NAME'],
                            'COLUMN' => $arParams['LIST_TWO_COLUMNS']
                        ),
                        $component
                    ); ?>
                </div>
                <?php if ($arViewParams['LIST_TWO_COLUMNS']) { ?>
                    <div class="intec-grid-item-auto intec-grid-item-1000-1 news-elements-content right-column">
                        <?php if ($arViewParams['LIST_TAG_CLOUD_SHOW']) { ?>
                            <div class="news-tags-cloud-wrap position-right">
                                <?php $APPLICATION->IncludeComponent(
                                    'intec.universe:tags.cloud',
                                    'template.1',
                                    array(
                                        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                        'PROPERTY_TAG' => $arParams['PROPERTY_TAG'],
                                        'TAG_VARIABLE_NAME' => $arParams['TAG_VARIABLE_NAME'],
                                        'HEADER_SHOW' => $arParams['LIST_TAG_HEADER_SHOW'],
                                        'HEADER_TEXT' => $arParams['LIST_TAG_HEADER_TEXT']
                                    ),
                                    $component
                                ); ?>
                            </div>
                        <?php } ?>
                        <div class="intec-grid intec-grid-wrap intec-grid-i-h-5 intec-grid-i-v-15">
                            <?php if ($bNewsTopShow) { ?>
                                <?= Html::beginTag('div', [
                                    'class' => Html::cssClassFromArray([
                                        'intec-grid-item' => [
                                            '1' => true,
                                            '1000-2' => !$sNofFullView,
                                            '600-1' => true
                                        ]
                                    ], true),
                                ]) ?>
                                    <div class="news-top-viewed-wrap">
                                        <?php $APPLICATION->IncludeComponent(
                                            "bitrix:news.list",
                                            "news.top",
                                            array(
                                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                                "NEWS_COUNT" => $arParams["LIST_NEWS_TOP_ELEMENTS_COUNT"],
                                                "SORT_BY1" => 'SHOW_COUNTER',
                                                "SORT_ORDER1" => 'DESC',
                                                "SORT_BY2" => $arParams["SORT_BY2"],
                                                "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                                                "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                                                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                                                "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                                                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                                                "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                                                "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                                                "SET_TITLE" => 'N',
                                                "SET_LAST_MODIFIED" => '',
                                                "MESSAGE_404" => $arParams["MESSAGE_404"],
                                                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                                                "SHOW_404" => $arParams["SHOW_404"],
                                                "FILE_404" => $arParams["FILE_404"],
                                                "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
                                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                                "DISPLAY_TOP_PAGER" => 'N',
                                                "DISPLAY_BOTTOM_PAGER" => 'N',
                                                "PAGER_TITLE" => '',
                                                "PAGER_TEMPLATE" => '',
                                                "PAGER_SHOW_ALWAYS" => '',
                                                "PAGER_DESC_NUMBERING" => '',
                                                "PAGER_DESC_NUMBERING_CACHE_TIME" => '',
                                                "PAGER_SHOW_ALL" => '',
                                                "PAGER_BASE_LINK_ENABLE" => '',
                                                "PAGER_BASE_LINK" => '',
                                                "PAGER_PARAMS_NAME" => '',
                                                "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                                                "DISPLAY_NAME" => $arParams['DISPLAY_NAME'],
                                                "DISPLAY_PICTURE" => 'N',
                                                "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                                                "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                                                "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                                                "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                                                "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                                                "FILTER_NAME" => '',
                                                "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                                                "CHECK_DATES" => $arParams["CHECK_DATES"],
                                                'PROPERTY_TAG' => $arParams['PROPERTY_TAG'],
                                                'TAG_VARIABLE_NAME' => $arParams['TAG_VARIABLE_NAME'],
                                                'HEADER_SHOW' => $arParams['LIST_NEWS_TOP_HEADER_SHOW'],
                                                'HEADER_TEXT' => $arParams['LIST_NEWS_TOP_HEADER_TEXT'],
                                                'TAG_SHOW' => $arParams['LIST_NEWS_TOP_TAG_SHOW'],
                                                'DATE_SHOW' => $arParams['LIST_NEWS_TOP_DATE_SHOW']
                                            ),
                                            $component
                                        ); ?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?php } ?>
                            <?php if ($bSubscribeShow) { ?>
                                <?= Html::beginTag('div', [
                                    'class' => Html::cssClassFromArray([
                                        'intec-grid-item' => [
                                            '1' => true,
                                            '1000-2' => !$sNofFullView,
                                            '600-1' => true
                                        ]
                                    ], true),
                                ]) ?>
                                    <div class="news-subscribe-wrapper">
                                        <?php $APPLICATION->IncludeComponent(
                                            'bitrix:subscribe.edit',
                                            'blog',
                                            array(
                                                'COMPONENT_TEMPLATE' => 'blog',
                                                'SHOW_HIDDEN' => 'N',
                                                'CONSENT_URL' => $arParams['LIST_SUBSCRIBE_CONSENT'],
                                                'AJAX_MODE' => 'N',
                                                'AJAX_OPTION_JUMP' => 'N',
                                                'AJAX_OPTION_STYLE' => 'Y',
                                                'AJAX_OPTION_HISTORY' => 'N',
                                                'AJAX_OPTION_ADDITIONAL' => '',
                                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                                'CACHE_TIME' => $arParams['CACHE_TIME'],
                                                'ALLOW_ANONYMOUS' => $arParams['LIST_SUBSCRIBE_ALLOW_ANONIMOUS'],
                                                'SHOW_AUTH_LINKS' => 'N',
                                                'SET_TITLE' => 'N',
                                                'HEADER_SHOW' => $arParams['LIST_SUBSCRIBE_HEADER_SHOW'],
                                                'HEADER_TEXT' => $arParams['LIST_SUBSCRIBE_HEADER_TEXT'],
                                                'HEADER_POSITION' => $arParams['LIST_SUBSCRIBE_HEADER_POSITION'],
                                                'SUBSCRIBE_RUBRICS' => $arParams['LIST_SUBSCRIBE_RUBRICS'],
                                                'SUBSCRIBE_TYPE' => $arParams['LIST_SUBSCRIBE_TYPE']
                                            ),
                                            $component
                                        );?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
