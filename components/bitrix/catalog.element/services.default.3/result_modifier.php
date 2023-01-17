<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!Loader::includeModule('intec.core'))
    return;

$arParams = ArrayHelper::merge([
    'BLOCKS' => [],
    'BLOCKS_ORDER' => '',
    'PROPERTY_PRICE' => null,
    'PROPERTY_CURRENCY' => null,
    'PRICE_FORMAT' => '#VALUE# #CURRENCY#',
    'BLOCKS_BANNER_WIDE' => 'Y',
    'BLOCKS_BANNER_SPLIT' => 'N',
    'BLOCKS_BANNER_PRICE_TITLE' => null,
    'BLOCKS_BANNER_TEXT_SHOW' => 'Y',
    'BLOCKS_BANNER_ORDER_BUTTON_SHOW' => null,
    'BLOCKS_BANNER_ORDER_BUTTON_TEXT' => null,
    'BLOCKS_BANNER_ORDER_FORM_ID' => null,
    'BLOCKS_BANNER_ORDER_FORM_TEMPLATE' => null,
    'BLOCKS_BANNER_ORDER_FORM_SERVICE' => null,
    'BLOCKS_BANNER_ORDER_FORM_CONSENT' => null,
    'BLOCKS_DESCRIPTION_1_HEADER' => null,
    'BLOCKS_DESCRIPTION_1_PROPERTY_HEADER' => null,
    'BLOCKS_DESCRIPTION_1_HEADER_POSITION' => null,
    'BLOCKS_ICONS_1_HEADER' => null,
    'BLOCKS_ICONS_1_PROPERTY_HEADER' => null,
    'BLOCKS_ICONS_1_HEADER_POSITION' => null,
    'BLOCKS_ICONS_1_IBLOCK_TYPE' => null,
    'BLOCKS_ICONS_1_IBLOCK_ID' => null,
    'BLOCKS_ICONS_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_GALLERY_1_HEADER' => null,
    'BLOCKS_GALLERY_1_PROPERTY_HEADER' => null,
    'BLOCKS_GALLERY_1_HEADER_POSITION' => null,
    'BLOCKS_GALLERY_1_IBLOCK_TYPE' => null,
    'BLOCKS_GALLERY_1_IBLOCK_ID' => null,
    'BLOCKS_GALLERY_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_PROPERTIES_1_HEADER' => null,
    'BLOCKS_PROPERTIES_1_PROPERTY_HEADER' => null,
    'BLOCKS_PROPERTIES_1_HEADER_POSITION' => null,
    'BLOCKS_PROPERTIES_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_DOCUMENTS_1_HEADER' => null,
    'BLOCKS_DOCUMENTS_1_PROPERTY_HEADER' => null,
    'BLOCKS_DOCUMENTS_1_HEADER_POSITION' => null,
    'BLOCKS_DOCUMENTS_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_VIDEOS_1_HEADER' => null,
    'BLOCKS_VIDEOS_1_PROPERTY_HEADER' => null,
    'BLOCKS_VIDEOS_1_HEADER_POSITION' => null,
    'BLOCKS_VIDEOS_1_IBLOCK_TYPE' => null,
    'BLOCKS_VIDEOS_1_IBLOCK_ID' => null,
    'BLOCKS_VIDEOS_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_VIDEOS_1_PROPERTY_LINK' => null,
    'BLOCKS_PROJECTS_1_HEADER' => null,
    'BLOCKS_PROJECTS_1_PROPERTY_HEADER' => null,
    'BLOCKS_PROJECTS_1_HEADER_POSITION' => null,
    'BLOCKS_PROJECTS_1_IBLOCK_TYPE' => null,
    'BLOCKS_PROJECTS_1_IBLOCK_ID' => null,
    'BLOCKS_PROJECTS_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_REVIEWS_1_HEADER' => null,
    'BLOCKS_REVIEWS_1_PROPERTY_HEADER' => null,
    'BLOCKS_REVIEWS_1_HEADER_POSITION' => null,
    'BLOCKS_REVIEWS_1_IBLOCK_TYPE' => null,
    'BLOCKS_REVIEWS_1_IBLOCK_ID' => null,
    'BLOCKS_REVIEWS_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_REVIEWS_1_PROPERTY_POSITION' => null,
    'BLOCKS_SERVICES_1_HEADER' => null,
    'BLOCKS_SERVICES_1_PROPERTY_HEADER' => null,
    'BLOCKS_SERVICES_1_HEADER_POSITION' => null,
    'BLOCKS_SERVICES_1_IBLOCK_TYPE' => null,
    'BLOCKS_SERVICES_1_IBLOCK_ID' => null,
    'BLOCKS_SERVICES_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_PRODUCTS_1_HEADER' => null,
    'BLOCKS_PRODUCTS_1_PROPERTY_HEADER' => null,
    'BLOCKS_PRODUCTS_1_HEADER_POSITION' => null,
    'BLOCKS_PRODUCTS_1_IBLOCK_TYPE' => null,
    'BLOCKS_PRODUCTS_1_IBLOCK_ID' => null,
    'BLOCKS_PRODUCTS_1_PROPERTY_ELEMENTS' => null,
    'BLOCKS_PRODUCTS_1_PRICE_CODE' => null

], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

include(__DIR__.'/modifiers/blocks.php');
include(__DIR__.'/modifiers/properties.php');

$fGetPropertyValue = function ($sName, $bRaw = false) use (&$arResult) {
    $mValue = null;

    if (empty($arResult['PROPERTIES'][$sName]))
        return $mValue;

    $arProperty = $arResult['PROPERTIES'][$sName];

    if (!empty($arProperty['USER_TYPE']) && !$bRaw) {
        $arProperty = CIBlockFormatProperties::GetDisplayValue($arResult, $arProperty, 'services_out');

        if (!empty($arProperty['DISPLAY_VALUE'])) {
            $mValue = $arProperty['DISPLAY_VALUE'];
        } else {
            $mValue = $arProperty['VALUE'];
        }
    } else {
        $mValue = $bRaw ? $arProperty['~VALUE'] : $arProperty['VALUE'];
    }

    return $mValue;
};

$arPrice = [
    'VALUE' => $fGetPropertyValue($arParams['PROPERTY_PRICE']),
    'CURRENCY' => ' ' . $fGetPropertyValue($arParams['PROPERTY_CURRENCY']),
    'PRICE_FORMAT' => $fGetPropertyValue($arParams['PROPERTY_PRICE_FORMAT'])
];

if (empty($arPrice['PRICE_FORMAT']))
    $arPrice['PRICE_FORMAT'] = $arParams['PRICE_FORMAT'];

$arPrice['VALUE'] = number_format($arPrice['VALUE'], 0, '', ' ');
$arPrice['VALUE'] = StringHelper::replaceMacros($arPrice['PRICE_FORMAT'], ['VALUE' => $arPrice['VALUE'],'CURRENCY' => $arPrice['CURRENCY']]);

$arResult['PRICE'] = $arPrice;

/** Блок banner */
$arBlock = &$arResult['BLOCKS']['banner'];

if ($arBlock['ACTIVE']) {
    $arBlock['WIDE'] = $arParams['BLOCKS_BANNER_WIDE'] === 'Y';
    $arBlock['SPLIT'] = $arParams['BLOCKS_BANNER_SPLIT'] === 'Y';
    $arBlock['NAME'] = $arResult['NAME'];
    $arBlock['TEXT'] = [
        'SHOW' => $arParams['BLOCKS_BANNER_TEXT_SHOW'] === 'Y',
        'VALUE' => $arResult['PREVIEW_TEXT']
    ];
    $arBlock['PRICE'] = [
        'TITLE' => $arParams['BLOCKS_BANNER_PRICE_TITLE']
    ];
    $arBlock['BUTTON']['SHOW'] = $fGetPropertyValue($arParams['BLOCKS_BANNER_PROPERTY_ORDER_BUTTON_SHOW']) === 'Y';

    if ($arBlock['BUTTON']['SHOW']) {
        $arBlock['BUTTON']['TEXT'] = $arParams['BLOCKS_BANNER_ORDER_BUTTON_TEXT'];
        $arBlock['FORM'] = [
            'ID' => $arParams['BLOCKS_BANNER_ORDER_FORM_ID'],
            'TEMPLATE' => $arParams['BLOCKS_BANNER_ORDER_FORM_TEMPLATE'],
            'SERVICE' => $arParams['BLOCKS_BANNER_ORDER_FORM_SERVICE'],
            'CONSENT' => $arParams['BLOCKS_BANNER_ORDER_FORM_CONSENT']
        ];
    }

    if (!empty($arResult['DETAIL_PICTURE'])) {
        $arBlock['PICTURE'] = $arResult['DETAIL_PICTURE'];
    } else if (!empty($arResult['PREVIEW_PICTURE'])) {
        $arBlock['PICTURE'] = $arResult['PREVIEW_PICTURE'];
    } else {
        $arBlock['PICTURE']['SRC'] = SITE_TEMPLATE_PATH.'/images/picture.missing.png';
    }
}

/** Блок description.1 */
$arBlock = &$arResult['BLOCKS']['description.1'];

if ($arBlock['ACTIVE']) {
    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_DESCRIPTION_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_DESCRIPTION_1_HEADER_POSITION']
    ];
    $arBlock['TEXT'] = [
        'VALUE' => $arResult['DETAIL_TEXT']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_DESCRIPTION_1_HEADER'];
}

/** Блок icons.1 */
$arBlock = &$arResult['BLOCKS']['icons.1'];

if ($arBlock['ACTIVE']) {
    $sPrefix = 'BLOCKS_ICONS_1_';
    $arBlock['IBLOCK'] = [
        'TYPE' => $arParams['BLOCKS_ICONS_1_IBLOCK_TYPE'],
        'ID' => $arParams['BLOCKS_ICONS_1_IBLOCK_ID'],
        'ELEMENTS' => $fGetPropertyValue($arParams['BLOCKS_ICONS_1_PROPERTY_ELEMENTS'], true)
    ];

    $arBlock['PARAMETERS'] = [];

    foreach ($arParams as $sKey => $mValue) {
        if (!StringHelper::startsWith($sKey, $sPrefix))
            continue;

        $sKey = StringHelper::cut(
            $sKey,
            StringHelper::length($sPrefix)
        );

        $arBlock['PARAMETERS'][$sKey] = $mValue;
    }

    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_ICONS_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_ICONS_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_ICONS_1_HEADER'];

    if (!empty($arBlock['IBLOCK']['ELEMENTS']) && !Type::isArray($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['IBLOCK']['ELEMENTS'] = [$arBlock['IBLOCK']['ELEMENTS']];

    if (empty($arBlock['IBLOCK']['ID']) || empty($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['ACTIVE'] = false;
}

/** Блок gallery.1 */
$arBlock = &$arResult['BLOCKS']['gallery.1'];

if ($arBlock['ACTIVE']) {
    $arBlock['IBLOCK'] = [
        'TYPE' => $arParams['BLOCKS_GALLERY_1_IBLOCK_TYPE'],
        'ID' => $arParams['BLOCKS_GALLERY_1_IBLOCK_ID'],
        'ELEMENTS' => $fGetPropertyValue($arParams['BLOCKS_GALLERY_1_PROPERTY_ELEMENTS'], true),
        'PROPERTIES' => [
            'LINK' => $arParams['BLOCKS_GALLERY_1_PROPERTY_LINK']
        ]
    ];

    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_GALLERY_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_GALLERY_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_GALLERY_1_HEADER'];

    if (!empty($arBlock['IBLOCK']['ELEMENTS']) && !Type::isArray($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['IBLOCK']['ELEMENTS'] = [$arBlock['IBLOCK']['ELEMENTS']];

    if (empty($arBlock['IBLOCK']['ID']) || empty($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['ACTIVE'] = false;
}

/** Блок properties.1 */
$arBlock = &$arResult['BLOCKS']['properties.1'];

if ($arBlock['ACTIVE']) {
    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_PROPERTIES_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_PROPERTIES_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_PROPERTIES_1_HEADER'];

    if (empty($arResult['DISPLAY_PROPERTIES']))
        $arBlock['ACTIVE'] = false;
}

/** Блок documents.1 */
$arBlock = &$arResult['BLOCKS']['documents.1'];

if ($arBlock['ACTIVE']) {
    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_DOCUMENTS_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_DOCUMENTS_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_DOCUMENTS_1_HEADER'];

    $arProperty = ArrayHelper::getValue($arResult['PROPERTIES'], $arParams['BLOCKS_DOCUMENTS_1_PROPERTY_FILES']);

    foreach ($arProperty['VALUE'] as $iKey => $arFile) {
        $arBlock['DOCUMENTS'][$iKey] = $arFile;
    }

    if (empty($arBlock['DOCUMENTS']))
        $arBlock['ACTIVE'] = false;

    unset($arProperty);
}

/** Блок videos.1 */
$arBlock = &$arResult['BLOCKS']['videos.1'];

if ($arBlock['ACTIVE']) {
    $arBlock['IBLOCK'] = [
        'TYPE' => $arParams['BLOCKS_VIDEOS_1_IBLOCK_TYPE'],
        'ID' => $arParams['BLOCKS_VIDEOS_1_IBLOCK_ID'],
        'ELEMENTS' => $fGetPropertyValue($arParams['BLOCKS_VIDEOS_1_PROPERTY_ELEMENTS'], true),
        'PROPERTIES' => [
            'LINK' => $arParams['BLOCKS_VIDEOS_1_PROPERTY_LINK']
        ]
    ];

    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_VIDEOS_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_VIDEOS_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_VIDEOS_1_HEADER'];

    if (!empty($arBlock['IBLOCK']['ELEMENTS']) && !Type::isArray($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['IBLOCK']['ELEMENTS'] = [$arBlock['IBLOCK']['ELEMENTS']];

    if (empty($arBlock['IBLOCK']['ID']) || empty($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['ACTIVE'] = false;
}

/** Блок form.1 */
$arBlock = &$arResult['BLOCKS']['form.1'];

if ($arBlock['ACTIVE']) {
    $sPrefix = 'BLOCKS_FORM_1_';

    $arBlock['PARAMETERS'] = [];

    foreach ($arParams as $sKey => $mValue) {
        if (!StringHelper::startsWith($sKey, $sPrefix))
            continue;

        $sKey = StringHelper::cut(
            $sKey,
            StringHelper::length($sPrefix)
        );

        $arBlock['PARAMETERS'][$sKey] = $mValue;
    }
}

/** Блок projects.1 */
$arBlock = &$arResult['BLOCKS']['projects.1'];

if ($arBlock['ACTIVE']) {
    $arBlock['IBLOCK'] = [
        'TYPE' => $arParams['BLOCKS_PROJECTS_1_IBLOCK_TYPE'],
        'ID' => $arParams['BLOCKS_PROJECTS_1_IBLOCK_ID'],
        'ELEMENTS' => $fGetPropertyValue($arParams['BLOCKS_PROJECTS_1_PROPERTY_ELEMENTS'], true)
    ];

    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_PROJECTS_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_PROJECTS_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_PROJECTS_1_HEADER'];

    if (!empty($arBlock['IBLOCK']['ELEMENTS']) && !Type::isArray($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['IBLOCK']['ELEMENTS'] = [$arBlock['IBLOCK']['ELEMENTS']];

    if (empty($arBlock['IBLOCK']['ID']) || empty($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['ACTIVE'] = false;
}

/** Блок reviews.1 */
$arBlock = &$arResult['BLOCKS']['reviews.1'];

if ($arBlock['ACTIVE']) {
    $arBlock['IBLOCK'] = [
        'TYPE' => $arParams['BLOCKS_REVIEWS_1_IBLOCK_TYPE'],
        'ID' => $arParams['BLOCKS_REVIEWS_1_IBLOCK_ID'],
        'ELEMENTS' => $fGetPropertyValue($arParams['BLOCKS_REVIEWS_1_PROPERTY_ELEMENTS'], true),
        'PROPERTIES' => [
            'POSITION' => $arParams['BLOCKS_REVIEWS_1_PROPERTY_POSITION']
        ]
    ];

    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_REVIEWS_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_REVIEWS_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_REVIEWS_1_HEADER'];

    if (!empty($arBlock['IBLOCK']['ELEMENTS']) && !Type::isArray($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['IBLOCK']['ELEMENTS'] = [$arBlock['IBLOCK']['ELEMENTS']];

    if (empty($arBlock['IBLOCK']['ID']) || empty($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['ACTIVE'] = false;
}

/** Блок services.1 */
$arBlock = &$arResult['BLOCKS']['services.1'];

if ($arBlock['ACTIVE']) {
    $sPrefix = 'BLOCKS_SERVICES_1_';
    $arBlock['IBLOCK'] = [
        'TYPE' => $arParams['BLOCKS_SERVICES_1_IBLOCK_TYPE'],
        'ID' => $arParams['BLOCKS_SERVICES_1_IBLOCK_ID'],
        'ELEMENTS' => $fGetPropertyValue($arParams['BLOCKS_SERVICES_1_PROPERTY_ELEMENTS'], true),
    ];

    $arBlock['PROPERTY_PRICE'] = $arParams['PROPERTY_PRICE'];
    $arBlock['PROPERTY_CURRENCY'] = $arParams['PROPERTY_CURRENCY'];
    $arBlock['PROPERTY_PRICE_FORMAT'] = $arParams['PROPERTY_PRICE_FORMAT'];
    $arBlock['PRICE_FORMAT'] = $arParams['PRICE_FORMAT'];

    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_SERVICES_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_SERVICES_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_SERVICES_1_HEADER'];

    if (!empty($arBlock['IBLOCK']['ELEMENTS']) && !Type::isArray($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['IBLOCK']['ELEMENTS'] = [$arBlock['IBLOCK']['ELEMENTS']];

    if (empty($arBlock['IBLOCK']['ID']) || empty($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['ACTIVE'] = false;
}

/** Блок products.1 */
$arBlock = &$arResult['BLOCKS']['products.1'];

if ($arBlock['ACTIVE']) {
    $sPrefix = 'BLOCKS_PRODUCTS_1_';
    $arBlock['IBLOCK'] = [
        'TYPE' => $arParams['BLOCKS_PRODUCTS_1_IBLOCK_TYPE'],
        'ID' => $arParams['BLOCKS_PRODUCTS_1_IBLOCK_ID'],
        'ELEMENTS' => $fGetPropertyValue($arParams['BLOCKS_PRODUCTS_1_PROPERTY_ELEMENTS'], true),
    ];

    $arBlock['PRICE_CODE'] = $arParams['BLOCKS_PRODUCTS_1_PRICE_CODE'];

    $arBlock['HEADER'] = [
        'VALUE' =>$fGetPropertyValue($arParams['BLOCKS_PRODUCTS_1_PROPERTY_HEADER']),
        'POSITION' => $arParams['BLOCKS_PRODUCTS_1_HEADER_POSITION']
    ];

    if (empty($arBlock['HEADER']['VALUE']))
        $arBlock['HEADER']['VALUE'] = $arParams['BLOCKS_PRODUCTS_1_HEADER'];

    if (!empty($arBlock['IBLOCK']['ELEMENTS']) && !Type::isArray($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['IBLOCK']['ELEMENTS'] = [$arBlock['IBLOCK']['ELEMENTS']];

    if (empty($arBlock['IBLOCK']['ID']) || empty($arBlock['IBLOCK']['ELEMENTS']))
        $arBlock['ACTIVE'] = false;
}

unset($arBlock);