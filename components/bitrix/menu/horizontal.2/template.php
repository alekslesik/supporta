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

?>
<?php $fDraw = function ($arItem, $iLevel) use (&$fDraw, &$arParams, &$arResult) { ?>
<?php $arItems = $arItem['ITEMS'] ?>
    <div class="menu-submenu menu-submenu-catalog menu-submenu-<?= $iLevel ?>" data-role="menu">
        <div class="menu-submenu-wrapper" data-role="items">
            <?php foreach ($arItems as $arItem) { ?>
            <?php
                $bSelected = ArrayHelper::getValue($arItem, 'SELECTED');
                $bSelected = Type::toBoolean($bSelected);
            ?>
                <div class="menu-submenu-item<?= $bSelected ? ' menu-submenu-item-active' : null ?>" data-role="item">
                    <?= Html::beginTag('a', array(
                        'class' => 'menu-submenu-item-text intec-cl-text-hover'.($bSelected ? ' intec-cl-text' : null),
                        'href' => $arItem['LINK']
                    )); ?>
                    <?= Html::encode($arItem['TEXT']) ?>
                    <?= Html::endTag('a') ?>
                    <?php if (!empty($arItem['ITEMS'])) { ?>
                        <div class="menu-submenu-item-arrow far fa-angle-right"></div>
                    <?php } ?>
                    <?php if (!empty($arItem['ITEMS'])) $fDraw($arItem, $iLevel + 1) ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?php if (!empty($arResult)) { ?>
    <?= Html::beginTag('div', [
        'id' => $sTemplateId,
        'class' => [
            'ns-bitrix',
            'c-menu',
            'c-menu-horizontal-2'
        ],
        'data' => [
            'role' => 'menu'
        ]
    ]) ?>
        <div class="menu-wrapper intec-grid intec-grid-nowrap intec-grid-a-h-start intec-grid-a-v-stretch intec-grid-i-h-5" data-role="items">
            <?php foreach ($arResult as $arItem) { ?>
            <?php
                $bSelected = ArrayHelper::getValue($arItem, 'SELECTED');
                $bSelected = Type::toBoolean($bSelected);
            ?>
                <?= Html::beginTag('div', [
                    'class' => Html::cssClassFromArray([
                        'intec-grid-item-auto' => true,
                        'menu-item' => [
                            '' => true,
                            'active' => $bSelected
                        ]
                    ], true),
                    'data' => [
                        'role' => 'item'
                    ]
                ]) ?>
                    <div class="intec-aligner"></div>
                    <a href="<?= $arItem['LINK'] ?>" class="menu-item-text<?= !empty($arItem['ITEMS']) ? ' menu-item-arrow' : null ?>">
                        <div class="intec-aligner"></div>
                        <div class="menu-item-background"></div>
                        <?= Html::beginTag('div', [
                            'class' => [
                                'menu-item-text-wrapper'
                            ]
                        ]) ?>
                            <?= Html::encode($arItem['TEXT']) ?>
                        <?= Html::endTag('div') ?>
                        <?php if (!empty($arItem['ITEMS'])) {?>
                            <div class="menu-item-text-icon menu-item-text-icon-arrow">
                                <i class="far fa-angle-down"></i>
                            </div>
                        <?php } ?>
                    </a>
                    <?php if (!empty($arItem['ITEMS'])) {
                        $fDraw($arItem, 1);
                    } ?>
                <?= Html::endTag('div') ?>
            <?php } ?>
            <?= Html::beginTag('div', [
                'class' => [
                    'menu-item' => [
                        '',
                        'default',
                        'more'
                    ]
                ],
                'data' => [
                    'role' => 'more'
                ]
            ]) ?>
                <div class="intec-aligner"></div>
                <a class="menu-item-text">
                    <div class="intec-aligner"></div>
                    <div class="menu-item-background"></div>
                    <?= Html::tag('div', '...', [
                        'class' => [
                            'menu-item-text-wrapper'
                        ]
                    ]) ?>
                </a>
                <?php $fDraw(array(
                    'TEXT' => '...',
                    'LINK' => null,
                    'ITEMS' => $arResult
                ), 1) ?>
            <?= Html::endTag('div') ?>
        </div>
        <div class="clearfix"></div>

        <script type="text/javascript">
            (function ($, api) {
                $(document).ready(function () {
                    var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
                    var selectors = {
                        'menu': '[data-role=menu]',
                        'item': '[data-role=item]',
                        'items': '[data-role=items]',
                        'more': '[data-role=more]'
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