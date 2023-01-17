<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $sTemplateId
 * @var array $arVisual
 */

$GLOBALS['arCatalogElementFilter'] = [
    'ID' => $arResult['SERVICES']
];

?>
<div class="catalog-element-section-services">
    <?php $APPLICATION->IncludeComponent(
        'intec.universe:iblock.elements',
        'tiles.landing.3',
        array(
            "IBLOCK_TYPE" => $arParams['SERVICES_IBLOCK_TYPE'],
            "IBLOCK_ID" => $arParams['SERVICES_IBLOCK_ID'],
            "ELEMENTS_ID" => $arResult['SERVICES'],
            "LINK_TO_ELEMENTS" => "",
            "NAME_PROP_PRICE" => $arParams['SERVICES_PROPERTY_PRICE']
        ),
        $component
    );?>
</div>