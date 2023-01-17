<?php if (!defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @param $arItem
 */
$vPurchase = function (&$arItem) use (&$arResult, &$arVisual) {

    $sLink = Html::decode($arItem['DETAIL_PAGE_URL']);

    $fRender = function (&$arItem, $bOffer = false) use (&$arResult, &$arVisual, &$sLink) { ?>
        <?php if ($bOffer || $arItem['ACTION'] === 'buy') { ?>
            <?php if ($arItem['CAN_BUY']) { ?>
                <?php $arPrice = ArrayHelper::getValue($arItem, ['ITEM_PRICES', 0]) ?>
                <div class="catalog-section-item-purchase-buttons" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
                    <?= Html::beginTag('div', [
                        'class' => [
                            'intec-ui',
                            'intec-ui-control-basket-button',
                            'catalog-section-item-purchase-button',
                            'catalog-section-item-purchase-button-add',
                            'intec-cl-background',
                            'intec-cl-background-light-hover'
                        ],
                        'data' => [
                            'basket-id' => $arItem['ID'],
                            'basket-action' => 'add',
                            'basket-state' => 'none',
                            'basket-quantity' => $arItem['CATALOG_MEASURE_RATIO'],
                            'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                        ]
                    ]) ?>
                        <span class="catalog-section-item-purchase-button-content intec-ui-part-content">
                            <i class="glyph-icon-cart"></i>
                            <span>
                                <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_BASKET_ADD') ?>
                            </span>
                        </span>
                        <span class="intec-ui-part-effect intec-ui-part-effect-bounce">
                            <span class="intec-ui-part-effect-wrapper">
                                <i></i><i></i><i></i>
                            </span>
                        </span>
                    <?= Html::endTag('div') ?>
                    <?= Html::beginTag('a', [
                        'href' => $arResult['URL']['BASKET'],
                        'class' => [
                            'catalog-section-item-purchase-button',
                            'catalog-section-item-purchase-button-added',
                            'intec-cl-background-light'
                        ],
                        'data' => [
                            'basket-id' => $arItem['ID'],
                            'basket-state' => 'none'
                        ]
                    ]) ?>
                        <span class="catalog-section-item-purchase-button-content">
                            <span>
                                <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_BASKET_ADDED') ?>
                            </span>
                        </span>
                    <?= Html::endTag('a') ?>
                </div>
            <?php } else { ?>
                <div class="catalog-section-item-purchase-buttons" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
                    <?= Html::beginTag('div', [
                        'class' => [
                            'catalog-section-item-purchase-button',
                            'catalog-section-item-purchase-button-unavailable'
                        ]
                    ]) ?>
                        <span class="catalog-section-item-purchase-button-content">
                            <i class="far fa-times-circle"></i>
                            <span>
                                <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_BASKET_NOT_AVAILABLE') ?>
                            </span>
                        </span>
                    <?= Html::endTag('div') ?>
                </div>
            <?php } ?>
        <?php } else if ($arItem['ACTION'] === 'detail') { ?>
            <div class="catalog-section-item-purchase-detail">
                <?= Html::beginTag('a', [
                    'class' => [
                        'catalog-section-item-purchase-button',
                        'intec-cl-background',
                        'intec-cl-background-light-hover'
                    ],
                    'href' => Html::decode($sLink)
                ]) ?>
                    <span class="catalog-section-item-purchase-button-content">
                        <span>
                            <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_MORE_INFO') ?>
                        </span>
                    </span>
                <?= Html::endTag('a') ?>
            </div>
        <?php } else if ($arItem['ACTION'] === 'order') { ?>
            <div class="catalog-section-item-purchase-order">
                <?= Html::beginTag('div', [
                    'class' => [
                        'catalog-section-item-purchase-button',
                        'intec-cl-background',
                        'intec-cl-background-light-hover'
                    ],
                    'data' => [
                        'role' => 'item.order'
                    ]
                ]) ?>
                    <span class="catalog-section-item-purchase-button-content">
                        <span>
                            <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_3_ORDER') ?>
                        </span>
                    </span>
                <?= Html::endTag('div') ?>
            </div>
        <?php } ?>
    <?php };

    $fRender($arItem, false);

    if ($arItem['ACTION'] === 'buy' && $arVisual['OFFERS']['USE'] && !empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer) {
            $fRender($arOffer, true);

            unset($arOffer);
        }
};