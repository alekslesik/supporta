<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

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

$bSubscribe = false;

if (Loader::includeModule('subscribe'))
    $bSubscribe = true;

$arViewParams = ArrayHelper::getValue($arResult, 'VIEW_PARAMETERS');

$bSubscribeShow = $arViewParams['LIST_SUBSCRIBE_SHOW'] && $arViewParams['LIST_SUBSCRIBE_SHOW_IN_DETAIL'] && $bSubscribe;
$bNewsTopShow = $arViewParams['LIST_NEWS_TOP_SHOW'] && $arViewParams['LIST_NEWS_TOP_SHOW_IN_DETAIL'];

$sNofFullView = !$bSubscribeShow || !$bNewsTopShow ? true : false;
?>
<div class="intec-content">
	<div class="intec-content-wrapper">
		<div class="ns-bitrix c-news c-news-blog<?= $arViewParams['LIST_TWO_COLUMNS'] ? ' two-columns' : null ?>">
            <div class="intec-grid intec-grid-wrap intec-grid-i-h-25">
                <div class="news-elements-content intec-grid-item intec-grid-item-1000-1">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:news.detail",
                        ".default",
                        array(
                            "COMPONENT_TEMPLATE" => ".default",
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "ELEMENT_ID" => $arResult['VARIABLES']['ELEMENT_ID'],
                            "ELEMENT_CODE" => $arResult['VARIABLES']['ELEMENT_CODE'],
                            "CHECK_DATES" => $arParams['CHECK_DATES'],
                            'FIELD_CODE' => $arParams['DETAIL_FIELD_CODE'],
                            'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
                            "IBLOCK_URL" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news'],
                            "DETAIL_URL" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "SET_TITLE" => $arParams['SET_TITLE'],
                            "SET_CANONICAL_URL" => $arParams['DETAIL_SET_CANONICAL_URL'],
                            "SET_BROWSER_TITLE" => $arParams['SET_BROWSER_TITLE'],
                            "BROWSER_TITLE" => $arParams['BROWSER_TITLE'],
                            "SET_META_KEYWORDS" => $arParams['SET_META_KEYWORDS'],
                            "META_KEYWORDS" => $arParams['META_KEYWORDS'],
                            "SET_META_DESCRIPTION" => $arParams['SET_META_DESCRIPTION'],
                            "META_DESCRIPTION" => $arParams['META_DESCRIPTION'],
                            "SET_LAST_MODIFIED" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
                            "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                            "ADD_ELEMENT_CHAIN" => $arParams['ADD_ELEMENT_CHAIN'],
                            "ACTIVE_DATE_FORMAT" => $arParams['DETAIL_ACTIVE_DATE_FORMAT'],
                            "USE_PERMISSIONS" => $arParams['USE_PERMISSIONS'],
                            "STRICT_SECTION_CHECK" => "N",
                            "DISPLAY_DATE" => "N",
                            "DISPLAY_NAME" => "N",
                            "DISPLAY_PICTURE" => "N",
                            "DISPLAY_PREVIEW_TEXT" => "N",
                            "USE_SHARE" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "PAGER_TITLE" => "",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                            "SHOW_404" => $arParams["SHOW_404"],
                            "MESSAGE_404" => $arParams["MESSAGE_404"],
                            'DATE_SHOW' => $arParams['DETAIL_DATE_SHOW'],
                            'TAG_SHOW' => $arParams['DETAIL_TAG_SHOW'],
                            'PREVIEW_SHOW' => $arParams['DETAIL_PREVIEW_TEXT_SHOW'],
                            'IMAGE_SHOW' => $arParams['DETAIL_IMAGE_SHOW'],
                            'READ_ALSO_SHOW' => $arParams['DETAIL_READ_ALSO_SHOW'],
                            'PROPERTY_READ_ALSO' => $arParams['DETAIL_PROPERTY_READ_ALSO'],
                            'PROPERTY_TAG' => $arParams['PROPERTY_TAG'],
                            'VIEW_READ_ALSO' => $arParams['DETAIL_READ_ALSO_VIEW'],
                            'READ_ALSO_TITLE' => $arParams['DETAIL_READ_ALSO_HEADER_TEXT'],
                            'BACK_SHOW' => $arParams['DETAIL_BACK_SHOW'],
                            'BACK_TEXT' => $arParams['DETAIL_BACK_TEXT'],
                            'SOCIAL_SHOW' => $arParams['DETAIL_SOCIAL_SHOW'],
                            'SOCIAL_LIST' => $arParams['DETAIL_SOCIAL_LIST']
                        ),
                        $component
                    ); ?>
                </div>
                <?php if ($arViewParams['DETAIL_TWO_COLUMNS']) { ?>
                    <div class="intec-grid-item-auto intec-grid-item-1000-1 news-elements-content right-column">
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
                                                'DATE_SHOW' => $arParams['LIST_NEWS_TOP_DATE_SHOW'],
                                                'TAG_DISABLED' => 'Y'
                                            ),
                                            $component
                                        ); ?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?php } ?>
                            <?php if ($bSubscribeShow && $arViewParams['LIST_SUBSCRIBE_SHOW']) { ?>
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
