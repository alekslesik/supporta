<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

?>
<div class="catalog-element-icons">
    <?php $APPLICATION->IncludeComponent(
        'intec.universe:main.advantages',
        'template.16',
        ArrayHelper::merge($arBlock['PARAMETERS'], [
            'IBLOCK_TYPE' => $arBlock['IBLOCK']['TYPE'],
            'IBLOCK_ID' => $arBlock['IBLOCK']['ID'],
            'FILTER' => [
                'ID' => $arBlock['IBLOCK']['ELEMENTS']
            ],
            'HEADER_SHOW' => 'Y',
            'HEADER_POSITION' => $arBlock['HEADER']['POSITION'],
            'HEADER' => $arBlock['HEADER']['VALUE'],
            'DESCRIPTION_BLOCK_SHOW' => 'N',
            'ELEMENTS_COUNT' => '',
            'MODE' => 'N',
            'SECTIONS' => null,
            'CACHE_TYPE' => 'N'
        ]),
        $component
    ) ?>
</div>
