<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use intec\Core;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 */

$this->setFrameMode(true);

$classFirst = ($arParams['DISPLAY_FIRST_VIDEO'] == 'Y')
    ? 'video-gallery-list-item-first-big'
    : 'video-gallery-list-item'
?>

<div class="intec-content">
    <div class="intec-content-wrapper">
        <div class="video-gallery-list clearfix">
            <?php foreach($arResult["ITEMS"] as $arItem) { ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                if(isset($arItem['PROPERTIES'][$arParams['IBLOCK_PROPERTY']])) {

                    $url = $arItem['PROPERTIES'][$arParams['IBLOCK_PROPERTY']]['VALUE'];
                    $idVideo = youtube_video($url);

                ?>
                    <?= Html::beginTag('div', [
                        'class' => $classFirst,
                        'id' => $this->GetEditAreaId($arItem['ID']),
                        'data-src' => $url
                    ]) ?>
                        <div>
                            <?= Html::beginTag('div', [
                                'class' => 'video-gallery-list-item-wrapper',
                                'style' => [
                                    'background-image' =>  'url('.$idVideo['sddefault'].')',
                                ]
                            ]) ?>
                            <?= Html::endTag('div') ?>
                            <div class="video-gallery-list-item-wrapper-dark"></div>
                            <div class="video-gallery-list-item-icon">
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="video-gallery-list-item-name">
                                <?= $arItem['NAME'] ?>
                            </div>
                        </div>
                        <div itemscope itemtype="http://schema.org/VideoObject" style="display: none">
                            <span itemprop="name">
                                <?= $arItem['NAME'] ?>
                            </span>
                            <span itemprop="description">
                                <?= $arItem['NAME'] ?>
                            </span>
                            <span itemprop="thumbnail">
                                <?= $idVideo['sddefault'] ?>
                            </span>
                            <a itemprop="url" href="<?= Core::$app->request->getHostInfo().$APPLICATION->GetCurUri() ?>"></a>
                            <a itemprop="thumbnailUrl" href="<?= $idVideo['sddefault'] ?>"></a>
                            <span itemprop="uploadDate">
                                <?php $qwe = MakeTimeStamp($arItem['DATE_CREATE']) ?>
                                <?= date('Y-m-d', $qwe) ?>
                            </span>
                            <span itemprop="isFamilyFriendly">
                                True
                            </span>
                        </div>
                    <?= Html::endTag('div') ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $('.video-gallery-list').lightGallery();
</script>
