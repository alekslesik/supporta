<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arPrice
 */

?>
<?= Html::beginTag('div', [
    'class' => 'catalog-element-price',
    'data' => [
        'role' => 'price',
        'show' => !empty($arPrice) ? 'true' : 'false',
        'discount' => !empty($arPrice) && $arPrice['PERCENT'] > 0 ? 'true' : 'false'
    ]
]) ?>
	<?
	
	if (empty($arPrice["PRICE"])){
		$arPrice['PRINT_PRICE'] = 'По запросу';
		?>
			<div style="font-size: 30px;line-height: 30px;" class="catalog-element-price-">
				Цена по запросу
			</div>
			
		<?
	}
	else
	{?>
		<div class="catalog-element-price-discount" data-role="price.discount">
        <?= !empty($arPrice) ? $arPrice['PRINT_PRICE'] : null ?>
		</div>
		<div class="catalog-element-price-percent-wrap">
			<div class="catalog-element-price-percent" data-role="price.percent">
				<?= !empty($arPrice) ? '-'.$arPrice['PERCENT'].'%' : null ?>
			</div>
			<div class="catalog-element-price-base" data-role="price.base">
				<?= !empty($arPrice) ? $arPrice['PRINT_PRICE'] : null ?>
			</div>
		</div>	
	<?}
	
	?>
    
<?= Html::endTag('div') ?>