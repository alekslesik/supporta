<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

/**
 * @var array $arParams
 * @var array $arResult
 */

?>
<div class="catalog-element-offers-properties">
    <?php foreach ($arResult['SKU_PROPS'] as $arProperty) { ?>
        <div class="catalog-element-offers-property" data-role="property" data-property="<?= $arProperty['code'] ?>" data-type="<?= $arProperty['type'] ?>">
            <div class="catalog-element-offers-property-title">
                <?= $arProperty['name'] ?>
            </div>
            <div class="catalog-element-offers-property-values">
                <?php foreach ($arProperty['values'] as $arValue) { ?>
                    <div class="catalog-element-offers-property-value intec-cl-border-hover" data-role="property.value" data-state="hidden" data-value="<?= $arValue['id'] ?>">
                        <div class="catalog-element-offers-property-value-text">
                            <?= $arValue['name'] ?>
                        </div>
                        <?php if ($arProperty['type'] === 'picture' && !empty($arValue['picture'])) { ?>
                            <div class="catalog-element-offers-property-value-image" style="background-image: url('<?= $arValue['picture'] ?>')"></div>
                        <?php } ?>
                        <div class="catalog-element-offers-property-value-overlay"></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>