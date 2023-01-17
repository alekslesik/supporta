<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 * @var array $arTemplateParameters
 */

if (!Loader::includeModule('intec.core'))
    return;

if (!Loader::includeModule('sale') || !Loader::includeModule('catalog'))
	return;

Loc::loadMessages(__FILE__);

$arSKU = false;
$boolSKU = false;
$arOfferProps = array();

// get iblock props from all catalog iblocks including sku iblocks
$arSkuIblockIDs = array();
$dbCatalog = CCatalog::GetList(array(), array());
while ($arCatalog = $dbCatalog->GetNext())
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCatalog['IBLOCK_ID']);

	if (!empty($arSKU) && is_array($arSKU))
	{
		$arSkuIblockIDs[] = $arSKU['IBLOCK_ID'];
		$arSkuData[$arSKU['IBLOCK_ID']] = $arSKU;

		$boolSKU = true;
	}
}

// iblock props
$arProps = array();
foreach ($arSkuIblockIDs as $iblockID)
{
	$dbProps = CIBlockProperty::GetList(
		array(
			'SORT' => 'ASC',
			'NAME' => 'ASC'
		),
		array(
			'IBLOCK_ID' => $iblockID,
			'ACTIVE' => 'Y',
			'CHECK_PERMISSIONS' => 'N',
		)
	);

	while ($arProp = $dbProps->GetNext())
	{
		if ($arProp['ID'] == $arSkuData[$arSKU['IBLOCK_ID']]['SKU_PROPERTY_ID'])
			continue;

		if ($arProp['XML_ID'] == 'CML2_LINK')
			continue;

		$strPropName = '['. $arProp['ID'] .'] '. ('' != $arProp['CODE'] ? '['. $arProp['CODE'] .']' : '') .' '. $arProp['NAME'];

		if ($arProp['PROPERTY_TYPE'] != 'F') {
			$arOfferProps[$arProp['CODE']] = $strPropName;
		}
	}

	if (!empty($arOfferProps) && is_array($arOfferProps))
	{
		$arTemplateParameters['OFFERS_PROPS'] = array(
			'PARENT' => 'OFFERS_PROPS',
			'NAME' => GetMessage('SALE_PROPERTIES_RECALCULATE_BASKET'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'SIZE' => '7',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arOfferProps
		);
	}
}

$arTemplateParameters['CONSENT_URL'] = array(
    'PARENT' => 'URL_TEMPLATES',
    'TYPE' => 'STRING',
    'NAME' => GetMessage('SBB_CONSENT_URL')
);

include(__DIR__.'/parameters/order.fast.php');