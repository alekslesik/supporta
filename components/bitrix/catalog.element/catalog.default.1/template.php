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
$arPrice = null;

if (!empty($arResult['ITEM_PRICES']))
    $arPrice = ArrayHelper::getFirstValue($arResult['ITEM_PRICES']);

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-element',
        'c-catalog-element-catalog-default-1'
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
    <div class="catalog-element-wrapper intec-content intec-content-visible">
        <div class="catalog-element-wrapper-2 intec-content-wrapper">
            <div class="catalog-element-information">
                <?php if ($arVisual['GALLERY']['SHOW']) { ?>
                    <div class="catalog-element-information-left">
                        <?php if ($arVisual['MARKS']['SHOW']) { ?>
                            <?php include(__DIR__.'/parts/marks.php') ?>
                        <?php } ?>
                        <?php include(__DIR__.'/parts/gallery.php') ?>
                    </div>
                    <div class="catalog-element-information-right">
                        <div class="catalog-element-information-right-wrapper">
                <?php } else { ?>
                    <?php if ($arVisual['MARKS']['SHOW']) { ?>
                        <?php include(__DIR__.'/parts/marks.php') ?>
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
                                <?php if ($arVisual['VOTE']['SHOW']) { ?>
                                    <?php include(__DIR__.'/parts/vote.php') ?>
                                <?php } ?>
                            </div>
                            <div class="catalog-element-information-part intec-grid intec-grid-wrap intec-grid-i-5 intec-grid-a-h-start intec-grid-a-v-start">
                                <div class="intec-grid-item">
                                    <?php if ($arVisual['QUANTITY']['SHOW']) { ?>
                                        <?php include(__DIR__.'/parts/quantity.php') ?>
                                    <?php } ?>
                                    <?php include(__DIR__.'/parts/price.php') ?>
                                </div>
                                <div class="intec-grid-item-auto intec-grid-item-shrink-1">
                                    <?php include(__DIR__.'/parts/purchase.php') ?>
                                </div>
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
                            <?php if ($arVisual['DESCRIPTION']['PREVIEW']['SHOW']) { ?>
                                <div class="catalog-element-information-part">
                                    <div class="catalog-element-description catalog-element-description-preview intec-ui-mark-text">
                                        <?= $arResult['PREVIEW_TEXT'] ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($arVisual['PROPERTIES']['PREVIEW']['SHOW']) { ?>
                                <div class="catalog-element-information-part">
                                    <?php include(__DIR__.'/parts/properties.php') ?>
                                </div>
                            <?php } ?>
                            <div class="catalog-element-information-part">
                                <div class="catalog-element-tabs-right">
                                    <?php if ($arVisual['VIEW']['VALUE'] === 'tabs' && $arVisual['VIEW']['POSITION'] === 'right') {
                                        include(__DIR__.'/parts/sections.tabs.right.php');
                                    } ?>
                                </div>
                            </div>
                <?php if ($arVisual['GALLERY']['SHOW']) { ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>

            <?php if ($arVisual['VIEW']['VALUE'] === 'wide' || ($arVisual['VIEW']['VALUE'] === 'tabs' && $arVisual['VIEW']['POSITION'] === 'right')) {
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

            <?php if ($arVisual['VIEW']['VALUE'] === 'tabs' && $arVisual['VIEW']['POSITION'] === 'right') { ?>
                <?php if ($arVisual['STORES']['SHOW']) { ?>
                    <div class="catalog-element-sections catalog-element-sections-wide">
                        <div class="catalog-element-section">
                            <div class="catalog-element-section-name">
                                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_1_SECTIONS_STORES') ?>
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

            <?php if ($arVisual['ASSOCIATED']['SHOW']) { ?>
                <div class="catalog-element-sections catalog-element-sections-wide">
                    <div class="catalog-element-section">
                        <div class="catalog-element-section-name">
                            <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_1_SECTIONS_ASSOCIATED') ?>
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
                            <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_1_SECTIONS_RECOMMENDED') ?>
                        </div>
                        <div class="catalog-element-section-content">
                            <?php include(__DIR__.'/parts/recommended.php') ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($arVisual['SERVICES']['SHOW']) { ?>
                <div class="catalog-element-sections catalog-element-sections-wide">
                    <div class="catalog-element-section">
                        <div class="catalog-element-section-name">
                            <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_1_SECTIONS_SERVICES') ?>
                        </div>
                        <div class="catalog-element-section-content">
                            <?php include(__DIR__.'/parts/services.php') ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php include(__DIR__.'/parts/microdata.php') ?>
            <?php include(__DIR__.'/parts/script.php') ?>
        </div>
    </div>
<?= Html::endTag('div') ?>