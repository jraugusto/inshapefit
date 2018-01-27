(function($) {
    "use strict";
    var gsf = new Custom_Editor();

    function post_render_event() {
        gsf.post_render_event(this);
    }

    function command_click_event() {
        gsf.command_click_event(this);
    }

    function raw_js_before_click_event() {
        gsf.raw_js_before_click_event(this);
    }

    function raw_js_after_click_event() {
        gsf.raw_js_after_click_event(this);
    }

    function formatter_click_event() {
        gsf.formatter_click_event(this);
    }

    function onShow() {
        gsf.trigger_sub_menu(this.settings.menu);
    }

    function toggleClass(classes, removeClassPattern, node) {
        gsf.toggleClass(classes, removeClassPattern, node);
    }

    var content_padding_pattern = /^gsf-padding-\d+-\d+$/;
    tinymce.PluginManager.add('custom_editor', function (editor, url) {
        editor.addButton('custom_editor', {
            text: custom_editor_var.menu_name,
            icon: 'table',
            type: 'menubutton',
            menu: [
                {
                    text: custom_editor_var.blockquote_text[0],
                    onshow: onShow,
                    classes: 'blockquote',
                    menu: [
                        {
                            text: custom_editor_var.blockquote_text[1],
                            classes: 'blockquote-circle',
                            command: 'gsf_blockquote_circle',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-blockquote-circle'
                            },
                            onclick: function () {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.blockquote_text[2],
                            classes: 'blockquote-center',
                            command: 'gsf_blockquote_center',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-blockquote-center'
                            },
                            onclick: function () {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.blockquote_text[3],
                            classes: 'blockquote-left',
                            command: 'gsf_blockquote_left',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-blockquote-left'
                            },
                            onclick: function () {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.blockquote_text[4],
                            classes: 'blockquote-right',
                            command: 'gsf_blockquote_right',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-blockquote-right'
                            },
                            onclick: function () {
                                formatter_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.content_padding_text[0],
                    onshow: onShow,
                    classes: 'content-padding',
                    menu: [
                        {
                            text: custom_editor_var.content_padding_text[1],
                            classes: 'text-padding-right-1',
                            activeConditions: {
                                'classes': 'gsf-padding-0-1'
                            },
                            command: 'text-padding-right-1-active',
                            onPostRender: post_render_event,
                            onclick: function () {
                                raw_js_before_click_event.call(this);
                                toggleClass('gsf-padding-0-1',content_padding_pattern);
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.content_padding_text[2],
                            classes: 'text-padding-left-1',
                            activeConditions: {
                                'classes': 'gsf-padding-1-0'
                            },
                            command: 'text-padding-left-1-active',
                            onPostRender: post_render_event,
                            onclick: function () {
                                raw_js_before_click_event.call(this);
                                toggleClass('gsf-padding-1-0',content_padding_pattern);
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.content_padding_text[3],
                            classes: 'text-padding-1',
                            activeConditions: {
                                'classes': 'gsf-padding-1-1'
                            },
                            command: 'text-padding-1-active',
                            onPostRender: post_render_event,
                            onclick: function () {
                                raw_js_before_click_event.call(this);
                                toggleClass('gsf-padding-1-1',content_padding_pattern);
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.content_padding_text[4],
                            classes: 'text-padding-1-2',
                            activeConditions: {
                                'classes': 'gsf-padding-1-2'
                            },
                            command: 'text-padding-1-2-active',
                            onPostRender: post_render_event,
                            onclick: function () {
                                raw_js_before_click_event.call(this);
                                toggleClass('gsf-padding-1-2',content_padding_pattern);
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.content_padding_text[5],
                            classes: 'text-padding-2-1',
                            activeConditions: {
                                'classes': 'gsf-padding-2-1'
                            },
                            command: 'text-padding-2-1-active',
                            onPostRender: post_render_event,
                            onclick: function () {
                                raw_js_before_click_event.call(this);
                                toggleClass('gsf-padding-2-1',content_padding_pattern);
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.content_padding_text[6],
                            classes: 'text-padding-2-2',
                            activeConditions: {
                                'classes': 'gsf-padding-2-2'
                            },
                            command: 'text-padding-2-2-active',
                            onPostRender: post_render_event,
                            onclick: function () {
                                raw_js_before_click_event.call(this);
                                toggleClass('gsf-padding-2-2',content_padding_pattern);
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.content_padding_text[7],
                            classes: 'text-padding-3-3',
                            activeConditions: {
                                'classes': 'gsf-padding-3-3'
                            },
                            command: 'text-padding-3-3-active',
                            onPostRender: post_render_event,
                            onclick: function () {
                                raw_js_before_click_event.call(this);
                                toggleClass('gsf-padding-3-3',content_padding_pattern);
                                raw_js_after_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.dropcap_text[0],
                    classes: 'dropcap',
                    onshow: onShow,
                    menu: [
                        {
                            text: custom_editor_var.dropcap_text[1],
                            classes: 'dropcap',
                            command: 'gsf_dropcap_simple',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-dropcap-simple'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.dropcap_text[2],
                            classes: 'dropcap-square',
                            command: 'gsf_dropcap_square',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-dropcap-square'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.dropcap_text[3],
                            classes: 'dropcap-square-outline',
                            command: 'gsf_dropcap_square_outline',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-dropcap-square-outline'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },

                        {
                            text: custom_editor_var.dropcap_text[4],
                            classes: 'dropcap-circle',
                            command: 'gsf_dropcap_circle',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-dropcap-circle'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },

                        {
                            text: custom_editor_var.dropcap_text[5],
                            classes: 'dropcap-circle-outline',
                            command: 'gsf_dropcap_circle_outline',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-dropcap-circle-outline'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.highlighted_text[0],
                    classes: 'highlighted',
                    onshow: onShow,
                    menu: [
                        {
                            text: custom_editor_var.highlighted_text[1],
                            classes: 'gsf-highlighted-yellow',
                            command: 'gsf_highlighted_yellow',
                            onPostRender: post_render_event,
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.highlighted_text[2],
                            classes: 'gsf-highlighted-red',
                            command: 'gsf_highlighted_red',
                            onPostRender: post_render_event,
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.column_text[0],
                    classes: 'columns',
                    onshow: onShow,
                    menu: [
                        {
                            text: custom_editor_var.column_text[1],
                            classes: 'columns-2',
                            command: 'gsf_column_2',
                            onPostRender: post_render_event,
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.column_text[2],
                            classes: 'columns-3',
                            command: 'gsf_column_3',
                            onPostRender: post_render_event,
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.column_text[3],
                            classes: 'columns-4',
                            command: 'gsf_column_4',
                            onPostRender: post_render_event,
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.custom_list_text[0],
                    classes: 'list-drop',
                    onshow: onShow,
                    menu: [
                        {
                            text: custom_editor_var.custom_list_text[1],
                            classes: 'list-check',
                            command: 'gsf_list_check',
                            icon: 'fa-check',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-list-check',
                                'parent': 'ul'
                            },
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.custom_list_text[2],
                            classes: 'list-star',
                            command: 'gsf_list_star',
                            icon: 'fa-star',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-list-star',
                                'parent': 'ul'
                            },
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.custom_list_text[3],
                            classes: 'list-edit',
                            command: 'gsf_list_edit',
                            icon: 'fa-edit',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-list-edit',
                                'parent': 'ul'
                            },
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.custom_list_text[4],
                            classes: 'list-folder',
                            command: 'gsf_list_folder',
                            icon: 'fa-folder',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-list-folder',
                                'parent': 'ul'
                            },
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.custom_list_text[5],
                            classes: 'list-file',
                            command: 'gsf_list_file',
                            icon: 'fa-file',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-list-file',
                                'parent': 'ul'
                            },
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.custom_list_text[6],
                            classes: 'list-heart',
                            command: 'gsf_list_heart',
                            icon: 'fa-heart',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-list-heart',
                                'parent': 'ul'
                            },
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.custom_list_text[7],
                            classes: 'list-asterisk',
                            command: 'gsf_list_asterisk',
                            icon: 'fa-asterisk',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'gsf-list-asterisk',
                                'parent': 'ul'
                            },
                            onclick: function() {
                                command_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.divider_text[0],
                    classes: 'divider',
                    onshow: onShow,
                    menu: [
                        {
                            text: custom_editor_var.divider_text[1],
                            classes: 'divider-full',
                            command: 'divider-full-active',
                            onclick: function() {
                                raw_js_before_click_event.call(this);
                                editor.insertContent('<hr>');
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.divider_text[2],
                            classes: 'divider-small',
                            command: 'divider-small-active',
                            onclick: function() {
                                raw_js_before_click_event.call(this);
                                editor.insertContent('<hr class="gsf-divider-small">');
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.divider_text[3],
                            classes: 'divider-tiny',
                            command: 'divider-tiny-active',
                            onclick: function() {
                                raw_js_before_click_event.call(this);
                                editor.insertContent('<hr class="gsf-divider-tiny">');
                                raw_js_after_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.divider_text[4],
                            classes: 'divider-double',
                            command: 'divider-double-active',
                            onclick: function() {
                                raw_js_before_click_event.call(this);
                                editor.insertContent('<hr class="gsf-divider-large">');
                                raw_js_after_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.alert_text[0],
                    classes: 'alert-drop',
                    onshow: onShow,
                    menu: [
                        {
                            text: custom_editor_var.alert_text[1],
                            classes: 'alert-simple',
                            command: 'gsf_alert_simple',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'alert gsf-alert'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.alert_text[2],
                            classes: 'alert-success',
                            command: 'gsf_alert_success',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'alert alert-success'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.alert_text[3],
                            classes: 'alert-info',
                            command: 'gsf_alert_info',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'alert alert-info'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.alert_text[4],
                            classes: 'alert-warning',
                            command: 'gsf_alert_warning',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'alert alert-warning'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        },
                        {
                            text: custom_editor_var.alert_text[5],
                            classes: 'alert-danger',
                            command: 'gsf_alert_danger',
                            onPostRender: post_render_event,
                            activeConditions: {
                                'classes': 'alert alert-danger'
                            },
                            onclick: function() {
                                formatter_click_event.call(this);
                            }
                        }
                    ]
                },
                {
                    text: custom_editor_var.white_text,
                    classes: 'white-text',
                    command: 'gsf_white_text',
                    onPostRender: post_render_event,
                    activeConditions: {
                        'classes': 'gsf-white-text'
                    },
                    onclick: function() {
                        formatter_click_event.call(this);
                    }
                }
            ]
        });
    });
})(jQuery);