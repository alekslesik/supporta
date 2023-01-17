<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\Component;
use intec\core\bitrix\component\InnerTemplate;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

/** @var InnerTemplate $oTemplate */
$oTemplate = $arResult['TEMPLATE'];
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];
$arData = [
    'id' => $sTemplateId
];

$this->setFrameMode(true);

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'widget',
        'c-footer',
        'c-footer-template-1'
    ],
    'data' => [
        'theme' => $arResult['THEME']
    ]
]) ?>
    <div class="widget-content">
        <div class="widget-view">
            <?php if (!empty($oTemplate)) { ?>
                <?= $oTemplate->render(
                    $arParams,
                    $arResult,
                    $arData
                ) ?>
            <?php } ?>
        </div>
    </div>
<?= Html::endTag('div') ?>