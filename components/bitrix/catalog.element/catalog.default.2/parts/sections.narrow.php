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
<div class="catalog-element-sections catalog-element-sections-narrow" data-role="sections">
    <?php foreach ($arVisual['SECTIONS'] as $sSection => $bSectionActive) { ?>
    <?php
        if (!$bSectionActive)
            continue;

        $sSectionCode = StringHelper::toLowerCase($sSection);

        if ($sSectionCode == 'stores') continue;
    ?>
        <div id="<?= $sTemplateId.'-'.$sSectionCode ?>" class="catalog-element-section" data-role="section" data-expanded="false">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <div class="catalog-element-section-name-wrapper">
                    <span data-role="section.toggle">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_'.$sSection) ?>
                    </span>
                    <div class="catalog-element-section-name-decoration" data-role="section.toggle"></div>
                </div>
            </div>
            <div class="catalog-element-section-content" data-role="section.content">
                <div class="catalog-element-section-content-wrapper">
                    <?php include(__DIR__.'/sections/'.$sSectionCode.'.php') ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>