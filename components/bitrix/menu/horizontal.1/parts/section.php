<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 * @var int $iLevel
 * @var array $arItem
 * @var array $arItems
 */

$bFirstItem = true;
?>
<div class="menu-submenu menu-submenu-<?= $iLevel ?>" data-role="menu" data-columns="<?= $arVisual['SECTION']['COLUMNS'] ?>">
    <div class="menu-submenu-wrapper">
        <?php foreach ($arItems as $arItem) { ?>
        <?php
            $bActive = $arItem['ACTIVE'];
            $bSelected = ArrayHelper::getValue($arItem, 'SELECTED');
            $bSelected = Type::toBoolean($bSelected);

            $sImage = null;

            if (!empty($arItem['IMAGE'])) {
                $sImage = CFile::ResizeImageGet($arItem['IMAGE'], array(
                    'width' => 90,
                    'height' => 90
                ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                if (!empty($sImage)) {
                    $sImage = $sImage['src'];
                } else {
                    $sImage = null;
                }
            }

            $sUrl = $bActive ? null : $arItem['LINK'];
            $sTag = $bActive ? 'div' : 'a';
        ?>
            <?php if ($arParams['SECTION_VIEW'] == 'default') { ?>
                <div class="menu-submenu-section menu-submenu-section-default<?= $bSelected ? ' menu-submenu-section-active' : null ?>">
                    <div class="menu-submenu-section-wrapper">
                        <div class="menu-submenu-section-header">
                            <?= Html::beginTag($sTag, array(
                                'class' => 'menu-submenu-section-header-wrapper intec-cl-text',
                                'href' => $arItem['LINK']
                            )); ?>
                                <?= Html::encode($arItem['TEXT']) ?>
                            <?= Html::endTag($sTag) ?>
                        </div>
                        <?php if (!empty($arItem['ITEMS'])) { ?>
                            <div class="menu-submenu-section-items">
                                <div class="menu-submenu-section-items-wrapper">
                                    <?php foreach ($arItem['ITEMS'] as $arSubItem) { ?>
                                    <?php
                                        $bActive = $arSubItem['ACTIVE'];
                                        $bSelected = ArrayHelper::getValue($arSubItem, 'SELECTED');
                                        $bSelected = Type::toBoolean($bSelected);

                                        $sSubUrl = $bActive ? null : $arSubItem['LINK'];
                                        $sSubTag = $bActive ? 'div' : 'a';
                                    ?>
                                        <?= Html::beginTag($sSubTag, array(
                                            'class' => 'menu-submenu-section-item intec-cl-text-hover'.($bSelected ? ' menu-submenu-section-item-active intec-cl-text' : null),
                                            'href' => $sSubUrl
                                        )); ?>
                                            <?= Html::encode($arSubItem['TEXT']) ?>
                                        <?= Html::endTag($sSubTag) ?>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } else if ($arParams['SECTION_VIEW'] == 'images') { ?>
                <div class="menu-submenu-section menu-submenu-section-with-images<?= $bSelected ? ' menu-submenu-section-active' : null ?>">
                    <div class="menu-submenu-section-wrapper">
                        <div class="menu-submenu-section-image intec-image-effect" style="background-image: url('<?= $sImage ?>')"></div>
                        <div class="menu-submenu-section-links">
                            <div class="menu-submenu-section-header">
                                <?= Html::beginTag($sTag, array(
                                    'class' => 'menu-submenu-section-header-wrapper intec-cl-text-hover',
                                    'href' => $sUrl
                                )); ?>
                                    <?= $arItem['TEXT'] ?>
                                <?= Html::endTag($sTag) ?>
                            </div>
                            <?php if (!empty($arItem['ITEMS'])) { ?>
                                <div class="menu-submenu-section-items">
                                    <div class="menu-submenu-section-items-wrapper">
                                        <?php $iSubItemsCount = 0 ?>
                                        <?php foreach ($arItem['ITEMS'] as $arSubItem) { ?>
                                        <?php
                                            $iSubItemsCount++;

                                            if ($iSubItemsCount > $arVisual['SECTION']['ITEMS'])
                                                break;

                                            $bActive = $arSubItem['ACTIVE'];
                                            $bSelected = ArrayHelper::getValue($arSubItem, 'SELECTED');
                                            $bSelected = Type::toBoolean($bSelected);

                                            $sSubUrl = $bActive ? null : $arSubItem['LINK'];
                                            $sSubTag = $bActive ? 'div' : 'a';
                                        ?>
                                            <div class="menu-submenu-section-item<?= $bSelected ? ' menu-submenu-section-item-active' : null ?>">
                                                <?= Html::beginTag($sSubTag, array(
                                                    'class' => 'menu-submenu-section-item-wrapper intec-cl-text-hover',
                                                    'href' => $sSubUrl
                                                )); ?>
                                                    <?= $arSubItem['TEXT'] ?>
                                                <?= Html::endTag($sSubTag) ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php } ?>
            <?php $bFirstItem = false ?>
        <?php } ?>
    </div>
</div>
