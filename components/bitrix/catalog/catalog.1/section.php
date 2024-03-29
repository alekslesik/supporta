<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Loader;
use intec\Core;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

$this->setFrameMode(true);

$oRequest = Core::$app->request;
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$bIsBase = Loader::includeModule('catalog') && Loader::includeModule('sale');
$bIsLite = !$bIsBase && Loader::includeModule('intec.startshop');
$bIsAjax = false;

if ($oRequest->getIsAjax()) {
    $bIsAjax = $oRequest->get('catalog');
    $bIsAjax = ArrayHelper::getValue($bIsAjax, 'ajax') === 'Y';
}

$arParams = ArrayHelper::merge([
    'SECTIONS_CHILDREN_SECTION_DESCRIPTION_SHOW' => 'Y',
    'SECTIONS_CHILDREN_SECTION_DESCRIPTION_POSITION' => 'top',
    'SECTIONS_CHILDREN_MENU_SHOW' => 'Y',
    'FILTER_AJAX' => 'N'
], $arParams);

include(__DIR__.'/parts/sort.php');

$arIBlock = $arResult['IBLOCK'];
$arSection = $arResult['SECTION'];
$arDescription = [
    'SHOW' => $arParams['SECTIONS_CHILDREN_SECTION_DESCRIPTION_SHOW'] === 'Y',
    'POSITION' => ArrayHelper::fromRange([
        'top',
        'bottom'
    ], $arParams['SECTIONS_CHILDREN_SECTION_DESCRIPTION_POSITION']),
    'VALUE' => !empty($arSection) ? $arSection['DESCRIPTION'] : null
];

if (empty($arDescription['VALUE']))
    $arDescription['SHOW'] = false;

$sLevel = 'CHILDREN';

include(__DIR__.'/parts/menu.php');
include(__DIR__.'/parts/tags.php');
include(__DIR__.'/parts/filter.php');
include(__DIR__.'/parts/sections.php');
include(__DIR__.'/parts/elements.php');

$arMenu['SHOW'] = $arMenu['SHOW'] && $arParams['SECTIONS_CHILDREN_MENU_SHOW'] === 'Y';
$arColumns = [
    'SHOW' => $arMenu['SHOW'] || ($arFilter['SHOW'] && $arFilter['TYPE'] === 'vertical')
];

if ($arColumns['SHOW']) {
    $arSections['PARAMETERS']['WIDE'] = 'N';
    $arElements['PARAMETERS']['WIDE'] = 'N';
}

?>
<div id="<?= $sTemplateId ?>" class="ns-bitrix c-catalog c-catalog-catalog-1 p-section">
    <div class="catalog-wrapper intec-content intec-content-visible">
        <div class="catalog-wrapper-2 intec-content-wrapper">
            <?php if ($arFilter['SHOW'] && $arFilter['TYPE'] === 'horizontal') { ?>
                <?php if ($arTags['SHOW']) { ?>
                    <?php $arTags['SHOW'] = false ?>
                    <?php $APPLICATION->IncludeComponent(
                        'intec.universe:tags.list',
                        $arTags['TEMPLATE'],
                        $arTags['PARAMETERS'],
                        $component
                    ) ?>
                <?php } ?>
                    <?php $APPLICATION->IncludeComponent(
                        'bitrix:catalog.smart.filter',
                        $arFilter['TEMPLATE'],
                        $arFilter['PARAMETERS'],
                        $component
                    ) ?>
            <?php } ?>
            <?= Html::beginTag('div', [
                'class' => 'catalog-content',
                'data' => [
                    'role' => !$arColumns['SHOW'] ? 'content' : null
                ]
            ]) ?>
                <?php if ($arColumns['SHOW']) { ?>
                    <div class="catalog-content-left intec-content-left">
                       
                        <?php if ($arMenu['SHOW']) { ?>
                            <div class="catalog-menu">
                                <?php $APPLICATION->IncludeComponent(
                                    'bitrix:menu',
                                    $arMenu['TEMPLATE'],
                                    $arMenu['PARAMETERS'],
                                    $component
                                ) ?>
                            </div>
                        <?php } ?>
						<br>
						 <?php if ($arFilter['SHOW'] && $arFilter['TYPE'] === 'vertical') { ?>
                                <?php $APPLICATION->IncludeComponent(
                                    'bitrix:catalog.smart.filter',
                                    $arFilter['TEMPLATE'],
                                    $arFilter['PARAMETERS'],
                                    $component
                                ) ?>
                        <?php } ?>
                    </div>
                    <div class="catalog-content-right intec-content-right">
                        <div class="catalog-content-right-wrapper intec-content-right-wrapper" data-role="content">
                <?php } ?>
                <?php if ($arTags['SHOW']) { ?>
                    <?php $APPLICATION->IncludeComponent(
                        'intec.universe:tags.list',
                        $arTags['TEMPLATE'],
                        $arTags['PARAMETERS'],
                        $component
                    ) ?>
                <?php } ?>
                <?php if ($bIsAjax) $APPLICATION->RestartBuffer() ?>
                <?php if ($arDescription['SHOW'] && $arDescription['POSITION'] === 'top') { ?>
                    <div class="<?= Html::cssClassFromArray([
                        'catalog-description',
                        'catalog-description-'.$arDescription['POSITION'],
                        'intec-ui-markup-text'
                    ]) ?>"><?= $arDescription['VALUE'] ?></div>
                <?php } ?>
                <?php if ($arSections['SHOW']) { ?>
                    <?php $APPLICATION->IncludeComponent(
                        'bitrix:catalog.section.list',
                        $arSections['TEMPLATE'],
                        $arSections['PARAMETERS'],
                        $component
                    ) ?>
                <?php } ?>
                <?php if ($arElements['SHOW']) { ?>
                    <?php include(__DIR__.'/parts/panel.php') ?>
                    <?php
                        foreach ($arSort['PROPERTIES'] as $arSortProperty) {
                            if ($arSortProperty['ACTIVE']) {
                                $arElements['PARAMETERS']['ELEMENT_SORT_FIELD'] = $arSortProperty['FIELD'];
                                $arElements['PARAMETERS']['ELEMENT_SORT_ORDER'] = $arSort['ORDER'];

                                break;
                            }
                        }

                        unset($arSortProperty);
                    ?>
                <?php } ?>
                <?php if ($arElements['SHOW'] || !empty($arElements['TEMPLATE'])) { ?>
                    <?php $APPLICATION->IncludeComponent(
                        'bitrix:catalog.section',
                        $arElements['TEMPLATE'],
                        $arElements['PARAMETERS'],
                        $component
                    ) ?>
                <?php } ?>
                <?php if ($arDescription['SHOW'] && $arDescription['POSITION'] === 'bottom') { ?>
                    <div class="<?= Html::cssClassFromArray([
                        'catalog-description',
                        'catalog-description-'.$arDescription['POSITION'],
                        'intec-ui-markup-text'
                    ]) ?>"><?= $arDescription['VALUE'] ?></div>
                <?php } ?>
                <?php if ($bIsAjax) exit() ?>
                <?php if ($arColumns['SHOW']) { ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
            <?= Html::endTag('div') ?>
        </div>
    </div>
    <script type="text/javascript">
        (function () {
            var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
            var filter = $('[data-role="filter"]', root);
            var content = $('[data-role="content"]', root);

            filter.state = false;
            filter.button = $('[data-role="filter.button"]', root);
            filter.button.on('click', function () {
                if (filter.state) {
                    filter.hide();
                } else {
                    filter.show();
                }

                filter.state = !filter.state;
            });

            content.refresh = function (url) {
                if (url == null)
                    url = null;

                $.ajax({
                    'url': url,
                    'data': {
                        'catalog': {
                            'ajax': 'Y'
                        }
                    },
                    'cache': false,
                    'success': function (response) {
                        content.html(response);
                        universe.basket.update();
                    }
                });
            };

            <?php if ($arFilter['SHOW'] && $arFilter['AJAX']) { ?>
                if (smartFilter && smartFilter.on)
                    smartFilter.on('refresh', function (event, url) {
                        if (window.history.enabled || window.history.pushState != null) {
                            window.history.pushState(null, document.title, url);
                        } else {
                            window.location.href = url;
                        }

                        content.refresh(url);
                    });
            <?php } ?>
        })();
    </script>
</div>