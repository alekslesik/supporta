<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
    <?php

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Json;

/**
 * @var array $arParams
 * @var array $arResult
 */

$this->setFrameMode(true);

Loc::loadMessages(__FILE__);

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

include(__DIR__.'/parts/data.php');

$arVisual = $arResult['VISUAL'];
$arSections = $arResult['SECTIONS'];
$arPrice = null;

if (!empty($arResult['ITEM_PRICES']))
    $arPrice = ArrayHelper::getFirstValue($arResult['ITEM_PRICES']);

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-element',
        'c-catalog-element-catalog-default-2'
    ],
    'data' => [
        'data' => Json::encode($arData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true),
        'properties' => Json::encode($arResult['SKU_PROPS'], JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true),
        'available' => $arData['available'] ? 'true' : 'false',
        'wide' => $arVisual['WIDE'] ? 'true' : 'false'
    ]
]) ?>
    <?php if ($arVisual['PANEL']['SHOW']) {
        include(__DIR__.'/parts/panel.php');
    } ?>
    <?php if ($arVisual['WIDE']) { ?>
        <div class="catalog-element-wrapper intec-content intec-content-visible">
            <div class="catalog-element-wrapper-2 intec-content-wrapper">
    <?php } ?>
    <div class="catalog-element-information">
        <?php if ($arVisual['GALLERY']['SHOW']) { ?>
            <div class="catalog-element-information-left">
                <?php if ($arVisual['MARKS']['SHOW']) { ?>
                    <?php include(__DIR__.'/parts/marks.php') ?>
                <?php } ?>
                <?php include(__DIR__.'/parts/buttons.php') ?>
                <?php include(__DIR__.'/parts/gallery.php') ?>
            </div>
            <div class="catalog-element-information-right">
        <?php } else { ?>
            <?php if ($arVisual['MARKS']['SHOW']) { ?>
                <div class="catalog-element-information-part">
                    <?php include(__DIR__.'/parts/marks.php') ?>
                </div>
            <?php } ?>
        <?php } ?>
            <div class="catalog-element-information-part intec-grid">
                <div class="intec-grid-item">
                    <?php if ($arVisual['ARTICLE']['SHOW']) { ?>
                        <?php include(__DIR__.'/parts/article.php') ?>
                    <?php } ?>
                </div>
                <div class="intec-grid-item-auto">
                    <?php if ($arVisual['BRAND']['SHOW']) { ?>
                        <?php include(__DIR__.'/parts/brand.php') ?>
                    <?php } ?>
                </div>
            </div>
            <div class="catalog-element-information-part">
                <?php if ($arVisual['VOTE']['SHOW'] || $arVisual['QUANTITY']['SHOW']) { ?>
                    <div class="catalog-element-information-part-wrapper intec-grid intec-grid-i-h-10 intec-grid-a-v-center">
                        <?php if ($arVisual['VOTE']['SHOW']) { ?>
                            <div class="intec-grid-item-auto">
                                <?php include(__DIR__.'/parts/vote.php') ?>
                            </div>
                        <?php } ?>
                        <?php if ($arVisual['QUANTITY']['SHOW']) { ?>
                            <div class="intec-grid-item-auto">
                                <?php include(__DIR__.'/parts/quantity.php') ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="catalog-element-information-part">
                <?php include(__DIR__.'/parts/price.php') ?>
            </div>
            <?php if ($arVisual['PRICE']['RANGE']) { ?>
                <div class="catalog-element-information-part">
                    <?php include(__DIR__.'/parts/price.range.php') ?>
                </div>
            <?php } ?>
            <?php if (!empty($arResult['SKU_PROPS']) && !empty($arResult['OFFERS'])) { ?>
                <div class="catalog-element-information-part">
                    <?php include(__DIR__.'/parts/sku.php') ?>
                </div>
            <?php } ?>
            <?php if ($arVisual['SIZES']['SHOW']) { ?>
                <div class="catalog-element-information-part">
                    <?php include(__DIR__.'/parts/sizes.php') ?>
                </div>
            <?php } ?>
            <?php if ($arVisual['ADDITIONAL']['SHOW']) { ?>
                <div class="catalog-element-information-part catalog-element-additional-products">
                    <?php include(__DIR__.'/parts/additional.php') ?>
                </div>
            <?php } ?>
            <?php if ($arResult['ACTION'] !== 'none') { ?>
                <?php include(__DIR__.'/parts/purchase.php') ?>
            <?php } ?>
            <?php if ($arVisual['DESCRIPTION']['PREVIEW']['SHOW']) { ?>
                <div class="catalog-element-information-part">
                    <div class="catalog-element-description catalog-element-description-preview intec-ui-markup-text">
                        <?= $arResult['PREVIEW_TEXT'] ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($arVisual['PROPERTIES']['PREVIEW']['SHOW']) { ?>
                <div class="catalog-element-information-part">
                    <?php include(__DIR__.'/parts/properties.php') ?>
                </div>
            <?php } ?>
            <?php if ($arVisual['INFORMATION']['PAYMENT']['SHOW'] || $arVisual['INFORMATION']['SHIPMENT']['SHOW']) { ?>
                <div class="catalog-element-information-part">
                    <div class="catalog-element-other-information">
                        <?php include(__DIR__.'/parts/information.php') ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($arVisual['SECTIONS']) && $arVisual['VIEW']['VALUE'] === 'narrow') { ?>
                <div class="catalog-element-information-part">
                    <?php include(__DIR__.'/parts/sections.narrow.php') ?>
                </div>
            <?php } ?>
        <?php if ($arVisual['GALLERY']['SHOW']) { ?>
            </div>
        <?php } ?>
        <div class="clearfix"></div>
    </div>
    <?php if ($arVisual['VIEW']['VALUE'] !== 'tabs') {
        include(__DIR__.'/parts/sets.php');
    } ?>
    <?php if (!empty($arVisual['SECTIONS'])) {
        if ($arVisual['VIEW']['VALUE'] === 'wide') {
            include(__DIR__.'/parts/sections.wide.php');
        } else if (
            $arVisual['VIEW']['VALUE'] === 'tabs' &&
            $arVisual['VIEW']['POSITION'] === 'top'
        ) {
            include(__DIR__.'/parts/sections.tabs.php');
        }
    } ?>
    <?php if ($arVisual['VIEW']['VALUE'] === 'tabs') {
        include(__DIR__.'/parts/sets.php');
    } ?>

    <?php if ($arVisual['VIEW']['VALUE'] === 'narrow') { ?>
        <?php if ($arVisual['STORES']['SHOW']) { ?>
            <div class="catalog-element-sections catalog-element-sections-wide">
                <div class="catalog-element-section">
                    <div class="catalog-element-section-name">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_STORES') ?>
                    </div>
                    <div class="catalog-element-section-content">
                        <?php include(__DIR__.'/parts/sections/stores.php'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if ($arVisual['FORM']['SHOW']) { ?>
        <div class="catalog-element-sections catalog-element-sections-wide">
            <div class="catalog-element-section">
                <div class="catalog-element-section-content">
                    <?php include(__DIR__.'/parts/form.php'); ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($arVisual['ASSOCIATED']['SHOW'] || $arVisual['RECOMMENDED']['SHOW']) { ?>
        <?php if ($arVisual['ASSOCIATED']['SHOW']) { ?>
            <div class="catalog-element-sections catalog-element-sections-wide">
                <div class="catalog-element-section">
                    <div class="catalog-element-section-name">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_ASSOCIATED') ?>
                    </div>
                    <div class="catalog-element-section-content">
                        <?php include(__DIR__.'/parts/associated.php') ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($arVisual['RECOMMENDED']['SHOW']) { ?>
            <div class="catalog-element-sections catalog-element-sections-wide">
                <div class="catalog-element-section">
                    <div class="catalog-element-section-name">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_RECOMMENDED') ?>
                    </div>
                    <div class="catalog-element-section-content">
                        <?php include(__DIR__.'/parts/recommended.php') ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <?php if (!empty($arVisual['SECTIONS'])) {
        if (
            $arVisual['VIEW']['VALUE'] === 'tabs' &&
            $arVisual['VIEW']['POSITION'] === 'bottom'
        ) include(__DIR__.'/parts/sections.tabs.php');
    } ?>
    <?php include(__DIR__.'/parts/script.php') ?>
    <?php if ($arVisual['WIDE']) { ?>
            </div>
        </div>
    <?php } ?>
    <?php include(__DIR__.'/parts/microdata.php') ?>
<?= Html::endTag('div') ?>