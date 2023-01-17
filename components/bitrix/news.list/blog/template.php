<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\Core;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$this->setFrameMode(true);

$sVariableTag = ArrayHelper::getValue($arResult, 'VARIABLE_TAG');

$request = Core::$app->request;
$arTagsActive = $request->get($sVariableTag);

$arViewParams = ArrayHelper::getValue($arResult, 'VIEW_PARAMETERS');
$arCodes = ArrayHelper::getValue($arResult, 'PROPERTY_CODES');

$sWithDescription = $arViewParams['DESCRIPTION_SHOW'] ? ' with-description' : null;

$bBigBlock = $arViewParams['VIEW'] == 'big-block';

if (!empty($arResult['NAV_RESULT'])) {
    $navParams =  array(
        'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
        'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
        'NavNum' => $arResult['NAV_RESULT']->NavNum
    );
} else {
    $navParams = array(
        'NavPageCount' => 1,
        'NavPageNomer' => 1,
        'NavNum' => $this->randString()
    );
}
$showBottomPager = false;
$showTopPager = false;

if ($arParams['NEWS_COUNT'] > 0 && $navParams['NavPageCount'] > 1) {
    $showTopPager = $arParams['DISPLAY_TOP_PAGER'];
    $showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
}

?>
<div class="intec-content intec-content-visible">
    <div class="intec-content-wrapper">
        <?php if ($showTopPager) { ?>
            <div data-pagination-num="<?= $navParams['NavNum'] ?>">
                <!-- pagination-container -->
                <?= $arResult['NAV_STRING'] ?>
                <!-- pagination-container -->
            </div>
        <?php } ?>
        <div class="ns-bitrix c-news-list c-news-list-blog">
            <div class="news-list-content">
                <?php foreach ($arResult['ITEMS'] as $arItem) {

                    $sId = $sTemplateId.'_'.$arItem['ID'];
                    $sAreaId = $this->GetEditAreaId($sId);
                    $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                    $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                    $sGrid = $arViewParams['GRID'];

                    $iCountTags = ' in-block';

                    $sPicture = ArrayHelper::getValue($arItem, ['PREVIEW_PICTURE', 'SRC']);
                    $sPicture = !empty($sPicture) ? "url($sPicture)" : null;
                    $sName = ArrayHelper::getValue($arItem, 'NAME');
                    $sUrl = ArrayHelper::getValue($arItem, 'DETAIL_PAGE_URL');
                    $sDate = ArrayHelper::getValue($arItem, 'DATE_PRINT');
                    $sDescription = ArrayHelper::getValue($arItem, 'PREVIEW_TEXT');

                    $arTags = ArrayHelper::getValue($arItem, ['PROPERTIES', $arCodes['TAG']]);

                    $arPictureAttributes = [
                        'class' => 'news-list-element-image',
                        'href' => $sUrl,
                        'style' => [
                            'background-image' => $sPicture
                        ]
                    ];

                ?>
                    <?php if ($bBigBlock) { ?>
                        <div class="news-list-element-wrap big-block grid-<?= $sGrid ?>">
                            <div class="news-list-element<?= $sWithDescription ?>" id="<?= $sAreaId ?>">
                                <?= Html::tag('a', '', $arPictureAttributes) ?>
                                <div class="news-list-element-content">
                                    <div class="news-list-element-name">
                                        <?= $sName ?>
                                    </div>
                                    <div class="news-list-element-additional">
                                        <?php if ($arViewParams['TAG_SHOW'] && !empty($arTags['VALUE_ENUM_ID']) && Type::isArray($arTags['VALUE_ENUM_ID'])) { ?>
                                            <div class="news-list-element-tags">
                                                <?php foreach ($arTags['VALUE_ENUM_ID'] as $sValue) {

                                                    $arTag = ArrayHelper::getValue($arResult, ['TAGS', $sValue]);

                                                    $sTagCurrent = ArrayHelper::getValue($arTagsActive, $sValue) == 'Y';
                                                    $sTagValue = $sTagCurrent ? 'N' : 'Y';
                                                    $sActiveClass = $sTagCurrent ? ' active intec-cl-background intec-cl-background-light-hover' : ' intec-cl-background-hover';

                                                ?>
                                                    <form action="" method="get" class="news-list-element-tag">
                                                        <?= Html::hiddenInput($sVariableTag, $arTagsActive) ?>
                                                        <button class="news-list-element-tag-button<?= $sActiveClass ?>" name="<?= $sVariableTag ?>[<?= $sValue ?>]" type="submit" value="<?= $sTagValue ?>">
                                                            <?= $arTag['VALUE'] ?>
                                                        </button>
                                                    </form>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <?php if ($arViewParams['DATE_SHOW']) { ?>
                                            <div class="news-list-element-date">
                                                <?= $sDate ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $bBigBlock = false ?>
                    <?php } else { ?>
                        <div class="news-list-element-wrap grid-<?= $sGrid ?>">
                           <div class="news-list-element<?= $sWithDescription ?>" id="<?= $sAreaId ?>">
                               <?= Html::tag('a', '', $arPictureAttributes) ?>
                               <div class="news-list-element-content">
                                   <div class="news-list-element-name">
                                       <a class="intec-cl-text-hover" href="<?= $sUrl ?>">
                                           <?= $sName ?>
                                       </a>
                                   </div>
                                   <div class="news-list-element-additional">
                                       <?php if ($arViewParams['TAG_SHOW'] && !empty($arTags['VALUE_ENUM_ID']) && Type::isArray($arTags['VALUE_ENUM_ID'])) {

                                           $iCountTags = count($arTags['VALUE_ENUM_ID']);
                                           $iCountTags = $iCountTags < 2 ? ' in-line' : ' in-block'

                                       ?>
                                           <div class="news-list-element-tags<?= $iCountTags ?>">
                                               <?php foreach ($arTags['VALUE_ENUM_ID'] as $sValue) {

                                                   $arTag = ArrayHelper::getValue($arResult, ['TAGS', $sValue]);

                                                   $sTagCurrent = ArrayHelper::getValue($arTagsActive, $sValue) == 'Y';
                                                   $sTagValue = $sTagCurrent ? 'N' : 'Y';
                                                   $sActiveClass = $sTagCurrent ? ' active intec-cl-background intec-cl-background-light-hover' : ' intec-cl-background-hover';

                                               ?>
                                                   <form action="" method="get" class="news-list-element-tag">
                                                       <?= Html::hiddenInput($sVariableTag, $arTagsActive); ?>
                                                       <button class="news-list-element-tag-button<?= $sActiveClass ?>" name="<?= $sVariableTag ?>[<?= $sValue ?>]" type="submit" value="<?= $sTagValue ?>">
                                                            <?= $arTag['VALUE'] ?>
                                                       </button>
                                                   </form>
                                               <?php } ?>
                                           </div>
                                       <?php } ?>
                                       <?php if ($arViewParams['DATE_SHOW']) { ?>
                                           <div class="news-list-element-date<?= $iCountTags ?>">
                                               <?= $sDate ?>
                                           </div>
                                       <?php } ?>
                                   </div>
                                   <?php if ($arViewParams['DESCRIPTION_SHOW'] && !empty($sDescription)) { ?>
                                       <div class="news-list-element-description">
                                           <?= $sDescription ?>
                                       </div>
                                   <?php } ?>
                               </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php if ($showBottomPager) { ?>
            <div data-pagination-num="<?= $navParams['NavNum'] ?>">
                <!-- pagination-container -->
                <?= $arResult['NAV_STRING'] ?>
                <!-- pagination-container -->
            </div>
        <?php } ?>
    </div>
</div>