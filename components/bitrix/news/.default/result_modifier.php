<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Loader;
use intec\core\collections\Arrays;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;
use intec\regionality\models\Region;

/**
 * @var array $arParams
 * @var array $arResult
 */

$bSubscribe = false;

if (!Loader::includeModule('iblock'))
    return;

if (!Loader::includeModule('intec.core'))
    return;

if (Loader::includeModule('subscribe'))
    $bSubscribe = true;

$arParams = ArrayHelper::merge([
    'REGIONALITY_USE' => 'N',
    'REGIONALITY_FILTER_USE' => 'N',
    'REGIONALITY_FILTER_PROPERTY' => null,
    'REGIONALITY_FILTER_STRICT' => 'N'
], $arParams);

if (empty($arParams['FILTER_NAME']))
    $arParams['FILTER_NAME'] = 'arrNewsFilter';

$arIBlock = null;

if (!empty($arParams['IBLOCK_ID'])) {
    $oCache = Cache::createInstance();
    $arFilter = [
        'ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y'
    ];

    if ($oCache->initCache(36000, 'IBLOCK'.serialize($arFilter), '/iblock/news')) {
        $arIBlock = $oCache->getVars();
    } else if ($oCache->startDataCache()) {
        $arIBlocks = Arrays::fromDBResult(CIBlock::GetList([], $arFilter));
        $arIBlock = $arIBlocks->getFirst();
        $oCache->endDataCache($arIBlock);
    }
}

$arDisplayIn = [
    'list',
    'detail',
    'both'
];

$arResult['IBLOCK'] = $arIBlock;

/** VISUAL */
$arResult['VISUAL'] = [
    'TWO_COLUMNS' => [
        'USE' => ArrayHelper::getValue($arParams, 'TWO_COLUMNS_USE') == 'Y',
        'IN' => ArrayHelper::fromRange($arDisplayIn, ArrayHelper::getValue($arParams, 'TWO_COLUMNS_IN'))
    ],
    'RIGHT_COLUMN' => [
        'NEWS_TOP' => [
            'SHOW' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_TOP_NEWS_SHOW') == 'Y',
            'IN' => ArrayHelper::fromRange($arDisplayIn, ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_TOP_NEWS_SHOW_IN')),
            'LINE_COUNT' => ArrayHelper::fromRange([4, 1, 2, 3, 5], ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_TOP_NEWS_LINE_COUNT')),
            'HEADER' => [
                'SHOW' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_TOP_NEWS_HEADER_SHOW'),
                'TEXT' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_TOP_NEWS_HEADER_TEXT')
            ],
            'DATE_SHOW' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_TOP_NEWS_DATE_SHOW')
        ],
        'SUBSCRIBE' => [
            'SHOW' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_SHOW') == 'Y' && $bSubscribe,
            'IN' => ArrayHelper::fromRange($arDisplayIn, ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_SHOW_IN')),
            'RUBRICS' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_RUBRICS'),
            'TYPE' => ArrayHelper::fromRange(['html', 'text'], ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_TYPE')),
            'ALLOW_ANONYMOUS' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_ALLOW_ANONYMOUS'),
            'CONSENT' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_CONSENT'),
            'HEADER' => [
                'SHOW' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_HEADER_SHOW'),
                'POSITION' => ArrayHelper::fromRange(['center', 'left', 'right'], ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_HEADER_POSITION')),
                'TEXT' => ArrayHelper::getValue($arParams, 'RIGHT_COLUMN_SUBSCRIBE_HEADER_TEXT')
            ]
        ]
    ]
];

if ($arResult['VISUAL']['TWO_COLUMNS']['USE'] &&
    !$arResult['VISUAL']['RIGHT_COLUMN']['NEWS_TOP']['SHOW'] &&
    !$arResult['VISUAL']['RIGHT_COLUMN']['SUBSCRIBE']['SHOW']
)
    $arResult['VISUAL']['TWO_COLUMNS']['USE'] = false;

$arResult['REGIONALITY'] = [
    'USE' => $arParams['REGIONALITY_USE'] === 'Y',
    'FILTER' => [
        'USE' => $arParams['REGIONALITY_FILTER_USE'] === 'Y',
        'PROPERTY' => $arParams['REGIONALITY_FILTER_PROPERTY'],
        'STRICT' => $arParams['REGIONALITY_FILTER_STRICT'] === 'Y'
    ]
];

if (empty($arIBlock) || !Loader::includeModule('intec.regionality'))
    $arResult['REGIONALITY']['USE'] = false;

if (empty($arResult['REGIONALITY']['FILTER']['PROPERTY']))
    $arResult['REGIONALITY']['FILTER']['USE'] = false;

if ($arResult['REGIONALITY']['USE']) {
    $oRegion = Region::getCurrent();

    if (!empty($oRegion)) {
        if ($arResult['REGIONALITY']['FILTER']['USE']) {
            if (!isset($GLOBALS[$arParams['FILTER_NAME']]) || !Type::isArray($GLOBALS[$arParams['FILTER_NAME']]))
                $GLOBALS[$arParams['FILTER_NAME']] = [];

            $arConditions = [
                'LOGIC' => 'OR',
                ['PROPERTY_'.$arResult['REGIONALITY']['FILTER']['PROPERTY'] => $oRegion->id]
            ];

            if (!$arResult['REGIONALITY']['FILTER']['STRICT'])
                $arConditions[] = ['PROPERTY_'.$arResult['REGIONALITY']['FILTER']['PROPERTY'] => false];

            $GLOBALS[$arParams['FILTER_NAME']][] = $arConditions;
        }
    }
}