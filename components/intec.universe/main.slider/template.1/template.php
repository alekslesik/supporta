<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\Core;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var CAllMain $APPLICATION
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];
$arForm = $arResult['FORM'];

$bSliderUse = count($arResult['ITEMS']) > 1;
$bDesktop = Core::$app->browser->isDesktop;
$bItemsFirst = true;

/**
 * @var Closure $hText($arData)
 * @var Closure $vImage($arData)
 * @var Closure $vNavigation()
 * @var Closure $vAdditional()
 */
$vText = include(__DIR__.'/parts/text.php');
$vPicture = include(__DIR__.'/parts/picture.php');
$vNavigation = include(__DIR__.'/parts/navigation.php');
$vAdditional = include(__DIR__.'/parts/additional.php');

?>
<div class="widget c-slider c-slider-template-1" id="<?= $sTemplateId ?>">
    <div class="intec-content-wrap">
        <?= Html::beginTag('div', [
            'class' => 'widget-content',
            'data' => [
                'role' => 'content',
                'scheme' => 'dark',
                'nav' => $bSliderUse && $arVisual['SLIDER']['NAV']['SHOW'] ? 'true' : 'false',
                'nav-view' => $bSliderUse && $arVisual['SLIDER']['NAV']['SHOW'] ? $arVisual['SLIDER']['NAV']['VIEW'] : null,
                'dots' => $bSliderUse && $arVisual['SLIDER']['DOTS']['SHOW'] ? 'true' : 'false',
                'dots-view' => $bSliderUse && $arVisual['SLIDER']['DOTS']['SHOW'] ? $arVisual['SLIDER']['DOTS']['VIEW'] : null
            ]
        ]) ?>
            <?= Html::beginTag('div', [
                'class' => Html::cssClassFromArray([
                    'widget-items' => true,
                    'owl-carousel' => $bSliderUse
                ], true),
                'data' => [
                    'role' => 'container'
                ]
            ]) ?>
                <?php foreach ($arResult['ITEMS'] as $arItem) {

                    $sId = $sTemplateId.'_'.$arItem['ID'];
                    $sAreaId = $this->GetEditAreaId($sId);
                    $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                    $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                    $arData = $arItem['DATA'];

                    $sItemName = $arItem['NAME'];

                    $sTag = !empty($arData['LINK']['VALUE']) && !$arData['BUTTON']['SHOW'] ? 'a' : 'div';
                    $sPicture = ArrayHelper::getValue($arItem, ['PREVIEW_PICTURE', 'SRC']);

                    if (empty($sPicture))
                        $sPicture = ArrayHelper::getValue($arItem, ['DETAIL_PICTURE', 'SRC']);

                    if (empty($sPicture))
                        $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

                ?>
                    <?= Html::beginTag($sTag, [
                        'href' => $sTag === 'a' ? $arData['LINK']['VALUE'] : null,
                        'class' => 'widget-item',
                        'target' => $sTag === 'a' && $arData['LINK']['BLANK'] ? '_blank' : null,
                        'style' => [
                            'background-image' => 'url("'.$sPicture.'")'
                        ],
                        'data' => [
                            'item-scheme' => $arData['SCHEME']
                        ]
                    ]) ?>
                        <?php if ($bDesktop && $arVisual['VIDEO']['SHOW']) { ?>
                            <?php if (!empty($arData['VIDEO']['FILES'])) { ?>
                                <div class="widget-item-video">
                                    <?php $APPLICATION->IncludeComponent(
                                        'intec.universe:system.video.tag',
                                        '.default', [
                                            'FILES_MP4' => !empty($arData['VIDEO']['FILES']['MP4']) ? $arData['VIDEO']['FILES']['MP4']['SRC'] : null,
                                            'FILES_WEBM' => !empty($arData['VIDEO']['FILES']['WEBM']) ? $arData['VIDEO']['FILES']['WEBM']['SRC'] : null,
                                            'FILES_OGV' => !empty($arData['VIDEO']['FILES']['OGV']) ? $arData['VIDEO']['FILES']['OGV']['SRC'] : null,
                                            'PICTURE' => $sPicture,
                                            'CACHE_TYPE' => 'N'
                                        ],
                                        $component,
                                        ['HIDE_ICONS' => 'Y']
                                    ) ?>
                                </div>
                            <?php } else if (!empty($arData['VIDEO']['LINK'])) { ?>
                                <div class="widget-item-video">
                                    <?php $APPLICATION->IncludeComponent(
                                        'intec.universe:system.video.frame',
                                        '.default', [
                                            'URL' => $arData['VIDEO']['LINK'],
                                            'CACHE_TYPE' => 'N'
                                        ],
                                        $component,
                                        ['HIDE_ICONS' => 'Y']
                                    ) ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($arData['FADE']) { ?>
                            <div class="widget-item-fade"></div>
                        <?php } ?>
                        <?= Html::beginTag('div', [
                            'class' => [
                                'widget-item-content',
                                'intec-content' => [
                                    '',
                                    'primary',
                                    'visible'
                                ]
                            ],
                            'style' => [
                                'height' => $arVisual['HEIGHT'].'px'
                            ]
                        ]) ?>
                            <div class="widget-item-content-wrapper intec-content-wrapper" id="<?= $sAreaId ?>">
                                <?= Html::beginTag('div', [
                                    'class' => [
                                        'widget-item-grid-vertical',
                                        'intec-grid' => [
                                            '',
                                            'wrap',
                                            'o-vertical',
                                            'a-h-start',
                                            'a-v-stretch'
                                        ]
                                    ]
                                ]) ?>
                                    <?php if ($sTag !== 'a' && $arVisual['BUTTONS']['BACK']['SHOW']) { ?>
                                        <div class="widget-item-grid-vertical-item intec-grid-item-auto">
                                            <div class="widget-item-back-wrap">
                                                <a href="<?= $arVisual['BUTTONS']['BACK']['LINK'] ?>" class="widget-item-back">
                                                    <span class="widget-item-back-icon"><i class="far fa-angle-left"></i></span>
                                                    <span class="widget-item-back-text"><?= Loc::getMessage('C_MAIN_SLIDER_TEMPLATE_1_BUTTONS_BACK_TEXT') ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="widget-item-grid-vertical-item intec-grid-item">
                                        <?= Html::beginTag('div', [
                                            'class' => [
                                                'widget-item-grid-horizontal',
                                                'intec-grid' => [
                                                    '',
                                                    'wrap',
                                                    'a-h-start',
                                                    'a-v-stretch'
                                                ]
                                            ]
                                        ]) ?>
                                            <?php if ($arData['TEXT']['POSITION'] === 'right') { ?>
                                                <?php $vPicture($arData) ?>
                                            <?php } ?>
                                            <?php $vText($arData, $bItemsFirst && $arVisual['HEADER']['H1']) ?>
                                            <?php if ($arData['TEXT']['POSITION'] === 'left') { ?>
                                                <?php $vPicture($arData) ?>
                                            <?php } ?>
                                        <?= Html::endTag('div') ?>
                                    </div>
                                    <?php $vAdditional($arData) ?>
                                <?= Html::endTag('div') ?>
                            </div>
                        <?= Html::endTag('div') ?>
                    <?= Html::endTag($sTag) ?>
                    <?php $bItemsFirst = false ?>
                <?php } ?>
            <?= Html::endTag('div') ?>
            <?php $vNavigation() ?>
        <?= Html::endTag('div') ?>
    </div>
</div>
<?php include(__DIR__.'/parts/script.php') ?>