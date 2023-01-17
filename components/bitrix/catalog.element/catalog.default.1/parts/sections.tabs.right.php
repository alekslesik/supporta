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

$sSectionActive = null;

foreach ($arVisual['SECTIONS'] as $sSection => $bSectionActive) {
    if ($bSectionActive) {
        $sSectionActive = $sSection;
        break;
    }
}

unset($bSectionActive);
unset($sSection);

?>
<ul class="catalog-element-tabs nav nav-tabs intec-ui-mod-simple">
    <?php foreach ($arVisual['SECTIONS'] as $sSection => $bSectionActive) { ?>
    <?php
        if ($sSection === 'STORES')
            continue;

        if (!$bSectionActive)
            continue;

        $sSectionCode = StringHelper::toLowerCase($sSection);
    ?>
        <li class="<?= Html::cssClassFromArray([
            'catalog-element-tab' => true,
            'active' => $sSectionActive === $sSection
        ], true) ?>">
            <a href="<?= '#'.$sTemplateId.'-'.$sSectionCode ?>" role="tab" data-toggle="tab">
                <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_1_SECTIONS_'.$sSection) ?>
            </a>
        </li>
    <?php } ?>
</ul>
<div class="catalog-element-sections catalog-element-sections-tabs tab-content">
    <?php foreach ($arVisual['SECTIONS'] as $sSection => $bSectionActive) { ?>
    <?php
        if ($sSection === 'STORES')
            continue;

        if (!$bSectionActive)
            continue;

        $sSectionCode = StringHelper::toLowerCase($sSection);
    ?>
        <div id="<?= $sTemplateId.'-'.$sSectionCode ?>" class="<?= Html::cssClassFromArray([
            'catalog-element-section' => true,
            'tab-pane' => true,
            'active' => $sSectionActive === $sSection
        ], true) ?>" role="tabpanel">
            <div class="catalog-element-section-content" data-role="section.content">
                <?php include(__DIR__.'/sections/'.$sSectionCode.'.php') ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php

unset($bSectionActive);
unset($sSection);
unset($sSectionActive);