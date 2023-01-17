<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 */

$vQuickView = function (&$arItem) use (&$arParams, &$arResult) { ?>
<?php
    $sTemplate = $arResult['QUICK_VIEW']['TEMPLATE'];
    $arParameters = $arResult['QUICK_VIEW']['PARAMETERS'];

    if (empty($sTemplate))
        return;

    if (!empty($arParameters['PROPERTY_CODE']) && Type::isArray($arParameters['PROPERTY_CODE'])) {
        $iCount = 0;
        $arProperties = [];

        foreach ($arParameters['PROPERTY_CODE'] as $sPropertyCode) {
            $sPropertyValue = ArrayHelper::getValue($arItem, ['PROPERTIES', $sPropertyCode, 'VALUE']);

            if (empty($sPropertyValue) && !Type::isNumeric($sPropertyValue))
                continue;

            $arProperties[] = $sPropertyCode;
            $iCount++;

            if ($iCount >= 10)
                break;
        }

        $arParameters['PROPERTY_CODE'] = $arProperties;
    }

    $arParameters = ArrayHelper::merge($arParameters, [
        'ELEMENT_ID' => $arItem['ID'],
        'ELEMENT_CODE' => $arItem['CODE'],
        'SECTION_ID' => $arItem['IBLOCK_SECTION_ID'],
        'SECTION_CODE' => null
    ]);
?>
    <div class="widget-item-quick-view" onclick="universe.components.show(<?= JavaScript::toObject([
        'component' => 'bitrix:catalog.element',
        'template' => $sTemplate,
        'parameters' => $arParameters,
        'settings' => [
            'parameters' => [
                'className' => 'popup-window-quick-view',
                'width' => null
            ]
        ]
    ]) ?>)">
        <div class="intec-aligner"></div>
        <div class="widget-item-quick-view-button">
            <div class="widget-item-quick-view-button-icon">
                <i class="intec-ui-icon intec-ui-icon-eye-1"></i>
            </div>
            <div class="widget-item-quick-view-button-text">
                <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_2_QUICK_VIEW') ?>
            </div>
        </div>
    </div>
<?php };