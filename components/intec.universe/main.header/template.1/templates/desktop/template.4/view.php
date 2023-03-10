<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\component\InnerTemplate;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arData
 * @var InnerTemplate $this
 */

$sTemplateId = $arData['id'];
$sTemplateType = $arData['type'];

?>
<div class="widget-view-desktop-4">
    <div class="intec-content intec-content-visible intec-content-primary">
        <div class="intec-content-wrapper">
            <?= Html::beginTag('div', [
                'class' => [
                    'widget-wrapper',
                    'intec-grid' => [
                        '',
                        'nowrap',
                        'a-v-center',
                        'i-h-15'
                    ]
                ]
            ]) ?>
                <?php if ($arResult['MENU']['MAIN']['SHOW']['DESKTOP']) { ?>
                    <div class="widget-menu-wrap intec-grid-item-auto">
                        <div class="widget-item widget-menu">
                            <?php include(__DIR__.'/../../../parts/menu/main.popup.1.php') ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($arResult['LOGOTYPE']['SHOW']['DESKTOP']) { ?>
                    <div class="widget-logotype-wrap intec-grid-item-auto">
                        <a href="<?= SITE_DIR ?>" class="widget-item widget-logotype intec-image">
                            <div class="intec-aligner"></div>
                            <?php include(__DIR__.'/../../../parts/logotype.php') ?>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($arResult['TAGLINE']['SHOW']['DESKTOP']) { ?>
                    <div class="widget-tagline-wrap intec-grid-item-auto intec-grid-item-shrink-1">
                        <div class="widget-item widget-tagline">
                            <div class="widget-tagline-text">
                                <?= $arResult['TAGLINE']['VALUE'] ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="intec-grid-item"></div>
                <?php if ($arResult['REGIONALITY']['USE']) { ?>
                    <div class="widget-region-wrap intec-grid-item-auto">
                        <div class="widget-region">
                            <div class="widget-region-icon intec-cl-text">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="widget-region-text">
                                <?= $APPLICATION->IncludeComponent('intec.regionality:regions.select', '', []) ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($arResult['EMAIL']['SHOW']['DESKTOP']) { ?>
                    <div class="widget-email-wrap intec-grid-item-auto">
                        <div class="widget-item widget-email">
                            <a href="mailto:<?= $arResult['EMAIL']['VALUE'] ?>" class="widget-email-text intec-cl-text-hover">
                                <?= $arResult['EMAIL']['VALUE'] ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($arResult['CONTACTS']['SHOW']['DESKTOP']) { ?>
                    <?php $arContact = $arResult['CONTACTS']['SELECTED'] ?>
                    <?php $arContacts = $arResult['CONTACTS']['VALUES'] ?>
                    <div class="widget-phone-wrap intec-grid-item-auto">
                        <div class="widget-item widget-phone" data-block="phone">
                            <div class="widget-phone-content">
                                <?php if ($arResult['CONTACTS']['ADVANCED']) { ?>
                                    <a href="tel:<?= $arContact['PHONE']['VALUE'] ?>" class="widget-phone-text intec-cl-text-hover" data-block-action="popup.open">
                                        <?= $arContact['PHONE']['DISPLAY'] ?>
                                    </a>
                                <?php } else { ?>
                                    <a href="tel:<?= $arContact['VALUE'] ?>" class="widget-phone-text intec-cl-text-hover" data-block-action="popup.open">
                                        <?= $arContact['DISPLAY'] ?>
                                    </a>
                                <?php } ?>
                                <?php if (!empty($arContacts)) { ?>
                                    <div class="widget-phone-popup" data-block-element="popup" data-expanded="false">
                                        <div class="widget-phone-popup-wrapper" data-advanced="<?= $arResult['CONTACTS']['ADVANCED'] ? 'true' : 'false' ?>">
                                            <?php if ($arResult['CONTACTS']['ADVANCED']) { ?>
                                                <?php foreach ($arContacts as $arContact) { ?>
                                                    <div class="widget-phone-popup-contacts">
                                                        <?php if (!empty($arContact['PHONE'])) { ?>
                                                            <a href="tel:<?= $arContact['PHONE']['VALUE'] ?>" class="widget-phone-popup-contact phone intec-cl-text-hover">
                                                                <?= $arContact['PHONE']['DISPLAY'] ?>
                                                            </a>
                                                        <?php } ?>
                                                        <?php if (!empty($arContact['ADDRESS'])) { ?>
                                                            <div class="widget-phone-popup-contact address">
                                                                <?php if (Type::isArray($arContact['ADDRESS'])) { ?>
                                                                    <?php foreach ($arContact['ADDRESS'] as $sValue) { ?>
                                                                        <span><?= $sValue ?></span>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?= $arContact['ADDRESS'] ?>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if (!empty($arContact['SCHEDULE'])) { ?>
                                                            <div class="widget-phone-popup-contact schedule">
                                                                <?php if (Type::isArray($arContact['SCHEDULE'])) { ?>
                                                                    <?php foreach ($arContact['SCHEDULE'] as $sValue) { ?>
                                                                        <span><?= $sValue ?></span>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?= $arContact['SCHEDULE'] ?>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if (!empty($arContact['EMAIL'])) { ?>
                                                            <a href="mailto:<?= $arContact['EMAIL'] ?>" class="widget-phone-popup-contact email intec-cl-text-hover">
                                                                <?= $arContact['EMAIL'] ?>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php foreach ($arContacts as $arContact) { ?>
                                                    <a href="tel:<?= $arContact['VALUE'] ?>" class="widget-phone-popup-item intec-cl-text-hover">
                                                        <?= $arContact['DISPLAY'] ?>
                                                    </a>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (!empty($arContacts)) { ?>
                                <div class="widget-phone-arrow far fa-chevron-down" data-block-action="popup.open"></div>
                            <?php } ?>
                        </div>
                        <?php if (!empty($arContacts) && !defined('EDITOR')) { ?>
                            <script type="text/javascript">
                                (function ($) {
                                    $(document).on('ready', function () {
                                        var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
                                        var block = $('[data-block="phone"]', root);
                                        var popup = $('[data-block-element="popup"]', block);

                                        popup.open = $('[data-block-action="popup.open"]', block);
                                        popup.open.on('mouseenter', function () {
                                            block.attr('data-expanded', 'true');
                                        });

                                        block.on('mouseleave', function () {
                                            block.attr('data-expanded', 'false');
                                        });
                                    });
                                })(jQuery)
                            </script>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($arResult['FORMS']['CALL']['SHOW']) { ?>
                    <?= Html::beginTag('div', [
                        'class' => [
                            'widget-button-wrap',
                            'intec-grid-item-auto',
                            'intec-grid-item-a-stretch',
                            'intec-cl-background',
                            'intec-cl-background-light-hover'
                        ]
                    ]) ?>
                        <div class="widget-item widget-button intec-grid intec-grid-nowrap intec-grid-a-v-center intec-grid-i-h-5" data-action="forms.call.open">
                            <div class="widget-button-icon intec-grid-item-auto">
                                <div class="widget-button-icon intec-ui-icon intec-ui-icon-phone-1"></div>
                            </div>
                            <div class="widget-button-text intec-grid-item-auto">
                                <?= Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP4_BUTTON') ?>
                            </div>
                        </div>
                        <?php include(__DIR__.'/../../../parts/forms/call.php') ?>
                    <?= Html::endTag('div') ?>
                <?php } ?>
            <?= Html::endTag('div') ?>
        </div>
    </div>
</div>