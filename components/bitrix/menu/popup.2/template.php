<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\StringHelper;

/** @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

$arLogotype = [
    'SHOW' => ArrayHelper::getValue($arParams, 'LOGOTYPE_SHOW') == 'Y',
    'PATH' => ArrayHelper::getValue($arParams, 'LOGOTYPE', null),
    'LINK' => ArrayHelper::getValue($arParams, 'LOGOTYPE_LINK', null),
];

$arLogotype['PATH'] = trim($arLogotype['PATH']);
$arLogotype['PATH'] = StringHelper::replaceMacros($arLogotype['PATH'], $arMacros);
$arLogotype['SHOW'] = $arLogotype['SHOW'] && !empty($arLogotype['PATH']);

include(__DIR__.'/parts/views.php');

/**
 * @param array $arItems
 * @param integer $iLevel
 * @param array $arParent
 */

$fRender = function ($arItems, $iLevel, $arParent = null) use (&$fRender, &$arViews) {
    $sView = 'simple.level.'.$iLevel;

    if (empty($arViews[$sView]))
        $sView = 'simple.level.*';

    if (empty($arViews[$sView]))
        return;

    $fView = $arViews[$sView];
    $fView($arItems, $iLevel, $arParent);
};

if ($arResult['PHONES']['ADVANCED']) {
    $arContact = $arResult['CONTACT'];
    $arContacts = $arResult['CONTACTS'];
} else {
    $arContacts = $arResult['PHONES']['VALUES'];
    $arContact = ArrayHelper::shift($arContacts);
}
$iContactsCount = count($arContacts);
$sTheme = $arParams['THEME'];

$sTheme = 'black';
?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-menu',
        'c-menu-popup-2'
    ]
]) ?>
    <div class="menu-button intec-cl-text-hover" data-action="menu.open">
        <i class="menu-button-icon glyph-icon-menu-icon"></i>
    </div>
    <?= Html::beginTag('div', [
        'class' => 'menu',
        'data-role' => 'menu',
        'data-theme' => $sTheme
    ]) ?>
        <div class="menu-wrapper intec-content intec-content-primary">
            <div class="menu-wrapper-2 intec-content-wrapper">
                <div class="menu-panel">
                    <div class="menu-panel-wrapper intec-grid intec-grid-nowrap intec-grid-i-h-20 intec-grid-a-v-center">
                        <?php if ($arLogotype['SHOW']) { ?>
                            <div class="menu-panel-logotype-wrap intec-grid-item-auto">
                                <?= Html::beginTag(!empty($arLogotype['LINK']) ? 'a' : 'div', [
                                    'class' => [
                                        'menu-panel-logotype',
                                        'intec-image'
                                    ],
                                    'href' => !empty($arLogotype['LINK']) ? $arLogotype['LINK'] : null
                                ]) ?>
                                <div class="intec-aligner"></div>
                                <?php $APPLICATION->IncludeComponent(
                                    'bitrix:main.include',
                                    '.default',
                                    array(
                                        'AREA_FILE_SHOW' => 'file',
                                        'PATH' => $arLogotype['PATH'],
                                        'EDIT_TEMPLATE' => null
                                    ),
                                    $this->getComponent()
                                ) ?>
                                <?= Html::endTag(!empty($arLogotype['LINK']) ? 'a' : 'div') ?>
                            </div>
                        <?php } else { ?>
                            <div class="intec-grid-item"></div>
                        <?php } ?>
                        <div class="menu-panel-search-wrap intec-grid-item">
                            <div class="menu-panel-search">
                                <?php include(__DIR__.'/parts/search/input.1.php') ?>
                            </div>
                        </div>

                        <div class="menu-panel-contacts-wrap intec-grid-item-auto">
                            <div class="menu-panel-item menu-panel-contacts" data-block="phone" data-multiple="<?= !empty($arContacts) ? 'true' : 'false' ?>" data-expanded="false">
                                <div class="menu-panel-phone">
                                    <div class="menu-panel-phone-content">
                                        <a href="tel:<?= $arContact['PHONE']['VALUE'] ?>" class="menu-panel-phone-text intec-cl-text-hover" data-block-action="popup.open">
                                            <?= $arContact['PHONE']['DISPLAY'] ?>
                                        </a>
                                        <?php if (!empty($arContacts)) { ?>
                                            <div class="menu-panel-phone-popup" data-block-element="popup">
                                                <div class="menu-panel-phone-popup-wrapper">
                                                    <?php if ($arResult['PHONES']['ADVANCED']) {?>
                                                        <?php foreach ($arContacts as $arContact) { ?>
                                                            <div class="menu-panel-phone-popup-contacts">
                                                                <a href="tel:<?= $arContact['PHONE']['VALUE'] ?>" class="menu-panel-phone-popup-contact phone intec-cl-text-hover">
                                                                    <?= $arContact['PHONE']['DISPLAY'] ?>
                                                                </a>
                                                                <div  class="menu-panel-phone-popup-contact address">
                                                                    <?php if (is_array($arContact['ADDRESS'])) { ?>
                                                                        <?php foreach ($arContact['ADDRESS'] as $sValue) { ?>
                                                                            <span><?= $sValue ?></span>
                                                                        <?php } ?>
                                                                    <?php } else { ?>
                                                                        <?= $arContact['ADDRESS'] ?>
                                                                    <?php } ?>
                                                                </div>
                                                                <div  class="menu-panel-phone-popup-contact schedule">
                                                                    <?php if (is_array($arContact['SCHEDULE'])) { ?>
                                                                        <?php foreach ($arContact['SCHEDULE'] as $sValue) { ?>
                                                                            <span><?= $sValue ?></span>
                                                                        <?php } ?>
                                                                    <?php } else { ?>
                                                                        <?= $arContact['SCHEDULE'] ?>
                                                                    <?php } ?>
                                                                </div>
                                                                <a href="mailto: <?= $arContact['EMAIL'] ?>" class="menu-panel-phone-popup-contact email intec-cl-text-hover">
                                                                    <?= $arContact['EMAIL'] ?>
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php foreach ($arContacts as $arContact) { ?>
                                                            <a href="tel:<?= $arContact['VALUE'] ?>" class="menu-panel-phone-popup-item intec-cl-text-hover">
                                                                <?= $arContact['DISPLAY'] ?>
                                                            </a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if (!empty($arContacts)) { ?>
                                        <div class="menu-panel-phone-arrow far fa-chevron-down" data-block-action="popup.open"></div>
                                    <?php } ?>
                                    <?php if ($iContactsCount > 1) { ?>
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
                                <?php if ($arContact['EMAIL']) { ?>
                                    <div class="menu-panel-item menu-panel-email-wrap">
                                        <a href="mailto: <?= $arContact['EMAIL'] ?>" class="menu-panel-email">
                                            <?= $arContact['EMAIL'] ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="menu-panel-form-call-wrap intec-grid-item-auto">
                            <?php if ($arResult['FORMS']['CALL']['SHOW']) { ?>
                                <div class="menu-panel-form-call">
                                    <div class="menu-panel-form-call-button intec-cl-background intec-cl-background-light-hover" data-action="forms.call.open">
                                        <?= Loc::getMessage('C_HEADER_TEMP1_DESKTOP_TEMP1_BUTTON') ?>
                                    </div>
                                    <?php include(__DIR__.'/parts/forms/call.php') ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="menu-panel-button-wrap intec-grid-item-auto">
                            <div class="menu-panel-button intec-cl-text-hover" data-action="menu.close">
                                <i class="glyph-icon-cancel"></i>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="menu-content">
                    <div class="menu-content-wrapper" >
                        <div class="menu-content-wrapper-2 scrollbar-inner" data-role="scroll">
                            <div class="menu-content-wrapper-3">
                                <?= Html::beginTag('div', [
                                    'class' => Html::cssClassFromArray([
                                        'menu-content-wrapper-4' => true,
                                        'intec-grid' => [
                                            '' => true,
                                            'wrap' => true,
                                            'a-v-begin' => true,
                                            'a-h-begin' => true,
                                            'i-h-5'
                                        ]
                                    ], true)
                                ])?>
                                    <?php $fRender($arResult['MENU']['ITEMS'], 0) ?>
                                <?= Html::endTag('div') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?= Html::endTag('div') ?>
    <script type="text/javascript">
        (function ($, api) {
            $(document).on('ready', function () {
                var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
                var menu = $('[data-role="menu"]', root);
                var buttons = {};
                var state = false;
                var scroll = $('[data-role="scroll"]', root);
                var scrollValue = 0;

                menu.items = $('[data-role="menu.item"]', menu);
                buttons.open = $('[data-action="menu.open"]', root);
                buttons.close = $('[data-action="menu.close"]', root);

                scroll.scrollbar();

                menu.open = function () {
                    if (state) return;

                    state = true;
                    scrollValue = $(window).scrollTop();
                    menu.css({
                        'display': 'block'
                    }).stop().animate({
                        'opacity': 1
                    }, 500);
                };

                menu.close = function () {
                    if (!state) return;

                    state = false;
                    menu.stop().animate({
                        'opacity': 0
                    }, 500, function () {
                        menu.css({
                            'display': 'none'
                        });
                    });
                };

                $(window).on('scroll', function () {
                    if (state && $(window).scrollTop() !== scrollValue)
                        $(window).scrollTop(scrollValue);
                });

                buttons.open.on('click', menu.open);
                buttons.close.on('click', menu.close);

                menu.items.each(function () {
                    var item = $(this);
                    var items = $('[data-role="menu.items"]', item).first();
                    var buttons = {};
                    var state = false;
                    var expanded = item.data('expanded');

                    buttons.toggle = $('[data-action="menu.item.toggle"]', item)
                        .not(items.find('[data-action="menu.item.toggle"]'))
                        .first();

                    item.open = function () {
                        var height = {};

                        if (state) return;

                        state = true;
                        item.attr('data-expanded', 'true');

                        height.old = items.height();
                        items.css({
                            'height': 'auto'
                        });

                        height.new = items.height();
                        items.css({
                            'height': height.old
                        });

                        items.stop().animate({
                            'height': height.new
                        }, 350, function () {
                            items.css({
                                'height': 'auto'
                            })
                        })
                    };

                    item.close = function () {
                        if (!state) return;

                        state = false;
                        item.attr('data-expanded', 'false');

                        items.stop().animate({
                            'height': 0
                        }, 350);
                    };

                    if (expanded)
                        item.open();

                    buttons.toggle.on('click', function () {
                        if (state) {
                            item.close();
                        } else {
                            item.open();
                        }
                    });
                });
            })
        })(jQuery, intec);
    </script>
<?= Html::endTag('div') ?>