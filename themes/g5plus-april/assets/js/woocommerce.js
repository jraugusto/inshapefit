var G5_Woocommerce = window.G5_Woocommerce || {};
(function ($) {
    "use strict";
    window.G5_Woocommerce = G5_Woocommerce;

    var $body = $('body'),
        isLazy = $body.hasClass('gf-lazy-load'),
        isRTL = $body.hasClass('rtl');

    G5_Woocommerce = {
        init : function () {
            this.initSwitchLayout();
            this.processTabs();
            this.updateAjaxPosts();
            this.addToWishlist();
            this.addToCart();
            this.quickView();
            this.addCartQuantity();
            var $productImageWrap = $('#single-product-image');
            this.singleProductImage($productImageWrap);
            setTimeout(function () {
                G5_Woocommerce.setCartScrollBar();
            }, 500);
            this.saleCountdown();
            this.yith_wcan_ajax_filtered();
        },
        initSwitchLayout: function () {
            var handle = false;
            $(document).on('click', '.gf-shop-switch-layout li a', function (event) {
                event.preventDefault();
                var $this = $(this),
                    $layout = $this.data('layout'),
                    product_wrap = $this.closest('.gsf-product-wrap').find('[data-items-container="true"]'),
                    paging = $this.closest('.gsf-product-wrap').find('.gf-paging');
                if(!$this.closest('li').hasClass('active') && !handle) {
                    handle = true;
                    $this.closest('.gf-shop-switch-layout').children('li').removeClass('active');
                    $this.closest('li').addClass('active');
                    //product_wrap.fadeOut();
                    paging.fadeOut();
                    $this.waypoint(function () {
                        $(this.element).addClass("wpb_start_animation animated");
                        this.destroy();
                    });
                    product_wrap.fadeOut(function () {
                        if('list' === $layout) {
                            product_wrap.removeClass('layout-grid').addClass('layout-list');
                        } else {
                            product_wrap.removeClass('layout-list').addClass('layout-grid');
                        }
                        G5_Core.util.tooltip();
                        product_wrap.fadeIn('slow');
                        paging.fadeIn('slow');
                    });

                    $.cookie('product_layout', $layout, {expires: 15});
                    handle = false;
                }
            });
        },
        processTabs: function () {
            $('.gsf-pretty-tabs').each(function () {
                var $this = $(this);
                if($this.closest('.custom-product-row').length > 0) {
                    var heading = $this.closest('.custom-product-row').find('.gf-heading');
                    if(heading.length > 0) {
                        var heading_width = heading.find('.heading-title').outerWidth();
                        if(isRTL) {
                            $this.css('margin-right', (heading_width + 30));
                        } else {
                            $this.css('margin-left', (heading_width + 30));
                        }
                        $this.gsfPrettyTabs();
                    }
                }
            });
        },
        updateAjaxPosts : function () {
            var _that = this;
            $body.on('gf_pagination_ajax_success', function (event, data,$ajaxHTML) {
                if (data.settings['post_type'] === 'product') {
                    _that.updateResultCount($(event.target),data,$ajaxHTML);
                    $(event.target).imagesLoaded({background: true}, function () {
                        $(event.target).trigger('gf_update_ajax_product',[data]);
                        G5_Core.util.tooltip();
                        G5_Woocommerce.saleCountdown();
                    });
                }
            });
        },
        updateResultCount : function ($wrapper,data,$ajaxHTML) {
            var $resultCount = $wrapper.find('.woocommerce-result-count'),
                $resultCountResult = $ajaxHTML.find('.woocommerce-result-count');
            if (($resultCount.length === 0) || ($resultCountResult.length === 0)) return;
            $resultCount.html($resultCountResult.html());
        },
        addToWishlist : function() {
            $(document).on('click', '.add_to_wishlist', function () {
                var button = $(this),
                    buttonWrap = button.parent().parent();

                if (!buttonWrap.parent().hasClass('single-product-function')) {
                    button.addClass("added-spinner");
                    var productWrap = buttonWrap.parent().parent().parent().parent();
                    if (typeof(productWrap) === 'undefined') {
                        return;
                    }
                    productWrap.addClass('active');
                }
            });

            $body.on("added_to_wishlist", function (event, fragments, cart_hash, $thisbutton) {
                var button = $('.added-spinner.add_to_wishlist'),
                    buttonWrap = button.parent().parent();
                if (!buttonWrap.parent().hasClass('single-product-function')) {
                    var productWrap = buttonWrap.parent().parent().parent().parent();
                    if (typeof(productWrap) === 'undefined') {
                        return;
                    }
                    setTimeout(function () {
                        productWrap.removeClass('active');
                        button.removeClass('added-spinner');
                    }, 700);
                }
            });
        },
        addToCart: function() {
            $(document).on('click', '.add_to_cart_button', function () {
                var button = $(this);
                if (!button.hasClass('single_add_to_cart_button') && button.is( '.product_type_simple' )) {
                    var productWrap = button.closest('.product-item-wrap');
                    if (typeof(productWrap) === 'undefined') {
                        return;
                    }
                    productWrap.addClass('active');
                }
            });

            $body.on('wc_cart_button_updated',function (event,$button) {
                var header_sticky = $('.header-sticky-wrapper .header-sticky'),
                    mini_cart = $('.item-shopping-cart', header_sticky);
                var is_single_product = $button.hasClass('single_add_to_cart_button');

                if (is_single_product) return;

                var buttonWrap = $button.parent(),
                    buttonViewCart = buttonWrap.find('.added_to_cart'),
                    addedTitle = buttonViewCart.text(),
                    productWrap = buttonWrap.closest('.product-item-wrap');

                $button.remove();
                buttonViewCart.html('<i class="fa fa-check"></i> ' + addedTitle);
                setTimeout(function () {
                    buttonWrap.tooltip('hide').attr('title', addedTitle).tooltip('fixTitle');
                }, 500);
                setTimeout(function () {
                    G5_Woocommerce.setCartScrollBar(function () {
                        if(mini_cart.length > 0) {
                            var timeOut = 0;
                            if(header_sticky.hasClass('header-hidden')) {
                                header_sticky.removeClass('header-hidden');
                                timeOut = 500;
                            }
                            setTimeout(function () {
                                mini_cart.addClass('show-cart');
                                setTimeout(function () {
                                    mini_cart.removeClass('show-cart');
                                }, 2000);
                            }, timeOut);
                        }
                    });
                }, 10);
                setTimeout(function () {
                    productWrap.removeClass('active');
                }, 700);
            });
        },
        quickView: function(){
            var is_click_quick_view = false;
            $(document).on('click', '.product-quick-view', function (event) {
                event.preventDefault();
                if (is_click_quick_view) return;

                is_click_quick_view = true;
                var $this = $(this),
                    product_id = $this.data('product_id'),
                    popupWrapper = '#popup-product-quick-view-wrapper',
                    $icon = $this.find('i'),
                    iconClass = $icon.attr('class'),
                    productWrap = $this.parent().parent().parent().parent(),
                    button = $this,
                    is_pagination = ($this.hasClass('prev-product') || $this.hasClass('next-product'));
                productWrap.addClass('active');
                button.addClass('active');
                $icon.attr('class','fa fa-spinner fa-pulse');
                $.ajax({
                    url: g5plus_variable.ajax_url,
                    data: {
                        action: 'product_quick_view',
                        id: product_id
                    },
                    success: function (html) {
                        productWrap.removeClass('active');
                        button.removeClass('active');
                        $icon.attr('class',iconClass);
                        var modal_body = $('.modal-body', popupWrapper);
                        if(!is_pagination) {
                            if ($(popupWrapper).length) {
                                $(popupWrapper).remove();
                            }
                            $body.append(html);
                            var $productImageWrap = $('.quick-view-product-image', popupWrapper);
                            G5_Woocommerce.singleProductImage($productImageWrap);
                            if( typeof $.fn.wc_variation_form !== 'undefined' ) {
                                var form_variation = $(popupWrapper).find( '.variations_form' );
                                var form_variation_select = $(popupWrapper).find( '.variations_form .variations select' );
                                form_variation.wc_variation_form();
                                form_variation.trigger( 'check_variations' );
                                form_variation_select.change();
                            }
                            $(popupWrapper).modal();
                            G5_Core.util.tooltip();
                            G5_Woocommerce.saleCountdown();
                            $(popupWrapper).find('.single-product-image-thumb a').off('click').on('click', function (e) {
                                e.preventDefault();
                            });
                        } else {
                            var modal_content = $('.modal-content', popupWrapper),
                                quickview_navigation = $('.product-quickview-navigation', popupWrapper);
                            modal_content.css({
                                width: modal_content.width(),
                                height: modal_content.height()
                            });
                            modal_body.fadeOut(function () {
                                modal_body.html($('.modal-body', html).html()).fadeIn();
                                quickview_navigation.html($('.product-quickview-navigation', html).html());
                                var $productImageWrap = $('.quick-view-product-image', modal_body);
                                G5_Woocommerce.singleProductImage($productImageWrap);
                                if( typeof $.fn.wc_variation_form !== 'undefined' ) {
                                    var form_variation = $(popupWrapper).find( '.variations_form' );
                                    var form_variation_select = $(popupWrapper).find( '.variations_form .variations select' );
                                    form_variation.wc_variation_form();
                                    form_variation.trigger( 'check_variations' );
                                    form_variation_select.change();
                                }
                                $(popupWrapper).addClass('in');
                                $(popupWrapper).fadeIn();
                                setTimeout(function () {
                                    modal_content.css({
                                        width: '',
                                        height: ''
                                    });
                                }, 1000);
                                G5_Core.util.tooltip();
                                G5_Woocommerce.saleCountdown();
                                $(modal_content).find('.single-product-image-thumb a').off('click').on('click', function (e) {
                                    e.preventDefault();
                                });
                            });
                        }

                        G5_Woocommerce.addCartQuantity();
                        is_click_quick_view = false;
                    },
                    error: function (html) {
                        is_click_quick_view = false;
                    }
                });

            });
        },
        addCartQuantity: function(){
            $(document).off('click', '.quantity .btn-number').on('click', '.quantity .btn-number', function (event) {
                event.preventDefault();
                var type = $(this).data('type'),
                    input = $('input', $(this).parent()),
                    current_value = parseFloat(input.val()),
                    max  = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    step = parseFloat(input.attr('step')),
                    stepLength = 0;
                if (input.attr('step').indexOf('.') > 0) {
                    stepLength = input.attr('step').split('.')[1].length;
                }

                if (isNaN(max)) {
                    max = 100;
                }
                if (isNaN(min)) {
                    min = 0;
                }
                if (isNaN(step)) {
                    step = 1;
                    stepLength = 0;
                }

                if (!isNaN(current_value)) {
                    if (type == 'minus') {
                        if (current_value > min) {
                            current_value = (current_value - step).toFixed(stepLength);
                            input.val(current_value).change();
                        }

                        if (parseFloat(input.val()) <= min) {
                            input.val(min).change();
                            $(this).attr('disabled', true);
                        }
                    }

                    if (type == 'plus') {
                        if (current_value < max) {
                            current_value = (current_value + step).toFixed(stepLength);
                            input.val(current_value).change();
                        }
                        if (parseFloat(input.val()) >= max) {
                            input.val(max).change();
                            $(this).attr('disabled', true);
                        }
                    }
                } else {
                    input.val(min);
                }
            });


            $('input', '.quantity').on('focusin',function () {
                $(this).data('oldValue', $(this).val());
            });

            $('input', '.quantity').on('change', function () {
                var input = $(this),
                    max = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    current_value = parseFloat(input.val()),
                    step = parseFloat(input.attr('step'));

                if (isNaN(max)) {
                    max = 100;
                }
                if (isNaN(min)) {
                    min = 0;
                }

                if (isNaN(step)) {
                    step = 1;
                }


                var btn_add_to_cart = $('.add_to_cart_button', $(this).parent().parent().parent());
                if (current_value >= min) {
                    $(".btn-number[data-type='minus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }

                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));

                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

                if (current_value <= max) {
                    $(".btn-number[data-type='plus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

            });
        },
        setCartScrollBar: function (callback) {
            $('.cart_list.product_list_widget').perfectScrollbar({
                wheelSpeed: 0.5,
                suppressScrollX: true
            });
            if (callback) {
                callback();
            }
        },
        singleProductImage: function($productImageWrap){
            var single_main = $productImageWrap.find('.single-product-image-main'),
                zoom_image = single_main.find('.zoom-image'),
                main_image = single_main.find('img').attr('srcset', ''),
                slider_thumb = $productImageWrap.find('.single-product-image-thumb').addClass('hidden'),
                time_out = null;

            slider_thumb.on('initialized.owl.carousel', function (event) {
                slider_thumb.find(".owl-item").eq(0).addClass("current");
                setTimeout(function () {
                    slider_thumb.removeClass('hidden');
                }, 1000);
            }).owlCarousel({
                items : 5,
                nav: false,
                dots: false,
                rtl: isRTL,
                lazyLoad: isLazy,
                margin: 10,
                responsive: {
                    992 : {
                        items : 5
                    },
                    768 : {
                        items : 3
                    }
                }
            }).on('changed.owl.carousel', syncPosition);

            function syncPosition(el) {
                var selector = $(el.target).find('[data-index="' + el.item.index + '"]'),
                    large_img = selector.attr('data-large-image'),
                    origin_img = selector.attr('href'),
                    owl_current = selector.closest('.owl-item');
                $(el.target).find('.owl-item').removeClass('current');
                owl_current.addClass('current');
                zoom_image.attr('href', origin_img);
                if (time_out != null) {
                    clearTimeout(time_out);
                }
                time_out = setTimeout(function () {
                    main_image.stop().animate({opacity:0}, function()
                    {
                        main_image.attr('src', large_img);
                        main_image.imagesLoaded({src: true}, function () {
                            main_image.animate({opacity: 1});
                            G5_Core.util.magnificPopup();
                        });
                    });
                }, 200);
            }

            slider_thumb.on("mouseenter", ".owl-item", function(e){
                e.preventDefault();
                if ($(this).hasClass('current')) return;
                var number = $(this).index();
                var selector = $(this).find('[data-index="' + number + '"]'),
                    large_img = selector.attr('data-large-image'),
                    origin_img = selector.attr('href');
                $(this).closest('.owl-carousel').find('.owl-item').removeClass('current');
                $(this).addClass('current');
                zoom_image.attr('href', origin_img);
                if (time_out != null) {
                    clearTimeout(time_out);
                }
                time_out = setTimeout(function () {
                    main_image.stop().animate({opacity:0}, function()
                    {
                        main_image.attr('src', large_img);
                        main_image.imagesLoaded({src: true}, function () {
                            main_image.animate({opacity: 1});
                            G5_Core.util.magnificPopup();
                        });
                    });
                }, 200);
            });

            $(document).on('found_variation',function(event,variation){
                if ((typeof variation !== 'undefined') && (typeof variation.variation_id !== 'undefined')) {
                    var variation_id = variation.variation_id,
                        selector = $('a[data-variation_id*="|'+variation_id+'|"]',slider_thumb),
                        owl_current = selector.closest('.owl-item');
                    owl_current.trigger('mouseenter');
                }
            });

            $(document).on('reset_data',function(event){
                $('a[data-index="0"]',slider_thumb).closest('.owl-item').trigger('mouseenter');
            });
        },
        saleCountdown: function(){
            $('.product-deal-countdown').each(function() {
                var date_end = $(this).data('date-end');
                var $this = $(this);
                $this.countdown(date_end,function(event){
                    count_down_callback(event,$this);
                }).on('update.countdown', function(event) {
                    count_down_callback(event,$this);
                });
            });

            function count_down_callback(event,$this) {
                var seconds = parseInt(event.offset.seconds);
                var minutes = parseInt(event.offset.minutes);
                var hours = parseInt(event.offset.hours);
                var days = parseInt(event.offset.totalDays);

                if (days < 10) days = '0' + days;
                if (hours < 10) hours = '0' + hours;
                if (minutes < 10) minutes = '0' + minutes;
                if (seconds < 10) seconds = '0' + seconds;


                $('.countdown-day',$this).text(days);
                $('.countdown-hours',$this).text(hours);
                $('.countdown-minutes',$this).text(minutes);
                $('.countdown-seconds',$this).text(seconds);
            }
            G5_Woocommerce.saleCountdownWidth();
        },
        saleCountdownWidth: function(){
            $('.product-deal-countdown').each(function(){
                var innerWidth = 0;
                $(this).removeClass('small');
                $('.countdown-section',$(this)).each(function(){
                    innerWidth += $(this).outerWidth() + parseInt($(this).css('margin-right').replace("px", ''),10);
                });
                if (innerWidth > $(this).outerWidth()) {
                    $(this).addClass('small');
                }
            });
        },
        yith_wcan_ajax_filtered : function () {
            $(document).on("yith-wcan-ajax-filtered",function (event,response) {
                var $wrapper = $body;

                if ((typeof (yith_wcan) !== 'undefined')
                    && (typeof (yith_wcan.container) !== 'undefined')) {
                    $wrapper = $(yith_wcan.container);
                }
                new G5_Core_Animation($wrapper);
                $wrapper.find('.gsf-pretty-tabs').gsfPrettyTabs({
                    more_text : g5plus_variable.pretty_tabs_more_text
                });
                G5_Core.lazyLoad.init();
                G5_Core.off_canvas.init();
                G5_Core.util.tooltip();
            });
        }
    };

    $(document).ready(function () {
        G5_Woocommerce.init();
    });

})(jQuery);
