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
$arPictureSizes = [
    'small' => [
        'width' => 60,
        'height' => 60
    ],
    'medium' => [
        'width' => 90,
        'height' => 90
    ],
    'large' => [
        'width' => 120,
        'height' => 120
    ]
];

$arPictureSize = $arPictureSizes[$arVisual['PICTURE']['SIZE']];

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-section-list',
        'c-catalog-section-list-catalog-tile-1'
    ],
    'data' => [
        'borders' => $arVisual['BORDERS'] ? 'true' : 'false',
        'columns' => $arVisual['COLUMNS'],
        'picture-show' => $arVisual['PICTURE']['SHOW'] ? 'true' : 'false',
        'picture-size' => $arVisual['PICTURE']['SIZE'],
        'children-show' => $arVisual['CHILDREN']['SHOW'] ? 'true' : 'false',
        'description-show' => $arVisual['DESCRIPTION']['SHOW'] ? 'true' : 'false',
        'wide' => $arVisual['WIDE'] ? 'true' : 'false'
    ]
]) ?>
    <div class="<?= Html::cssClassFromArray([
        'catalog-section-list-items',
        'intec-grid' => [
            '',
            'wrap',
            'a-h-start',
            'a-v-stretch'
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
            $sDescription = null;
            $arPicture = null;
            $arChildren = null;

            if ($arVisual['DESCRIPTION']['SHOW'])
                $sDescription = $arSection['DESCRIPTION'];

            if ($arVisual['PICTURE']['SHOW']) {
                $arPicture = $arSection['PICTURE'];

                if (!empty($arPicture)) {
                    $arPicture = CFile::ResizeImageGet($arPicture, $arPictureSize, BX_RESIZE_IMAGE_PROPORTIONAL);

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
            }

            if ($arVisual['CHILDREN']['SHOW'])
                $arChildren = $arSection['SECTIONS'];
        ?>
            <div class="<?= Html::cssClassFromArray([
                'catalog-section-list-item' => true,
                'intec-grid-item' => [
                    $arVisual['COLUMNS'] => true,
                    '800-1' => $arVisual['WIDE'] && $arVisual['COLUMNS'] > 1,
                    '1000-1' => !$arVisual['WIDE'] && $arVisual['COLUMNS'] > 1,
                    '1150-2' => $arVisual['WIDE'] && $arVisual['COLUMNS'] > 2,
                ]
            ], true) ?>">
                <div id="<?= $sAreaId ?>" class="catalog-section-list-item-wrapper">
                    <div class="<?= Html::cssClassFromArray([
                        'catalog-section-item-header' => true,
                        'intec-grid' => [
                            '' => true,
                            'nowrap' => true,
                            '450-wrap' => true,
                            'i-h-12' => true,
                            'i-v-10' => true,
                            'a-h-center' => true,
                            'a-v-start' => !empty($arChildren),
                            'a-v-center' => empty($arChildren),
                        ]
                    ], true) ?>">
                        <?php if (!empty($arPicture)) { ?>
                            <a href="<?= $sLink ?>" class="catalog-section-list-item-image intec-grid-item-auto">
                                <div class="catalog-section-list-item-image-wrapper intec-image intec-image-effect">
                                    <div class="intec-aligner"></div>
                                    <?= Html::img($arPicture['SRC'], [
                                        'alt' => $arPicture['ALT'],
                                        'title' => $arPicture['TITLE']
                                    ]) ?>
                                </div>
                            </a>
                        <?php } ?>
                        <div class="catalog-section-list-item-information intec-grid-item intec-grid-item-450-1 intec-grid-item-shrink-1">
                            <a href="<?= $sLink ?>" class="catalog-section-list-item-title intec-cl-text-hover">
                                <?= $sName ?>
                            </a>
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
                                        <a href="<?= $sChildLink ?>" class="catalog-section-list-item-child intec-cl-text-hover">
                                            <span class="catalog-section-list-item-child-name"><?= $sChildName ?></span>
                                            <?php if ($arVisual['ELEMENTS']['QUANTITY']) { ?>
                                                <span class="catalog-section-list-item-child-elements"><?= $arChild['ELEMENT_CNT'] ?></span>
                                            <?php } ?>
                                        </a>
                                    <?php $iChildCount++ ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($sDescription)) { ?>
                        <div class="catalog-section-list-item-description">
                            <?= $sDescription ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::endTag('div') ?>