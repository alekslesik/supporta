<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\Core;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;
use intec\constructor\models\Build;

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

$arFilter = [];

if (isset($GLOBALS[$arParams['FILTER_NAME']]))
    $arFilter = $GLOBALS[$arParams['FILTER_NAME']];

$iIBlockId = $arParams['IBLOCK_ID'];

$this->setFrameMode(true);

$sView = ArrayHelper::getValue($arParams, 'VIEW_LIST');
if ($sView == 'settings') {
    $build = Build::getCurrent();
    $page = $build->getPage();
    $properties = $page->getProperties();

    switch ($properties->get('sections-news-template')) {
        case 'blocks.1':
            $sView = 'news.blocks.2';
            break;
        case 'list.1':
            $sView = 'news.list';
            break;
        case 'tiles.1':
            $sView = 'news.tile';
            break;
    }
}

$sView = ArrayHelper::fromRange(['news.tile', 'news.list', 'news.blocks.2'], $sView);

$iLineCount = ArrayHelper::getValue($arParams, 'VIEW_LIST_LINE_COUNT');
$iLineCount = ArrayHelper::fromRange($sView == 'news.tile' ? [3, 4] : [4, 5], $iLineCount);

$arParams['VIEW_LIST_LINE_COUNT'] = $iLineCount;
$arParams['VIEW_LIST'] = $sView;
unset($iLineCount, $sView);

$arVisual = $arResult['VISUAL'];

$bNewsTopShow = $arVisual['RIGHT_COLUMN']['NEWS_TOP']['SHOW'] &&
    $arVisual['RIGHT_COLUMN']['NEWS_TOP']['IN'] != 'detail';

$bSubscribeShow = $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['SHOW'] &&
    $arVisual['RIGHT_COLUMN']['SUBSCRIBE']['IN'] != 'detail';

$bTwoColumnUse = $arVisual['TWO_COLUMNS']['USE'] &&
    $arVisual['TWO_COLUMNS']['IN'] != 'detail' &&
    ($bNewsTopShow || $bSubscribeShow);

?>
<div class="intec-content intec-content-visible">
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
                    <?php if ($arParams['USE_LIST_DATE_FILTER'] == 'Y' && !empty($iIBlockId)) { ?>
                    <?php
                        $arYears = array();
                        $sParameter = $arParams['PARAMETER_DATE_FILTER'];
                        $rsElements = CIBlockElement::GetList(array('SORT' => 'ASC'), array(
                            'IBLOCK_ID' => $iIBlockId
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
                            <div class="news-list-filter">
                                <div class="news-list-filter-wrapper">
                                    <a class="news-list-filter-button<?= empty($sValue) ? ' news-list-filter-button-active' : null ?>" href="<?= $APPLICATION->GetCurPageParam('', array($sParameter)) ?>">
                                        <?= GetMessage('N_DEFAULT_FILTER_ALL') ?>
                                    </a>
                                    <?php foreach ($arYears as $iYear) { ?>
                                        <a class="news-list-filter-button<?= $iYear == $sValue ? ' news-list-filter-button-active' : null ?>" href="<?= $APPLICATION->GetCurPageParam($sParameter.'='.$iYear, array($sParameter)) ?>">
                                            <?= $iYear ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php $GLOBALS[$arParams['FILTER_NAME']] = $arFilter ?>
                    <?php $APPLICATION->IncludeComponent(
                        'bitrix:news.list',
                        $arParams['VIEW_LIST'],
                        array(
                            'DISPLAY_FIRST_VIDEO' => $arParams['DISPLAY_FIRST_VIDEO'],
                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                            'NEWS_COUNT' => $arParams['NEWS_COUNT'],
                            'SORT_BY1' => $arParams['SORT_BY1'],
                            'SORT_ORDER1' => $arParams['SORT_ORDER1'],
                            'SORT_BY2' => $arParams['SORT_BY2'],
                            'SORT_ORDER2' => $arParams['SORT_ORDER2'],
                            'FIELD_CODE' => $arParams['LIST_FIELD_CODE'],
                            'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
                            'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'],
                            'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
                            'IBLOCK_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news'],
                            'DISPLAY_PANEL' => $arParams['DISPLAY_PANEL'],
                            'SET_TITLE' => $arParams['SET_TITLE'],
                            'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
                            'MESSAGE_404' => $arParams['MESSAGE_404'],
                            'SET_STATUS_404' => $arParams['SET_STATUS_404'],
                            'SHOW_404' => $arParams['SHOW_404'],
                            'FILE_404' => $arParams['FILE_404'],
                            'INCLUDE_IBLOCK_INTO_CHAIN' => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                            'CACHE_TIME' => $arParams['CACHE_TIME'],
                            'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
                            'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
                            'PAGER_TITLE' => $arParams['PAGER_TITLE'],
                            'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
                            'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
                            'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
                            'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
                            'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
                            'PAGER_BASE_LINK_ENABLE' => $arParams['PAGER_BASE_LINK_ENABLE'],
                            'PAGER_BASE_LINK' => $arParams['PAGER_BASE_LINK'],
                            'PAGER_PARAMS_NAME' => $arParams['PAGER_PARAMS_NAME'],
                            'DISPLAY_DATE' => $arParams['DISPLAY_DATE'],
                            'DISPLAY_NAME' => 'Y',
                            'DISPLAY_PICTURE' => $arParams['DISPLAY_LIST_PICTURE'],
                            'DISPLAY_PREVIEW_TEXT' => $arParams['DISPLAY_LIST_PREVIEW_TEXT'],
                            'PREVIEW_TRUNCATE_LEN' => $arParams['PREVIEW_TRUNCATE_LEN'],
                            'ACTIVE_DATE_FORMAT' => $arParams['LIST_ACTIVE_DATE_FORMAT'],
                            'USE_PERMISSIONS' => $arParams['USE_PERMISSIONS'],
                            'GROUP_PERMISSIONS' => $arParams['GROUP_PERMISSIONS'],
                            'FILTER_NAME' => $arParams['FILTER_NAME'],
                            'HIDE_LINK_WHEN_NO_DETAIL' => $arParams['HIDE_LINK_WHEN_NO_DETAIL'],
                            'CHECK_DATES' => $arParams['CHECK_DATES'],
                            'LINE_COUNT' => $arParams['VIEW_LIST_LINE_COUNT'],
                            'PAGE_ELEMENT_COUNT' => $arParams["NEWS_COUNT"]
                        ),
                        $component
                    );?>
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
