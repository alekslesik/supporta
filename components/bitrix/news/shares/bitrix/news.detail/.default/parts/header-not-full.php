<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

?>
<div class="share">
    <div class="share-img">
        <div class="share-img-wrapper" style="background-image: url('<?= $arResult['DETAIL_PICTURE']['SRC'] ?>')"></div>
    </div>
    <?php if ($period) { ?>
        <div class="share-period"><?= $period ?></div>
    <?php } ?>
    <div class="share-preview">
        <?php if (!empty($arResult['PREVIEW_TEXT'])) { ?>
            <div class="share-header-products"><?= $arResult['PREVIEW_TEXT']?></div>
        <?php } ?>
    </div>
    <?php if (!empty($arResult['DETAIL_TEXT'])) { ?>
        <div class="share-content"><?= $arResult['DETAIL_TEXT'] ?></div>
    <?php } ?>
</div>
