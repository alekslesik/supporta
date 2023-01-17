<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\StringHelper;
use Bitrix\Main\Localization\Loc;

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

$arVisual = $arResult['VISUAL'];
$arContacts = $arResult['CONTACTS'];
$arSocial = $arResult['SOCIAL'];
$arForms = $arResult['FORMS'];

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
}
?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-menu',
        'c-menu-popup-3'
    ],
    'data-theme' => $arVisual['THEME']
]) ?>
    <div class="menu-button intec-cl-text-hover" data-action="menu.open">
        <i class="menu-button-icon glyph-icon-menu-icon"></i>
    </div>
    <?= Html::beginTag('div', [
        'class' => Html::cssClassFromArray([
            'menu' => true,
            'background-image' => $arVisual['BACKGROUND']['TYPE'] == 'picture' && !empty($arVisual['BACKGROUND']['URL'])
        ], true),
        'data-role' => 'menu',
        'style' => Html::cssStyleFromArray([
            'background-image' => $arVisual['BACKGROUND']['TYPE'] == 'picture' && !empty($arVisual['BACKGROUND']['URL']) ? 'url(' . $arVisual['BACKGROUND']['URL'] . ')' : null,
            'background-color' => $arVisual['BACKGROUND']['TYPE'] == 'color' && !empty($arVisual['BACKGROUND']['COLOR']) ? $arVisual['BACKGROUND']['COLOR'] : null
        ])
    ]) ?>
        <div class="menu-wrapper intec-content intec-content-primary">
            <div class="menu-wrapper-2 intec-content-wrapper">
                <div class="menu-panel">
                    <div class="menu-panel-wrapper intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
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
                        <?php } ?>
                        <div class="intec-grid-item"></div>
                        <div class="menu-panel-button-wrap intec-grid-item-auto">
                            <div class="menu-panel-button intec-cl-text-hover" data-action="menu.close">
                                <i class="glyph-icon-cancel"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-content">
                    <div class="menu-content-wrapper intec-grid intec-grid-nowrap intec-grid-a-v-stretch">
                        <div class="menu-content-items-wrapper scroll-mod-hiding scrollbar-inner intec-grid-item" data-role="scroll">
                            <div class="menu-content-items-wrapper-2">
                                <?php $fRender($arResult, 0) ?>
                            </div>
                        </div>
                        <?php if ($arContacts['SHOW'] || $arSocial['SHOW']) { ?>
                            <div class="menu-content-contacts-wrap intec-grid-item-4">
                                <?php if ($arContacts['SHOW']) { ?>
                                    <div class="menu-content-contacts">
                                        <div class="menu-content-contacts-title">
                                            <?= Loc::getMessage('C_MENU_POPUP_3_CONTACTS_TITLE') ?>
                                        </div>
                                        <div class="menu-content-contacts-items">
                                            <?php if (!empty($arContacts['CITY'])) { ?>
                                                <div class="menu-content-contacts-name">
                                                    <?= $arContacts['CITY'] ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($arContacts['ADDRESS'])) { ?>
                                                <div class="menu-content-contacts-address">
                                                    <?= $arContacts['ADDRESS'] ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($arContacts['SCHEDULE'])) { ?>
                                                <div class="menu-content-contacts-time">
                                                    <?php if (Type::isArray($arContacts['SCHEDULE'])) { ?>
                                                        <?php foreach ($arContacts['SCHEDULE'] as $sValue) { ?>
                                                            <div><?= $sValue ?></div>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?= $arContacts['SCHEDULE'] ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <a href="tel:<?= $arContacts['PHONE']['VALUE'] ?>" class="menu-content-contacts-phone intec-cl-text-hover">
                                                <?= $arContacts['PHONE']['DISPLAY'] ?>
                                            </a>
                                            <?php if (!empty($arContacts['EMAIL'])) { ?>
                                                <a href="mailto:<?= $arContacts['EMAIL'] ?>" class="menu-content-contacts-mail intec-cl-text-hover">
                                                    <?= $arContacts['EMAIL'] ?>
                                                </a>
                                            <?php } ?>
                                            <?php if ($arForms['CALL']['SHOW']) { ?>
                                                <div class="menu-content-contacts-button intec-cl-background-light-hover" data-action="forms.call.open">
                                                    <?= $arForms['CALL']['TITLE'] ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($arSocial['SHOW']) { ?>
                                    <div class="menu-content-social">
                                            <div class="menu-content-social-title">
                                                <?= Loc::getMessage('C_MENU_POPUP_3_SOCIAL_TITLE') ?>
                                            </div>
                                        <div class="menu-content-social-icons intec-grid intec-grid-nowrap intec-grid-i-h-10">
                                            <?php foreach ($arSocial['ITEMS'] as $arItem) { ?>
                                                <?php if (empty($arItem['LINK'])) continue ?>
                                                <div class="menu-content-social-icon-wrap intec-grid-item-auto">
                                                    <a href="<?= $arItem['LINK'] ?>" class="menu-content-social-icon" style="background-image:url('<?= $arItem['ICON_URL'] ?>')"></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php include(__DIR__.'parts/form.php') ?>
                        <?php } ?>
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