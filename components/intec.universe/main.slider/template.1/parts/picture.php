<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arVisual
 */

?>
<?php return function (&$arData) use (&$arVisual) { ?>
    <?php if ($arVisual['PICTURE']['SHOW'] && !empty($arData['PICTURE'])) { ?>
        <?= Html::beginTag('div', [
            'class' => [
                'widget-item-picture-wrap',
                'widget-item-grid-horizontal-item',
                'intec-grid-item' => [
                    '2',
                    'a-'.$arData['PICTURE']['ALIGN']['VERTICAL']
                ]
            ]
        ]) ?>
            <div class="widget-item-picture">
                <?= Html::img($arData['PICTURE']['SRC'], [
                    'class' => 'widget-item-picture-wrapper',
                    'alt' => '',
                    'title' => ''
                ]) ?>
            </div>
        <?= Html::endTag('div') ?>
    <?php } ?>
<?php } ?>