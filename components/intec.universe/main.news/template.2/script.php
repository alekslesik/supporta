<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arVisual
 */

$arSlider = $arVisual['SLIDER'];
$arResponsiveReady = [];

if ($arSlider['ITEMS'] > 1) {
    $arResponsive = [
        '1' => ['0' => ['items' => 1]],
        '2' => ['640' => ['items' => 2]],
        '3' => ['960' => ['items' => ($arSlider['ITEMS'] >= 3) ? "3" : "2"]],
        '4' => ['1201' => ['items' => $arSlider['ITEMS']]]
    ];

    foreach ($arResponsive as $iKey => $arLineElements) {
        if ($iKey <= $arSlider['ITEMS'])
            $arResponsiveReady += $arLineElements;
    }

    $arResponsiveReady = JavaScript::toObject($arResponsiveReady);
}

?>
<script>
    (function ($, api) {
        $(document).ready(function () {
            var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
            var slider = $('.owl-carousel', root);
            var parent = slider.parent().parent();
            var navigation = parent.find('.widget-navigation');
            var dots = parent.find('.widget-dots');
            var refresh = function (event) {
                if (event.page.size < event.item.count) {
                    navigation.show();
                } else {
                    navigation.hide();
                }
            };

            slider.on('initialized.owl.carousel', refresh)
                .on('resized.owl.carousel', refresh)
                .on('refreshed.owl.carousel', refresh);

            slider.owlCarousel({
                items: <?= $arVisual['COLUMNS'] ?>,
                autoplay: <?= $arSlider['AUTO']['USE'] ? 'true' : 'false' ?>,
                autoplaySpeed: <?= $arSlider['SPEED'] ?>,
                autoplayTimeout: <?= $arSlider['AUTO']['TIME'] ?>,
                autoplayHoverPause: <?= $arSlider['AUTO']['HOVER'] ? 'true' : 'false' ?>,
                loop: <?= $arSlider['LOOP'] ? 'true' : 'false' ?>,
                nav: false,
                navText: ['', ''],
                dots: true,
                dotsData: false,
                dotsContainer: dots,
                margin: 2,
                <?php if ($arSlider['ITEMS'] > 1) { ?>
                    responsive: <?= $arResponsiveReady ?>
                <?php } ?>
            });
            navigation.find('[data-move]').on('click', function (event) {
                var self = $(this);
                var value = self.data('move');

                if (value == 'next') {
                    slider.trigger('next.owl.carousel');
                } else if (value == 'previous') {
                    slider.trigger('prev.owl.carousel');
                } else {
                    slider.trigger('to.owl.carousel', [value])
                }
            });
        });
    })(jQuery, intec)
</script>