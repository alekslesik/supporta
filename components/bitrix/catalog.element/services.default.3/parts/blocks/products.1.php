<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

$GLOBALS['arCatalogElementFilter'] = [
    'ID' => $arBlock['IBLOCK']['ELEMENTS']
];

?>
<div class="catalog-element-products">
    <div class="intec-content intec-content-visible">
        <div class="intec-content-wrapper">
            <?php if (!empty($arBlock['HEADER']['VALUE'])) { ?>
                <div class="catalog-element-products-header" style="text-align:<?= $arBlock['HEADER']['POSITION'] ?>">
                    <?= $arBlock['HEADER']['VALUE'] ?>
                </div>
            <?php } ?>
            <div class="catalog-element-products-content">
                <?php $APPLICATION->IncludeComponent(
                    'bitrix:catalog.section',
                    'products.small.1',
                    array(
                        'IBLOCK_TYPE' => $arBlock['IBLOCK']['TYPE'],
                        'IBLOCK_ID' => $arBlock['IBLOCK']['ID'],
                        'SECTION_USER_FIELDS' => array(),
                        'SHOW_ALL_WO_SECTION' => 'Y',
                        'FILTER_NAME' => 'arCatalogElementFilter',
                        'PRICE_CODE' => $arBlock['PRICE_CODE'],
                        'CONVERT_CURRENCY' => 'N',
                        'COLUMNS' => 4,
                        'BORDERS' => 'Y',
                        'POSITION' => 'left',
                        'SIZE' => 'small',
                        'SLIDER_USE' => 'N',
                        'WIDE' => 'N'
                    ),
                    $component
                ) ?>
            </div>
        </div>
    </div>
</div>