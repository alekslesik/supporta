<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

?>
<div class="catalog-element-description">
    <div class="catalog-element-description-wrapper intec-content">
        <div class="catalog-element-description-wrapper-2 intec-content-wrapper">
            <?php if (!empty($arBlock['HEADER']['VALUE'])) { ?>
                <div class="catalog-element-description-header" style="text-align:<?= $arBlock['HEADER']['POSITION'] ?>">
                    <?= $arBlock['HEADER']['VALUE'] ?>
                </div>
            <?php } ?>
            <?php if (!empty($arBlock['TEXT']['VALUE'])) { ?>
                <div class="catalog-element-description-text">
                    <?= $arBlock['TEXT']['VALUE'] ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
