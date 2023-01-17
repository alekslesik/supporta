<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arContact
 */

?>
<div itemscope itemtype="http://schema.org/LocalBusiness" style="display:none;">
    <?php if (!empty($arContact['NAME'])) { ?>
        <span itemprop="name">
            <?= $arContact['NAME'] ?>
        </span>
    <?php } ?>
    <?php if (!empty($arContact['SYSTEM_PROPERTIES']['ADDRESS']['VALUE'])) { ?>
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <span itemprop="streetAddress">
                <?= $arContact['SYSTEM_PROPERTIES']['ADDRESS']['VALUE'] ?>
            </span>
        </div>
    <?php } ?>
    <?php if (!empty($arContact['SYSTEM_PROPERTIES']['PHONE']['VALUE'])) { ?>
        <span itemprop="telephone">
            <?= $arContact['SYSTEM_PROPERTIES']['PHONE']['VALUE'] ?>
        </span>
    <?php } ?>
    <?php if (!empty($arContact['SYSTEM_PROPERTIES']['PHONE_HELP']['VALUE'])) { ?>
        <span itemprop="telephone">
            <?= $arContact['SYSTEM_PROPERTIES']['PHONE_HELP']['VALUE'] ?>
        </span>
    <?php } ?>
    <?php if (!empty($arContact['SYSTEM_PROPERTIES']['EMAIL']['VALUE'])) { ?>
        <span itemprop="email">
            <?= $arContact['SYSTEM_PROPERTIES']['EMAIL']['VALUE'] ?>
        </span>
    <?php } ?>
    <?php if (!empty($arContact['SYSTEM_PROPERTIES']['OPENING_HOURS']['VALUE'])) { ?>
        <time itemprop="openingHours" datetime="<?= $arContact['SYSTEM_PROPERTIES']['OPENING_HOURS']['VALUE'] ?>"></time>
    <?php } ?>
</div>