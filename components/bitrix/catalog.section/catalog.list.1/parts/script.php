<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $sTemplateId
 * @var string $sTemplateContainer
 * @var array $arVisual
 * @var array $arNavigation
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$oSigner = new \Bitrix\Main\Security\Sign\Signer;
$sSignedTemplate = $oSigner->sign($templateName, 'catalog.section');
$sSignedParameters = $oSigner->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');

?>
<script type="text/javascript">
    (function ($, api) {
        $(function () {
            var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
            var properties = root.data('properties');
            var items;
            var component;
            var order;

            <?php if ($arResult['FORM']['SHOW']) { ?>
                order = function (data) {
                    var options = <?= JavaScript::toObject([
                        'id' => $arResult['FORM']['ID'],
                        'template' => $arResult['FORM']['TEMPLATE'],
                        'parameters' => [
                            'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'-form',
                            'CONSENT_URL' => $arResult['URL']['CONSENT']
                        ],
                        'settings' => [
                            'title' => Loc::getMessage('C_CATALOG_SECTION_CATALOG_LIST_1_FORM_TITLE')
                        ]
                    ]) ?>;

                    options.fields = {};

                    <?php if (!empty($arResult['FORM']['PROPERTIES']['PRODUCT'])) { ?>
                        options.fields[<?= JavaScript::toObject($arResult['FORM']['PROPERTIES']['PRODUCT']) ?>] = data.name;
                    <?php } ?>

                    universe.forms.show(options);
                };
            <?php } ?>

            root.update = function () {
                var handled = [];

                if (api.isDeclared(items))
                    handled = items.handled;

                items = $('[data-role="item"]', root);
                items.handled = handled;
                items.each(function () {
                    var item = $(this);
                    var data = item.data('data');
                    var entity = data;

                    if (handled.indexOf(this) > -1)
                        return;

                    handled.push(this);
                    item.offers = new universe.catalog.offers({
                        'properties': properties.length !== 0 ? properties : data.properties,
                        'list': data.offers
                    });

                    item.counter = $('[data-role="item.counter"]', item);
                    item.price = $('[data-role="item.price"]', item);
                    item.price.base = $('[data-role="item.price.base"]', item.price);
                    item.price.discount = $('[data-role="item.price.discount"]', item.price);
                    item.order = $('[data-role="item.order"]', item);
                    item.quantity = api.controls.numeric({
                        'bounds': {
                            'minimum': entity.quantity.ratio,
                            'maximum': entity.quantity.trace && !entity.quantity.zero ? entity.quantity.value : false
                        },
                        'step': entity.quantity.ratio
                    }, item.counter);

                    item.update = function () {
                        var price = null;

                        item.attr('data-available', entity.available ? 'true' : 'false');
                        api.each(entity.prices, function (index, object) {
                            if (object.quantity.from === null || item.quantity.get() >= object.quantity.from)
                                price = object;
                        });

                        if (price !== null) {
                            item.price.attr('data-discount', price.discount.use ? 'true' : 'false');
                            item.price.base.html(price.base.display);
                            item.price.discount.html(price.discount.display);
                        } else {
                            item.price.attr('data-discount', 'false');
                            item.price.base.html(null);
                            item.price.discount.html(null);
                        }

                        item.price.attr('data-show', price !== null ? 'true' : 'false');
                        item.quantity.configure({
                            'bounds': {
                                'minimum': entity.quantity.ratio,
                                'maximum': entity.quantity.trace && !entity.quantity.zero ? entity.quantity.value : false
                            },
                            'step': entity.quantity.ratio
                        });

                        item.find('[data-offer]').css('display', '');

                        if (entity !== data) {
                            item.find('[data-offer=' + entity.id + ']').css('display', 'block');
                            item.find('[data-offer="false"]').css('display', 'none');
                        }

                        item.find('[data-basket-id]')
                            .data('basketQuantity', item.quantity.get())
                            .attr('data-basket-quantity', item.quantity.get());
                    };

                    item.update();

                    <?php if ($arResult['FORM']['SHOW']) { ?>
                        item.order.on('click', function () {
                            order(data);
                        });
                    <?php } ?>

                    item.quantity.on('change', function (event, value) {
                        item.update();
                    });

                    if (!item.offers.isEmpty()) {
                        item.properties = $('[data-role="item.property"]', item);
                        item.properties.values = $('[data-role="item.property.value"]', item.properties);
                        item.properties.attr('data-visible', 'false');
                        item.properties.each(function () {
                            var self = $(this);
                            var property = self.data('property');
                            var values = self.find(item.properties.values);

                            values.each(function () {
                                var self = $(this);
                                var value = self.data('value');

                                self.on('click', function () {
                                    item.offers.setCurrentByValue(property, value);
                                });
                            });
                        });

                        api.each(item.offers.getList(), function (index, offer) {
                            api.each(offer.values, function (key, value) {
                                if (value == 0)
                                    return;

                                item.properties
                                    .filter('[data-property=' + key + ']')
                                    .attr('data-visible', 'true');
                            });
                        });

                        item.offers.on('change', function (event, offer, values) {
                            entity = offer;

                            api.each(values, function (state, values) {
                                api.each(values, function (property, values) {
                                    property = item.properties.filter('[data-property="' + property + '"]');

                                    api.each(values, function (index, value) {
                                        value = property.find(item.properties.values).filter('[data-value="' + value + '"]');
                                        value.attr('data-state', state);
                                    });
                                });
                            });

                            item.update();
                        });

                        item.offers.setCurrentById(item.offers.getList()[0].id);
                    }

                });
            };

            BX.message(<?= JavaScript::toObject([
                'BTN_MESSAGE_LAZY_LOAD' => '',
                'BTN_MESSAGE_LAZY_LOAD_WAITER' => ''
            ]) ?>);

            component = new JCCatalogSectionComponent(<?= JavaScript::toObject([
                'siteId' => SITE_ID,
                'componentPath' => $componentPath,
                'navParams' => $arNavigation,
                'deferredLoad' => false,
                'initiallyShowHeader' => false,
                'bigData' => $arResult['BIG_DATA'],
                'lazyLoad' => $arVisual['NAVIGATION']['LAZY']['BUTTON'],
                'loadOnScroll' => $arVisual['NAVIGATION']['LAZY']['SCROLL'],
                'template' => $sSignedTemplate,
                'parameters' => $sSignedParameters,
                'ajaxId' => $arParams['AJAX_ID'],
                'container' => $sTemplateContainer
            ]) ?>);

            component.processItems = (function () {
                var action = component.processItems;

                return function () {
                    var result = action.apply(this, arguments);

                    root.update();
                    universe.basket.update();

                    return result;
                };
            })();

            root.update();
        });
    })(jQuery, intec);
</script>
<?php

unset($sSignedParameters);
unset($sSignedTemplate);
unset($oSigner);