<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

?>
<?php if (!empty($arResult['DISPLAY_PROPERTIES'])) { ?>
    <div class="catalog-element-properties">
        <div class="intec-content">
            <div class="intec-content-wrapper">
                <?php if (!empty($arBlock['HEADER']['VALUE'])) { ?>
                    <div class="catalog-element-properties-header" style="text-align:<?= $arBlock['HEADER']['POSITION'] ?>">
                        <?= $arBlock['HEADER']['VALUE'] ?>
                    </div>
                <?php } ?>
                <div class="catalog-element-properties-table">
                    <?php foreach ($arResult['DISPLAY_PROPERTIES'] as $arProperty) { ?>
                        <div class="catalog-element-property intec-grid intec-grid-a-v-stretch">
                            <div class="catalog-element-property-name intec-grid-item-2"><?= $arProperty['NAME'] ?></div>
                            <div class="catalog-element-property-value intec-grid-item-2"><?= $arProperty['VALUE'] ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>