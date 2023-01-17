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
 * @var string $sectionsHeader
 * @var array $sections
 */

?>
<div class="share-header-block">
    <?php if ($sectionsHeader) {
        echo $sectionsHeader;
    } else {
	    echo GetMessage('SECTIONS');
	} ?>
</div>

<?php $APPLICATION->IncludeComponent(
	"intec.universe:main.sections",
	"template.1",
	array(
		"IBLOCK_TYPE" => $arParams['PROPERTY_IBLOCK_TYPE_SECTION'],
		"IBLOCK_ID" => $arParams['PROPERTY_IBLOCK_ID_SECTION'],
		"QUANTITY" => "N",
        "MODE" => "ID",
        "SECTIONS" => $sections,
        "DEPTH" => 1,
        "HEADER_SHOW" => "N",
        "DESCRIPTION_SHOW" => "N",
        "LINE_COUNT" => 5,
        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
        "CACHE_TIME" => $arParams['CACHE_TIME'],
        "SORT_BY" => "SORT",
        "ORDER_BY" => "ASC"
	),
	$component
); ?>
