<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;
use intec\constructor\models\Build;
use Bitrix\Main\Loader;

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

if (!Loader::IncludeModule('intec.core'))
    return;

if ($arParams['SHOW_LIST'] == 'SETTINGS') {
    $build = Build::getCurrent();
    $page = $build->getPage();
    $properties = $page->getProperties();
    $showList = $properties->get('sections-contacts-template');

    switch ($showList) {
        case 'simple.1': $showList = 'NONE'; break;
        case 'shops.1': $showList = 'SHOPS'; break;
        case 'offices.1': $showList = 'OFFICES'; break;
    }

    if (in_array($showList, ['NONE', 'SHOPS', 'OFFICES'])) {
        $arParams['SHOW_LIST'] = $showList;
    }
}

$arParams['SHOW_LIST'] = ArrayHelper::isIn($arParams['SHOW_LIST'], ['SHOPS', 'OFFICES']) ? $arParams['SHOW_LIST'] : 'NONE';

$getMapCoordinates = function ($arItem) {
    if (empty($arItem['SYSTEM_PROPERTIES']['MAP']['VALUE']))
        return null;

    $arCoordinates = StringHelper::explode($arItem['SYSTEM_PROPERTIES']['MAP']['VALUE']);

    if (!empty($arCoordinates) && count($arCoordinates) == 2) {
        $arCoordinates[0] = Type::toFloat($arCoordinates[0]);
        $arCoordinates[1] = Type::toFloat($arCoordinates[1]);

        return $arCoordinates;
    }

    return null;
};
?>
<div class="contacts" id="<?= $sTemplateId ?>">
    <?php if ($arParams['SHOW_MAP'] == 'Y') { ?>
        <div class="contacts-map" id="<?= $sTemplateId ?>_map">
            <?php
            $arContact = $arResult['CONTACT'];
            $arData = array();

            if (!empty($arContact)) {
                $arCoordinates = $getMapCoordinates($arContact);

                if (!empty($arCoordinates)) {
                    if ($arParams['MAP_VENDOR'] == 'google') {
                        $arData['google_lat'] = $arCoordinates[0];
                        $arData['google_lon'] = $arCoordinates[1];
                        $arData['google_scale'] = 16;
                    } else if ($arParams['MAP_VENDOR'] == 'yandex') {
                        $arData['yandex_lat'] = $arCoordinates[0];
                        $arData['yandex_lon'] = $arCoordinates[1];
                        $arData['yandex_scale'] = 16;
                    }
                }
            }

            $arData['PLACEMARKS'] = array();

            foreach ($arResult['ITEMS'] as $arItem) {
                if (!empty($arItem['SYSTEM_PROPERTIES']['MAP']['VALUE'])) {
                    $arCoordinates = $getMapCoordinates($arItem);

                    if (!empty($arCoordinates)) {
                        $arPlaceMark = array();

                        $arPlaceMark['LAT'] = $arCoordinates[0];
                        $arPlaceMark['LON'] = $arCoordinates[1];
                        $arPlaceMark['TEXT'] = $arItem['NAME'];

                        $arData['PLACEMARKS'][] = $arPlaceMark;
                    }
                }
            }
            ?>
            <?php if ($arParams['MAP_VENDOR'] == 'google') { ?>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:map.google.view",
                    ".default",
                    array(
                        'MAP_ID' => $arParams['MAP_ID'],
                        'API_KEY' => $arParams['API_KEY_MAP'],
                        'INIT_MAP_TYPE' => 'ROADMAP',
                        'MAP_DATA' => serialize($arData),
                        'MAP_WIDTH' => '100%',
                        'MAP_HEIGHT' => '100%',
                        'OVERLAY' => 'Y',
                        'CONTROLS' => array(
                            'SMALL_ZOOM_CONTROL',
                            'TYPECONTROL',
                            'SCALELINE'
                        ),
                        'OPTIONS' => array(
                            'ENABLE_SCROLL_ZOOM',
                            'ENABLE_DBLCLICK_ZOOM',
                            'ENABLE_DRAGGING',
                            'ENABLE_KEYBOARD'
                        )
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );?>
            <?php } else if ($arParams['MAP_VENDOR'] == 'yandex') { ?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:map.yandex.view",
                    ".default",
                    array(
                        "COMPONENT_TEMPLATE" => ".default",
                        "INIT_MAP_TYPE" => 'ROADMAP',
                        "MAP_ID" => $arParams['MAP_ID'],
                        "MAP_DATA" => serialize($arData),
                        'MAP_WIDTH' => '100%',
                        'MAP_HEIGHT' => '100%',
                        'CONTROLS' => array(
                            0 => "ZOOM",
                            1 => "MINIMAP",
                            2 => "TYPECONTROL",
                            3 => "SCALELINE"
                        ),
                        'OPTIONS' => array(
                            0 => "ENABLE_SCROLL_ZOOM",
                            1 => "ENABLE_DBLCLICK_ZOOM",
                            2 => "ENABLE_DRAGGING"
                        ),
                        'OVERLAY' => 'Y'
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );?>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="intec-content contacts-contact-wrap">
        <div class="intec-content-wrapper">
            <?php if (!empty($arResult['CONTACT'])) { ?>
                <?php $arContact = $arResult['CONTACT'] ?>
                <?php $bDisplay =
                    !empty($arContact['SYSTEM_PROPERTIES']['ADDRESS']['VALUE']) ||
                    !empty($arContact['SYSTEM_PROPERTIES']['PHONE']['VALUE']) ||
                    !empty($arContact['SYSTEM_PROPERTIES']['WORK_TIME']['VALUE']) ||
                    !empty($arContact['SYSTEM_PROPERTIES']['EMAIL']['VALUE']);
                ?>
                <?php if ($bDisplay) { ?>
                    <div class="contacts-contact<?= $arParams['SHOW_MAP'] == 'Y' ? ' contacts-contact-with-map' : null ?>">
                        <div class="contacts-contact-wrapper">
                            <?php if (!empty($arContact['SYSTEM_PROPERTIES']['ADDRESS']['VALUE'])) { ?>
                                <div class="contacts-contact-parameter">
                                    <div class="contacts-contact-parameter-wrapper">
                                        <div class="contacts-contact-icon-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-icon" style="background-image: url('<?= $this->GetFolder().'/images/location.png' ?>')"></div>
                                        </div>
                                        <div class="contacts-contact-text-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-text">
                                                <?= $arContact['SYSTEM_PROPERTIES']['ADDRESS']['VALUE'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (!empty($arContact['SYSTEM_PROPERTIES']['PHONE']['VALUE'])) { ?>
                                <div class="contacts-contact-parameter">
                                    <div class="contacts-contact-parameter-wrapper">
                                        <div class="contacts-contact-icon-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-icon" style="background-image: url('<?= $this->GetFolder().'/images/phone.png' ?>')"></div>
                                        </div>
                                        <div class="contacts-contact-text-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-text">
                                                <div class="contacts-contact-title">
                                                    <?= GetMessage('N_L_CONTACTS_PROPERTY_PHONE') ?>:
                                                </div>
                                                <a class="contacts-contact-value" href="<?= 'tel:'.$arContact['SYSTEM_PROPERTIES']['PHONE']['VALUE_CLEAN'] ?>">
                                                    <?= $arContact['SYSTEM_PROPERTIES']['PHONE']['VALUE'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (!empty($arContact['SYSTEM_PROPERTIES']['WORK_TIME']['VALUE'])) { ?>
                                <div class="contacts-contact-parameter">
                                    <div class="contacts-contact-parameter-wrapper">
                                        <div class="contacts-contact-icon-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-icon" style="background-image: url('<?= $this->GetFolder().'/images/time.png' ?>')"></div>
                                        </div>
                                        <div class="contacts-contact-text-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-text">
                                                <div class="contacts-contact-title">
                                                    <?= GetMessage('N_L_CONTACTS_PROPERTY_WORK_TIME') ?>:
                                                </div>
                                                <div class="contacts-contact-value">
                                                    <?php foreach ($arContact['SYSTEM_PROPERTIES']['WORK_TIME']['VALUE'] as $key => $time) { ?>
                                                        <?php $sDescription = ArrayHelper::getValue($arItem['SYSTEM_PROPERTIES']['WORK_TIME']['DESCRIPTION'], $key); ?>
                                                        <div class="contacts-contact-value-part">
                                                            <?= !empty($sDescription) ? $sDescription.' '.$time : $time ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (!empty($arContact['SYSTEM_PROPERTIES']['EMAIL']['VALUE'])) { ?>
                                <div class="contacts-contact-parameter">
                                    <div class="contacts-contact-parameter-wrapper">
                                        <div class="contacts-contact-icon-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-icon" style="background-image: url('<?= $this->GetFolder().'/images/email.png' ?>')"></div>
                                        </div>
                                        <div class="contacts-contact-text-wrap">
                                            <div class="intec-aligner"></div>
                                            <div class="contacts-contact-text">
                                                <div class="contacts-contact-title">
                                                    <?= GetMessage('N_L_CONTACTS_PROPERTY_EMAIL') ?>:
                                                </div>
                                                <a class="contacts-contact-value" href="<?= 'mailto:'.$arContact['SYSTEM_PROPERTIES']['EMAIL']['VALUE'] ?>">
                                                    <?= $arContact['SYSTEM_PROPERTIES']['EMAIL']['VALUE'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php include(__DIR__.'/parts/schema.php') ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="intec-content">
        <div class="intec-content-wrapper">
            <?php if ($arParams['SHOW_LIST'] == 'SHOPS') { ?>
                <?php require('parts/shops.php') ?>
            <?php } ?>
            <?php if ($arParams['SHOW_LIST'] == 'OFFICES') { ?>
                <?php require('parts/offices.php') ?>
            <?php } ?>
            <?php if ($arParams['SHOW_MAP'] == 'Y') { ?>
                <script type="text/javascript">
                    (function ($, api) {
                        var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
                        var buttons = $('[data-latitude][data-longitude]', root);
                        var initialize;
                        var loader;
                        var move;
                        var map;

                        initialize = function () {
                            if (!api.isObject(window.maps))
                                return false;

                            map = window.maps[<?= JavaScript::toObject($arParams['MAP_ID']) ?>];

                            if (map == null)
                                return false;

                            buttons.on('click', function (event) {
                                var item = $(this);
                                var anchor = item.attr('href');

                                move(
                                    item.data('latitude'),
                                    item.data('longitude')
                                );

                                if (anchor) {
                                    $(window).stop().animate({
                                        scrollTop: $(anchor).offset().top
                                    }, 1000);

                                    event.preventDefault();
                                }
                            });

                            return true;
                        };

                        move = function (latitude, longitude) {
                            latitude = api.toFloat(latitude);
                            longitude = api.toFloat(longitude);

                            <?php if ($arParams['MAP_VENDOR'] == 'google') { ?>
                                map.panTo(new google.maps.LatLng(latitude, longitude));
                            <?php } else if ($arParams['MAP_VENDOR'] == 'yandex') { ?>
                                map.panTo([latitude, longitude]);
                            <?php } ?>
                        };

                        <?php if ($arParams['MAP_VENDOR'] == 'google') { ?>
                            BX.ready(initialize);
                        <?php } else if ($arParams['MAP_VENDOR'] == 'yandex') { ?>
                            loader = function () {
                                var load;

                                load = function () {
                                    if (!initialize())
                                        setTimeout(load, 100);
                                };

                                if (window.ymaps) {
                                    ymaps.ready(load);
                                } else {
                                    setTimeout(loader, 100);
                                }
                            };

                            loader();
                        <?php } ?>
                    })(jQuery, intec)
                </script>
            <?php } ?>
            <?php if ($arParams['SHOW_FORM'] == 'Y') { ?>
                <div class="contacts-form-wrap">
                    <?php if (Loader::IncludeModule('form')) {?>
                        <?php $APPLICATION->IncludeComponent(
                            'bitrix:form.result.new',
                            'contacts',
                            array(
                                'WEB_FORM_ID' => $arParams['WEB_FORM_ID'],
                                'AJAX_MODE' => 'Y',
                                'IGNORE_CUSTOM_TEMPLATE' => 'N',
                                'USE_EXTENDED_ERRORS' => 'N',
                                'LIST_URL' => null,
                                'EDIT_URL' => null,
                                'SUCCESS_URL' => null,
                                'CHAIN_ITEM_TEXT' => null,
                                'CHAIN_ITEM_LINK' => null,
                                'CONSENT_URL' => $arResult['WEB_FORM_CONSENT_URL']
                            ),
                            $component,
                            array(
                                'HIDE_ICONS' => 'Y'
                            )
                        ) ?>
                    <?php } else if (Loader::IncludeModule('intec.startshop')) {?>
                        <?php $APPLICATION->IncludeComponent(
                            "intec:startshop.forms.result.new",
                            "contacts",
                            array(
                                "COMPONENT_TEMPLATE" => "contacts",
                                "FORM_ID" => $arParams['WEB_FORM_ID'],
                                "AJAX_MODE" => "Y",
                                "CONSENT_URL" => $arResult['WEB_FORM_CONSENT_URL'],
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "REQUEST_VARIABLE_ACTION" => "action",
                                "FORM_VARIABLE_CAPTCHA_SID" => "CAPTCHA_SID",
                                "FORM_VARIABLE_CAPTCHA_CODE" => "CAPTCHA_CODE"
                            ),
                            $component,
                            array(
                                'HIDE_ICONS' => 'Y'
                            )
                        ); ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
