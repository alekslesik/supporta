<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

/**
 * @param array $arItem
 */
$vPurchase = function (&$arItem) use (&$arResult) {
    $fRender = function (&$arItem) use (&$arResult) { ?>
        <?php if ($arItem['ACTION'] === 'buy') { ?>
            <?php if ($arItem['CAN_BUY']) { ?>
                <?php $arPrice = ArrayHelper::getValue($arItem, ['ITEM_PRICES', 0]) ?>
                <div class="catalog-section-item-purchase-buttons">
                    <?= Html::beginTag('div', [
                        'class' => [
                            'intec-ui',
                            'intec-ui-control-basket-button',
                            'catalog-section-item-purchase-button',
                            'catalog-section-item-purchase-button-add',
                            'intec-button',
                            'intec-button-w-icon',
                            'intec-button-transparent',
                            'intec-button-cl-common'
                        ],
                        'data' => [
                            'basket-id' => $arItem['ID'],
                            'basket-action' => 'add',
                            'basket-state' => 'none',
                            'basket-quantity' => $arItem['CATALOG_MEASURE_RATIO'],
                            'basket-price' => !empty($arPrice) ? $arPrice['PRICE_TYPE_ID'] : null
                        ]
                    ]) ?>
                        <span class="intec-ui-part-content">
                            <i class="intec-button-icon intec-basket glyph-icon-cart"></i>
                            <span class="intec-button-text">
                                <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TEXT_1_BUTTON_ADD') ?>
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
                            'intec-button',
                            'intec-button-w-icon',
                            'intec-button-cl-common',
                            'hover'
                        ],
                        'data' => [
                            'basket-id' => $arItem['ID'],
                            'basket-state' => 'none',
                        ]
                    ]) ?>
                        <i class="intec-button-icon intec-basket glyph-icon-cart"></i>
                        <span class="intec-button-text">
                            <?=Loc::getMessage('C_CATALOG_SECTION_CATALOG_TEXT_1_BUTTON_ADDED')?>
                        </span>
                    <?= Html::endTag('a') ?>
                </div>
            <?php } ?>
        <?php } else if ($arItem['ACTION'] === 'detail') { ?>
            <div class="catalog-section-item-purchase-buttons">
                <?= Html::beginTag('a', [
                    'href' => $arItem['DETAIL_PAGE_URL'],
                    'class' => [
                        'catalog-section-item-purchase-button',
                        'catalog-section-item-purchase-button-detail',
                        'intec-button',
                        'intec-button-transparent',
                        'intec-button-cl-common'
                    ]
                ]) ?>
                    <span>
                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TEXT_1_BUTTON_DETAIL') ?>
                    </span>
                <?= Html::endTag('a') ?>
            </div>
        <?php } else if ($arItem['ACTION'] === 'order') { ?>
            <?php if ($arResult['FORM']['SHOW']) { ?>
                <div class="catalog-section-item-purchase-buttons">
                    <?= Html::beginTag('div', [
                        'class' => [
                            'catalog-section-item-purchase-button',
                            'catalog-section-item-purchase-button-order',
                            'intec-button',
                            'intec-button-transparent',
                            'intec-button-cl-common'
                        ],
                        'data' => [
                            'role' => 'item.order'
                        ]
                    ]) ?>
                        <span>
                            <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TEXT_1_BUTTON_ORDER') ?>
                        </span>
                    <?= Html::endTag('div') ?>
                </div>
            <?php } ?>
        <?php } ?>
    <?php };

    $fRender($arItem);
};