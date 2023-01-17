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
        'c-catalog-section-list-services-tile-2'
    ],
    'data' => [
        'columns' => $arVisual['COLUMNS'],
        'wide' => $arVisual['WIDE'] ? 'true' : 'false'
    ]
]) ?>
    <div class="<?= Html::cssClassFromArray([
        'catalog-section-list-items',
        'intec-grid' => [
            '',
            'wrap',
            'a-h-start',
            'a-v-stretch',
            'i-10'
        ]
    ]) ?>">
        <?php foreach ($arResult['SECTIONS'] as $arSection) { ?>
        <?php
            $sId = $sTemplateId.'_'.$arSection['ID'];
            $sAreaId = $this->GetEditAreaId($sId);
            $this->AddEditAction($sId, $arSection['EDIT_LINK']);
            $this->AddDeleteAction($sId, $arSection['DELETE_LINK']);

            $sName = $arSection['NAME'];
            $sLink = $arSection['SECTION_PAGE_URL'];
            $sDescription = null;
            $arPicture = $arSection['PICTURE'];

            if ($arVisual['DESCRIPTION']['SHOW']) {
                $sDescription = $arSection['DESCRIPTION'];

                if (!empty($sDescription))
                    $sDescription = Html::stripTags($sDescription);

                if (!empty($sDescription))
                    $sDescription = StringHelper::truncate($sDescription, 125);
            }

            if (!empty($arPicture)) {
                $arPicture = CFile::ResizeImageGet($arPicture, [
                    'width' => 600,
                    'height' => 600
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
            <div class="<?= Html::cssClassFromArray([
                'catalog-section-list-item' => true,
                'intec-grid-item' => [
                    $arVisual['COLUMNS'] => true,
                    '1050-2' => !$arVisual['WIDE'] && $arVisual['COLUMNS'] >= 3,
                    '750-1' => !$arVisual['WIDE'],
                    '720-2' => !$arVisual['WIDE'],
                    '1000-3' => $arVisual['WIDE'] && $arVisual['COLUMNS'] >= 4,
                    '750-2' => $arVisual['WIDE'] && $arVisual['COLUMNS'] >= 3,
                    '450-1' => true
                ]
            ], true) ?>">
                <div id="<?= $sAreaId ?>" class="catalog-section-list-item-wrapper">
                    <?= Html::beginTag('div', [
                        'class' => 'catalog-section-list-item-picture',
                        'data' => [
                            'type' => $arVisual['PICTURE']['TYPE'],
                            'indents' => $arVisual['PICTURE']['INDENTS'] ? 'true' : 'false'
                        ]
                    ]) ?>
                        <a href="<?= $sLink ?>" style="background-image: url('<?= $arPicture['SRC'] ?>');"></a>
                    <?= Html::endTag('div') ?>
                    <div class="catalog-section-list-item-information">
                        <div class="catalog-section-list-item-name" data-alignment="<?= $arVisual['NAME']['POSITION'] ?>">
                            <a href="<?= $sLink ?>"><?= $sName ?></a>
                        </div>
                        <?php if (!empty($sDescription)) { ?>
                            <div class="catalog-section-list-item-description" data-alignment="<?= $arVisual['DESCRIPTION']['POSITION'] ?>">
                                <?= $sDescription ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::endTag('div') ?>