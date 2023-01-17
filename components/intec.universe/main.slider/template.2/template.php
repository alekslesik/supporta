<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

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

$bSliderUse = count($arResult['ITEMS']) > 1;
$bDesktop = Core::$app->browser->isDesktop;

$iBlocksCount = count($arResult['BLOCKS']);

/**
 * @var Closure $vText($arData)
 * @var Closure $vNavigation()
 */
$vText = include(__DIR__.'/parts/text.php');
$vNavigation = include(__DIR__.'/parts/navigation.php');

$arBlocks = [];
$arVisual['BLOCKS']['HALF'] = false;

if ($arVisual['BLOCKS']['USE'] && !empty($arResult['BLOCKS'])) {
    if ($arVisual['BLOCKS']['POSITION'] === 'left')
        $arBlocks['LEFT'] = $arResult['BLOCKS'];
    else if ($arVisual['BLOCKS']['POSITION'] === 'right')
        $arBlocks['RIGHT'] = $arResult['BLOCKS'];
    else if ($arVisual['BLOCKS']['POSITION'] === 'both') {
        if ($iBlocksCount === 1)
            $arBlocks['RIGHT'] = $arResult['BLOCKS'];
        else if ($iBlocksCount === 2 || $iBlocksCount === 3) {
            $arBlocks['LEFT'] = array_slice($arResult['BLOCKS'], 0, 1);
            $arBlocks['RIGHT'] = array_slice($arResult['BLOCKS'], 1);
        } else if ($iBlocksCount === 4) {
            $arBlocks['LEFT'] = array_slice($arResult['BLOCKS'], 0, 2);
            $arBlocks['RIGHT'] = array_slice($arResult['BLOCKS'], 2);
        }
    }

    if (!empty($arBlocks['LEFT']) && !empty($arBlocks['RIGHT']))
        $arVisual['BLOCKS']['HALF'] = true;

    /**
     * @var Closure $vBlocks($arBlocks, $position, $half)
     */
    $vBlocks = include(__DIR__.'/parts/blocks.php');
}

?>
<div class="widget c-slider c-slider-template-2" id="<?= $sTemplateId ?>">
    <div class="intec-content intec-content-primary">
        <div class="intec-content-wrapper">
            <div class="widget-content">
                <?= Html::beginTag('div', [
                    'class' => 'widget-slider',
                    'data' => [
                        'role' => 'content',
                        'indent-left' => !empty($arBlocks['LEFT']) ? 'true' : 'false',
                        'indent-right' => !empty($arBlocks['RIGHT']) ? 'true' : 'false',
                        'rounded' => $arVisual['ROUNDED'] ? 'true' : 'false',
                        'nav-view' => $arVisual['SLIDER']['NAV']['VIEW'],
                        'dots-view' => $arVisual['SLIDER']['DOTS']['VIEW'],
                        'scheme' => 'dark'
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

                            $sTag = !empty($arData['LINK']['VALUE']) && !$arData['BUTTON']['SHOW'] ? 'a' : 'div';
                            $sPicture = ArrayHelper::getValue($arItem, ['PREVIEW_PICTURE', 'SRC']);

                            if (empty($sPicture))
                                $sPicture = ArrayHelper::getValue($arItem, ['DETAIL_PICTURE', 'SRC']);

                            if (empty($sPicture))
                                $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

                        ?>
                            <?= Html::beginTag($sTag, [
                                'id' => $sAreaId,
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
                                        'widget-item-wrapper',
                                        'intec-grid'
                                    ],
                                    'style' => [
                                        'height' => $arVisual['HEIGHT'].'px'
                                    ]
                                ]) ?>
                                    <div class="intec-grid-item intec-grid-item-a-center">
                                        <?php $vText($arData) ?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?= Html::endTag($sTag) ?>
                        <?php } ?>
                    <?= Html::endTag('div') ?>
                    <?php $vNavigation() ?>
                <?= Html::endTag('div') ?>
                <?php if ($arVisual['BLOCKS']['USE'] && !empty($arResult['BLOCKS'])) { ?>
                    <?php $vBlocks($arBlocks['LEFT'], 'left', $arVisual['BLOCKS']['HALF']) ?>
                    <?php $vBlocks($arBlocks['RIGHT'], 'right', $arVisual['BLOCKS']['HALF']) ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include(__DIR__.'/parts/script.php') ?>