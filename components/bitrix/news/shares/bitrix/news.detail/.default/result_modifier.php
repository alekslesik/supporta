<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * @var array $arResult
 */

$this->__component->arResult['PREVIEW_TEXT'] = $arResult['PREVIEW_TEXT'];
$this->__component->arResult['PREVIEW_PICTURE'] = $arResult['PREVIEW_PICTURE']['SRC'];

$this->__component->SetResultCacheKeys(['PREVIEW_TEXT', 'PREVIEW_PICTURE']);