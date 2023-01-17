<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
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
    <?= Html::beginTag('div', [
        'class' => 'catalog-element-gallery',
        'data' => [
            'role' => 'gallery',
            'offer' => $bOffer ? $arItem['ID'] : 'false'
        ]
    ]) ?>
        <div class="catalog-element-gallery-items">
            <?= Html::beginTag('div', [
                'class' => Html::cssClassFromArray([
                    'catalog-element-gallery-items-wrapper' => true,
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
                        <?= Html::beginTag('div', [
                            'class' => [
                                'catalog-element-gallery-item',
                                'intec-image'
                            ],
                            'data' => [
                                'role' => 'gallery.picture'
                            ]
                        ]) ?>
                            <div class="intec-aligner"></div>
                            <?= Html::img($arPictureResize['src'], [
                                'alt' => Html::encode($arResult['NAME']),
                                'title' => Html::decode($arResult['NAME'])
                            ]) ?>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                <?php } else { ?>
                    <div class="catalog-element-gallery-item intec-image">
                        <div class="intec-aligner"></div>
                        <?= Html::img(SITE_TEMPLATE_PATH.'/images/picture.missing.png', [
                            'alt' => $arResult['NAME'],
                            'title' => $arResult['NAME']
                        ]) ?>
                    </div>
                <?php } ?>
            <?= Html::endTag('div') ?>
        </div>
        <?php if ($arVisual['GALLERY']['PREVIEW'] && count($arItem['PICTURES']) > 1) { ?>
            <div class="catalog-element-gallery-previews owl-carousel" data-role="gallery.previews">
                <?php foreach ($arItem['PICTURES'] as $arPicture) {

                    $arPictureResize = CFile::ResizeImageGet($arPicture, [
                        'width' => 100,
                        'height' => 100
                    ], BX_RESIZE_IMAGE_PROPORTIONAL);

                ?>
                    <?= Html::beginTag('div', [
                        'class' => 'catalog-element-gallery-preview',
                        'data' => [
                            'role' => 'gallery.preview',
                            'active' => 'false'
                        ]
                    ]) ?>
                        <div class="intec-aligner"></div>
                        <?= Html::img($arPictureResize['src'], [
                            'alt' => $arResult['NAME'],
                            'title' => $arResult['NAME']
                        ]) ?>
                    <?= Html::endTag('div') ?>
                <?php } ?>
            </div>
        <?php } ?>
    <?= Html::endTag('div') ?>
<?php };

$vGallery($arResult);

if (!empty($arResult['OFFERS']))
    foreach ($arResult['OFFERS'] as &$arOffer) {
        $vGallery($arOffer, true);

        unset($arOffer);
    }

unset($vGallery);