<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

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

$bBase = false;
$bLite = false;

if (Loader::includeModule('catalog') && Loader::includeModule('sale'))
    $bBase = true;
else if (Loader::includeModule('intec.startshop'))
    $bLite = true;

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

$arParams = ArrayHelper::merge([
    'PROPERTY_MARKS_HIT' => null,
    'PROPERTY_MARKS_NEW' => null,
    'PROPERTY_MARKS_RECOMMEND' => null,
    'PROPERTY_ARTICLE' => null,
    'PROPERTY_BRAND' => null,
    'PROPERTY_PICTURES' => null,
    'PROPERTY_SERVICES' => null,
    'PROPERTY_DOCUMENTS' => null,
    'PROPERTY_VIDEO' => null,
    'PROPERTY_ASSOCIATED' => null,
    'PROPERTY_RECOMMENDED' => null,
    'OFFERS_PROPERTY_ARTICLE' => null,
    'OFFERS_PROPERTY_PICTURES' => null,
    'ARTICLE_SHOW' => 'Y',
    'BRAND_SHOW' => 'Y',
    'VIDEO_IBLOCK_TYPE' => null,
    'VIDEO_IBLOCK_ID' => null,
    'VIDEO_PROPERTY_URL' => 'LINK',
    'REVIEWS_IBLOCK_TYPE' => null,
    'REVIEWS_IBLOCK_ID' => 	null,
    'REVIEWS_PROPERTY_ELEMENT_ID' => null,
    'REVIEWS_MAIL_EVENT' => null,
    'REVIEWS_USE_CAPTCHA' => 'Y',
    'REVIEWS_SHOW' => 'Y',
    'SERVICES_IBLOCK_TYPE' => null,
    'SERVICES_IBLOCK_ID' => null,
    'SERVICES_PROPERTY_PRICE' => 'SYSTEM_PRICE',
    'ORDER_FAST_USE' => 'N',
    'ORDER_FAST_TEMPLATE' => null,
    'VIEW' => 'wide',
    'VIEW_TABS_POSITION' => 'top',
    'PANEL_SHOW' => 'N',
    'ACTION' => 'none',
    'VOTE_SHOW' => 'Y',
    'VOTE_MODE' => 'rating',
    'QUANTITY_SHOW' => 'Y',
    'QUANTITY_MODE' => 'number',
    'SERVICES_SHOW' => 'Y',
    'DOCUMENTS_SHOW' => 'Y',
    'ASSOCIATED_SHOW' => 'Y',
    'RECOMMENDED_SHOW' => 'Y',
    'MARKS_SHOW' => 'Y',
    'GALLERY_SHOW' => 'Y',
    'GALLERY_ZOOM' => 'Y',
    'GALLERY_POPUP' => 'Y',
    'GALLERY_PANEL' => 'Y',
    'COUNTER_SHOW' => 'Y',
    'STORES_SHOW' => 'Y',
    'SETS_SHOW' => 'Y',
    'PROPERTIES_DETAIL_SHOW' => 'Y',
    'PRICE_EXTENDED' => 'N',
    'PRICE_RANGE' => 'N',
    'FORM_ID' => null,
    'FORM_TEMPLATE' => null,
    'FORM_PROPERTY_PRODUCT' => null,
    'BASKET_URL' => null,
    'COMPARE_URL' => null,
    'USE_STORE' => 'N',

    'WIDE' => 'Y'
], $arParams);

$arVisual = [
    'ARTICLE' => [
        'SHOW' => $arParams['ARTICLE_SHOW'] === 'Y'
    ],
    'BRAND' => [
        'SHOW' => $arParams['BRAND_SHOW'] === 'Y'
    ],
    'COUNTER' => [
        'SHOW' => $arParams['COUNTER_SHOW'] === 'Y'
    ],
    'QUANTITY' => [
        'SHOW' => ArrayHelper::getValue($arParams, 'QUANTITY_SHOW') === 'Y',
        'MODE' => ArrayHelper::fromRange(['number', 'text', 'logic'], ArrayHelper::getValue($arParams, 'QUANTITY_MODE')),
        'BOUNDS' => [
            'FEW' => ArrayHelper::getValue($arParams, 'QUANTITY_BOUNDS_FEW'),
            'MANY' => ArrayHelper::getValue($arParams, 'QUANTITY_BOUNDS_MANY')
        ]
    ],
    'STORES' => [
        'SHOW' => $arParams['USE_STORE'] === 'Y' && $arParams['STORES_SHOW'] === 'Y'
    ],
    'SETS' => [
        'SHOW' => $arParams['SETS_SHOW'] === 'Y'
    ],
    'MARKS' => [
        'SHOW' => $arParams['MARKS_SHOW'] === 'Y'
    ],
    'GALLERY' => [
        'SHOW' => $arParams['GALLERY_SHOW'] === 'Y',
        'ZOOM' => $arParams['GALLERY_ZOOM'] === 'Y',
        'POPUP' => $arParams['GALLERY_POPUP'] === 'Y',
        'SLIDER' => $arParams['GALLERY_SLIDER'] === 'Y'
    ],
    'DESCRIPTION' => [
        'PREVIEW' => [
            'SHOW' => $arParams['DESCRIPTION_PREVIEW_SHOW'] === 'Y'
        ],
        'DETAIL' => [
            'SHOW' => $arParams['DESCRIPTION_DETAIL_SHOW'] === 'Y'
        ]
    ],
    'PROPERTIES' => [
        'PREVIEW' => [
            'SHOW' => $arParams['PROPERTIES_PREVIEW_SHOW'] === 'Y',
            'COUNT' => $arParams['PROPERTIES_PREVIEW_COUNT'],
        ],
        'DETAIL' => [
            'SHOW' => $arParams['PROPERTIES_DETAIL_SHOW'] === 'Y'
        ]
    ],
    'DOCUMENTS' => [
        'SHOW' => $arParams['DOCUMENTS_SHOW'] === 'Y'
    ],
    'VIDEO' => [
        'SHOW' => $arParams['VIDEO_SHOW'] === 'Y'
    ],
    'REVIEWS' => [
        'SHOW' => $arParams['REVIEWS_SHOW'] === 'Y'
    ],
    'ASSOCIATED' => [
        'SHOW' => $arParams['ASSOCIATED_SHOW'] === 'Y'
    ],
    'RECOMMENDED' => [
        'SHOW' => $arParams['RECOMMENDED_SHOW'] === 'Y'
    ],
    'SERVICES' => [
        'SHOW' => $arParams['SERVICES_SHOW'] === 'Y'
    ],
    'VIEW' => [
        'VALUE' => ArrayHelper::fromRange([
            'wide',
            'tabs'
        ], $arParams['VIEW'])
    ],
    'WIDE' => $arParams['WIDE'] === 'Y',
    'PANEL' => [
        'SHOW' => $arParams['PANEL_SHOW'] === 'Y'
    ],
    'VOTE' => [
        'SHOW' => $arParams['VOTE_SHOW'] === 'Y',
        'MODE' => ArrayHelper::fromRange(['average', 'rating'], $arParams['VOTE_MODE'])
    ],
    'PRICE' => [
        'EXTENDED' => $arParams['PRICE_EXTENDED'] === 'Y',
        'RANGE' => $arParams['PRICE_RANGE'] === 'Y'
    ],
    'FORM' => [
        'SHOW' => $arParams['FORM_SHOW'] === 'Y'
    ]
];

if ($arVisual['VIEW']['VALUE'] === 'tabs') {
    $arVisual['VIEW']['POSITION'] = ArrayHelper::fromRange([
        'top',
        'right'
    ], $arParams['VIEW_TABS_POSITION']);
}

if (empty($arResult['PREVIEW_TEXT']))
    $arVisual['DESCRIPTION']['PREVIEW']['SHOW'] = false;

if (empty($arResult['DETAIL_TEXT']))
    $arVisual['DESCRIPTION']['DETAIL']['SHOW'] = false;

if (empty($arParams['WEB_FORM_ID']) || empty($arParams['WEB_FORM_TEMPLATE']))
    $arVisual['FORM']['SHOW'] = false;

$arResult['ACTION'] = ArrayHelper::fromRange([
    'none',
    'buy',
    'order'
], $arParams['ACTION']);

$arResult['COMPARE'] = [
    'USE' => $arParams['USE_COMPARE'] === 'Y',
    'CODE' => $arParams['COMPARE_NAME']
];

if (empty($arResult['COMPARE']['CODE']))
    $arResult['COMPARE']['USE'] = false;

$arResult['DELAY'] = [
    'USE' => $arParams['DELAY_USE'] === 'Y'
];

$arResult['FORM'] = [
    'SHOW' => $arResult['ACTION'] === 'order',
    'ID' => $arParams['FORM_ID'],
    'TEMPLATE' => $arParams['FORM_TEMPLATE'],
    'PROPERTIES' => [
        'PRODUCT' => $arParams['FORM_PROPERTY_PRODUCT']
    ]
];

$arResult['URL'] = [
    'BASKET' => $arParams['BASKET_URL'],
    'CONSENT' => $arParams['CONSENT_URL']
];

foreach ($arResult['URL'] as $sKey => $sUrl)
    $arResult['URL'][$sKey] = StringHelper::replaceMacros($sUrl, $arMacros);

if ($bLite) {
    $arResult['DELAY']['USE'] = false;
    $arVisual['SETS']['SHOW'] = false;
    $arVisual['STORES']['SHOW'] = false;

    include(__DIR__.'/modifiers/lite/catalog.php');
}

include(__DIR__.'/modifiers/fields.php');
include(__DIR__.'/modifiers/pictures.php');
include(__DIR__.'/modifiers/order.fast.php');
include(__DIR__.'/modifiers/marks.php');

if ($arResult['ACTION'] !== 'buy') {
    $arResult['ORDER_FAST']['USE'] = false;
    $arVisual['COUNTER']['SHOW'] = false;
}

if (empty($arResult['BRAND']))
    $arVisual['BRAND']['SHOW'] = false;

if (empty($arResult['DOCUMENTS']))
    $arVisual['DOCUMENTS']['SHOW'] = false;

if (empty($arResult['VIDEO']) || empty($arParams['VIDEO_IBLOCK_ID']))
    $arVisual['VIDEO']['SHOW'] = false;

if (empty($arResult['ASSOCIATED']))
    $arVisual['ASSOCIATED']['SHOW'] = false;

if (empty($arResult['RECOMMENDED']))
    $arVisual['RECOMMENDED']['SHOW'] = false;

if (empty($arResult['SERVICES']) || empty($arParams['SERVICES_IBLOCK_ID']))
    $arVisual['SERVICES']['SHOW'] = false;

if ($bBase)
    include(__DIR__.'/modifiers/base/catalog.php');

if ($bBase || $bLite)
    include(__DIR__.'/modifiers/catalog.php');

include(__DIR__.'/modifiers/properties.php');

if (empty($arResult['DISPLAY_PROPERTIES'])) {
    $arVisual['PROPERTIES']['PREVIEW']['SHOW'] = false;
    $arVisual['PROPERTIES']['DETAIL']['SHOW'] = false;
} else {
    if ($arVisual['PROPERTIES']['PREVIEW']['SHOW']) {
        $arVisual['PROPERTIES']['PREVIEW']['SHOW'] = false;

        foreach ($arResult['DISPLAY_PROPERTIES'] as &$arProperty)
            if (empty($arProperty['USER_TYPE'])) {
                $arVisual['PROPERTIES']['PREVIEW']['SHOW'] = true;
                break;
            }

        unset($arProperty);
    }
}

$arVisual['SECTIONS'] = [
    'DESCRIPTION' => $arVisual['DESCRIPTION']['DETAIL']['SHOW'],
    'STORES' => $arVisual['STORES']['SHOW'],
    'PROPERTIES' => $arVisual['PROPERTIES']['DETAIL']['SHOW'],
    'DOCUMENTS' => $arVisual['DOCUMENTS']['SHOW'],
    'VIDEO' => $arVisual['VIDEO']['SHOW'],
    'REVIEWS' => $arVisual['REVIEWS']['SHOW']
];

$bSections = false;

foreach ($arVisual['SECTIONS'] as $bSection)
    if ($bSection) { $bSections = true; break; }

if (!$bSections)
    $arVisual['SECTIONS'] = [];

unset($bSection);
unset($bSections);

$arResult['VISUAL'] = $arVisual;