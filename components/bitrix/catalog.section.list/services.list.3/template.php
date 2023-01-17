<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;

/**
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (empty($arResult['SECTIONS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$arVisual = $arResult['VISUAL'];

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-section-list',
        'c-catalog-section-list-services-list-3'
    ],
    'data' => [
        'wide' => $arVisual['WIDE'] ? 'true' : 'false'
    ]
]) ?>
    <div class="catalog-section-list-items">
        <?php foreach ($arResult['SECTIONS'] as $arSection) { ?>
        <?php
            $sId = $sTemplateId.'_'.$arSection['ID'];
            $sAreaId = $this->GetEditAreaId($sId);
            $this->AddEditAction($sId, $arSection['EDIT_LINK']);
            $this->AddDeleteAction($sId, $arSection['DELETE_LINK']);

            $sName = $arSection['NAME'];
            $sLink = $arSection['SECTION_PAGE_URL'];
            $sDescription = $arSection['DESCRIPTION'];
            $arPicture = $arSection['PICTURE'];

            if (!empty($sDescription))
                $sDescription = Html::stripTags($sDescription);

            if (!empty($sDescription))
                $sDescription = StringHelper::truncate($sDescription, 300);

            if (!empty($arPicture)) {
                $arPicture = CFile::ResizeImageGet($arPicture, [
                    'width' => 450,
                    'height' => 450
                ], BX_RESIZE_IMAGE_PROPORTIONAL);

                if (!empty($arPicture))
                    $arPicture = [
                        'ALT' => $arSection['PICTURE']['ALT'],
                        'SRC' => $arPicture['src'],
                        'TITLE' => $arSection['PICTURE']['TITLE']
                    ];
            }

            if (empty($arPicture)) {
                $arPicture = [
                    'ALT' => null,
                    'SRC' => SITE_TEMPLATE_PATH.'/images/picture.missing.png',
                    'TITLE' => null
                ];
            }
        ?>
            <div class="catalog-section-list-item">
                <div id="<?= $sAreaId ?>" class="catalog-section-list-item-wrapper">
                    <div class="catalog-section-list-item-picture">
                        <?= Html::tag('a', null, [
                            'href' => $sLink,
                            'class' => 'intec-image-effect',
                            'style' => [
                                'background-image' => 'url(\''.$arPicture['SRC'].'\')'
                            ]
                        ]) ?>
                    </div>
                    <div class="catalog-section-list-item-information">
                        <a href="<?= $sLink ?>" class="catalog-section-list-item-name">
                            <?= $sName ?>
                        </a>
                        <?php if (!empty($sDescription)) { ?>
                            <div class="catalog-section-list-item-description">
                                <?= $sDescription ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="intec-ui-clear"></div>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::endTag('div') ?>