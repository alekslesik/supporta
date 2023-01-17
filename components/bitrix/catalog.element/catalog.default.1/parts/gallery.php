<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arVisual
 */

/**
 * @param $arItem
 * @param bool $bOffer
 */
$vGallery = function (&$arItem, $bOffer = false) use (&$arResult, &$arVisual) {
    if ($bOffer && empty($arItem['PICTURES']))
        return;
?>
    <div class="catalog-element-gallery" data-role="gallery" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>">
        <?= Html::beginTag('div', [
            'class' => Html::cssClassFromArray([
                'catalog-element-gallery-pictures' => true,
                'owl-carousel' => !empty($arItem['PICTURES'])
            ], true),
            'data' => [
                'role' => !empty($arItem['PICTURES']) ? 'gallery.pictures' : 'gallery.empty'
            ]
        ]) ?>
            <?php if (!empty($arItem['PICTURES'])) { ?>
                <?php foreach ($arItem['PICTURES'] as $arPicture) {

                    $arPictureResize = CFile::ResizeImageGet($arPicture, [
                        'width' => 500,
                        'height' => 500
                    ], BX_RESIZE_IMAGE_PROPORTIONAL);

                ?>
                    <?= Html::beginTag('a', [
                        'href' => $arPicture['SRC'],
                        'class' => [
                            'catalog-element-gallery-picture'
                        ],
                        'data' => [
                            'role' => 'gallery.picture',
                            'src' => $arPicture['SRC']
                        ]
                    ]) ?>
                        <div class="catalog-element-gallery-picture-wrapper intec-image">
                            <div class="intec-aligner"></div>
                            <?= Html::img($arPictureResize['src'], [
                                'alt' => Html::encode($arResult['NAME']),
                                'title' => Html::encode($arResult['NAME'])
                            ]) ?>
                        </div>
                    <?= Html::endTag('a') ?>
                <?php } ?>
            <?php } else { ?>
                <div class="catalog-element-gallery-picture intec-image" data-active="true">
                    <div class="catalog-element-gallery-picture-wrapper intec-image">
                        <div class="intec-aligner"></div>
                        <?= Html::img(SITE_TEMPLATE_PATH.'/images/picture.missing.png', [
                            'alt' => Html::encode($arResult['NAME']),
                            'title' => Html::encode($arResult['NAME'])
                        ]) ?>
                    </div>
                </div>
            <?php } ?>
        <?= Html::endTag('div') ?>
        <?php if (Type::isArray($arItem['PICTURES']) && $arVisual['GALLERY']['SLIDER'] && count($arItem['PICTURES']) > 1) { ?>
            <div class="catalog-element-gallery-previews owl-carousel" data-role="gallery.previews">
                <?php $bPictureFirst = true ?>
                <?php foreach ($arItem['PICTURES'] as $arPicture) { ?>
                <?php
                    $arPictureResize = CFile::ResizeImageGet($arPicture, [
                        'width' => 120,
                        'height' => 120
                    ], BX_RESIZE_IMAGE_PROPORTIONAL);
                ?>
                    <div class="catalog-element-gallery-preview" data-active="<?= $bPictureFirst ? 'true' : 'false' ?>" data-role="gallery.preview">
                        <div class="catalog-element-gallery-preview-wrapper">
                            <div class="catalog-element-gallery-preview-wrapper-2 intec-image">
                                <div class="intec-aligner"></div>
                                <?= Html::img($arPictureResize['src'], [
                                    'alt' => Html::encode($arResult['NAME']),
                                    'title' => Html::encode($arResult['NAME'])
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    <?php $bPictureFirst = false ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php };

$vGallery($arResult);

if (!empty($arResult['OFFERS']))
    foreach ($arResult['OFFERS'] as &$arOffer) {
        $vGallery($arOffer, true);

        unset($arOffer);
    }

unset($vGallery);