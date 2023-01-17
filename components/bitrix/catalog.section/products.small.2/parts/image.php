<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\Html;

$vImage = function (&$arItem) {
    $sPicture = $arItem['PICTURE'];

    if (!empty($sPicture)) {
        $sPicture = CFile::ResizeImageGet($sPicture, [
            'width' => 300,
            'height' => 300
        ], BX_RESIZE_IMAGE_PROPORTIONAL);

        if (!empty($sPicture))
            $sPicture = $sPicture['src'];
    }

    if (empty($sPicture))
        $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';
?>
    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="catalog-section-item-picture-wrap intec-image-effect">
        <?= Html::tag('div', '', [
            'class' => 'catalog-section-item-picture',
            'style' => [
                'background-image' => 'url('.$sPicture.')'
            ]
        ]) ?>
    </a>
<?php };