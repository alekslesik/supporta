<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Json;

/**
 * @var array $arResult
 * @var array $arVisual
 */

$iItemsCount = null;
$iItemsCurrent = 0;

if ($arVisual['LINES'] !== null)
    $iItemsCount = $arVisual['COLUMNS'] * $arVisual['LINES'];

?>
<?= Html::beginTag('div', [
    'class' => [
        'widget-items',
        'intec-grid' => [
            '',
            'wrap',
            'a-v-stretch',
            'a-h-start'
        ]
    ]
]) ?>
    <?php foreach ($arItems as $arItem) {

        /*if ($iItemsCount !== null)
            if ($iItemsCurrent >= $iItemsCount)
                break;*/

        $sId = $sTemplateId.'_'.$arItem['ID'];
        $sAreaId = $this->GetEditAreaId($sId);
        $this->AddEditAction($sId, $arItem['EDIT_LINK']);
        $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

        $sData = Json::encode($dData($arItem), JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true);
        $sLink = Html::decode($arItem['DETAIL_PAGE_URL']);
        $arPrice = null;

        $bSkuExtended = !empty($arItem['OFFERS']) && $arVisual['OFFERS']['VIEW'] === 'extended' && !empty($arSkuExtended);

        if (!empty($arItem['ITEM_PRICES']))
            $arPrice = ArrayHelper::getFirstValue($arItem['ITEM_PRICES']);

        $arSkuProps = [];

        if (!empty($arResult['SKU_PROPS']))
            $arSkuProps = $arResult['SKU_PROPS'];
        else if (!empty($arItem['SKU_PROPS']))
            $arSkuProps = $arItem['SKU_PROPS'];

        ?>
        <?= Html::beginTag('div', [
            'id' => $sAreaId,
            'class' => Html::cssClassFromArray([
                'widget-item' => true,
                'intec-grid-item' => [
                    $arVisual['COLUMNS'] => true,
                    '500-1' => $arVisual['COLUMNS'] <= 4,
                    '800-2' => $arVisual['WIDE'] && $arVisual['COLUMNS'] > 2,
                    '1000-3' => $arVisual['WIDE'] && $arVisual['COLUMNS'] > 3,
                    '700-2' => !$arVisual['WIDE'] && $arVisual['COLUMNS'] > 2,
                    '720-3' => !$arVisual['WIDE'] && $arVisual['COLUMNS'] > 2,
                    '950-2' => !$arVisual['WIDE'] && $arVisual['COLUMNS'] > 2,
                    '1200-3' => !$arVisual['WIDE'] && $arVisual['COLUMNS'] > 3
                ]
            ],  true),
            'data' => [
                'id' => $arItem['ID'],
                'role' => 'item',
                'data' => $sData,
                'expanded' => 'false',
                'available' => $arItem['CAN_BUY'] ? 'true' : 'false'
            ]
        ]) ?>
            <div class="widget-item-wrapper" data-borders-style="<?= $arVisual['BORDERS']['STYLE'] ?>">
                <div class="widget-item-base">
                    <?php if ($arVisual['NAME']['POSITION'] == 'top') { ?>
                        <div class="widget-item-name" data-align="<?= $arVisual['NAME']['ALIGN'] ?>">
                            <a class="intec-cl-text-hover" href="<?= $sLink ?>">
                                <?= $arItem['NAME'] ?>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="widget-item-image-container">
                        <?php $vImage($arItem) ?>
                        <?php if ($arResult['QUICK_VIEW']['USE']) { ?>
                            <?php $vQuickView($arItem) ?>
                        <?php } ?>
                        <!-- noindex -->
                        <div class="widget-item-marks">
                            <?php $APPLICATION->includeComponent(
                                'intec.universe:main.markers',
                                'template.1', [
                                'HIT' => $arItem['MARKS']['HIT'] ? 'Y' : 'N',
                                'NEW' => $arItem['MARKS']['NEW'] ? 'Y' : 'N',
                                'RECOMMEND' => $arItem['MARKS']['RECOMMEND'] ? 'Y' : 'N',
                                'ORIENTATION' => $arVisual['MARKS']['ORIENTATION']
                            ],
                                $component
                            ) ?>
                        </div>
                        <?php $vButtons($arItem) ?>
                        <?php if ($bSkuExtended) {
                            $vSkuExtended($arSkuExtended);
                        } ?>
                        <!-- /noindex-->
                    </div>
                    <!-- noindex -->
                    <?php if ($arVisual['VOTE']['SHOW']) { ?>
                        <div class="widget-item-vote" data-align="<?= $arVisual['VOTE']['ALIGN'] ?>">
                            <?php $APPLICATION->IncludeComponent(
                                'bitrix:iblock.vote',
                                'template.1',
                                array(
                                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                    'ELEMENT_ID' => $arItem['ID'],
                                    'ELEMENT_CODE' => $arItem['CODE'],
                                    'MAX_VOTE' => '5',
                                    'VOTE_NAMES' => array(
                                        0 => '1',
                                        1 => '2',
                                        2 => '3',
                                        3 => '4',
                                        4 => '5',
                                    ),
                                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                    'CACHE_TIME' => $arParams['CACHE_TIME'],
                                    'DISPLAY_AS_RATING' => $arVisual['VOTE']['MODE'] === 'rating' ? 'rating' : 'vote_avg',
                                    'SHOW_RATING' => 'N'
                                ),
                                $component
                            ) ?>
                        </div>
                    <?php } ?>
                    <?php if ($arVisual['QUANTITY']['SHOW']) { ?>
                        <div class="widget-item-quantity-wrap">
                            <?php $vQuantity($arItem) ?>
                        </div>
                    <?php } ?>
                    <!-- /noindex -->
                    <?php if ($arVisual['NAME']['POSITION'] == 'middle') { ?>
                        <div class="widget-item-name" data-align="<?= $arVisual['NAME']['ALIGN'] ?>">
                            <a class="intec-cl-text-hover" href="<?= $sLink ?>">
                                <?= $arItem['NAME'] ?>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if ($arVisual['SECTION']['SHOW'] && !empty($arItem['SECTION'])) { ?>
                        <div class="widget-item-section" data-align="<?= $arVisual['SECTION']['ALIGN'] ?>">
                            <a class="intec-cl-text-hover" href="<?= $arItem['SECTION']['SECTION_PAGE_URL'] ?>">
                                <?= $arItem['SECTION']['NAME'] ?>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if (!empty($arPrice)) {
                        $vPrice($arPrice);
                    } ?>
                </div>
                <!-- noindex -->
                <div class="widget-item-advanced">
                    <?php if ($arVisual['OFFERS']['USE'] && !empty($arItem['OFFERS']) && !empty($arSkuProps)) {
                        $vSku($arSkuProps);
                    } ?>
                    <?php if ($arItem['ACTION'] !== 'none') { ?>
                        <div class="widget-item-purchase-container intec-grid intec-grid-a-v-center">
                            <?php if ($arVisual['COUNTER']['SHOW'] && $arItem['ACTION'] === 'buy') {
                                $vCounter();
                            } ?>
                            <div class="widget-item-purchase intec-grid-item intec-grid-item-shrink-1">
                                <?php $vPurchase($arItem) ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- /noindex -->
            </div>
        <?= Html::endTag('div') ?>
        <?php $iItemsCurrent++; ?>
    <?php } ?>
<?= Html::endTag('div') ?>
