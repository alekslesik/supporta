<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\Core;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var CMain $APPLICATION
 */

$this->setFrameMode(true);

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arVisual = $arResult['VISUAL'];

$sReqSign = ' *';
$bErrorInput = $arResult['ERROR']['CODE'] == 5;

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'widget',
        'c-form-result-new',
        'c-form-result-new-form-3'
    ],
    'data-theme' => $arVisual['THEME'],
    'data-background' => $arVisual['BACKGROUND']['USE'] ? 'true' : null
]) ?>
    <?php if ($arVisual['BACKGROUND']['USE']) { ?>
        <?= Html::tag('div', '', [
            'class' => Html::cssClassFromArray([
                'widget-form-result-new-background' => true,
                'intec-cl-background' => $arVisual['BACKGROUND']['COLOR']['VALUE'] == 'theme'
            ], true),
            'style' => [
                'background-color' => $arVisual['BACKGROUND']['COLOR']['VALUE'] == 'custom' &&
                    !empty($arVisual['BACKGROUND']['COLOR']['CUSTOM']) ?
                    $arVisual['BACKGROUND']['COLOR']['CUSTOM'] : null,
                'opacity' => $arVisual['BACKGROUND']['OPACITY']
            ]
        ]) ?>
    <?php } ?>
    <div class="widget-form-result-new-body intec-content">
        <div class="intec-content-wrapper">
            <?php if ($arVisual['TITLE']['SHOW']) { ?>
                <div class="widget-form-result-new-title" data-align="<?= $arVisual['TITLE']['POSITION'] ?>">
                    <?= $arResult['LANG'][LANGUAGE_ID]['NAME'] ?>
                </div>
            <?php } ?>
            <?php if ($arResult['ERROR']['CODE'] == 0 || $arResult['ERROR']['CODE'] >= 4) { ?>
                <?= Html::beginForm($APPLICATION->GetCurPage(), 'post', [
                    'id' => "form_$sTemplateId",
                    'enctype' => 'multipart/form-data'
                ]) ?>
                    <?= Html::hiddenInput($arResult['VARIABLES']['REQUEST_VARIABLE_ACTION'], 'send') ?>
                    <?php if ($arResult['SENT']) { ?>
                        <div class="widget-form-result-new-sent" data-align="<?= $arVisual['TITLE']['POSITION'] ?>">
                            <?= $arResult['LANG'][LANGUAGE_ID]['SENT'] ?>
                        </div>
                    <?php } ?>
                    <div class="<?= Html::cssClassFromArray([
                        'widget-form-result-new-fields',
                        'intec-grid' => [
                            '',
                            'wrap',
                            'a-v-end',
                            'i-h-20'
                        ]
                    ]) ?>">
                        <?php foreach ($arResult['PROPERTIES'] as $iKey => $arProperty) {

                            $bRequired = $arProperty['REQUIRED'] == 'Y';
                            $bReadOnly = $arProperty['READ_ONLY'] == 'Y';
                            $bError = false;

                            $sCaption = $arProperty['LANG'][LANGUAGE_ID]['NAME'];
                            $sCaption = $bRequired ? $sCaption.$sReqSign : $sCaption;
                            $sName = Html::encode($arProperty['CODE']);
                            $sValue = !$arResult['SENT'] ? Html::encode(Core::$app->request->post($sName)) : '';

                            if ($bErrorInput) {
                                if (
                                    ArrayHelper::keyExists($sName, $arResult['ERROR']['FIELDS']['EMPTY']) ||
                                    ArrayHelper::keyExists($sName, $arResult['ERROR']['FIELDS']['INVALID'])
                                )
                                    $bError = true;
                            }

                        ?>
                            <?= Html::beginTag('div', [
                                'class' => Html::cssClassFromArray([
                                    'widget-form-result-new-field-wrap' => true,
                                    'intec-grid-item-1' => $arProperty['TYPE'] == STARTSHOP_FORM_PROPERTY_TYPE_TEXTAREA,
                                    'intec-grid-item-3' => $arProperty['TYPE'] == STARTSHOP_FORM_PROPERTY_TYPE_TEXT,
                                    'intec-grid-item-600-1' => true
                                ], true),
                            ]) ?>
                            <div class="widget-form-result-new-field" data-role="field" data-active="<?= !empty($sValue) ? "true" : "false" ?>">
                                <label for="<?= $sName ?>">
                                    <?= $sCaption ?>
                                </label>
                                <?php if ($arProperty['TYPE'] == STARTSHOP_FORM_PROPERTY_TYPE_TEXT) { ?>
                                    <?= Html::input('text', $sName, $sValue, [
                                        'class' => Html::cssClassFromArray([
                                            'widget-form-result-new-field-input' => true,
                                            'widget-form-result-new-field-input-error' => $bError
                                        ], true),
                                        'data-role' => 'input',
                                        'required' => $bRequired ? '' : null
                                    ]) ?>
                                <?php } elseif ($arProperty['TYPE'] == STARTSHOP_FORM_PROPERTY_TYPE_TEXTAREA) { ?>
                                    <?= Html::textarea($sName, $sValue, [
                                        'class' => Html::cssClassFromArray([
                                            'widget-form-result-new-field-input' => true,
                                            'widget-form-result-new-field-input-error' => $bError
                                        ], true),
                                        'data-role' => 'input',
                                        'required' => $bRequired ? '' : null
                                    ]) ?>
                                <?php } ?>
                            </div>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
                    </div>
                    <?php if ($arResult['USE_CAPTCHA'] == 'Y') {

                        $sCaptchaCode = $APPLICATION->CaptchaGetCode();

                    ?>
                        <div class="widget-form-result-new-captcha-wrap" data-align="<?= $arVisual['BUTTON']['POSITION'] ?>">
                            <div class="widget-form-result-new-captcha">
                                <div class="widget-form-result-new-captcha-title">
                                    <?= Loc::getMessage('C_WIDGET_FORM_3_WEB_FORM_CAPTCHA_TITLE') ?>
                                </div>
                                <?= Html::hiddenInput($arResult['VARIABLES']['FORM_VARIABLE_CAPTCHA_SID'], $sCaptchaCode) ?>
                                <?= Html::img('/bitrix/tools/captcha.php?captcha_sid='.$sCaptchaCode, [
                                    'width' => 180,
                                    'height' => 40
                                ]) ?>
                                <div class="clear"></div>
                                <?= Html::input('text', $arResult['VARIABLES']['FORM_VARIABLE_CAPTCHA_CODE'], null, [
                                    'class' => Html::cssClassFromArray([
                                        'widget-form-result-new-field-input' => true,
                                        'widget-form-result-new-captcha-input' => true,
                                        'widget-form-result-new-field-input-error' => $arResult['ERROR']['CODE'] == 4
                                    ], true),
                                    'required' => '',
                                    'placeholder' => Loc::getMessage('C_WIDGET_FORM_3_WEB_FORM_CAPTCHA_PLACEHOLDER')
                                ]) ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="intec-grid intec-grid-wrap intec-grid-a-v-center intec-grid-i-20">
                        <div class="intec-grid-item-auto">
                            <div class="widget-form-result-new-submit-wrap" data-align="<?= $arVisual['BUTTON']['POSITION'] ?>">
                                <?= Html::input('submit', 'web_form_submit', $arResult['LANG'][LANGUAGE_ID]['BUTTON'], [
                                    'class' => [
                                        'widget-form-result-new-submit',
                                        'intec-cl-background-light',
                                        'intec-cl-background-dark-hover'
                                    ]
                                    
                                ]) ?>
                            </div>
                        </div>
                        <?php if ($arVisual['CONSENT']['SHOW']) { ?>
                            <div class="intec-grid-item">
                                <div class="widget-form-result-new-consent-wrap" data-align="<?= $arVisual['BUTTON']['POSITION'] ?>">
                                    <div class="widget-form-result-new-consent-text">
                                        <?= Loc::getMessage('C_WIDGET_FORM_3_WEB_FORM_CONSENT_TEXT_REPLACE', [
                                            '#BUTTON_TEXT#' => $arResult['LANG'][LANGUAGE_ID]['BUTTON'],
                                            '#URL#' => $arVisual['CONSENT']['LINK']
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?= Html::endForm() ?>
            <?php } else { ?>
                <div class="widget-form-result-new-message">
                    <div class="widget-form-result-message-error">
                        <?php if ($arResult['ERROR']['CODE'] == 1) { ?>
                            <?= Loc::getMessage('C_WIDGET_FORM_3_WEB_FORM_ERROR_FORM_NOT_EXIST') ?>
                        <?php } else if ($arResult['ERROR']['CODE'] == 2) {?>
                            <?= Loc::getMessage('C_WIDGET_FORM_3_WEB_FORM_ERROR_FORM_UNBOUND') ?>
                        <?php } else if ($arResult['ERROR']['CODE'] == 3) {?>
                            <?= Loc::getMessage('C_WIDGET_FORM_3_WEB_FORM_ERROR_FORM_NO_FIELDS') ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?= Html::endTag('div') ?>
<?php include(__DIR__.'/script.php') ?>