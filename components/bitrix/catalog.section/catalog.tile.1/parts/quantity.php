<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
    <?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 */

$vQuantity = function (&$arItem) use (&$arVisual) {
    $fRender = function (&$arItem, $bOffer = false) use (&$arVisual) { ?>
        <div class="catalog-section-item-quantity" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
            <?php if ($arItem['CAN_BUY']) { ?>
                <?php if ($arVisual['QUANTITY']['MODE'] === 'number') { ?>
                    <?php if ($arItem['CATALOG_QUANTITY'] > 0) { ?>
                        <span class="catalog-section-item-quantity-icon catalog-section-item-quantity-check">
                            <i class="far fa-check"></i>
                        </span>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_AVAILABLE').': ' ?>
                        <?= $arItem['CATALOG_QUANTITY'] ?>
                        <?php if (!empty($arItem['CATALOG_MEASURE_NAME'])) { ?>
                            <?= $arItem['CATALOG_MEASURE_NAME'].'.' ?>
                        <?php } ?>
                    <?php } else { ?>
                        <span class="catalog-section-item-quantity-icon catalog-section-item-quantity-check">
                            <i class="far fa-check"></i>
                        </span>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_AVAILABLE'); ?>
                    <?php } ?>
                <?php } else if ($arVisual['QUANTITY']['MODE'] === 'text') {?>
                    <span class="catalog-section-item-quantity-icon catalog-section-item-quantity-check">
                        <i class="far fa-check"></i>
                    </span>
                    <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_AVAILABLE').': ' ?>
                    <?php if ($arItem['CATALOG_QUANTITY'] >= $arVisual['QUANTITY']['BOUNDS']['MANY'] || $arItem['CATALOG_QUANTITY'] <= 0) { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_BOUNDS_MANY') ?>
                    <?php } else if ($arItem['CATALOG_QUANTITY'] <= $arVisual['QUANTITY']['BOUNDS']['FEW']) { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_BOUNDS_FEW') ?>
                    <?php } else { ?>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_BOUNDS_ENOUGH') ?>
                    <?php } ?>
                <?php } else if ($arVisual['QUANTITY']['MODE'] === 'logic') { ?>
                    <span class="catalog-section-item-quantity-icon catalog-section-item-quantity-check">
                        <i class="far fa-check"></i>
                    </span>
                    <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_AVAILABLE') ?>
                <?php } ?>
            <?php } else { ?>
                <span class="catalog-section-item-quantity-icon catalog-section-item-quantity-times">
                    <i class="far fa-times"></i>
                </span>
                <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_1_QUANTITY_UNAVAILABLE'); ?>
            <?php } ?>
        </div>
    <?php };

    $fRender($arItem, false);

    if (!empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer) {
            $fRender($arOffer, true);

            unset($arOffer);
        }
};