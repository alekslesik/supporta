<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var IntecSaleBasketSmallComponent $component
 * @var CBitrixComponentTemplate $this
 */

if (!defined('EDITOR')) {
    if (empty($arResult['CURRENCY']))
        return;

    if (!$component->getIsBase() && !$component->getIsLite())
        return;
}

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this, true));

?>

<?php if (!defined('EDITOR')) { ?>
    <div id="<?= $sTemplateId ?>" class="ns-intec-universe c-sale-basket-small c-sale-basket-small-template-2">
        <?php include(__DIR__.'/parts/panel.php') ?>
        <?php include(__DIR__.'/parts/content.php') ?>
        <?php include(__DIR__.'/parts/script.php') ?>
    </div>
<?php } else { ?>
    <div class="constructor-element-stub">
        <div class="constructor-element-stub-wrapper">
            <?= Loc::getMessage('C_SALE_BASKET_SMALL_TEMPLATE_2_EDITOR') ?>
        </div>
    </div>
<?php } ?>
