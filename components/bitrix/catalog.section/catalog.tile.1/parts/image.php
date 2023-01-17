<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$vImage = function (&$arItem) use (&$arVisual) {
    $fRender = function ($arPicture, $sName, $sLink, &$arOffer = null) {
        $sPicture = $arPicture;

        if (!empty($sPicture)) {
            $sPicture = CFile::ResizeImageGet($sPicture, [
                'width' => 450,
                'height' => 450
            ], BX_RESIZE_IMAGE_PROPORTIONAL);

            if (!empty($sPicture))
                $sPicture = $sPicture['src'];
        }

        if (empty($sPicture))
            $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';
    ?>
        <?= Html::beginTag('a', [
            'href' => $sLink,
            'class' => [
                'catalog-section-item-image-look',
                'intec-image',
                'intec-image-effect'
            ],
            'data' => [
                'offer' => !empty($arOffer) ? $arOffer['ID'] : 'false'
            ]
        ]) ?>
            <div class="intec-aligner"></div>
            <img src="<?= $sPicture ?>" alt="<?= Html::encode($sName) ?>" title="<?= Html::encode($sName) ?>" />
        <?= Html::endTag('a') ?>
    <?php };

    $fRender(
        $arItem['PICTURE'],
        $arItem['NAME'],
        $arItem['DETAIL_PAGE_URL']
    );

    if ($arVisual['OFFERS']['USE'] && !empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer)
            $fRender(
                !empty($arOffer['PICTURE']) ? $arOffer['PICTURE'] : $arItem['PICTURE'],
                $arItem['NAME'],
                $arItem['DETAIL_PAGE_URL'],
                $arOffer
            );
};