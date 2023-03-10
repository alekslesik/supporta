<?php if (!defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;
use intec\core\helpers\Type;

/**
 * @var array $arVisual
 */

$vImage = function (&$arItem) use (&$arVisual) {
    $fRender = function ($arPictures, $sName, $sLink, &$arOffer = null) use (&$arVisual) {
        $bSlider = false;

        if (!empty($arPictures) && Type::isArray($arPictures)) {
            foreach ($arPictures as $iKey => $arPicture) {
                $arPicture = CFile::ResizeImageGet(
                    $arPicture,
                    [
                        'width' => 450,
                        'height' => 450
                    ],
                    BX_RESIZE_IMAGE_PROPORTIONAL_ALT
                );

                if (!empty($arPicture))
                    $arPictures[$iKey] = $arPicture['src'];
            }
        }

        if (empty($arPictures) && !empty($arOffer))
            return;

        if (empty($arPictures))
            $arPictures[] = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

        if ($arVisual['IMAGE']['SLIDER'] && count($arPictures) > 1)
            $bSlider = true;

    ?>
        <?= Html::beginTag('div', [
            'class' => [
                'widget-item-image',
                'intec-image'
            ],
            'data' => [
                'role' => 'image',
                'offer' => !empty($arOffer) ? $arOffer['ID'] : 'false',
                'view' => $arVisual['OFFERS']['VIEW']
            ]
        ]) ?>
            <?php if ($bSlider) { ?>
                <div class="widget-item-image-wrapper widget-item-image-slider owl-carousel">
                    <?php foreach ($arPictures as $sPicture) { ?>
                        <a class="widget-item-image-element intec-image-effect" href="<?= Html::decode($sLink) ?>">
                            <div class="intec-aligner"></div>
                            <?= Html::img($sPicture, [
                                'alt' => Html::decode($sName),
                                'title' => Html::decode($sName)
                            ]) ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } else {

                $sPicture = $arPictures[0];

            ?>
                <a class="widget-item-image-wrapper intec-image-effect" href="<?= Html::decode($sLink) ?>">
                    <div class="intec-aligner"></div>
                    <?= Html::img($sPicture, [
                        'alt' => Html::decode($sName),
                        'title' => Html::decode($sName)
                    ]) ?>
                </a>
            <?php } ?>
        <?= Html::endTag('div') ?>
    <?php };

    $fRender(
        $arItem['PICTURES'],
        $arItem['NAME'],
        $arItem['DETAIL_PAGE_URL']
    );

    if (!empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer)
            $fRender(
                !empty($arOffer['PICTURES']) ? $arOffer['PICTURES'] : $arItem['PICTURES'],
                $arItem['NAME'],
                $arItem['DETAIL_PAGE_URL'],
                $arOffer
            );
};