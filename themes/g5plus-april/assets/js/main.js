(function ($) {
    "use strict";
    var G5_Main = window.G5_Main || {};
    window.G5_Main = G5_Main;

    var $window = $(window),
        $body = $('body'),
        isRTL = $body.hasClass('rtl');
    G5_Main.blog = {
        init: function () {
            this.readingProcess();
            this.processTabs();
        },
        readingProcess: function () {
            var reading_process = $('#gsf-reading-process'),
                post_content = $('.single-post .gf-single-wrap .post-single');
            if (reading_process.length > 0 && post_content.length > 0) {
                post_content.imagesLoaded(function () {
                    var content_height = post_content.height(),
                        window_height = $window.height();
                    var percent = 0,
                        content_offset = post_content.offset().top,
                        window_offest = $window.scrollTop();

                    if (window_offest > content_offset) {
                        percent = 100 * (window_offest - content_offset) / (content_height - window_height);
                    }
                    if (percent > 100) {
                        percent = 100;
                    }
                    reading_process.css('width', percent + '%');
                    $window.scroll(function () {
                        var percent = 0,
                            content_offset = post_content.offset().top,
                            window_offest = $window.scrollTop();

                        if (window_offest > content_offset) {
                            percent = 100 * (window_offest - content_offset) / (content_height - window_height);
                        }
                        if (percent > 100) {
                            percent = 100;
                        }
                        reading_process.css('width', percent + '%');
                    });
                });
            }
        },
        processTabs: function () {
            $('.gsf-pretty-tabs').each(function () {
                var $this = $(this);
                if($this.closest('[data-items-wrapper]').find('.nav-top-right').length > 0) {
                    var owl_carousel = $(this).closest('[data-items-wrapper]').find('.nav-top-right');
                    owl_carousel.on('owlInitialized', function () {
                        var owl_nav = $(this).children('.owl-nav'),
                            owl_nav_width = owl_nav.outerWidth();
                        if(isRTL) {
                            $this.css('margin-left', (owl_nav_width + 30));
                        } else {
                            $this.css('margin-right', (owl_nav_width + 30));
                        }
                        $this.gsfPrettyTabs();
                    });
                }
            });
        }
    };
    G5_Main.header = {
        init: function () {
            this.login_link_event();
        },
        login_link_event: function () {
            $('.gsf-login-link-sign-in, .gsf-login-link-sign-up').off('click').on('click', function (event) {
                event.preventDefault();
                var $this = $(this),
                    action_name = 'gsf_user_login',
                    ladda_button = null;
                if ($this.hasClass('gsf-login-link-sign-up')) {
                    action_name = 'gsf_user_sign_up'
                }
                var popupWrapper = '#gsf-popup-login-wrapper';
                $body.addClass('overflow-hidden');
                $body.append('<div class="processing-title"><i class="fa fa-spinner fa-spin fa-fw"></i></div>');
                $.ajax({
                    type: 'POST',
                    data: 'action=' + action_name,
                    url: g5plus_variable.ajax_url,
                    success: function (html) {
                        $('.processing-title').fadeOut(function () {
                            $('.processing-title').remove();
                            $body.removeClass('overflow-hidden');
                        });
                        if ($(popupWrapper).length) {
                            $(popupWrapper).remove();
                        }
                        $body.append(html);

                        $(popupWrapper).modal();

                        $('#gsf-popup-login-form').submit(function (event) {
                            ladda_button = null;
                            var button = $(event.target).find('[type="submit"]');
                            if (button.hasClass('ladda-button') && button.length > 0) {
                                ladda_button = Ladda.create(button[0]);
                                ladda_button.start();
                            }
                            var input_data = $('#gsf-popup-login-form').serialize();
                            $body.addClass('overflow-hidden');
                            $body.append('<div class="processing-title"><i class="fa fa-spinner fa-spin fa-fw"></i></div>');
                            jQuery.ajax({
                                type: 'POST',
                                data: input_data,
                                url: g5plus_variable.ajax_url,
                                success: function (html) {
                                    $('.processing-title').fadeOut(function () {
                                        $('.processing-title').remove();
                                        $body.removeClass('overflow-hidden');
                                    });
                                    var response_data = jQuery.parseJSON(html);
                                    if (response_data.code < 0) {
                                        jQuery('.login-message', '#gsf-popup-login-form').html(response_data.message);
                                    }
                                    else {
                                        window.location.reload();
                                    }
                                    if (ladda_button !== null) {
                                        ladda_button.stop();
                                        ladda_button.remove();
                                    }
                                },
                                error: function (html) {
                                    $('.processing-title').fadeOut(function () {
                                        $('.processing-title').remove();
                                        $body.removeClass('overflow-hidden');
                                    });
                                    if (ladda_button !== null) {
                                        ladda_button.stop();
                                        ladda_button.remove();
                                    }
                                }
                            });
                            event.preventDefault();
                            return false;
                        });
                    },
                    error: function (html) {
                        $('.loading-wrapper').fadeOut(function () {
                            $('.loading-wrapper').remove();
                            $body.removeClass('overflow-hidden');
                        });
                    }
                });
            });
        }
    };
    G5_Main.page = {
        init: function() {
            this.rowEqualHeight();
            this.events();
        },
        rowEqualHeight: function () {
            $('.row-equal-height').each(function () {
                var product_singular = $('.gsf-product-singular', $(this)),
                    product_info_height = $('.product-info', product_singular).outerHeight(),
                    banner = $('.gf-banner', $(this)),
                    banner_bg = $('.gf-banner-bg', banner);
                if(G5_Core.util.isDesktop()) {
                    var image = $('.image-item', $('.product-singular-images', product_singular)),
                        image_height = image.outerHeight(),
                        product_height = (product_info_height + image_height);
                    banner_bg.css('padding-bottom', product_height + 'px');
                    $('.product-singular-images', product_singular).on('owlInitialized', function () {
                        image = $('.image-item', $(this));
                        image_height = image.outerHeight();
                        product_height = (product_info_height + image_height);
                        banner_bg.css('padding-bottom', product_height + 'px');
                    });
                } else {
                    banner_bg.css('padding-bottom', '');
                }
            });
        },
        events: function() {
            $(window).on('resize',function() {
                setTimeout(function () {
                    G5_Main.page.rowEqualHeight();
                }, 500);
            });
        }
    };
    $(document).ready(function () {
        G5_Main.blog.init();
        G5_Main.header.init();
        G5_Main.page.init();
    });
})
(jQuery);
