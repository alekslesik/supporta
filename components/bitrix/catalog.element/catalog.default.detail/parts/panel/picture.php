<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

/**
 * @var array $arResult
 */

/**
 * @param $arItem
 * @param bool $bOffer
 */
$vPicture = function (&$arItem, $bOffer = false) use (&$arResult) {

    if (!empty($arItem['DETAIL_PICTURE']))
        $arPicture = $arItem['DETAIL_PICTURE'];
    else if (!empty($arItem['PREVIEW_PICTURE']))
        $arPicture = $arItem['PREVIEW_PICTURE'];

    if ($bOffer && empty($arPicture))
        return;

?>
    <div class="catalog-element-panel-picture-item intec-image" data-offer="<?= $bOffer ? $arItem['ID'] : 'false' ?>" data-role="panel.picture">
        <div class="intec-aligner"></div>
        <?php if (!empty($arPicture)) {

            $arPicture = CFile::ResizeImageGet($arPicture,[
                'width' => 120,
                'height' => 120
            ], BX_RESIZE_IMAGE_PROPORTIONAL_ALT)

        ?>
            <?= Html::img($arPicture['src'], [
                'alt' => $arResult['NAME'],
                'title' => $arResult['NAME']
            ]) ?>
        <?php } else { ?>
            <?= Html::img(SITE_TEMPLATE_PATH.'/images/picture.missing.png', [
                'alt' => $arResult['NAME'],
                'title' => $arResult['NAME'],
            ]) ?>
        <?php } ?>
    </div>
<?php };

$vPicture($arResult);

if (!empty($arResult['OFFERS'])) {
    foreach ($arResult['OFFERS'] as $arOffer)
        $vPicture($arOffer, true);

    unset($arOffer);
}

unset($vPicture);