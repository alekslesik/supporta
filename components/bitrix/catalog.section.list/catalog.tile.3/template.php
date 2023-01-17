<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\Html;

/**
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (empty($arResult['SECTIONS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$arVisual = $arResult['VISUAL'];

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-section-list',
        'c-catalog-section-list-catalog-tile-3'
    ],
    'data' => [
        'columns' => $arVisual['COLUMNS'],
        'children-show' => $arVisual['CHILDREN']['SHOW'] ? 'true' : 'false',
        'wide' => $arVisual['WIDE'] ? 'true' : 'false'
    ]
]) ?>
    <div class="<?= Html::cssClassFromArray([
        'catalog-section-list-items',
        'intec-grid' => [
            '',
            'wrap',
            'a-h-start',
            'a-v-start',
            'i-h-6',
            'i-v-10'
        ]
    ]) ?>">
        <?php foreach ($arResult['SECTIONS'] as $arSection) { ?>
        <?php
            $sId = $sTemplateId.'_'.$arSection['ID'];
            $sAreaId = $this->GetEditAreaId($sId);
            $this->AddEditAction($sId, $arSection['EDIT_LINK']);
            $this->AddDeleteAction($sId, $arSection['DELETE_LINK']);

            $sName = $arSection['NAME'];
            $sLink = $arSection['SECTION_PAGE_URL'];
            $arPicture = $arSection['PICTURE'];
            $arChildren = null;

            if (!empty($arPicture)) {
                $arPicture = CFile::ResizeImageGet($arPicture, [
                    'width' => '320',
                    'height' => '320'
                ], BX_RESIZE_IMAGE_PROPORTIONAL);

                if (!empty($arPicture))
                    $arPicture = [
                        'ALT' => $arSection['PICTURE']['ALT'],
                        'SRC' => $arPicture['src'],
                        'TITLE' => $arSection['PICTURE']['TITLE']
                    ];
            }

            if (empty($arPicture)) {
                $arPicture = [
                    'ALT' => null,
                    'SRC' => SITE_TEMPLATE_PATH.'/images/picture.missing.png',
                    'TITLE' => null
                ];
            }

            if ($arVisual['CHILDREN']['SHOW'])
                $arChildren = $arSection['SECTIONS'];
        ?>
            <div class="<?= Html::cssClassFromArray([
                'catalog-section-list-item' => true,
                'intec-grid-item' => [
                    $arVisual['COLUMNS'] => true,
                    '450-1' => true,
                    '700-2' => $arVisual['WIDE'] && $arVisual['COLUMNS'] > 2,
                    '900-3' => $arVisual['WIDE'] && $arVisual['COLUMNS'] > 3,
                    '720-2' => !$arVisual['WIDE'],
                    '768-1' => !$arVisual['WIDE'],
                    '1000-3' => $arVisual['WIDE'] && $arVisual['COLUMNS'] > 3,
                    '1000-2' => !$arVisual['WIDE'] && $arVisual['COLUMNS'] > 2
                ]
            ], true) ?>">
                <div id="<?= $sAreaId ?>" class="catalog-section-list-item-wrapper">
                    <a href="<?= $sLink ?>" class="catalog-section-list-item-image">
                        <div class="catalog-section-list-item-image-wrapper">
                            <div class="catalog-section-list-item-image-wrapper-2 intec-image intec-image-effect">
                                <div class="intec-aligner"></div>
                                <?= Html::img($arPicture['SRC'], [
                                    'alt' => $arPicture['ALT'],
                                    'title' => $arPicture['TITLE']
                                ]) ?>
                            </div>
                        </div>
                    </a>
                    <div class="catalog-section-list-item-information">
                        <a href="<?= $sLink ?>" class="catalog-section-list-item-title intec-cl-text">
                            <span class="catalog-section-list-item-title-text">
                                <?= $sName ?>
                            </span>
                            <?php if ($arVisual['ELEMENTS']['QUANTITY']) { ?>
                                <span class="catalog-section-list-item-title-elements">
                                    (<?= $arSection['ELEMENT_CNT'] ?>)
                                </span>
                            <?php } ?>
                        </a>
                    </div>
                    <?php if (!empty($arChildren)) { ?>
                        <div class="catalog-section-list-item-children">
                            <?php $iChildCount = 0 ?>
                            <?php foreach ($arChildren as $arChild) { ?>
                            <?php
                                if ($arVisual['CHILDREN']['COUNT'] !== false)
                                    if ($iChildCount >= $arVisual['CHILDREN']['COUNT'])
                                        break;

                                $sChildName = $arChild['NAME'];
                                $sChildLink = $arChild['SECTION_PAGE_URL'];
                            ?>
                                <div class="catalog-section-list-item-child">
                                    <a href="<?= $sChildLink ?>" class="catalog-section-list-item-child-wrapper intec-cl-text-hover">
                                        <span class="catalog-section-list-item-child-name"><?= $sChildName ?></span>
                                        <?php if ($arVisual['ELEMENTS']['QUANTITY']) { ?>
                                            <span class="catalog-section-list-item-child-elements">(<?= $arChild['ELEMENT_CNT'] ?>)</span>
                                        <?php } ?>
                                    </a>
                                </div>
                            <?php $iChildCount++ ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::endTag('div') ?>