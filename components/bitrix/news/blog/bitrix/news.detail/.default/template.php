<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arResult
 * @var array $arParams
 */

$this->setFrameMode(true);

$arCodes = ArrayHelper::getValue($arResult, 'PROPERTY_CODES');
$arViewParams = ArrayHelper::getValue($arResult, 'VIEW_PARAMETERS');

$sDate = ArrayHelper::getValue($arResult, 'DISPLAY_ACTIVE_FROM');
$sPreviewText = ArrayHelper::getValue($arResult, 'PREVIEW_TEXT');
$sDetailText = ArrayHelper::getValue($arResult, 'DETAIL_TEXT');
$sDetailPicture = ArrayHelper::getValue($arResult, ['DETAIL_PICTURE', 'SRC']);
$sListPage = ArrayHelper::getValue($arResult, 'LIST_PAGE_URL');

$arTags = ArrayHelper::getValue($arResult, ['PROPERTIES', $arCodes['TAG'], 'VALUE']);
$arDetailPicture = [
    'class' => 'news-detail-text-image',
    'style' => ['background-image' => "url($sDetailPicture)"]
];

$bTagsShowTop = !empty($arCodes['TAG']) && Type::isArray($arTags) && ($arViewParams['TAG_SHOW'] == 'top' || $arViewParams['TAG_SHOW'] == 'all');
$bTagsShowBottom = !empty($arCodes['TAG']) && Type::isArray($arTags) && ($arViewParams['TAG_SHOW'] == 'bottom' || $arViewParams['TAG_SHOW'] == 'all');

$iCounter = 0;

?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <div class="ns-bitrix c-news-detail c-news-detail-default">
            <?php if ($bTagsShowTop || $arViewParams['DATE_SHOW']) { ?>
                <div class="news-detail-header">
                    <?php if ($arViewParams['DATE_SHOW']) { ?>
                        <div class="news-detail-header-date">
                            <?= $sDate ?>
                        </div>
                    <?php } ?>
                    <?php if ($bTagsShowTop) { ?>
                        <?php foreach ($arTags as $sTag) {

                            $iCounter++;

                        ?>
                            <div class="news-detail-tag news-detail-tag-color-<?= $iCounter ?>">
                                <?= '#'.$sTag ?>
                            </div>
                            <?php if ($iCounter == 5) $iCounter = 0 ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="news-detail-content">
                <div class="news-detail-text">
                    <?php if ($arViewParams['PREVIEW_SHOW'] && !empty($sPreviewText)) { ?>
                        <div class="news-detail-text-preview intec-ui-markup-text">
                            <?= $sPreviewText ?>
                        </div>
                    <?php } ?>
                    <?php if ($arViewParams['IMAGE_SHOW'] && !empty($sDetailPicture)) { ?>
                        <div class="news-detail-text-image-wrap">
                            <?= Html::tag('div', '', $arDetailPicture) ?>
                        </div>
                    <?php } ?>
                    <div class="news-detail-text-detail intec-ui-markup-text">
                        <?= $sDetailText ?>
                    </div>
                    <?php if ($bTagsShowBottom) {

                        $iCounter = 0;

                    ?>
                        <div class="news-detail-tags-list">
                            <?php foreach ($arTags as $sTag) {

                                $iCounter++;

                            ?>
                                <div class="news-detail-tag news-detail-tag-color-<?= $iCounter ?>">
                                    <?= '#'.$sTag ?>
                                </div>
                                <?php if ($iCounter == 5) $iCounter = 0 ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php if ($arViewParams['READ_ALSO_SHOW'] && !empty($arResult['FILTER']['ID'])) { ?>
                    <?php $GLOBALS['arrFilter'] = $arResult['FILTER'] ?>
                    <div class="news-detail-read-also">
                        <?php $APPLICATION->IncludeComponent(
                            'bitrix:news.list',
                            'news.'.($arViewParams['READ_ALSO_VIEW'] == 'blocks' ? 'blocks' : 'tile'),
                            array(
                                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                'NEWS_COUNT' => $arViewParams['READ_ALSO_VIEW'] == 'blocks' ? 3 : 4,
                                'LINE_COUNT' => $arViewParams['READ_ALSO_VIEW'] == 'blocks' ? 3 : 4,
                                'SORT_BY1' => 'SORT',
                                'SORT_ORDER1' => 'ASC',
                                'FIELD_CODE' => $arParams['FIELD_CODE'],
                                'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
                                "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                                "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                                'SET_TITLE' => 'N',
                                'SET_LAST_MODIFIED' => 'N',
                                'SET_STATUS_404' => 'N',
                                'SHOW_404' => 'N',
                                'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                'CACHE_TIME' => $arParams['CACHE_TIME'],
                                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                                'DISPLAY_TOP_PAGER' => 'N',
                                'DISPLAY_BOTTOM_PAGER' => 'N',
                                'PAGER_SHOW_ALWAYS' => 'N',
                                'DISPLAY_DATE' => 'Y',
                                'DISPLAY_NAME' => 'Y',
                                'DISPLAY_PICTURE' => 'Y',
                                'DISPLAY_TITLE' => 'Y',
                                'TITLE' => $arViewParams['READ_ALSO_HEADER'],
                                'ACTIVE_DATE_FORMAT' => $arParams['ACTIVE_DATE_FORMAT'],
                                'FILTER_NAME' => 'arrFilter'
                            ),
                            $component
                        ) ?>
                    </div>
                <?php } ?>
            </div>
            <?php if ($arViewParams['BACK_SHOW'] || $arViewParams['SOCIAL_SHOW']) { ?>
                <div class="news-detail-footer clearfix">
                    <?php if ($arViewParams['BACK_SHOW']) { ?>
                        <a class="news-detail-footer-back intec-cl-text-hover" href="<?= $sListPage ?>">
                            <span class="news-detail-footer-back-icon fal fa-angle-left"></span>
                            <span class="news-detail-footer-back-text">
                                <?= $arViewParams['BACK_TEXT'] ?>
                            </span>
                        </a>
                    <?php } ?>
                    <?php if ($arViewParams['SOCIAL_SHOW']) { ?>
                        <div class="news-detail-footer-social">
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:main.share",
                                "flat",
                                array(
                                    'HANDLERS' => $arViewParams['SOCIAL_LIST'],
                                    'PAGE_URL' => $arResult["DETAIL_PAGE_URL"],
                                    "PAGE_TITLE" => $arResult["NAME"]
                                ),
                                $component
                            ); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>