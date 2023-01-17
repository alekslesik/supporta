<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Json;

/**
 * @var array $arResult
 * @var CAllMain $APPLICATION
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);

Loc::loadMessages(__FILE__);

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

/**
 * @var array $arData
 */
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
        'c-catalog-element-catalog-default-3'
    ],
    'data' => [
        'data' => Json::encode($arData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true),
        'properties' => !empty($arResult['SKU_PROPS']) ? Json::encode($arResult['SKU_PROPS'], JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true) : '',
        'available' => $arData['available'] ? 'true' : 'false',
        'wide' => $arVisual['WIDE'] ? 'true' : 'false'
    ]
]) ?>
    <?php if ($arVisual['PANEL']['SHOW']) {
        include(__DIR__.'/parts/panel.php');
    } ?>
    <div class="catalog-element-content intec-content intec-content-visible">
        <div class="intec-content-wrapper">
            <div class="intec-grid intec-grid-wrap">
                <?= Html::beginTag('div', [
                    'class' => Html::cssClassFromArray([
                        'intec-grid-item' => [
                            '2' => true,
                            '720-1' => $arVisual['WIDE'],
                            '1000-1' => !$arVisual['WIDE']
                        ]
                    ], true),
                ]) ?>
                    <div class="catalog-element-block-left">
                        <div class="catalog-element-gallery-block">
                            <?php if ($arVisual['MARKS']['SHOW']) { ?>
                                <div class="catalog-element-marks">
                                    <?php $APPLICATION->IncludeComponent(
                                        'intec.universe:main.markers',
                                        'template.1',
                                        $arResult['MARKS'],
                                        $component
                                    ) ?>
                                </div>
                            <?php } ?>
                            <?php include(__DIR__.'/parts/gallery.php') ?>
                        </div>
                    </div>
                <?= Html::endTag('div') ?>
                <?= Html::beginTag('div', [
                    'class' => Html::cssClassFromArray([
                        'intec-grid-item' => [
                            '2' => true,
                            '720-1' => $arVisual['WIDE'],
                            '1000-1' => !$arVisual['WIDE']
                        ]
                    ], true)
                ]) ?>
                    <div class="catalog-element-block-right">
                        <div class="intec-grid">
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
                        <?php include(__DIR__.'/parts/price.php') ?>
                        <?php if ($arVisual['PRICE']['RANGE']) { ?>
                            <div class="catalog-element-price-ranges">
                                <?php include(__DIR__.'/parts/price.range.php') ?>
                            </div>
                        <?php } ?>
                        <?php if ($arResult['ACTION'] !== 'none') { ?>
                            <div class="catalog-element-purchase-block intec-grid intec-grid-wrap intec-grid-a-v-center">
                                <?php if ($arVisual['COUNTER']['SHOW']) { ?>
                                    <?= Html::beginTag('div', [
                                        'class' => Html::cssClassFromArray([
                                            'catalog-element-counter' => true,
                                            'intec-grid-item' => [
                                                'auto' => true,
                                                '500-1' => true
                                            ]
                                        ], true)
                                    ]) ?>
                                        <?php include(__DIR__.'/parts/counter.php') ?>
                                    <?= Html::endTag('div') ?>
                                <?php } ?>
                                <?= Html::beginTag('div', [
                                    'class' => Html::cssClassFromArray([
                                        'catalog-element-purchase' => true,
                                        'intec-grid-item' => [
                                            'auto' => true
                                        ]
                                    ], true)
                                ]) ?>
                                    <?php include(__DIR__.'/parts/purchase.php') ?>
                                <?= Html::endTag('div') ?>
                            </div>
                        <?php } ?>
                        <?php if ($arVisual['ADDITIONAL']['SHOW']) { ?>
                            <div class="catalog-element-additional-products">
                                <?php include(__DIR__.'/parts/additional.php') ?>
                            </div>
                        <?php } ?>
                        <?php if ($arVisual['DESCRIPTION']['SHOW']) { ?>
                            <?= Html::beginTag('div', [
                                'class' => [
                                    'catalog-element-description',
                                    'catalog-element-section'
                                ],
                                'data' => [
                                    'role' => 'section',
                                    'expanded' => $arVisual['DESCRIPTION']['EXPANDED'] ? 'true' : 'false'
                                ]
                            ]) ?>
                                <div class="catalog-element-section-name intec-ui-markup-header">
                                    <div class="catalog-element-section-name-wrapper">
                                        <span data-role="section.name">
                                            <?php if (!empty($arVisual['DESCRIPTION']['NAME'])) { ?>
                                                <?= $arVisual['DESCRIPTION']['NAME'] ?>
                                            <?php } else { ?>
                                                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_3_DESCRIPTION_NAME') ?>
                                            <?php } ?>
                                        </span>
                                        <div class="catalog-element-section-name-decoration" data-role="section.name"></div>
                                    </div>
                                </div>
                                <?= Html::beginTag('div', [
                                    'class' => [
                                        'catalog-element-section-content',
                                        'catalog-element-description-value',
                                        'intec-ui-markup-text'
                                    ],
                                    'data' => [
                                        'role' => 'section.content'
                                    ]
                                ]) ?>
                                    <div class="catalog-element-section-content-wrapper">
                                        <?= strip_tags($arResult[strtoupper($arVisual['DESCRIPTION']['MODE'].'_TEXT')], '<br>') ?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
                        <?php if (!empty($arResult['OFFERS'])) { ?>
                            <?= Html::beginTag('div', [
                                'class' => [
                                    'catalog-element-offers',
                                    'catalog-element-section'
                                ],
                                'data' => [
                                    'role' => 'section',
                                    'expanded' => $arVisual['OFFERS']['EXPANDED'] ? 'true' : 'false'
                                ]
                            ]) ?>
                                <div class="catalog-element-section-name intec-ui-markup-header">
                                    <div class="catalog-element-section-name-wrapper">
                                        <span data-role="section.name">
                                            <?php if (!empty($arVisual['OFFERS']['NAME'])) { ?>
                                                <?= $arVisual['OFFERS']['NAME'] ?>
                                            <?php } else { ?>
                                                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_3_OFFERS_NAME') ?>
                                            <?php } ?>
                                        </span>
                                        <div class="catalog-element-section-name-decoration" data-role="section.name"></div>
                                    </div>
                                </div>
                                <?= Html::beginTag('div', [
                                    'class' => [
                                        'catalog-element-offers-wrapper',
                                        'catalog-element-section-content'
                                    ],
                                    'data' => [
                                        'role' => 'section.content'
                                    ]
                                ]) ?>
                                    <div class="catalog-element-section-content-wrapper">
                                        <?php include(__DIR__.'/parts/sku.php') ?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
                        <?php if ($arVisual['PROPERTIES']['SHOW'] && !empty($arResult['DISPLAY_PROPERTIES'])) { ?>
                            <?= Html::beginTag('div', [
                                'class' => [
                                    'catalog-element-properties',
                                    'catalog-element-section'
                                ],
                                'data' => [
                                    'role' => 'section',
                                    'expanded' => $arVisual['PROPERTIES']['EXPANDED'] ? 'true' : 'false'
                                ]
                            ]) ?>
                                <div class="catalog-element-section-name intec-ui-markup-header">
                                    <div class="catalog-element-section-name-wrapper">
                                        <span data-role="section.name">
                                            <?php if (!empty($arVisual['PROPERTIES']['NAME'])) { ?>
                                                <?= $arVisual['PROPERTIES']['NAME'] ?>
                                            <?php } else { ?>
                                                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_3_PROPERTIES_NAME') ?>
                                            <?php } ?>
                                        </span>
                                        <div class="catalog-element-section-name-decoration" data-role="section.name"></div>
                                    </div>
                                </div>
                                <?= Html::beginTag('div', [
                                    'class' => [
                                        'catalog-element-properties-wrapper',
                                        'catalog-element-section-content'
                                    ],
                                    'data' => [
                                        'role' => 'section.content'
                                    ]
                                ]) ?>
                                    <div class="catalog-element-section-content-wrapper">
                                        <?php include(__DIR__.'/parts/properties.php') ?>
                                    </div>
                                <?= Html::endTag('div') ?>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
                        <?php if ($arVisual['INFORMATION']['PAYMENT']['SHOW'] || $arVisual['INFORMATION']['SHIPMENT']['SHOW']) { ?>
                            <div class="catalog-element-information">
                                <?php include(__DIR__.'/parts/information.php') ?>
                            </div>
                        <?php } ?>
                    </div>
                <?= Html::endTag('div') ?>
            </div>
            <?php if ($arVisual['ASSOCIATED']['SHOW']) { ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'catalog-element-associated',
                        'catalog-element-section'
                    ],
                    'data' => [
                        'role' => 'section',
                        'expanded' => $arVisual['ASSOCIATED']['EXPANDED'] ? 'true' : 'false'
                    ]
                ]) ?>
                    <div class="catalog-element-section-name intec-ui-markup-header">
                        <div class="catalog-element-section-name-wrapper">
                            <span data-role="section.name">
                                <?php if (!empty($arVisual['ASSOCIATED']['NAME'])) { ?>
                                    <?= $arVisual['ASSOCIATED']['NAME'] ?>
                                <?php } else { ?>
                                    <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_3_ASSOCIATED_NAME') ?>
                                <?php } ?>
                            </span>
                            <div class="catalog-element-section-name-decoration" data-role="section.name"></div>
                        </div>
                    </div>
                    <?= Html::beginTag('div', [
                        'class' => [
                            'catalog-element-associated-wrapper',
                            'catalog-element-section-content'
                        ],
                        'data' => [
                            'role' => 'section.content'
                        ]
                    ]) ?>
                        <div class="catalog-element-section-content-wrapper">
                            <?php include(__DIR__.'/parts/associated.php') ?>
                        </div>
                    <?= Html::endTag('div') ?>
                <?= Html::endTag('div') ?>
            <?php } ?>
            <?php if ($arVisual['RECOMMENDED']['SHOW']) { ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'catalog-element-associated',
                        'catalog-element-section'
                    ],
                    'data' => [
                        'role' => 'section',
                        'expanded' => $arVisual['RECOMMENDED']['EXPANDED'] ? 'true' : 'false'
                    ]
                ]) ?>
                    <div class="catalog-element-section-name intec-ui-markup-header">
                        <div class="catalog-element-section-name-wrapper">
                                <span data-role="section.name">
                                    <?php if (!empty($arVisual['RECOMMENDED']['NAME'])) { ?>
                                        <?= $arVisual['RECOMMENDED']['NAME'] ?>
                                    <?php } else { ?>
                                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_3_RECOMMEND_NAME') ?>
                                    <?php } ?>
                                </span>
                            <div class="catalog-element-section-name-decoration" data-role="section.name"></div>
                        </div>
                    </div>
                    <?= Html::beginTag('div', [
                        'class' => [
                            'catalog-element-associated-wrapper',
                            'catalog-element-section-content'
                        ],
                        'data' => [
                            'role' => 'section.content'
                        ]
                    ]) ?>
                        <div class="catalog-element-section-content-wrapper">
                            <?php include(__DIR__.'/parts/recommended.php') ?>
                        </div>
                    <?= Html::endTag('div') ?>
                <?= Html::endTag('div') ?>
            <?php } ?>
            <?php include(__DIR__.'/parts/microdata.php') ?>
        </div>
    </div>
<?= Html::endTag('div') ?>
<?php include(__DIR__.'/parts/script.php') ?>
