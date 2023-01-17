<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\base\Collection;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

$arParams = ArrayHelper::merge([
    'BLOCKS_USE' => 'N',
    'BLOCKS_IBLOCK_TYPE' => null,
    'BLOCKS_IBLOCK_ID' => null,
    'BLOCKS_MODE' => 'N',
    'BLOCKS_SECTIONS' => [],
    'BLOCKS_ELEMENTS_COUNT' => 2,
    'PROPERTY_HEADER_OVER' => null,
    'PROPERTY_LINK' => null,
    'PROPERTY_LINK_BLANK' => null,
    'PROPERTY_BUTTON_SHOW' => null,
    'PROPERTY_BUTTON_TEXT' => null,
    'PROPERTY_SCHEME' => null,
    'PROPERTY_FADE' => null,
    'PROPERTY_VIDEO' => null,
    'PROPERTY_VIDEO_FILE_MP4' => null,
    'PROPERTY_VIDEO_FILE_WEBM' => null,
    'PROPERTY_VIDEO_FILE_OGV' => null,
    'BLOCKS_PROPERTY_LINK' => null,
    'BLOCKS_PROPERTY_LINK_BLANK' => null,
    'HEIGHT' => 600,
    'WIDE' => 'N',
    'HEADER_SHOW' => 'N',
    'HEADER_VIEW' => 1,
    'DESCRIPTION_SHOW' => 'N',
    'DESCRIPTION_VIEW' => 1,
    'HEADER_OVER_SHOW' => 'N',
    'HEADER_OVER_VIEW' => 1,
    'BUTTON_VIEW' => 1,
    'VIDEO_SHOW' => 'N',
    'BLOCKS_EFFECT_FADE' => 'N',
    'BLOCKS_EFFECT_SCALE' => 'N',
    'SLIDER_NAV_SHOW' => 'N',
    'SLIDER_NAV_VIEW' => 1,
    'SLIDER_DOTS_SHOW' => 'N',
    'SLIDER_DOTS_VIEW' => 1,
    'SLIDER_LOOP' => 'N',
    'SLIDER_AUTO_USE' => 'N',
    'SLIDER_AUTO_TIME' => 10000,
    'SLIDER_AUTO_HOVER' => 'N',
    'ATTRIBUTE' => null,
    '~ATTRIBUTE' => null,
    'SELECTOR' => null,
    '~SELECTOR' => null
], $arParams);

$arVisual = [
    'HEIGHT' => Type::toInteger($arParams['HEIGHT']),
    'WIDE' => $arParams['WIDE'] === 'Y',
    'OVER' => [
        'SHOW' => $arParams['HEADER_OVER_SHOW'] === 'Y' && !empty($arParams['PROPERTY_HEADER_OVER']),
        'VIEW' => ArrayHelper::fromRange([1], $arParams['HEADER_OVER_VIEW'])
    ],
    'HEADER' => [
        'SHOW' => $arParams['HEADER_SHOW'] === 'Y' && !empty($arParams['PROPERTY_HEADER']),
        'VIEW' => ArrayHelper::fromRange([1, 2, 3, 4, 5], $arParams['HEADER_VIEW'])
    ],
    'DESCRIPTION' => [
        'SHOW' => $arParams['DESCRIPTION_SHOW'] === 'Y' && !empty($arParams['PROPERTY_DESCRIPTION']),
        'VIEW' => ArrayHelper::fromRange([1, 2, 3, 4, 5], $arParams['DESCRIPTION_VIEW'])
    ],
    'BUTTON' => [
        'VIEW' => ArrayHelper::fromRange([1, 2, 3, 4], $arParams['BUTTON_VIEW'])
    ],
    'VIDEO' => [
        'SHOW' => $arParams['VIDEO_SHOW'] === 'Y' && !empty($arParams['PROPERTY_VIDEO'])
    ],
    'BLOCKS' => [
        'USE' => $arParams['BLOCKS_USE'] === 'Y' && !empty($arParams['BLOCKS_IBLOCK_ID']),
        'EFFECT' => [
            'FADE' => $arParams['BLOCKS_EFFECT_FADE'] === 'Y',
            'SCALE' => $arParams['BLOCKS_EFFECT_SCALE'] === 'Y'
        ]
    ],
    'SLIDER' => [
        'NAV' => [
            'SHOW' => $arParams['SLIDER_NAV_SHOW'] === 'Y',
            'VIEW' => ArrayHelper::fromRange([1], $arParams['SLIDER_NAV_VIEW'])
        ],
        'DOTS' => [
            'SHOW' => $arParams['SLIDER_DOTS_SHOW'] === 'Y',
            'VIEW' => ArrayHelper::fromRange([1, 2], $arParams['SLIDER_DOTS_VIEW'])
        ],
        'LOOP' => $arParams['SLIDER_LOOP'] === 'Y',
        'AUTO' => [
            'USE' => $arParams['SLIDER_AUTO_USE'] === 'Y',
            'TIME' => Type::toInteger($arParams['SLIDER_AUTO_TIME']),
            'HOVER' => $arParams['SLIDER_AUTO_HOVER'] === 'Y'
        ]
    ]
];

if ($arVisual['HEIGHT'] < 1)
    $arVisual['HEIGHT'] = 600;

if ($arVisual['SLIDER']['AUTO']['TIME'] < 1)
    $arVisual['SLIDER']['AUTO']['TIME'] = 10000;

$arResult['VISUAL'] = $arVisual;

unset($arVisual);

$arFiles = Collection::from([]);

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['DATA'] = [];

    if (!empty($arParams['PROPERTY_HEADER_OVER'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_HEADER_OVER']
        ]);

        if (!empty($arProperty['VALUE'])) {
            $arProperty = CIBlockFormatProperties::GetDisplayValue(
                $arItem,
                $arProperty,
                false
            );

            if (!empty($arProperty['DISPLAY_VALUE'])) {
                if (Type::isArray($arProperty['DISPLAY_VALUE']))
                    $arProperty['DISPLAY_VALUE'] = ArrayHelper::getFirstValue($arProperty['DISPLAY_VALUE']);

                $arItem['DATA']['OVER'] = $arProperty['DISPLAY_VALUE'];
            }
        }
    }

    $sHeader = $arItem['NAME'];

    if (!empty($arParams['PROPERTY_HEADER'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_HEADER']
        ]);

        if (!empty($arProperty['VALUE'])) {
            $arProperty = CIBlockFormatProperties::GetDisplayValue(
                $arItem,
                $arProperty,
                false
            );

            if (!empty($arProperty['DISPLAY_VALUE'])) {
                if (Type::isArray($arProperty['DISPLAY_VALUE']))
                    $arProperty['DISPLAY_VALUE'] = ArrayHelper::getFirstValue($arProperty['DISPLAY_VALUE']);

                $sHeader = Html::stripTags($arProperty['DISPLAY_VALUE'], ['br']);
            }
        }
    }

    $arItem['DATA']['HEADER'] = $sHeader;
    unset($sHeader);

    if (!empty($arParams['PROPERTY_DESCRIPTION'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_DESCRIPTION']
        ]);

        if (!empty($arProperty['VALUE'])) {
            $arProperty = CIBlockFormatProperties::GetDisplayValue(
                $arItem,
                $arProperty,
                false
            );

            if (!empty($arProperty['DISPLAY_VALUE'])) {
                if (Type::isArray($arProperty['DISPLAY_VALUE']))
                    $arProperty['DISPLAY_VALUE'] = ArrayHelper::getFirstValue($arProperty['DISPLAY_VALUE']);

                $arItem['DATA']['DESCRIPTION'] = $arProperty['DISPLAY_VALUE'];
            }
        }
    }

    $arLink = [
        'VALUE' => null,
        'BLANK' => false
    ];

    if (!empty($arParams['PROPERTY_LINK'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_LINK']
        ]);

        if (!empty($arProperty['VALUE'])) {
            $arProperty = CIBlockFormatProperties::GetDisplayValue(
                $arItem,
                $arProperty,
                false
            );

            if (!empty($arProperty['DISPLAY_VALUE'])) {
                if (Type::isArray($arProperty['DISPLAY_VALUE']))
                    $arProperty['DISPLAY_VALUE'] = ArrayHelper::getFirstValue($arProperty['DISPLAY_VALUE']);

                $arLink['VALUE'] = StringHelper::replaceMacros(
                    $arProperty['DISPLAY_VALUE'],
                    ['SITE_DIR' => SITE_DIR]
                );
            }
        }
    }

    if (!empty($arParams['PROPERTY_LINK_BLANK'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_LINK_BLANK'],
            'VALUE_XML_ID'
        ]);

        if (!empty($arProperty))
            $arLink['BLANK'] = true;
    }

    $arItem['DATA']['LINK'] = $arLink;
    unset($arLink);

    $arButton = [
        'SHOW' => false,
        'TEXT' => null
    ];

    if (!empty($arParams['PROPERTY_BUTTON_SHOW'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_BUTTON_SHOW'],
            'VALUE_XML_ID'
        ]);

        if (!empty($arProperty) && !empty($arItem['DATA']['LINK']['VALUE']))
            $arButton['SHOW'] = true;
    }

    if (!empty($arParams['PROPERTY_BUTTON_TEXT'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_BUTTON_TEXT']
        ]);

        if (!empty($arProperty['VALUE'])) {
            $arProperty = CIBlockFormatProperties::GetDisplayValue(
                $arItem,
                $arProperty,
                false
            );

            if (!empty($arProperty['DISPLAY_VALUE'])) {
                if (Type::isArray($arProperty['DISPLAY_VALUE']))
                    $arProperty['DISPLAY_VALUE'] = ArrayHelper::getFirstValue($arProperty['DISPLAY_VALUE']);

                $arButton['TEXT'] = $arProperty['DISPLAY_VALUE'];
            }
        }
    }

    $arItem['DATA']['BUTTON'] = $arButton;
    unset($arButton);

    $sScheme = 'white';

    if (!empty($arParams['PROPERTY_SCHEME'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_SCHEME'],
            'VALUE_XML_ID'
        ]);

        if (!empty($arProperty))
            $sScheme = 'black';
    }

    $arItem['DATA']['SCHEME'] = $sScheme;
    unset($sScheme);

    $bFade = false;

    if (!empty($arParams['PROPERTY_FADE'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_FADE'],
            'VALUE_XML_ID'
        ]);

        if (!empty($arProperty))
            $bFade = true;
    }

    $arItem['DATA']['FADE'] = $bFade;
    unset($bFade);

    $arVideo = [
        'LINK' => null,
        'FILES' => []
    ];

    if (!empty($arParams['PROPERTY_VIDEO'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_VIDEO'],
            'VALUE'
        ]);

        if (!empty($arProperty)) {
            if (Type::isArray($arProperty))
                $arProperty = ArrayHelper::getFirstValue($arProperty);

            if (Type::isString($arProperty))
                $arVideo['LINK'] = $arProperty;
        }
    }

    if (!empty($arParams['PROPERTY_VIDEO_FILE_MP4'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_VIDEO_FILE_MP4'],
            'VALUE'
        ]);

        if (!empty($arProperty)) {
            if (Type::isArray($arProperty))
                $arProperty = ArrayHelper::getFirstValue($arProperty);

            if (!empty($arProperty))
                $arVideo['FILES']['MP4'] = $arProperty;
        }
    }

    if (!empty($arParams['PROPERTY_VIDEO_FILE_WEBM'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_VIDEO_FILE_WEBM'],
            'VALUE'
        ]);

        if (!empty($arProperty)) {
            if (Type::isArray($arProperty))
                $arProperty = ArrayHelper::getFirstValue($arProperty);

            if (!empty($arProperty))
                $arVideo['FILES']['WEBM'] = $arProperty;
        }
    }

    if (!empty($arParams['PROPERTY_VIDEO_FILE_OGV'])) {
        $arProperty = ArrayHelper::getValue($arItem, [
            'PROPERTIES',
            $arParams['PROPERTY_VIDEO_FILE_OGV'],
            'VALUE'
        ]);

        if (!empty($arProperty)) {
            if (Type::isArray($arProperty))
                $arProperty = ArrayHelper::getFirstValue($arProperty);

            if (!empty($arProperty))
                $arVideo['FILES']['OGV'] = $arProperty;
        }
    }

    $arItem['DATA']['VIDEO'] = $arVideo;
    unset($arVideo);

    foreach ($arItem['DATA']['VIDEO']['FILES'] as $sFile)
        if (!$arFiles->has($sFile))
            $arFiles->add($sFile);
}

unset($arProperty);

if (!$arFiles->isEmpty()) {
    $arFiles = Arrays::fromDBResult(CFile::GetList([], [
        '@ID' => implode(',', $arFiles->asArray())
    ]))->each(function ($iIndex, &$arFile) {
        $arFile['SRC'] = CFile::GetFileSRC($arFile);
    })->indexBy('ID');
} else {
    $arFiles = Arrays::from([]);
}

if (!$arFiles->isEmpty()) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        $arItemFiles = $arItem['DATA']['VIDEO']['FILES'];

        foreach ($arItemFiles as $sType => $sItemFile)
            if ($arFiles->exists($sItemFile)) {
                $arItem['DATA']['VIDEO']['FILES'][$sType] = $arFiles->get($sItemFile);
            } else {
                unset($arItem['DATA']['VIDEO']['FILES'][$sType]);
            }

        unset($sType, $sItemFile, $arItemFiles);
    }
}

unset($arFiles, $arItem);

if ($arResult['VISUAL']['BLOCKS']['USE'])
    include(__DIR__.'/modifiers/blocks.php');