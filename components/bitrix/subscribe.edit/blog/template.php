<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 */

global $USER;

if (!Loader::includeModule('intec.core'))
    return;

$arSubscription = ArrayHelper::getValue($arResult, 'SUBSCRIPTION');
$arRubrics = ArrayHelper::getValue($arResult, 'RUBRICS');
$arHeader = ArrayHelper::getValue($arResult, 'HEADER_BLOCK');
$arSubscribeRubrics = ArrayHelper::getValue($arResult, 'SUBSCRIBE_RUBRICS');
$bSubscribed = ArrayHelper::getValue($arSubscription, 'ID') != 0;
$bConfirmed = ArrayHelper::getValue($arSubscription, 'CONFIRMED') === 'Y';
$bFormatHtml = ArrayHelper::getValue($arSubscription, 'FORMAT') === 'html';
$sEmail = ArrayHelper::getValue($arSubscription, 'EMAIL');
$sEmail = !empty($sEmail) ? $sEmail : ArrayHelper::getValue($arResult, ['REQUEST', 'EMAIL']);
$sSubscribeType = ArrayHelper::getValue($arResult, 'SUBSCRIBE_TYPE');

?>
<div class="intec-content" style="font-size: 14px">
    <div class="intec-content-wrapper">
        <?php if($arResult['ALLOW_ANONYMOUS'] == 'N' && !$USER->IsAuthorized()) { ?>
            <div class="ns-bitrix c-subscribe-edit c-subscribe-edit-blog subscribe-edit-blog-error">
                <?php ShowMessage(['MESSAGE' => Loc::getMessage('SE_DEFAULT_ERROR'), 'TYPE' => 'ERROR']) ?>
            </div>
        <?php } else { ?>
            <div class="ns-bitrix c-subscribe-edit c-subscribe-edit-blog">
                <div class="subscribe-edit-wrapper">
                    <?php if ($arHeader['SHOW']) { ?>
                        <div class="subscribe-edit-header align-<?= $arHeader['POSITION'] ?>">
                            <?= $arHeader['TEXT'] ?>
                        </div>
                    <?php } ?>
                    <div class="subscribe-edit-form">
                        <form action="<?= $arResult['FORM_ACTION'] ?>" method="POST">
                            <?= bitrix_sessid_post() ?>
                            <input type="hidden" name="PostAction" value="<?= $bSubscribed ? 'Update' : 'Add' ?>" />
                            <input type="hidden" name="ID" value="<?= $arSubscription['ID'] ?>" />
                            <?= Html::hiddenInput('RUB_ID', $arSubscribeRubrics) ?>
                            <?= Html::hiddenInput('FORMAT', $sSubscribeType) ?>
                            <?php foreach($arResult['MESSAGE'] as $sMessage) { ?>
                                <div class="subscribe-edit-blog-message">
                                    <?php ShowMessage(['MESSAGE' => $sMessage, 'TYPE' => 'OK']) ?>
                                </div>
                            <?php } ?>
                            <?php foreach($arResult['ERROR'] as $sError) { ?>
                                <div class="subscribe-edit-blog-error">
                                    <?php ShowMessage(['MESSAGE' => $sError, 'TYPE' => 'ERROR']) ?>
                                </div>
                            <?php } ?>
                            <?php if ((!$bSubscribed && !$bConfirmed) || ($bSubscribed && $bConfirmed)) { ?>
                                <div class="subscribe-edit-information">
                                    <div class="subscribe-edit-information-email">
                                        <?= Html::textInput('EMAIL', $sEmail, [
                                            'class' => 'subscribe-edit-information-email-input intec-cl-border',
                                            'placeholder' => Loc::getMessage('SE_DEFAULT_INFORMATION_EMAIL')
                                        ]) ?>
                                    </div>
                                    <div class="subscribe-edit-information-description">
                                        <div class="subscribe-edit-information-description-text">
                                            <?= Loc::getMessage('SE_DEFAULT_INFORMATION_DESCRIPTION') ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?= Html::hiddenInput('EMAIL', $sEmail) ?>
                            <?php } ?>
                            <?php if ($bSubscribed && !$bConfirmed) { ?>
                                <div class="subscribe-edit-confirm">
                                    <div class="subscribe-edit-confirm-title">
                                        <?= Loc::getMessage('SE_DEFAULT_CONFIRM_TITLE') ?>
                                    </div>
                                    <div class="subscribe-edit-confirm-description">
                                        <?= Loc::getMessage('SE_DEFAULT_CONFIRM_DESCRIPTION')?>
                                    </div>
                                    <?= Html::textInput('CONFIRM_CODE', null, [
                                        'class' => 'subscribe-edit-confirm-input intec-cl-border',
                                        'placeholder' => Loc::getMessage('SE_DEFAULT_CONFIRM_INPUT')
                                    ]) ?>
                                    <input class="subscribe-edit-confirm-button intec-ui intec-ui-control-button intec-ui-mod-block intec-ui-scheme-current intec-ui-size-3<?/*intec-cl-background intec-cl-background-light-hover*/?>" type="submit" name="confirm" value="<?= Loc::getMessage('SE_DEFAULT_CONFIRM_BUTTON') ?>" />
                                </div>
                            <?php } ?>
                            <div class="subscribe-edit-buttons">
                                <?php if (!$bSubscribed || $bConfirmed) { ?>
                                    <input type="submit" class="subscribe-edit-button-send intec-ui intec-ui-control-button intec-ui-mod-block intec-ui-scheme-current intec-ui-size-3<?/*intec-cl-background intec-cl-background-light-hover*/?>" value="<?= $bSubscribed ? Loc::getMessage('SE_DEFAULT_BUTTONS_EDIT') : Loc::getMessage('SE_DEFAULT_BUTTONS_ADD') ?>" style="margin-right: 20px;" />
                                <?php } ?>
                                <?php if ($arResult['CONSENT']['SHOW']) { ?>
                                    <label class="subscribe-edit-consent intec-ui intec-ui-control-checkbox intec-ui-scheme-current">
                                        <?= Html::checkbox(null, true, [
                                            'onchange' => 'this.checked = !this.checked'
                                        ]) ?>
                                        <span class="intec-ui-part-selector"></span>
                                        <span class="intec-ui-part-content">
                                            <?= Loc::getMessage('SE_DEFAULT_CONSENT', [
                                                '#URL#' => $arResult['CONSENT']['URL']
                                            ]) ?>
                                        </span>
                                    </label>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>