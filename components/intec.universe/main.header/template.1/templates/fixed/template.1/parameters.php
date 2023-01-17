<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\UnsetArrayValue;

$arReturn = [];

$arReturn['ADDRESS_SHOW_FIXED'] = new UnsetArrayValue();
$arReturn['PHONES_SHOW_FIXED'] = new UnsetArrayValue();
$arReturn['EMAIL_SHOW_FIXED'] = new UnsetArrayValue();
$arReturn['TAGLINE_SHOW_FIXED'] = new UnsetArrayValue();

return $arReturn;