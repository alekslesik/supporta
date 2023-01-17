<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arBlocks = $arResult['BLOCKS'];
$arVisual = $arResult['VISUAL'];

$sTag = $arVisual['LINK']['USE'] ? 'a' : 'div';

?>
<div class="widget c-news c-news-template-2" id="<?= $sTemplateId ?>">
    <div class="widget-wrapper intec-content intec-content-visible">
        <div class="widget-wrapper-2 intec-content-wrapper">
            <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['DESCRIPTION']['SHOW']) { ?>
                <div class="widget-header">
                    <?php if ($arBlocks['HEADER']['SHOW']) { ?>
                        <div class="widget-title align-<?= $arBlocks['HEADER']['POSITION'] ?>">
                            <?= Html::encode($arBlocks['HEADER']['TEXT']) ?>
                        </div>
                    <?php } ?>
                    <?php if ($arBlocks['DESCRIPTION']['SHOW']) { ?>
                        <div class="widget-description align-<?= $arBlocks['DESCRIPTION']['POSITION'] ?>">
                            <?= Html::encode($arBlocks['DESCRIPTION']['TEXT']) ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="widget-content">
                <div class="widget-navigation">
                    <div class="intec-aligner"></div>
                    <div class="widget-navigation-wrapper">
                        <div class="widget-navigation-previous" data-move="previous">
                            <i class="fa fa-arrow-left intec-cl-text-hover"></i>
                        </div>
                        <div class="widget-navigation-next" data-move="next">
                            <i class="fa fa-arrow-right intec-cl-text-hover"></i>
                        </div>
                    </div>
                </div>
                <div class="widget-items owl-carousel">
                    <?php foreach ($arResult['ITEMS'] as $arItem) {

                        $sId = $sTemplateId.'_'.$arItem['ID'];
                        $sAreaId = $this->GetEditAreaId($sId);
                        $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                        $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                        $sPicture = null;
                        $sPicture = $arItem['PREVIEW_PICTURE'];

                        if (empty($sPicture))
                            $sPicture = $arItem['DETAIL_PICTURE'];

                        if (!empty($sPicture)) {
                            $sPicture = CFile::ResizeImageGet($sPicture, [
                                'width' => 600,
                                'height' => 600
                            ], BX_RESIZE_IMAGE_PROPORTIONAL);

                            if (!empty($sPicture))
                                $sPicture = $sPicture['src'];
                        }

                        if (empty($sPicture))
                            $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';
                    ?>
                        <?= Html::beginTag('div', [
                            'class' => 'widget-item-wrap'
                        ]) ?>
                            <div class="widget-item" id="<?= $sAreaId ?>">
                                <div class="intec-grid intec-grid-nowrap intec-grid-a-v-stretch intec-grid-a-h-center" >
                                    <div class="widget-item-picture-wrap intec-grid-item-auto">
                                        <?= Html::tag($sTag, '', [
                                            'class' => [
                                                'widget-item-picture',
                                                'intec-image-effect'
                                            ],
                                            'style' => [
                                                'background-image' => 'url('.$sPicture.')'
                                            ],
                                            'href' => $arVisual['LINK']['USE'] ? $arItem['DETAIL_PAGE_URL'] : null
                                        ]) ?>
                                    </div>
                                    <div class="widget-item-text intec-grid-item intec-grid-item-shrink-1">
                                        <div class="widget-item-name">
                                            <?= Html::tag($sTag, $arItem['NAME'], [
                                                'class' => [
                                                    'widget-item-name-wrapper',
                                                    'intec-cl-text-hover'
                                                ],
                                                'href' => $arVisual['LINK']['USE'] ? $arItem['DETAIL_PAGE_URL'] : null
                                            ]) ?>
                                        </div>
                                        <?php if ($arVisual['DESCRIPTION']['SHOW'] && $arVisual['COLUMNS'] == 2){ ?>
                                            <div class="widget-item-description">
                                                <?= $arItem['PREVIEW_TEXT'] ?>
                                            </div>
                                        <?php } ?>
                                        <?php if ($arVisual['DATE']['SHOW']) { ?>
                                            <div class="widget-item-date">
                                                <?php if (!empty($arItem['DATE_ACTIVE_FROM_FORMATTED'])) { ?>
                                                    <?= $arItem['DATE_ACTIVE_FROM_FORMATTED'] ?>
                                                <?php } else { ?>
                                                    <?= $arItem['DATE_CREATE_FORMATTED'] ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                </div>
                <div class="widget-dots"></div>
            </div>
            <?php if ($arBlocks['FOOTER']['SHOW']) { ?>
                <div class="widget-footer align-<?= $arBlocks['FOOTER']['POSITION'] ?>">
                    <?php if ($arBlocks['FOOTER']['BUTTON']['SHOW']) { ?>
                        <?= Html::tag('a', $arBlocks['FOOTER']['BUTTON']['TEXT'], [
                            'href' => $arBlocks['FOOTER']['BUTTON']['LINK'],
                            'class' => [
                                'widget-footer-button',
                                'intec-ui' => [
                                    '',
                                    'size-5',
                                    'scheme-current',
                                    'control-button',
                                    'mod' => [
                                        'transparent',
                                        'round-half'
                                    ]
                                ]
                            ]
                        ]) ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include(__DIR__.'/script.php') ?>
</div>