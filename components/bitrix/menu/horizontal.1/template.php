<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Type;

/** @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arParams = ArrayHelper::merge([
    'SECTION_VIEW' => 'default',
    'SECTION_COLUMNS_COUNT' => 3,
    'SECTION_ITEMS_COUNT' => 3
], $arParams);

$arVisual = [
    'SECTION' => [
        'VIEW' => ArrayHelper::fromRange([
            'default',
            'images'
        ], $arParams['SECTION_VIEW']),
        'COLUMNS' => ArrayHelper::fromRange([
            2, 3, 4
        ], $arParams['SECTION_COLUMNS_COUNT']),
        'ITEMS' => $arParams['SECTION_ITEMS_COUNT']
    ]
];

$bTransparent = ArrayHelper::getValue($arParams, 'TRANSPARENT') == 'Y';
$bDelimiters = ArrayHelper::getValue($arParams, 'DELIMITERS') == 'Y' && !$bTransparent;

?>
<?php $fDraw = function ($arItem, $iLevel, $bIsIBlock = false, $bIsSection = false) use (&$fDraw, &$arParams, &$arResult, &$arVisual) { ?>
<?php
    $arItems = $arItem['ITEMS'];

    if (!$bIsIBlock)
        $bIsSection = false;

    if ($bIsSection) {
        include('parts/section.php');
    } else {
        include('parts/default.php');
    }
?>

<?php } ?>
<?php if (!empty($arResult)) { ?>
    <?= Html::beginTag('div', [
        'id' => $sTemplateId,
        'class' => Html::cssClassFromArray([
            'ns-bitrix' => true,
            'c-menu' => true,
            'c-menu-horizontal-1' => true,
            'menu-transparent' => $bTransparent,
            'intec-cl-background' => !$bTransparent
        ], true),
        'data' => [
            'role' => 'menu',
            'section-view' => $arParams['SECTION_VIEW'],
            'submenu-view' => $arParams['SUBMENU_VIEW']
        ]
    ]) ?>
        <div class="intec-content">
            <div class="intec-content-wrapper">
                <div class="menu-wrapper intec-grid intec-grid-nowrap intec-grid-a-h-start intec-grid-a-v-stretch" data-role="items">
                    <?php foreach ($arResult as $arItem) { ?>
                    <?php
                        $bIsIBlock = false;

                        if (!empty($arItem['ITEMS'])) {
                            $bIsIBlock = ArrayHelper::getFirstValue($arItem['ITEMS']);
                            $bIsIBlock = ArrayHelper::getValue($bIsIBlock, ['PARAMS', 'FROM_IBLOCK']);
                            $bIsIBlock = Type::toBoolean($bIsIBlock);
                        }

                        $bIsSection = $bIsIBlock && $arParams['SECTION_VIEW'] !== 'information';

                        $bActive = $arItem['ACTIVE'];
                        $bCatalog = $arItem['IS_CATALOG'] == 'Y';
                        $bSelected = ArrayHelper::getValue($arItem, 'SELECTED');
                        $bSelected = Type::toBoolean($bSelected);

                        $sUrl = $bActive ? null : $arItem['LINK'];
                        $sTag = $bActive ? 'div' : 'a';
                    ?>
                        <?= Html::beginTag('div', [
                            'class' => Html::cssClassFromArray([
                                'intec-grid-item-auto' => true,
                                'menu-item' => [
                                    '' => true,
                                    'default' => !$bIsSection,
                                    'section' => $bIsSection,
                                    'active' => $bSelected,
                                    'border' => $bDelimiters
                                ],
                                'intec-cl' => [
                                    'text' => $bSelected,
                                    'background-light' => $bSelected,
                                    'background-light-hover' => !$bTransparent,
                                    'border-light' => $bDelimiters
                                ]

                            ], true),
                            'data' => [
                                'role' => 'item'
                            ]
                        ]) ?>
                            <?= Html::beginTag($sTag, [
                                'class' => Html::cssClassFromArray([
                                    'menu-item-text' => true,
                                    'menu-item-catalog-text' => $bCatalog && !$bTransparent
                                ], true),
                                'href' => $sUrl
                            ]) ?>
                                <div class="intec-aligner"></div>
                                <?php if ($bCatalog && !$bTransparent) {?>
                                    <div class="menu-item-text-icon menu-item-text-icon-catalog<?= $bTransparent ? ' intec-cl-text' : null ?>">
                                        <i class="far fa-bars"></i>
                                    </div>
                                <? } ?>
                                <?= Html::beginTag('div', [
                                    'class' => Html::cssClassFromArray([
                                        'menu-item-text-wrapper' => true,
                                        'intec-cl-text' => $bTransparent
                                    ], true)
                                ]) ?>
                                    <?= Html::encode($arItem['TEXT']) ?>
                                <?= Html::endTag('div') ?>
                                <?php if ($bCatalog && !$bTransparent) {?>
                                    <div class="menu-item-text-icon menu-item-text-icon-arrow<?= $bTransparent ? ' intec-cl-text' : null ?>">
                                        <i class="far fa-angle-down"></i>
                                    </div>
                                <?php } ?>
                            <?= Html::endTag($sTag) ?>
                            <?php if (!empty($arItem['ITEMS'])) {
                                $fDraw($arItem, 1, $bIsIBlock, $bIsSection);
                            } ?>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                    <?= Html::beginTag('div', [
                        'class' => Html::cssClassFromArray([
                            'menu-item' => [
                                '' => true,
                                'default' => true,
                                'more' => true,
                                'border' => $bDelimiters,
                            ],
                            'intec-cl' => [
                                'background-light-hover' => !$bTransparent,
                                'border-light' => $bDelimiters
                            ]
                        ], true),
                        'data' => [
                            'role' => 'more'
                        ]
                    ]) ?>
                        <a class="menu-item-text">
                            <div class="intec-aligner"></div>
                            <?= Html::tag('div', '...', [
                                'class' => Html::cssClassFromArray([
                                    'menu-item-text-wrapper' => true,
                                    'intec-cl-text' => $bTransparent
                                ], true)
                            ]) ?>
                        </a>
                        <?php $fDraw(array(
                            'TEXT' => '...',
                            'LINK' => null,
                            'ITEMS' => $arResult
                        ), 1, false) ?>
                    <?= Html::endTag('div') ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <script type="text/javascript">
            (function ($, api) {
                $(document).ready(function () {
                    var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
                    var selectors = {
                        'menu': '[data-role=menu]',
                        'item': '[data-role=item]',
                        'items': '[data-role=items]',
                        'more': '[data-role=more]',
                        'cards': '[data-role=cards]',
                        'card': '[data-role=card]'
                    };
                    var classes = {
                        'adapted': 'menu-adapted',
                        'initialized': 'menu-initialized',
                        'visible': 'menu-submenu-visible',
                        'right': 'menu-submenu-right'
                    };
                    var menu;
                    var adapt;

                    if (root.is(selectors.menu)) {
                        menu = root;
                    } else {
                        menu = root.find(selectors.menu).eq(0);
                    }

                    /**
                     * Возвращает элемент, содержащий все пункты указанного меню.
                     * Значение параметра submenu:
                     * - селектор или jQuery - возвращать элемент указанного меню.
                     * - false - возвращать элементы всех меню.
                     */
                    menu.getItemsWrappers = function (submenu) {
                        if (!submenu) {
                            return menu
                                .find(selectors.items);
                        }

                        if (menu.get(0) === submenu.get(0)) {
                            submenu = menu;
                        } else {
                            submenu = menu
                                .find(submenu);
                        }

                        return submenu
                            .find(selectors.items)
                            .eq(0);
                    };

                    /**
                     * Возвращает элементы меню.
                     * Значение параметра submenu:
                     * - селектор или jQuery - возвращать элементы определенного меню.
                     * - false - возвращать все элементы.
                     */
                    menu.getItems = function (submenu) {
                        if (!submenu) {
                            return menu
                                .find(selectors.item);
                        }

                        return menu
                            .getItemsWrappers(submenu)
                            .children(selectors.item);
                    };

                    /**
                     * Возвращает меню.
                     * Значение параметра item:
                     * - селектор или объект jQuery - возвращает меню элемента.
                     * - false - возвращать все меню.
                     */
                    menu.getMenu = function (item) {
                        if (item)
                            return menu
                                .find(item)
                                .find(selectors.menu)
                                .eq(0);

                        return menu
                            .find(selectors.menu);
                    };

                    /** Управление содержимым "Еще" */
                    menu.more = {};
                    /** Возвращает элемент меню "Еще" */
                    menu.more.getItem = function () {
                        return menu
                            .find(selectors.more);
                    };
                    /** Возвращает меню элемента "Еще" */
                    menu.more.getMenu = function () {
                        return menu.getMenu(menu.more.getItem());
                    };
                    /** Добавляет элементы (jQuery коллекция) в меню "Еще" */
                    menu.more.add = function (add) {
                        var items;

                        add = $(add);
                        items = menu.getItems(menu.more.getMenu());
                        add.each(function () {
                            var self = $(this);
                            var item = items.eq(self.index());

                            self.hide();
                            item.show();
                        });
                    };
                    /** Удаляет элементы (jQuery коллекция) из меню "Еще" */
                    menu.more.remove = function (remove) {
                        var items;

                        remove = $(remove);
                        items = menu.getItems(menu.more.getMenu());
                        remove.each(function () {
                            var self = $(this);
                            var item = items.eq(self.index());

                            self.show();
                            item.hide();
                        });
                    };

                    /** Правила адаптивности */
                    adapt = {};
                    /** Адаптация положения подменю */
                    adapt.menu = function () {
                        var submenu = menu.getMenu().filter('[data-visible=true]');
                        var wrapper = menu.getItemsWrappers(menu);
                        var width = wrapper.width();
                        var right = false;

                        submenu.each(function () {
                            var self = $(this);
                            var offset = {};

                            self.removeClass(classes.right);

                            offset.start = function () { return self.offset().left - wrapper.offset().left };
                            offset.end = function () { return offset.start() + self.width(); };

                            if (offset.end() > width)
                                right = true;

                            if (right) {
                                self.addClass(classes.right);

                                if (offset.start() < 0) {
                                    self.removeClass(classes.right);
                                    right = false;
                                }
                            }
                        });
                    };
                    /** Адаптация элементов корневого меню */
                    adapt.items = function () {
                        var items = {};
                        var width = {};
                        var wrapper = menu.getItemsWrappers(menu);

                        menu.removeClass(classes.adapted);
                        items.all = menu.getItems(menu);
                        items.visible = $([]);
                        items.hidden = $([]);

                        items.all.hide();
                        width.available = wrapper.width() - menu.more.getItem().show().width();
                        items.all.show();
                        width.total = 0;

                        menu.more.remove(items.all);
                        items.all.each(function () {
                            var item = $(this);

                            item.css({'width': 'auto'});
                            width.total += item.width();

                            if (width.total < width.available) {
                                items.visible = items.visible.add(item);
                            } else {
                                items.hidden = items.hidden.add(item);
                            }
                        });

                        if (items.hidden.size() > 0) {
                            menu.more.add(items.hidden);
                        } else {
                            menu.more.getItem().hide();
                            width.available = wrapper.width();
                        }

                        menu.addClass(classes.adapted);

                        var last = null;

                        width.total = {
                            'original': 0,
                            'rounded': 0
                        };

                        items.visible.each(function () {
                            width.total.original += $(this).width();
                        }).each(function () {
                            var item = $(this);
                            var size = Math.floor((width.available / 100) * (item.width() / width.total.original) * 100);

                            width.total.rounded += size;
                            item.css('width', size + 'px');
                            last = item;
                        });

                        if (last != null)
                            last.css('width', last.width() + (width.available - width.total.rounded) + 'px');
                    };

                    /** События наведения мыши на пунктах меню */
                    menu.getItems().add(menu.more.getItem()).on('mouseenter', function (event) {
                        var item = $(this);
                        var submenu;

                        submenu = menu.getMenu(item);
                        submenu.show().addClass(classes.visible).stop().animate({
                            'opacity': 1
                        }, 300);
                        submenu.attr('data-visible', 'true');
                        adapt.menu();

                        event.preventDefault();
                    }).on('mouseleave', function (event) {
                        var item = $(this);
                        var submenu;

                        submenu = menu.getMenu(item);
                        submenu.stop().removeClass(classes.visible).animate({
                            'opacity': 0
                        }, 50, function () {
                            adapt.menu();
                            submenu.removeAttr('data-visible');
                            submenu.hide();
                        });

                        event.preventDefault();
                    });

                    /** Анимация карт */
                    menu.getItems(menu).each(function () {
                        var item = $(this);
                        var submenu = menu.getMenu(item);
                        var items = menu.getItems(submenu);

                        if (submenu.length !== 1)
                            return;

                        var cardsWrapper = submenu.children(selectors.cards);

                        if (cardsWrapper.length !== 1)
                            return;

                        var cards = cardsWrapper.children(selectors.card);
                        var opening = false;

                        cardsWrapper.css({
                            'width': 0
                        });

                        items.on('mouseenter', function () {
                            var item = $(this);
                            var card = cards.eq(item.index());
                            var width;

                            cards.attr('data-expanded', 'false');
                            card.attr('data-expanded', 'true');

                            if (!opening) {
                                width = {
                                    'current': cardsWrapper.width(),
                                    'new': cardsWrapper.css({
                                        'width': 'auto'
                                    }).width()
                                };

                                if (width.current !== width.new) {
                                    opening = true;

                                    cardsWrapper.stop().css({
                                        'width': width.current
                                    }).animate({
                                        'width': width.new
                                    }, 500, function () {
                                        opening = false;
                                    });
                                }
                            }
                        });

                        submenu.on('mouseleave', function () {
                            var width = cardsWrapper.width();

                            opening = false;
                            cardsWrapper.stop().css({
                                'width': width
                            }).animate({
                                'width': 0
                            }, 500, function () {
                                cards.attr('data-expanded', 'false');
                            });
                        });
                    });

                    root.on('update', function () {
                        adapt.menu();
                        adapt.items();
                    });

                    $(window).on('resize', function () {
                        root.trigger('update');
                    });

                    menu.addClass(classes.initialized);
                    root.trigger('update');
                });
            })(jQuery, intec);
        </script>
    <?= Html::endTag('div') ?>
<?php } ?>