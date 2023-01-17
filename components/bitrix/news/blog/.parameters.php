<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('iblock'))
    return;

Loc::loadMessages(__FILE__);

/** Список свойств инфоблока */
$arPropertiesList = [];
$arPropertiesElement = [];

if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $rsProperties = CIBlockProperty::GetList(
        array(),
        array(
            'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID']
        )
    );

    while ($arProperty = $rsProperties->Fetch()) {
        if ($arProperty['PROPERTY_TYPE'] == 'E' && $arProperty['LIST_TYPE'] == 'L') {
            $arPropertiesElement[$arProperty['CODE']] = '[' . $arProperty['CODE'] . '] ' . $arProperty['NAME'];
        } else if ($arProperty['PROPERTY_TYPE'] == 'L' && $arProperty['LIST_TYPE'] == 'L') {
            $arPropertiesList[$arProperty['CODE']] = '[' . $arProperty['CODE'] . '] ' . $arProperty['NAME'];
        }
    }
}

/** HIDDEN SETTINGS */
$arTemplateParameters = array(
    'USE_SEARCH' => array(
        'HIDDEN' => 'Y'
    ),
    'USE_RSS' => array(
        'HIDDEN' => 'Y'
    ),
    'USE_RATING' => array(
        'HIDDEN' => 'Y'
    ),
    'USE_CATEGORIES' => array(
        'HIDDEN' => 'Y'
    ),
    'USE_REVIEW' => array(
        'HIDDEN' => 'Y'
    ),
    'AJAX_MODE' => array(
        'HIDDEN' => 'Y'
    ),
    'AJAX_OPTION_JUMP' => array(
        'HIDDEN' => 'Y'
    ),
    'AJAX_OPTION_STYLE' => array(
        'HIDDEN' => 'Y'
    ),
    'AJAX_OPTION_HISTORY' => array(
        'HIDDEN' => 'Y'
    ),
    'AJAX_OPTION_ADDITIONAL' => array(
        'HIDDEN' => 'Y'
    ),
    'SET_LAST_MODIFIED' => array(
        'HIDDEN' => 'Y'
    ),
    'USE_PERMISSIONS' => array(
        'HIDDEN' => 'Y'
    ),
    'HIDE_LINK_WHEN_NO_DETAIL' => array(
        'HIDDEN' => 'Y'
    ),
    'DETAIL_DISPLAY_TOP_PAGER' => array(
        'HIDDEN' => 'Y'
    ),
    'DETAIL_DISPLAY_BOTTOM_PAGER' => array(
        'HIDDEN' => 'Y'
    ),
    'DETAIL_PAGER_TITLE' => array(
        'HIDDEN' => 'Y'
    ),
    'DETAIL_PAGER_TEMPLATE' => array(
        'HIDDEN' => 'Y'
    ),
    'PAGER_SHOW_ALWAYS' => array(
        'HIDDEN' => 'Y'
    ),
    'PAGER_DESC_NUMBERING' => array(
        'HIDDEN' => 'Y'
    ),
    'PAGER_DESC_NUMBERING_CACHE_TIME' => array(
        'HIDDEN' => 'Y'
    ),
    'PAGER_SHOW_ALL' => array(
        'HIDDEN' => 'Y'
    ),
    'PAGER_BASE_LINK_ENABLE' => array(
        'HIDDEN' => 'Y'
    )
);

/** DATA_SOURCE */
$arTemplateParameters['PROPERTY_TAG'] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => Loc::getMessage('C_NEWS_PROPERTY_TAG'),
    'TYPE' => 'LIST',
    'VALUES' => $arPropertiesList,
    'ADDITIONAL_VALUES' => 'Y',
    'REFRESH' => 'Y'
);

if (!empty($arCurrentValues['PROPERTY_TAG'])) {
    $arTemplateParameters['TAG_VARIABLE_NAME'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_NEWS_TAG_VARIABLE_NAME'),
        'TYPE' => 'STRING',
        'DEFAULT' => 'tag'
    );
}

/** VISUAL */
$arTemplateParameters['LIST_TWO_COLUMNS'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_LIST_TWO_COLUMNS'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);
$arTemplateParameters['DETAIL_TWO_COLUMNS'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_NEWS_DETAIL_TWO_COLUMNS'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['LIST_TWO_COLUMNS'] == 'Y' || $arCurrentValues['DETAIL_TWO_COLUMNS'] == 'Y') {
    $arTemplateParameters['LIST_TAG_HEADER_SHOW'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_LIST_TAG_HEADER_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    );

    if ($arCurrentValues['LIST_TAG_HEADER_SHOW'] == 'Y') {
        $arTemplateParameters['LIST_TAG_HEADER_TEXT'] = array(
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_LIST_TAG_HEADER_TEXT'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('C_NEWS_LIST_TAG_HEADER_TEXT_DEFAULT')
        );
    }

    $arTemplateParameters['LIST_NEWS_TOP_SHOW'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    );

    if ($arCurrentValues['LIST_NEWS_TOP_SHOW'] == 'Y') {
        $arTemplateParameters['LIST_NEWS_TOP_SHOW_IN'] = array(
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_SHOW_IN'),
            'TYPE' => 'LIST',
            'VALUES' => array(
                'list' => Loc::getMessage('C_NEWS_SHOW_IN_LIST'),
                'detail' => Loc::getMessage('C_NEWS_SHOW_IN_DETAIL'),
                'all' => Loc::getMessage('C_NEWS_SHOW_IN_ALL')
            ),
            'DEFAULT' => 'all'
        );
        $arTemplateParameters['LIST_NEWS_TOP_ELEMENTS_COUNT'] = array(
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_ELEMENTS_COUNT'),
            'TYPE' => 'LIST',
            'VALUES' => array(
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5'
            ),
            'ADDITIONAL_VALUES' => 'Y',
            'DEFAULT' => 4
        );
        $arTemplateParameters['LIST_NEWS_TOP_HEADER_SHOW'] = array(
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_HEADER_SHOW'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
            'REFRESH' => 'Y'
        );

        if ($arCurrentValues['LIST_NEWS_TOP_HEADER_SHOW'] == 'Y') {
            $arTemplateParameters['LIST_NEWS_TOP_HEADER_TEXT'] = array(
                'PARENT' => 'VISUAL',
                'NAME' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_HEADER_TEXT'),
                'TYPE' => 'STRING',
                'DEFAULT' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_HEADER_TEXT_DEFAULT')
            );
        }

        if (!empty($arCurrentValues['PROPERTY_TAG'])) {
            $arTemplateParameters['LIST_NEWS_TOP_TAG_SHOW'] = array(
                'PARENT' => 'VISUAL',
                'NAME' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_TAG_SHOW'),
                'TYPE' => 'CHECKBOX',
                'DEFAULT' => 'N'
            );
        }

        $arTemplateParameters['LIST_NEWS_TOP_DATE_SHOW'] = array(
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('C_NEWS_LIST_NEWS_TOP_DATE_SHOW'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N'
        );
    }

    if (Loader::includeModule('subscribe'))
        include(__DIR__.'/parameters/base.php');
}

/** LIST_SETTINGS */
$arTemplateParameters['LIST_VIEW'] = array(
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_LIST_VIEW'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'standard' => Loc::getMessage('C_NEWS_LIST_VIEW_STANDARD'),
        'big-block' => Loc::getMessage('C_NEWS_LIST_VIEW_BIG_BLOCK')
    ),
    'DEFAULT' => 'big-block',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['LIST_VIEW'] == 'standard') {
    $arTemplateParameters['LIST_GRID'] = array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('C_NEWS_LIST_GRID'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            2 => '2',
            3 => '3',
            4 => '4'
        ),
        'DEFAULT' => 4
    );
}

$arTemplateParameters['USE_DATE_FILTER'] = array(
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => GetMessage('C_NEWS_USE_DATE_FILTER'),
    'TYPE' => 'CHECKBOX',
    'REFRESH' => 'Y'
);
if ($arCurrentValues['USE_DATE_FILTER'] == 'Y') {
    $arTemplateParameters['DATE_FILTER'] = array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => GetMessage('C_NEWS_DATE_FILTER'),
        'TYPE' => 'STRING',
        'DEFAULT' => 'date'
    );
}

$arTemplateParameters['LIST_DATE_SHOW'] = array(
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_LIST_DATE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);

if (!empty($arCurrentValues['PROPERTY_TAG'])) {
    $arTemplateParameters['LIST_TAG_CLOUD_SHOW'] = array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('C_NEWS_LIST_TAG_CLOUD_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    );
    $arTemplateParameters['LIST_TAG_SHOW'] = array(
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('C_NEWS_LIST_TAG_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    );
}

$arTemplateParameters['LIST_DESCRIPTION_SHOW'] = array(
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_LIST_DESCRIPTION_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);

/** DETAIL_SETTINGS */
$arTemplateParameters['DETAIL_DATE_SHOW'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_DETAIL_DATE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);
$arTemplateParameters['DETAIL_PREVIEW_TEXT_SHOW'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_DETAIL_PREVIEW_TEXT_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);
$arTemplateParameters['DETAIL_IMAGE_SHOW'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_DETAIL_IMAGE_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);

if (!empty($arCurrentValues['PROPERTY_TAG'])) {
    $arTemplateParameters['DETAIL_TAG_SHOW'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => Loc::getMessage('C_NEWS_DETAIL_TAG_SHOW'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'no' => Loc::getMessage('C_NEWS_DETAIL_TAG_SHOW_NO'),
            'top' => Loc::getMessage('C_NEWS_DETAIL_TAG_SHOW_TOP'),
            'bottom' => Loc::getMessage('C_NEWS_DETAIL_TAG_SHOW_BOT'),
            'all' => Loc::getMessage('C_NEWS_DETAIL_TAG_SHOW_ALL')
        ),
        'DEFAULT' => 'all'
    );
}

if ($arCurrentValues['IBLOCK_ID']) {
    $arTemplateParameters['DETAIL_READ_ALSO_SHOW'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => Loc::getMessage('C_NEWS_DETAIL_READ_ALSO_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    );

    if ($arCurrentValues['DETAIL_READ_ALSO_SHOW'] == 'Y') {
        $arTemplateParameters['DETAIL_PROPERTY_READ_ALSO'] = array(
            'PARENT' => 'DETAIL_SETTINGS',
            'NAME' => Loc::getMessage('C_NEWS_DETAIL_PROPERTY_READ_ALSO'),
            'TYPE' => 'LIST',
            'VALUES' => $arPropertiesElement,
            'ADDITIONAL_VALUES' => 'Y',
            'REFRESH' => 'Y'
        );

        if (!empty($arCurrentValues['DETAIL_READ_ALSO_SHOW'])) {
            $arTemplateParameters['DETAIL_READ_ALSO_VIEW'] = array(
                'PARENT' => 'DETAIL_SETTINGS',
                'NAME' => Loc::getMessage('C_NEWS_DETAIL_READ_ALSO_VIEW'),
                'TYPE' => 'LIST',
                'VALUES' => array(
                    'blocks' => Loc::getMessage('C_NEWS_DETAIL_READ_ALSO_VIEW_BLOCKS'),
                    'tile' => Loc::getMessage('C_NEWS_DETAIL_READ_ALSO_VIEW_TILE')
                ),
                'DEFAULT' => 'blocks'
            );
            $arTemplateParameters['DETAIL_READ_ALSO_HEADER_TEXT'] = array(
                'PARENT' => 'DETAIL_SETTINGS',
                'NAME' => Loc::getMessage('C_NEWS_DETAIL_READ_ALSO_HEADER_TEXT'),
                'TYPE' => 'STRING',
                'DEFAULT' => Loc::getMessage('C_NEWS_DETAIL_READ_ALSO_HEADER_TEXT_DEFAULT')
            );
        }
    }
}

$arTemplateParameters['DETAIL_BACK_SHOW'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_DETAIL_BACK_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['DETAIL_BACK_SHOW'] == 'Y') {
    $arTemplateParameters['DETAIL_BACK_TEXT'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => Loc::getMessage('C_NEWS_DETAIL_BACK_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_NEWS_DETAIL_BACK_TEXT_DEFAULT')
    );
}

$arTemplateParameters['DETAIL_SOCIAL_SHOW'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => Loc::getMessage('C_NEWS_DETAIL_SOCIAL_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
);

if ($arCurrentValues['DETAIL_SOCIAL_SHOW'] == 'Y') {
    $arTemplateParameters['DETAIL_SOCIAL_LIST'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => Loc::getMessage('C_NEWS_DETAIL_SOCIAL_LIST'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'vk' => Loc::getMessage('C_NEWS_SOCIAL_VK'),
            'facebook' => Loc::getMessage('C_NEWS_SOCIAL_FB'),
            'twitter' => Loc::getMessage('C_NEWS_SOCIAL_TW'),
            'gplus' => Loc::getMessage('C_NEWS_SOCIAL_GP'),
            'pinterest' => Loc::getMessage('C_NEWS_SOCIAL_PI')
        ),
        'MULTIPLE' => 'Y'
    );
}

include(__DIR__.'/parameters/regionality.php');