<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arVisual
 */

$vAdditionalView = include(__DIR__.'/additional/view.'.$arVisual['ADDITIONAL']['VIEW'].'.php');

?>
<?php return function (&$arData) use (&$arVisual, &$vAdditionalView) { ?>
    <?php if ($arVisual['ADDITIONAL']['SHOW'] && !empty($arData['ADDITIONAL'])) { ?>
        <div class="widget-item-additional-wrap widget-item-grid-vertical-item intec-grid-item-auto">
            <?= Html::beginTag('div', [
                'class' => [
                    'widget-item-additional',
                    'intec-grid'
                ],
                'data' => [
                    'view' => $arVisual['ADDITIONAL']['VIEW']
                ]
            ]) ?>
                <?php $vAdditionalView($arData) ?>
            <?= Html::endTag('div') ?>
        </div>
    <?php } ?>
<?php } ?>