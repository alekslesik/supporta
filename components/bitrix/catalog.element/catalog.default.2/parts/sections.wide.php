<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 */

?>
<?php if ($arVisual['SECTIONS']['DESCRIPTION']) { ?>
    <?php if ($arVisual['WIDE']) { ?>
            </div>
        </div>
    <?php } ?>
    <div class="catalog-element-sections catalog-element-sections-wide">
        <div class="<?= Html::cssClassFromArray([
            'catalog-element-section' => true,
            'catalog-element-section-dark' => $arVisual['WIDE'],
            'intec-content-wrap' => $arVisual['WIDE']
        ], true) ?>">
            <div class="catalog-element-section-wrapper">
                <div class="catalog-element-section-name intec-ui-markup-header">
                    <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_DESCRIPTION') ?>
                </div>
                <div class="catalog-element-section-content">
                    <?php if ($arVisual['WIDE']) { ?>
                        <div class="intec-content">
                            <div class="intec-content-wrapper">
                    <?php } ?>
                    <?php include(__DIR__.'/sections/description.php') ?>
                    <?php if ($arVisual['WIDE']) { ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($arVisual['WIDE']) { ?>
        <div class="catalog-element-wrapper intec-content intec-content-visible">
            <div class="catalog-element-wrapper-2 intec-content-wrapper">
    <?php } ?>
<?php } ?>
<div class="catalog-element-sections catalog-element-sections-wide" data-role="sections">
    <?php if ($arVisual['SECTIONS']['PROPERTIES']) { ?>
        <div id="<?= $sTemplateId.'-'.'properties' ?>" class="catalog-element-section" data-role="section">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <div class="catalog-element-section-name-wrapper">
                    <span data-role="section.toggle">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_PROPERTIES') ?>
                    </span>
                    <div class="catalog-element-section-name-decoration" data-role="section.toggle"></div>
                </div>
            </div>
            <div class="catalog-element-section-content" data-role="section.content">
                <?php include(__DIR__.'/sections/properties.php') ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($arVisual['SECTIONS']['STORES']) { ?>
        <div class="catalog-element-section" data-role="section">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <div class="catalog-element-section-name-wrapper">
                    <span data-role="section.toggle">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_STORES') ?>
                    </span>
                    <div class="catalog-element-section-name-decoration" data-role="section.toggle"></div>
                </div>
            </div>
            <div class="catalog-element-section-content" data-role="section.content">
                <?php include(__DIR__.'/sections/stores.php') ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($arVisual['SECTIONS']['DOCUMENTS']) { ?>
        <div class="catalog-element-section" data-role="section">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <div class="catalog-element-section-name-wrapper">
                    <span data-role="section.toggle">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_DOCUMENTS') ?>
                    </span>
                    <div class="catalog-element-section-name-decoration" data-role="section.toggle"></div>
                </div>
            </div>
            <div class="catalog-element-section-content" data-role="section.content">
                <?php include(__DIR__.'/sections/documents.php') ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($arVisual['SECTIONS']['VIDEO']) { ?>
        <div class="catalog-element-section" data-role="section">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <div class="catalog-element-section-name-wrapper">
                    <span data-role="section.toggle">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_VIDEO') ?>
                    </span>
                    <div class="catalog-element-section-name-decoration" data-role="section.toggle"></div>
                </div>
            </div>
            <div class="catalog-element-section-content" data-role="section.content">
                <?php include(__DIR__.'/sections/video.php') ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($arVisual['SECTIONS']['REVIEWS']) { ?>
        <div class="catalog-element-section" data-role="section">
            <div class="catalog-element-section-name intec-ui-markup-header">
                <div class="catalog-element-section-name-wrapper">
                    <span data-role="section.toggle">
                        <?= Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_REVIEWS') ?>
                    </span>
                    <div class="catalog-element-section-name-decoration" data-role="section.toggle"></div>
                </div>
            </div>
            <div class="catalog-element-section-content" data-role="section.content">
                <?php include(__DIR__.'/sections/reviews.php') ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($arVisual['SECTIONS']['REVIEWS']) { ?>
    <?php } ?>
</div>