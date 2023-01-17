<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

$arFormParameters = [
    'id' => $arBlock['FORM']['ID'],
    'template' => $arBlock['FORM']['TEMPLATE'],
    'parameters' => [
        'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_FORM_ORDER',
        'CONSENT_URL' => $arBlock['FORM']['CONSENT']
    ],
    'settings' => [
        'title' => $arBlock['BUTTON']['TEXT']
    ],
    'fields' => []
];

if (!empty($arBlock['FORM']['SERVICE'])) {
    $arFormParameters['fields'][$arBlock['FORM']['SERVICE']] = $arBlock['NAME'];
}

?>

<?php if (!$arBlock['WIDE']) { ?>
    <div class="intec-content">
        <div class="intec-content-wrapper">
<?php } ?>
    <?= Html::beginTag('div', [
        'class' => 'catalog-element-banner',
        'style' => !$arBlock['SPLIT'] ? 'background-image:url('.$arBlock['PICTURE']['SRC'].')' : '',
        'title' => !$arBlock['SPLIT'] ? $arBlock['NAME'] : ''
    ]) ?>
        <div class="intec-content">
            <div class="intec-content-wrapper">
                <?php if ($arBlock['SPLIT']) { ?>
                    <div class="catalog-element-banner-content intec-grid intec-grid-500-wrap intec-grid-a-v-stretch intec-grid-a-h-between">
                <?php } ?>
                <div class="catalog-element-banner-information intec-grid-item-auto intec-grid-item-500-1">
                    <h1 class="catalog-element-banner-header"><?= $arBlock['NAME'] ?></h1>
                    <div class="catalog-element-banner-information-wrapper">
                        <?php if (!empty($arResult['PRICE'])) { ?>
                            <div class="catalog-element-banner-purchase intec-grid intec-grid-500-wrap intec-grid-a-v-baseline intec-grid-i-5">
                                <div class="catalog-element-banner-purchase-caption intec-grid-item-auto"><?= $arBlock['PRICE_TITLE'] ?></div>
                                <div class="catalog-element-banner-purchase-price intec-grid-item-auto"><?= $arResult['PRICE']['VALUE'] ?></div>
                                <div class="intec-grid-item"></div>
                                <?php if ($arBlock['BUTTON']['SHOW'] && !empty($arBlock['BUTTON']['TEXT'])) { ?>
                                    <div class="catalog-element-banner-purchase-button-wrap intec-grid-item-auto">
                                        <a class="catalog-element-banner-purchase-button intec-button intec-button-cl-common intec-button-md"
                                           onclick="universe.forms.show(<?= JavaScript::toObject($arFormParameters) ?>)">
                                            <?= $arBlock['BUTTON']['TEXT'] ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }
                        if ($arBlock['TEXT']['SHOW'] && !empty($arBlock['TEXT']['VALUE'])) { ?>
                            <div class="catalog-element-banner-text"><?= $arBlock['TEXT']['VALUE'] ?></div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($arBlock['SPLIT']) { ?>
                    <div class="catalog-element-banner-picture-wrap intec-grid-item-2">
                        <div class="catalog-element-banner-picture" style="background-image:url(<?= $arBlock['PICTURE']['SRC'] ?>)" title="<?= $arBlock['NAME'] ?>"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    <?= Html::endTag('div') ?>
<?php if (!$arBlock['WIDE']) { ?>
        </div>
    </div>
<?php } ?>