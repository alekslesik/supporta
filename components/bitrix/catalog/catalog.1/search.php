<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

include(__DIR__.'/parts/search/search.php');

?>
<div class="ns-bitrix c-catalog c-catalog-catalog-1 p-search">
    <div class="catalog-wrapper intec-content intec-content-visible">
        <div class="catalog-wrapper-2 intec-content-wrapper">
            <?php $APPLICATION->IncludeComponent(
                'bitrix:catalog.search',
                $arSearch['TEMPLATE'],
                $arSearch['PARAMETERS'],
                $component
            ) ?>
        </div>
    </div>
</div>