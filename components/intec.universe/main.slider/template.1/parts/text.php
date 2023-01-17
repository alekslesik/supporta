<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var array $arForm
 * @var array $arItem
 * @var array $arVisual
 */

$vTextButton = include(__DIR__.'/buttons/view.'.$arVisual['BUTTON']['VIEW'].'.php');

?>
<?php return function (&$arData, $bHeaderH1 = false) use (&$arVisual, &$vTextButton, &$arForm, $sTemplateId, &$sItemName) { ?>
    <?= Html::beginTag('div', [
        'class' => Html::cssClassFromArray([
            'widget-item-text-wrap' => true,
            'widget-item-grid-horizontal-item' => true,
            'intec-grid-item' => [
                '' => !$arData['TEXT']['HALF'],
                '2' => $arData['TEXT']['HALF'],
                '768' => $arData['TEXT']['HALF'],
                'a-center' => true
            ]
        ], true)
    ]) ?>
        <?= Html::beginTag('div', [
            'class' => 'widget-item-text',
            'data' => [
                'align' => $arData['TEXT']['ALIGN'],
                'half' => $arData['TEXT']['HALF'] ? 'true' : 'false'
            ]
        ]) ?>
            <?php if ($arVisual['HEADER']['OVER']['SHOW'] && !empty($arData['HEADER']['OVER'])) { ?>
                <?= Html::tag('div', $arData['HEADER']['OVER'], [
                    'class' => 'widget-item-header-over',
                    'data' => [
                        'view' => $arVisual['HEADER']['OVER']['VIEW']
                    ]
                ]) ?>
            <?php } ?>
            <?php if ($arVisual['HEADER']['SHOW'] && !empty($arData['HEADER']['VALUE'])) { ?>
                <?= Html::tag($bHeaderH1 ? 'h1' : 'div', $arData['HEADER']['VALUE'], [
                    'class' => 'widget-item-header',
                    'data' => [
                        'view' => $arVisual['HEADER']['VIEW']
                    ]
                ]) ?>
            <?php } ?>
            <?php if ($arVisual['DESCRIPTION']['SHOW'] && !empty($arData['DESCRIPTION'])) { ?>
                <?= Html::tag('div', $arData['DESCRIPTION'], [
                    'class' => 'widget-item-description',
                    'data' => [
                        'view' => $arVisual['DESCRIPTION']['VIEW']
                    ]
                ]) ?>
            <?php } ?>
            <?php if (($arData['BUTTON']['SHOW'] && !empty($arData['LINK']['VALUE'])) || ($arForm['SHOW'])) { ?>
                <?= Html::beginTag('div', [
                    'class' => 'widget-item-buttons',
                    'data' => [
                        'view' => $arVisual['BUTTON']['VIEW']
                    ]
                ]) ?>
                    <?php if ($arData['BUTTON']['SHOW'] && !empty($arData['LINK']['VALUE'])) {

                        if (empty($arData['BUTTON']['TEXT']))
                            $arData['BUTTON']['TEXT'] = Loc::getMessage('C_MAIN_SLIDER_TEMPLATE_1_BUTTON_TEXT_DEFAULT');

                    ?>
                        <?php $vTextButton(
                            $arData['LINK']['VALUE'],
                            $arData['LINK']['BLANK'],
                            $arData['BUTTON']['TEXT']
                        ) ?>
                    <?php } ?>
                    <?php if ($arForm['SHOW']) { ?>
                        <?= Html::tag('div', $arForm['BUTTON'], [
                            'class' => [
                                'widget-item-button',
                                'intec-cl-background' => [
                                    '',
                                    'light-hover'
                                ]
                            ],
                            'onclick' => 'universe.forms.show('.JavaScript::toObject([
                                    'id' => $arForm['ID'],
                                    'template' => $arForm['TEMPLATE'],
                                    'parameters' => [
                                        'AJAX_OPTION_ADDITIONAL' => $sTemplateId . '_FORM_ASK',
                                        'CONSENT_URL' => $arForm['CONSENT']
                                    ],
                                    'settings' => [
                                        'title' => $arForm['NAME']
                                    ],
                                    'fields' => [
                                        $arForm['FIELD'] => $sItemName
                                    ]
                                ]).')'
                        ]) ?>
                    <?php } ?>
                <?= Html::endTag('div') ?>
            <?php } ?>
        <?= Html::endTag('div') ?>
    <?= Html::endTag('div') ?>
<?php } ?>