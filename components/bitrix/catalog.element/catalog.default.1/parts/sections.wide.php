<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $sTemplateId
 * @var array $arVisual
 */

?>
<div class="catalog-element-sections catalog-element-sections-wide">
    <?php foreach ($arVisual['SECTIONS'] as $sSection => $bSectionActive) { ?>
    <?php
        if (!$bSectionActive)
            continue;

        $sSectionCode = StringHelper::toLowerCase($sSection);
    ?>
        <div id="<?= $sTemplateId.'-'.$sSectionCode ?>" class="catalog-element-section">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_1_SECTIONS_'.$sSection) ?>
            </div>
            <div class="catalog-element-section-content">
                <?php include(__DIR__.'/sections/'.$sSectionCode.'.php') ?>
            </div>
        </div>
    <?php } ?>
</div>