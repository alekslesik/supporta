<?php if (defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true) ?>
<?php

use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (empty($arResult['BRAND']['PICTURE']))
    return;

$sPicture = $arResult['BRAND']['PICTURE'];
$sPicture = CFile::ResizeImageGet($sPicture, [
    'width' => 200,
    'height' => 60
], BX_RESIZE_IMAGE_PROPORTIONAL);

if (!empty($sPicture))
    $sPicture = $sPicture['src'];

if (empty($sPicture)) {
    unset($sPicture);
    return;
}

?>
<div class="catalog-element-brand">
    <a href="<?= $arResult['BRAND']['DETAIL_PAGE_URL'] ?>">
        <?= Html::img($sPicture, [
            'alt' => $arResult['BRAND']['NAME'],
            'title' => $arResult['BRAND']['NAME']
        ]) ?>
    </a>
</div>
<?php

unset($sPicture);