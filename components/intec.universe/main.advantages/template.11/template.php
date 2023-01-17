<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
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

$iCounter = 0;

?>
<div class="widget c-advantages c-advantages-template-11" id="<?= $sTemplateId ?>">
    <div class="widget-wrapper intec-content">
        <div class="widget-wrapper-2 intec-content-wrapper">
            <div class="widget-content">
                <div class="intec-grid intec-grid-1024-wrap">
                    <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['DESCRIPTION']['SHOW']) { ?>
                        <?= Html::beginTag('div', [
                            'class' => [
                                'widget-header',
                                'intec-grid-item-auto',
                                'intec-grid-item-shrink-1',
                                'intec-grid-item-1024-1'
                            ]
                        ]) ?>
                            <?php if ($arBlocks['HEADER']['SHOW']) { ?>
                                <div class="widget-title">
                                    <?= Html::encode($arBlocks['HEADER']['TEXT']) ?>
                                </div>
                            <?php } ?>
                            <?php if ($arBlocks['DESCRIPTION']['SHOW']) { ?>
                                <div class="widget-description">
                                    <?= Html::encode($arBlocks['DESCRIPTION']['TEXT']) ?>
                                </div>
                            <?php } ?>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                    <div class="widget-items intec-grid-item intec-grid-item-1024-1">
                        <?= Html::beginTag('div', [
                            'class' => [
                                'widget-items-wrapper',
                                'intec-grid',
                                'intec-grid-wrap',
                                'intec-grid-a-v-stretch',
                                'intec-grid-i-h-7',
                                'intec-grid-i-v-8'
                            ]
                        ]) ?>
                            <?php foreach ($arResult['ITEMS'] as $arItem) {

                                $sId = $sTemplateId.'_'.$arItem['ID'];
                                $sAreaId = $this->GetEditAreaId($sId);
                                $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                                $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                                $iCounter++;
                            ?>
                                <?= Html::beginTag('div', [
                                    'id' => $sAreaId,
                                    'class' => Html::cssClassFromArray([
                                        'widget-item' => true,
                                        'intec-grid-item' => [
                                            $arVisual['COLUMNS'] => true,
                                            '768-2' => $arVisual['COLUMNS'] >= 3,
                                            '600-1' => $arVisual['COLUMNS'] >= 2
                                        ]
                                    ], true)
                                ]) ?>
                                    <div class="widget-item-wrapper">
                                        <?php if ($arVisual['NUMBER']['SHOW']) { ?>
                                            <div class="widget-item-counter">
                                                <?= $iCounter ?>
                                            </div>
                                        <?php } ?>
                                        <div class="widget-item-name">
                                            <?= $arItem['NAME'] ?>
                                        </div>
                                        <?php if (!empty($arItem['PREVIEW_TEXT']) && $arVisual['PREVIEW']['SHOW']) { ?>
                                            <div class="widget-item-description">
                                                <?= $arItem['PREVIEW_TEXT'] ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?php } ?>
                        <?= Html::endTag('div') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>