<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\Html;

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
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

$this->setFrameMode(true);

$arVisual = $arResult['VISUAL'];

$bNewsTopShow = $arVisual['RIGHT_COLUMN']['NEWS_TOP']['SHOW'] &&
    $arVisual['RIGHT_COLUMN']['NEWS_TOP']['IN'] != 'list';

$bSubscribeShow = $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['SHOW'] &&
    $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['IN'] != 'list';

$bTwoColumnUse = $arVisual['TWO_COLUMNS']['USE'] &&
    $arVisual['TWO_COLUMNS']['IN'] != 'detail' &&
    ($bNewsTopShow || $bSubscribeShow);

?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <div class="ns-bitrix c-bitrix-news c-bitrix-news-template-default">
            <?= Html::beginTag('div', [
                'class' => Html::cssClassFromArray([
                    'news-columns-wrap' => true,
                    'intec-grid' => [
                        '' => true,
                        'wrap' => true,
                        'a-v-start' => true,
                        'a-h-start' => true
                    ]
                ], true)
            ]) ?>
                <?= Html::beginTag('div', [
                    'class' => Html::cssClassFromArray([
                        'news-column' => true,
                        'intec-grid-item' => [
                            '' => true
                        ]
                    ], true)
                ]) ?>
                    <?php $iElementId = $APPLICATION->IncludeComponent(
                        'bitrix:news.detail',
                        '',
                        Array(
                            'DISPLAY_DATE' => $arParams['DISPLAY_DETAIL_DATE'],
                            'DISPLAY_NAME' => $arParams['DISPLAY_NAME'],
                            'DISPLAY_PICTURE' => $arParams['DISPLAY_DETAIL_PICTURE'],
                            'DISPLAY_PREVIEW_TEXT' => $arParams['DISPLAY_DETAIL_PREVIEW_TEXT'],
                            'DISPLAY_READ_ALSO' => $arParams['DISPLAY_DETAIL_READ_ALSO'],
                            'PROPERTY_READ_ALSO' => $arParams['PROPERTY_DETAIL_READ_ALSO'],
                            'VIEW_READ_ALSO' => $arParams['VIEW_DETAIL_READ_ALSO'],
                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                            'FIELD_CODE' => $arParams['DETAIL_FIELD_CODE'],
                            'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
                            'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'],
                            'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
                            'IBLOCK_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news'],
                            'META_KEYWORDS' => $arParams['META_KEYWORDS'],
                            'META_DESCRIPTION' => $arParams['META_DESCRIPTION'],
                            'BROWSER_TITLE' => $arParams['BROWSER_TITLE'],
                            'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
                            'DISPLAY_PANEL' => $arParams['DISPLAY_PANEL'],
                            'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
                            'SET_TITLE' => $arParams['SET_TITLE'],
                            'MESSAGE_404' => $arParams['MESSAGE_404'],
                            'SET_STATUS_404' => $arParams['SET_STATUS_404'],
                            'SHOW_404' => $arParams['SHOW_404'],
                            'FILE_404' => $arParams['FILE_404'],
                            'INCLUDE_IBLOCK_INTO_CHAIN' => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
                            'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
                            'ACTIVE_DATE_FORMAT' => $arParams['DETAIL_ACTIVE_DATE_FORMAT'],
                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                            'CACHE_TIME' => $arParams['CACHE_TIME'],
                            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                            'USE_PERMISSIONS' => $arParams['USE_PERMISSIONS'],
                            'GROUP_PERMISSIONS' => $arParams['GROUP_PERMISSIONS'],
                            'DISPLAY_TOP_PAGER' => $arParams['DETAIL_DISPLAY_TOP_PAGER'],
                            'DISPLAY_BOTTOM_PAGER' => $arParams['DETAIL_DISPLAY_BOTTOM_PAGER'],
                            'PAGER_TITLE' => $arParams['DETAIL_PAGER_TITLE'],
                            'PAGER_SHOW_ALWAYS' => 'N',
                            'PAGER_TEMPLATE' => $arParams['DETAIL_PAGER_TEMPLATE'],
                            'PAGER_SHOW_ALL' => $arParams['DETAIL_PAGER_SHOW_ALL'],
                            'CHECK_DATES' => $arParams['CHECK_DATES'],
                            'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
                            'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
                            'USE_SHARE' => $arParams['USE_SHARE'],
                            'SHARE_HIDE' => $arParams['SHARE_HIDE'],
                            'SHARE_TEMPLATE' => $arParams['SHARE_TEMPLATE'],
                            'SHARE_HANDLERS' => $arParams['SHARE_HANDLERS'],
                            'SHARE_SHORTEN_URL_LOGIN' => $arParams['SHARE_SHORTEN_URL_LOGIN'],
                            'SHARE_SHORTEN_URL_KEY' => $arParams['SHARE_SHORTEN_URL_KEY'],
                            'ADD_ELEMENT_CHAIN' => (isset($arParams['ADD_ELEMENT_CHAIN']) ? $arParams['ADD_ELEMENT_CHAIN'] : ''),
                            'BACK_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news']
                        ),
                        $component
                    ) ?>
                <?= Html::endTag('div') ?>
                <?php if ($bTwoColumnUse) { ?>
                    <?= Html::beginTag('div', [
                        'class' => Html::cssClassFromArray([
                            'news-column-right' => true,
                            'intec-grid-item' => [
                                '' => true,
                                '4' => true,
                                '1100-1' => true
                            ]
                        ], true)
                    ]) ?>
                    <?php if ($bNewsTopShow) { ?>
                        <div class="news-column-right-element">
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "news.top",
                                array(
                                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "NEWS_COUNT" => $arVisual['RIGHT_COLUMN']['NEWS_TOP']['LINE_COUNT'],
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
                                    'HEADER_SHOW' => $arVisual['RIGHT_COLUMN']['NEWS_TOP']['HEADER']['SHOW'],
                                    'HEADER_TEXT' => $arVisual['RIGHT_COLUMN']['NEWS_TOP']['HEADER']['TEXT'],
                                    'TAG_SHOW' => 'N',
                                    'DATE_SHOW' => $arVisual['RIGHT_COLUMN']['NEWS_TOP']['DATE_SHOW']
                                ),
                                $component
                            ) ?>
                        </div>
                    <?php } ?>
                    <?php if ($bSubscribeShow) { ?>
                        <div class="news-column-right-element">
                            <?php $APPLICATION->IncludeComponent(
                                'bitrix:subscribe.edit',
                                'blog',
                                array(
                                    'COMPONENT_TEMPLATE' => 'blog',
                                    'SHOW_HIDDEN' => 'N',
                                    'CONSENT_URL' => $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['CONSENT'],
                                    'AJAX_MODE' => 'N',
                                    'AJAX_OPTION_JUMP' => 'N',
                                    'AJAX_OPTION_STYLE' => 'Y',
                                    'AJAX_OPTION_HISTORY' => 'N',
                                    'AJAX_OPTION_ADDITIONAL' => '',
                                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                    'CACHE_TIME' => $arParams['CACHE_TIME'],
                                    'ALLOW_ANONYMOUS' => $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['ALLOW_ANONYMOUS'],
                                    'SHOW_AUTH_LINKS' => 'N',
                                    'SET_TITLE' => 'N',
                                    'HEADER_SHOW' => $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['HEADER']['SHOW'],
                                    'HEADER_TEXT' => $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['HEADER']['TEXT'],
                                    'HEADER_POSITION' => $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['HEADER']['POSITION'],
                                    'SUBSCRIBE_RUBRICS' => $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['RUBRICS'],
                                    'SUBSCRIBE_TYPE' => $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['TYPE']
                                ),
                                $component
                            );?>
                        </div>
                    <?php } ?>
                    <?= Html::endTag('div') ?>
                <?php } ?>
            <?= Html::endTag('div') ?>
        </div>
    </div>
</div>