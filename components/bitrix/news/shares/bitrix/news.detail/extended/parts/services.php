<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 * @var array $services
 */

?>
<div class="share-header-block"><?= GetMessage('SERVICES') ?></div>
<?php $APPLICATION->IncludeComponent(
	"intec.universe:main.services",
	"template.8",
	array(
        "IBLOCK_TYPE" => $arParams['PROPERTY_IBLOCK_TYPE_SERVICES'],
        "IBLOCK_ID" => $arParams['PROPERTY_IBLOCK_ID_SERVICES'],
        "HEADER_BLOCK_SHOW" => "N",
        "DESCRIPTION_BLOCK_SHOW" => "N",
        "LINE_COUNT" => 2,
        "LINK_USE" => "Y",
        "INDENT_IMAGE_USE" => "N",
        "DESCRIPTION_USE" => "Y",
        "SEE_ALL_SHOW" => "N",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
        "CACHE_TIME" => $arParams['CACHE_TIME'],
        "SORT_BY" => "SORT",
        "ORDER_BY" => "ASC",
        'FILTER' => [
            'ID' => $services
        ]
	),
    $component
); ?>
