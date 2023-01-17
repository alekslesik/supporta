<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\constructor\models\Build;

global $APPLICATION;

if (
    Loader::includeModule('intec.constructor') ||
    Loader::includeModule('intec.constructorlite')
) {
    if (!defined('EDITOR')) {
        $build = Build::getCurrent();

        if (!empty($build)) {
            $page = $build->getPage();
            $properties = $page->getProperties();
            $blocks = $properties->get('pages-main-blocks');
            $basketUse = $properties->get('basket-use');
            $delayUse = $properties->get('basket-delay-use');
            $compareUse = $properties->get('basket-compare-use');
            $fixedHeaderUse = $properties->get('header-fixed-use');

            $mobileHeaderFixed = $properties->get('header-mobile-fixed');
            $mobileTemplate = $properties->get('header-mobile-template');

            $template = $properties->get('header-template');

            $arParams['AUTHORIZATION_SHOW_MOBILE'] = 'N';
            $arParams['TRANSPARENCY'] = 'N';
            $arParams['REGIONALITY_USE'] = $properties->get('base-regionality-use') ? 'Y' : 'N';
            $arParams['SEARCH_MODE'] = $properties->get('base-search-mode');
            $arParams['BASKET_POPUP'] = $properties->get('header-basket-popup-show') ? 'Y' : 'N';

            $arParams['MOBILE'] = 'template.1';
            $arParams['MOBILE_FIXED'] = 'N';
            $arParams['MOBILE_FILLED'] = 'N';

            $arParams['FIXED'] = 'template.1';

            switch ($template) {
                case 1:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'bottom';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'N';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'Y';
                    $arParams['DELAY_SHOW'] = 'Y';
                    $arParams['COMPARE_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 2:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'N';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'Y';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'N';
                    $arParams['BASKET_SHOW_FIXED'] = 'N';
                    $arParams['BASKET_SHOW_MOBILE'] = 'N';
                    $arParams['DELAY_SHOW'] = 'N';
                    $arParams['DELAY_SHOW_FIXED'] = 'N';
                    $arParams['DELAY_SHOW_MOBILE'] = 'N';
                    $arParams['COMPARE_SHOW'] = 'N';
                    $arParams['COMPARE_SHOW_FIXED'] = 'N';
                    $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 3:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'N';
                    $arParams['EMAIL_SHOW'] = 'N';
                    $arParams['AUTHORIZATION_SHOW'] = 'N';
                    $arParams['TAGLINE_SHOW'] = 'N';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'N';
                    $arParams['SEARCH_SHOW'] = 'N';
                    $arParams['BASKET_SHOW'] = 'N';
                    $arParams['BASKET_SHOW_FIXED'] = 'N';
                    $arParams['BASKET_SHOW_MOBILE'] = 'N';
                    $arParams['DELAY_SHOW'] = 'N';
                    $arParams['DELAY_SHOW_FIXED'] = 'N';
                    $arParams['DELAY_SHOW_MOBILE'] = 'N';
                    $arParams['COMPARE_SHOW'] = 'N';
                    $arParams['COMPARE_SHOW_FIXED'] = 'N';
                    $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 4:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'N';
                    $arParams['DESKTOP'] = 'template.3';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_MAIN_ROOT'] = 'catalog';
                    $arParams['MENU_MAIN_CHILD'] = 'catalog';
                    $arParams['MENU_INFO_SHOW'] = 'N';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'Y';
                    $arParams['DELAY_SHOW'] = 'Y';
                    $arParams['COMPARE_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'N';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 5:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'N';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'Y';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'Y';
                    $arParams['DELAY_SHOW'] = 'Y';
                    $arParams['COMPARE_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 6:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'bottom';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'Y';
                    $arParams['MENU_MAIN_ROOT'] = 'catalog';
                    $arParams['MENU_MAIN_CHILD'] = 'catalog';
                    $arParams['MENU_INFO_SHOW'] = 'N';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'Y';
                    $arParams['DELAY_SHOW'] = 'Y';
                    $arParams['COMPARE_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 7:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'bottom';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'Y';
                    $arParams['MENU_MAIN_ROOT'] = 'catalog';
                    $arParams['MENU_MAIN_CHILD'] = 'catalog';
                    $arParams['MENU_INFO_SHOW'] = 'N';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'N';
                    $arParams['BASKET_SHOW_FIXED'] = 'N';
                    $arParams['BASKET_SHOW_MOBILE'] = 'N';
                    $arParams['DELAY_SHOW'] = 'N';
                    $arParams['DELAY_SHOW_FIXED'] = 'N';
                    $arParams['DELAY_SHOW_MOBILE'] = 'N';
                    $arParams['COMPARE_SHOW'] = 'N';
                    $arParams['COMPARE_SHOW_FIXED'] = 'N';
                    $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 8:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'N';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'N';
                    $arParams['BASKET_SHOW_FIXED'] = 'N';
                    $arParams['BASKET_SHOW_MOBILE'] = 'N';
                    $arParams['DELAY_SHOW'] = 'N';
                    $arParams['DELAY_SHOW_FIXED'] = 'N';
                    $arParams['DELAY_SHOW_MOBILE'] = 'N';
                    $arParams['COMPARE_SHOW'] = 'N';
                    $arParams['COMPARE_SHOW_FIXED'] = 'N';
                    $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'top';
                    $arParams['SOCIAL_SHOW'] = 'Y';
                    $arParams['SOCIAL_POSITION'] = 'center';

                    break;
                case 9:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'N';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'N';
                    $arParams['BASKET_SHOW_FIXED'] = 'N';
                    $arParams['BASKET_SHOW_MOBILE'] = 'N';
                    $arParams['DELAY_SHOW'] = 'N';
                    $arParams['DELAY_SHOW_FIXED'] = 'N';
                    $arParams['DELAY_SHOW_MOBILE'] = 'N';
                    $arParams['COMPARE_SHOW'] = 'N';
                    $arParams['COMPARE_SHOW_FIXED'] = 'N';
                    $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'Y';
                    $arParams['SOCIAL_POSITION'] = 'left';

                    break;
                case 10:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'N';
                    $arParams['DESKTOP'] = 'template.1';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'Y';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'N';
                    $arParams['BASKET_SHOW_FIXED'] = 'N';
                    $arParams['BASKET_SHOW_MOBILE'] = 'N';
                    $arParams['DELAY_SHOW'] = 'N';
                    $arParams['DELAY_SHOW_FIXED'] = 'N';
                    $arParams['DELAY_SHOW_MOBILE'] = 'N';
                    $arParams['COMPARE_SHOW'] = 'N';
                    $arParams['COMPARE_SHOW_FIXED'] = 'N';
                    $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'left';

                    break;
                case 11:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'N';
                    $arParams['DESKTOP'] = 'template.2';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'Y';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'Y';
                    $arParams['DELAY_SHOW'] = 'Y';
                    $arParams['COMPARE_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'left';

                    break;
                case 12:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'N';
                    $arParams['DESKTOP'] = 'template.2';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['MENU_MAIN_POSITION'] = 'top';
                    $arParams['MENU_MAIN_TRANSPARENT'] = 'N';
                    $arParams['MENU_INFO_SHOW'] = 'Y';
                    $arParams['SEARCH_SHOW'] = 'Y';
                    $arParams['BASKET_SHOW'] = 'N';
                    $arParams['BASKET_SHOW_FIXED'] = 'N';
                    $arParams['BASKET_SHOW_MOBILE'] = 'N';
                    $arParams['DELAY_SHOW'] = 'N';
                    $arParams['DELAY_SHOW_FIXED'] = 'N';
                    $arParams['DELAY_SHOW_MOBILE'] = 'N';
                    $arParams['COMPARE_SHOW'] = 'N';
                    $arParams['COMPARE_SHOW_FIXED'] = 'N';
                    $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                    $arParams['MENU_MAIN_DELIMITERS'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';
                    $arParams['PHONES_POSITION'] = 'bottom';
                    $arParams['SOCIAL_SHOW'] = 'N';
                    $arParams['SOCIAL_POSITION'] = 'left';

                    break;
                case 13:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.4';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';

                    break;
                case 14:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.5';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';

                    break;
                case 15:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.6';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';

                    break;
                case 16:
                    $arParams['LOGOTYPE_SHOW'] = 'Y';
                    $arParams['PHONES_SHOW'] = 'Y';
                    $arParams['ADDRESS_SHOW'] = 'Y';
                    $arParams['EMAIL_SHOW'] = 'Y';
                    $arParams['TAGLINE_SHOW'] = 'Y';
                    $arParams['DESKTOP'] = 'template.7';
                    $arParams['MENU_MAIN_SHOW'] = 'Y';
                    $arParams['FORMS_CALL_SHOW'] = 'Y';

                    break;
                case 17:
                    $arParams['DESKTOP'] = 'template.8';

                    break;
                case 18:
                    $arParams['DESKTOP'] = 'template.9';
                    $arParams['MENU_MAIN_SECTION_VIEW'] = 'information';
                    $arParams['MENU_MAIN_SUBMENU_VIEW'] = 'simple.2';
                    $arParams['SOCIAL_SHOW'] = 'N';

                    break;
            }

            if (ArrayHelper::isIn($template, [2, 3, 7, 8, 9, 10, 12, 13, 14, 15, 16])) {
                $arParams['DELAY_SHOW_FIXED'] = 'N';
                $arParams['DELAY_SHOW_MOBILE'] = 'N';
                $arParams['COMPARE_SHOW_FIXED'] = 'N';
                $arParams['COMPARE_SHOW_MOBILE'] = 'N';
                $arParams['BASKET_SHOW_FIXED'] = 'N';
                $arParams['BASKET_SHOW_MOBILE'] = 'N';
            }

            if (!$delayUse) {
                $arParams['DELAY_SHOW'] = 'N';
                $arParams['DELAY_SHOW_FIXED'] = 'N';
                $arParams['DELAY_SHOW_MOBILE'] = 'N';
            }

            if (!$compareUse) {
                $arParams['COMPARE_SHOW'] = 'N';
                $arParams['COMPARE_SHOW_FIXED'] = 'N';
                $arParams['COMPARE_SHOW_MOBILE'] = 'N';
            }

            if (!$basketUse) {
                $arParams['BASKET_SHOW'] = 'N';
                $arParams['BASKET_SHOW_FIXED'] = 'N';
                $arParams['BASKET_SHOW_MOBILE'] = 'N';
                $arParams['DELAY_SHOW'] = 'N';
                $arParams['DELAY_SHOW_FIXED'] = 'N';
                $arParams['DELAY_SHOW_MOBILE'] = 'N';
            }

            if (!$fixedHeaderUse)
                $arParams['FIXED'] = null;

            if ($mobileHeaderFixed)
                $arParams['MOBILE_FIXED'] = 'Y';

            switch ($mobileTemplate) {
                case 'white': break;
                case 'colored': $arParams['MOBILE_FILLED'] = 'Y'; break;
                case 'white-with-icons': $arParams['AUTHORIZATION_SHOW_MOBILE'] = 'Y'; break;
                case 'colored-with-icons':
                    $arParams['MOBILE_FILLED'] = 'Y';
                    $arParams['AUTHORIZATION_SHOW_MOBILE'] = 'Y';

                    break;
            }

            if ($blocks['banner']['active']) {
                if (
                    $APPLICATION->GetCurPage(false) === SITE_DIR &&
                    $properties->get('pages-main-template') === 'narrow.left' &&
                    $blocks['banner']['template'] == 10
                ) $arParams['BANNER'] = null;
            } else {
                $arParams['BANNER'] = null;
            }

            if (!empty($arParams['BANNER'])) {
                switch ($blocks['banner']['template']) {
                    case 1: {
                        $arParams['BANNER'] = 'template.1';
                        $arParams['BANNER_HEIGHT'] = '600';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '5';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '5';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '4';
                        $arParams['BANNER_IMAGE_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_SHOW'] = 'N';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'N';

                        break;
                    }
                    case 2: {
                        $arParams['BANNER'] = 'template.2';
                        $arParams['BANNER_HEIGHT'] = '500';
                        $arParams['BANNER_ROUNDED'] = 'Y';
                        $arParams['BANNER_BLOCKS_USE'] = 'Y';
                        $arParams['BANNER_BLOCKS_ELEMENTS_COUNT'] = '4';
                        $arParams['BANNER_BLOCKS_POSITION'] = 'both';
                        $arParams['BANNER_BLOCKS_INDENT'] = 'Y';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '1';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '1';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'N';

                        break;
                    }
                    case 3: {
                        $arParams['BANNER'] = 'template.2';
                        $arParams['BANNER_HEIGHT'] = '500';
                        $arParams['BANNER_ROUNDED'] = 'Y';
                        $arParams['BANNER_BLOCKS_USE'] = 'Y';
                        $arParams['BANNER_BLOCKS_ELEMENTS_COUNT'] = '4';
                        $arParams['BANNER_BLOCKS_POSITION'] = 'right';
                        $arParams['BANNER_BLOCKS_INDENT'] = 'Y';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '1';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '1';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'N';

                        break;
                    }
                    case 4: {
                        $arParams['BANNER'] = 'template.2';
                        $arParams['BANNER_HEIGHT'] = '500';
                        $arParams['BANNER_ROUNDED'] = 'Y';
                        $arParams['BANNER_BLOCKS_USE'] = 'Y';
                        $arParams['BANNER_BLOCKS_ELEMENTS_COUNT'] = '2';
                        $arParams['BANNER_BLOCKS_POSITION'] = 'right';
                        $arParams['BANNER_BLOCKS_INDENT'] = 'Y';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '1';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '1';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'N';

                        break;
                    }
                    case 5: {
                        $arParams['BANNER'] = 'template.1';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '2';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '2';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '1';
                        $arParams['BANNER_IMAGE_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'Y';

                        break;
                    }
                    case 6: {
                        $arParams['BANNER'] = 'template.1';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '3';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '3';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '1';
                        $arParams['BANNER_IMAGE_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '2';
                        $arParams['TRANSPARENCY'] = 'Y';

                        break;
                    }
                    case 7: {
                        $arParams['BANNER'] = 'template.1';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '3';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '3';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '2';
                        $arParams['BANNER_IMAGE_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'Y';

                        break;
                    }
                    case 8: {
                        $arParams['BANNER'] = 'template.1';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '4';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '3';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '3';
                        $arParams['BANNER_IMAGE_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'Y';

                        break;
                    }
                    case 9: {
                        $arParams['BANNER'] = 'template.3';
                        $arParams['BANNER_HEIGHT'] = '600';
                        $arParams['BANNER_ROUNDED'] = 'Y';
                        $arParams['BANNER_BLOCKS_USE'] = 'Y';
                        $arParams['BANNER_BLOCKS_ELEMENTS_COUNT'] = '2';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '5';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '4';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '4';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['BANNER_WIDE'] = 'Y';
                        $arParams['TRANSPARENCY'] = 'N';

                        break;
                    }
                    case 10: {
                        $arParams['BANNER'] = 'template.3';
                        $arParams['BANNER_HEIGHT'] = '600';
                        $arParams['BANNER_ROUNDED'] = 'Y';
                        $arParams['BANNER_BLOCKS_USE'] = 'Y';
                        $arParams['BANNER_BLOCKS_ELEMENTS_COUNT'] = '2';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '5';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '4';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '4';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['BANNER_WIDE'] = 'N';
                        $arParams['TRANSPARENCY'] = 'N';

                        break;
                    }
                    case 11: {
                        $arParams['BANNER'] = 'template.1';
                        $arParams['BANNER_HEADER_SHOW'] = 'Y';
                        $arParams['BANNER_HEADER_VIEW'] = '4';
                        $arParams['BANNER_DESCRIPTION_SHOW'] = 'Y';
                        $arParams['BANNER_DESCRIPTION_VIEW'] = '1';
                        $arParams['BANNER_HEADER_OVER_SHOW'] = 'N';
                        $arParams['BANNER_BUTTON_VIEW'] = '1';
                        $arParams['BANNER_ADDITIONAL_SHOW'] = 'Y';
                        $arParams['BANNER_ADDITIONAL_VIEW'] = '2';
                        $arParams['BANNER_SLIDER_NAV_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_NAV_VIEW'] = '1';
                        $arParams['BANNER_SLIDER_DOTS_SHOW'] = 'Y';
                        $arParams['BANNER_SLIDER_DOTS_VIEW'] = '1';
                        $arParams['TRANSPARENCY'] = 'Y';

                        break;
                    }
                    default: $arParams['BANNER'] = null; break;
                }
            }
        }
    }
}