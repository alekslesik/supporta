<?php if (!defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED !== true) die;

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\Type;


/**
 * @param $arItem
 * @param bool $bOffer
 */
$vImage = function (&$arItem, $bOffer = false) use (&$arVisual) {
    /**
     * @param $arPictures
     * @param $sName
     * @param $sLink
     * @param null $arOffer
     */
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
                'catalog-section-item-image',
                'intec-image'
            ],
            'data' => [
                'role' => 'item.image',
                'offer' => !empty($arOffer) ? $arOffer['ID'] : 'false',
            ]
        ]) ?>
            <?php if ($bSlider) { ?>
                <div class="catalog-section-item-image-wrapper catalog-section-item-image-slider owl-carousel">
                    <?php foreach ($arPictures as $sPicture) { ?>
                        <a class="catalog-section-item-image-element intec-image-effect" href="<?= Html::decode($sLink) ?>">
                            <div class="intec-aligner"></div>
                            <?= Html::img($sPicture, [
                                'alt' => Html::decode($sName),
                                'title' => Html::decode($sName)
                            ]) ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } else {

                $sPicture = ArrayHelper::shift($arPictures);

            ?>
                <a class="catalog-section-item-image-wrapper intec-image-effect" href="<?= Html::decode($sLink) ?>">
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

    if ($arVisual['OFFERS']['USE'] && !empty($arItem['OFFERS']))
        foreach ($arItem['OFFERS'] as &$arOffer)
            $fRender(
                $arOffer['PICTURES'],
                $arItem['NAME'],
                $arItem['DETAIL_PAGE_URL'],
                $arOffer
            );
};