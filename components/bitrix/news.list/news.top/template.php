<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\Core;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 */

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$sVariableTag = ArrayHelper::getValue($arResult, 'VARIABLE_TAG');

$request = Core::$app->request;

$this->setFrameMode(true);

$arTagsActive = $request->get($sVariableTag);
$arViewParams = ArrayHelper::getValue($arResult, 'VIEW_PARAMETERS');
$arHeaderBlock = ArrayHelper::getValue($arResult, 'HEADER_BLOCK');
$arCodes = ArrayHelper::getValue($arResult, 'PROPERTY_CODES');

?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <div class="ns-bitrix c-news-list c-news-list-news-top">
            <?php if ($arHeaderBlock['SHOW']) { ?>
                <div class="news-list-header">
                    <?= $arHeaderBlock['TEXT'] ?>
                </div>
            <?php } ?>
            <div class="news-list-content">
                <?php foreach ($arResult['ITEMS'] as $arItem) {

                    $sId = $sTemplateId.'_'.$arItem['ID'];
                    $sAreaId = $this->GetEditAreaId($sId);
                    $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                    $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                    $arTags = ArrayHelper::getValue($arItem, ['PROPERTIES', $arCodes['TAG']]);

                    $sName = ArrayHelper::getValue($arItem, 'NAME');
                    $sUrl = ArrayHelper::getValue($arItem, 'DETAIL_PAGE_URL');
                    $sDate = ArrayHelper::getValue($arItem, 'DATE_PRINT');

                ?>
                    <div class="news-list-element-wrap">
                        <div class="news-list-element" id="<?= $sAreaId ?>">
                            <a class="news-list-element-name intec-cl-text-hover" href="<?= $sUrl ?>">
                                <?= $sName ?>
                            </a>
                            <div class="news-list-element-additional">
                                <?php if ($arViewParams['TAG_SHOW'] && !empty($arTags['VALUE_ENUM_ID']) && Type::isArray($arTags['VALUE_ENUM_ID'])) { ?>
                                    <div class="news-list-element-tags">
                                        <?php foreach ($arTags['VALUE_ENUM_ID'] as $sValue) {

                                            $arTag = ArrayHelper::getValue($arResult, ['TAGS', $sValue]);

                                            $sTagCurrent = ArrayHelper::getValue($arTagsActive, $sValue) == 'Y';
                                            $sTagValue = $sTagCurrent ? 'N' : 'Y';
                                            $sActiveClass = $sTagCurrent ? ' active intec-cl-background intec-cl-background-light-hover' : ' intec-cl-background-hover';

                                        ?>
                                            <?php if ($arViewParams['TAG_DISABLED']) { ?>
                                                <div class="news-list-element-tag">
                                                    <div class="news-list-element-tag-button tag-disabled<?= $sActiveClass ?>">
                                                        <?= $arTag['VALUE'] ?>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <form action="" method="get" class="news-list-element-tag">
                                                    <?= Html::hiddenInput($sVariableTag, $arTagsActive) ?>
                                                    <button class="news-list-element-tag-button<?= $sActiveClass ?>" name="<?= $sVariableTag ?>[<?= $sValue ?>]" type="submit" value="<?= $sTagValue ?>">
                                                        <?= $arTag['VALUE'] ?>
                                                    </button>
                                                </form>
                                            <?php } ?>
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>
