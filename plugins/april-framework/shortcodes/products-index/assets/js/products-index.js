(function ($) {
    "use strict";
    var G5PlusProductsIndex = {
        init: function () {
            G5PlusProductsIndex.events();
        },
        events: function () {
            $('.gsf-products-index').each(function () {
                var owl_carousel = $('.products-wrap .owl-carousel', $(this)),
                    product_index = $('.product-index-wrap', $(this));
                owl_carousel.on('changed.owl.carousel', function(el) {
                    var item = $('[data-item-index="' + el.item.index + '"]', product_index);
                    product_index.find('.active').removeClass('active');
                    item.addClass('active');
                });
                $('.index-item', product_index).on('click', function (event) {
                    event.preventDefault();
                    if ($(this).hasClass('active')) return;
                    var index = $(this).data('item-index');
                    owl_carousel.data('owl.carousel').to(index, 300, true);
                });
            });
        }
    };
    $(document).ready(function() {
        G5PlusProductsIndex.init()
    });
})(jQuery);