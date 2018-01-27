/**
 *
 * @constructor
 */
function Custom_Editor() {

    this.editor = false;
    this.formatter = false;
    this.dom = false;
    this.events = {};

    this.init();
}
Custom_Editor.prototype = {
    init_vars: function () {
        this.editor = tinyMCE.activeEditor;
        this.formatter = this.editor.formatter;
        this.dom = this.editor.dom;
    },
    get_formatter_name: function (obj) {
        if (typeof obj === 'object') {
            return obj.formatter || obj.command;
        }
    },
    get_formatter_value: function (obj) {
        if (typeof obj === 'object') {
            return obj.formatterValues;
        }
    },
    elm_isset: function ( variable ) {
        return typeof variable === 'undefined' || variable === null ? false : true;
    },
    insert_p_tag_after: function( reference_node ) {
        var p = this.dom.insertAfter(this.dom.create('p',{},"&nbsp;"), reference_node),
            rng = this.dom.createRng();
        // create p element and move cursor to el
        rng.setStart(p, 0);
        rng.setEnd(p, 0);
        this.editor.selection.setRng(rng);
    },
    append_elm: function( reference_node, newElAttr,newElHTML,newElName ) {
        if(! reference_node ||  ! reference_node.appendChild) {
            return ;
        }
        newElName = newElName || 'p';

        var p = reference_node.appendChild(this.dom.create(newElName,newElAttr, newElHTML)),
            rng = this.dom.createRng();
        // create p element and move cursor to el
        rng.setStart(p, 0);
        rng.setEnd(p, 0);
        this.editor.selection.setRng(rng);
    },
    on: function (name, callback) {
        if (typeof this.events[ name ] === 'undefined')
            this.events[ name ] = [];
        this.events[ name ].push(callback);
    },
    dispatchEvent: function(name) {
        var args = Array.prototype.slice.call(arguments, 1),
            self = this;
        if(typeof this.events[ name ] === 'object') {
            this.events[ name ].forEach(function(callback) {
                callback.apply(self,args);
            });
        }
    },
    init: function () {
        var self = this;

        if ( ! self.elm_isset( tinyMCE ) || ! self.elm_isset( tinyMCE.activeEditor ) || ! self.elm_isset( tinyMCE.activeEditor.formatter ) ) {
            jQuery(document).on('tinymce-editor-init', function () {
                self.init();
            });
            return;
        }

        this.init_vars();
        this.register_all_formatters();
        this.add_commands();
        this.attach_event_listeners();
        this.set_default_if_null();
    },
    each: function (o, cb, s) {
        if (!o) {
            return 0;
        }
        var n, l;
        s = s || o;
        if (o.length !== undefined) {
            // Indexed arrays, needed for Safari
            for (n = 0, l = o.length; n < l; n++) {
                if (cb.call(s, o[ n ], n, o) === false) {
                    return 0;
                }
            }
        } else {
            // Hashtables
            for (n in o) {
                if (o.hasOwnProperty(n)) {
                    if (cb.call(s, o[ n ], n, o) === false) {
                        return 0;
                    }
                }
            }
        }

        return 1;
    },
    is_current_user:function() {
        var selectionNode = this.editor.selection.getNode();

        return !(
            this.editor.selection.getNode().parentNode.hasAttribute("data-mce-bogus") ||
            this.dom.isEmpty(selectionNode) ||
            tinymce.trim(selectionNode.innerHTML) === '&nbsp;'
        );
    },
    get_formatter_list: function () {
        return {
            // blockquote
            gsf_blockquote_circle: {
                block: 'blockquote',
                classes: 'gsf-blockquote-circle'
            },
            gsf_blockquote_center: {
                block: 'blockquote',
                classes: 'gsf-blockquote-center'
            },
            gsf_blockquote_left: {
                block: 'blockquote',
                classes: 'gsf-blockquote-left'
            },
            gsf_blockquote_right: {
                block: 'blockquote',
                classes: 'gsf-blockquote-right'
            },

            //Dropcap
            gsf_dropcap_simple: {
                inline: 'span',
                classes: 'gsf-dropcap-default'
            },
            gsf_dropcap_square: {
                inline: 'span',
                classes: 'gsf-dropcap-square'
            },
            gsf_dropcap_square_outline: {
                inline: 'span',
                classes: 'gsf-dropcap-square-outline'
            },
            gsf_dropcap_circle: {
                inline: 'span',
                classes: 'gsf-dropcap-circle'
            },
            gsf_dropcap_circle_outline: {
                inline: 'span',
                classes: 'gsf-dropcap-circle-outline'
            },

            // Highlight
            gsf_highlighted_yellow: {
                inline: 'mark',
                classes: 'gsf-highlighted-yellow'
            },
            gsf_highlighted_red: {
                inline: 'mark',
                classes: 'gsf-highlighted-red'
            },

            //Alerts
            gsf_alert_simple: {
                block: 'div',
                classes: 'alert gsf-alert'
            },
            gsf_alert_success: {
                block: 'div',
                classes: 'alert alert-success'
            },
            gsf_alert_info: {
                block: 'div',
                classes: 'alert alert-info'
            },
            gsf_alert_warning: {
                block: 'div',
                classes: 'alert alert-warning'
            },
            gsf_alert_danger: {
                block: 'div',
                classes: 'alert alert-danger'
            },
            gsf_white_text: {
                inline: 'span',
                classes: 'gsf-white-text'
            }
        };
    },
    get_formatter: function (name) {
        var formatters = this.get_formatter_list();
        if (typeof formatters[ name ] === 'object')
            return formatters[ name ];
    },
    register_all_formatters: function () {
        var self = this;

        self.each(this.get_formatter_list(), function (obj, id) {
            self.formatter.register(id, obj);
        });
    },
    attach_event_listeners: function () {
        var self = this;

        self.editor.on('NewBlock', function (e) {
            function returnTrue() {
                return true;
            }
            var prev_el = self.editor.selection.dom.getPrev(e.newBlock, returnTrue);
            if(! prev_el) {
                return ;
            }

            if (e.newBlock.tagName != 'P' || /\bgsf\-.+/.test(e.newBlock.className)) {
                if (self.dom.isEmpty(prev_el)) {
                    self.insert_p_tag_after(e.newBlock);
                    self.dom.remove(prev_el);
                    self.dom.remove(e.newBlock);
                }
                /**
                 * inert p element when pressing enter in columns
                 */
                else if ( self.editor.dom.hasClass(prev_el, 'gsf-shortcode-col') ) {
                    /**
                     * keep text when press enter between paragraph
                     */
                    if(self.dom.isEmpty(e.newBlock)) {
                        self.append_elm(prev_el);
                    } else {
                        self.append_elm(prev_el);
                        self.append_elm(prev_el,{}, e.newBlock.innerHTML);
                    }

                    self.dom.remove(e.newBlock);
                }
            }

            /**
             * exit column shortcode when pressing enter in columns
             */
            else if(  self.get_parent_by_class(e.newBlock, 'gsf-shortcode-col') ) {
                if(prev_el.tagName === 'P' && self.dom.isEmpty(prev_el)) {
                    var parent =  self.get_parent_by_class(e.newBlock, 'gsf-shortcode-row');
                    //ignore coming out the block while press enter between elements (not bottom)
                    if(! self.editor.selection.dom.getNext(e.newBlock, returnTrue) ) {
                        self.insert_p_tag_after(parent);
                        self.dom.remove(e.newBlock);
                    }
                }
            }
        });
    },
    set_default_if_null: function() {
        var self = this;
        self.on('after-formatter', function(fmt){
            if(! self.is_current_user()) {
                if(/^\bgsf_dropcap.+/i.test(fmt)) {
                    self.editor.insertContent( "D" );
                }
                if(/^\bgsf_highlight.*/i.test(fmt)) {
                    self.editor.insertContent( "Highlighted text" );
                    ins( "Highlighted text" );
                }
                if(/^gsf_alert_(.*?)$/i.exec(fmt)) {
                    self.editor.insertContent( "This is an alert message." );
                }
            }
        });
    },
    add_commands: function () {
        var self = this,
            edit = self.editor;
        edit.addCommand('gsf-formatter', function (_, value) {
            self.formatter.toggle(self.get_formatter_name(value), self.get_formatter_value(value));
            edit.fire(value.command);
        });
        edit.addCommand('gsf_list_check', function () {
            edit.execCommand("InsertUnorderedList", false);
            if (self.dom.getParent(edit.selection.getNode(), "ul") !== null) {
                self.toggleClass('gsf-list-check',/^(gsf-list-)+/,self.dom.getParent(edit.selection.getNode(), "ul"));
            }
        });
        edit.addCommand('gsf_list_star', function () {
            edit.execCommand("InsertUnorderedList", false);
            if (self.dom.getParent(edit.selection.getNode(), "ul") !== null) {
                self.toggleClass('gsf-list-star',/^(gsf-list-)+/,self.dom.getParent(edit.selection.getNode(), "ul"));
            }
        });
        edit.addCommand('gsf_list_edit', function () {
            edit.execCommand("InsertUnorderedList", false);
            if (self.dom.getParent(edit.selection.getNode(), "ul") !== null) {
                self.toggleClass('gsf-list-edit',/^(gsf-list-)+/,self.dom.getParent(edit.selection.getNode(), "ul"));
            }
        });
        edit.addCommand('gsf_list_folder', function () {
            edit.execCommand("InsertUnorderedList", false);
            if (self.dom.getParent(edit.selection.getNode(), "ul") !== null) {
                self.toggleClass('gsf-list-folder',/^(gsf-list-)+/,self.dom.getParent(edit.selection.getNode(), "ul"));
            }
        });
        edit.addCommand('gsf_list_file', function () {
            edit.execCommand("InsertUnorderedList", false);
            if (self.dom.getParent(edit.selection.getNode(), "ul") !== null) {
                self.toggleClass('gsf-list-file',/^(gsf-list-)+/,self.dom.getParent(edit.selection.getNode(), "ul"));
            }
        });
        edit.addCommand('gsf_list_heart', function () {
            edit.execCommand("InsertUnorderedList", false);
            if (self.dom.getParent(edit.selection.getNode(), "ul") !== null) {
                self.toggleClass('gsf-list-heart',/^(gsf-list-)+/,self.dom.getParent(edit.selection.getNode(), "ul"));
            }
        });
        edit.addCommand('gsf_list_asterisk', function () {
            edit.execCommand("InsertUnorderedList", false);
            if (self.dom.getParent(edit.selection.getNode(), "ul") !== null) {
                self.toggleClass('gsf-list-asterisk',/^(gsf-list-)+/,self.dom.getParent(edit.selection.getNode(), "ul"));
            }
        });
        /**
         * Column commands
         */
        (function() {
            var lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt';

            function getRow() {
                var maybeRow,row,
                    rowClass = "gsf-shortcode-row";

                maybeRow = edit.selection.getNode();
                if(edit.dom.hasClass(maybeRow, rowClass) ) {
                    row = maybeRow;
                } else {
                    row = self.get_parent_by_class(maybeRow, rowClass)
                }

                return row;
            }

            function appendDefaultText(row) {
                var first_col = self.dom.select('.gsf-shortcode-col:first', row)[0];
                self.append_elm(first_col,{}, lorem);
            }

            function execColumns(row) {
                if( row ) {
                    var rng = edit.dom.createRng();
                    rng.setStart(row, 0);
                    rng.setEnd(row, 0);
                    edit.selection.setRng(rng);
                }
                var cols = self.dom.select('.gsf-shortcode-col', row);
                self.each(cols, function( col ) {
                    col.setAttribute('data-mce-contenteditable', 'true');
                } );
            }

            function handleColumn(beforeHTML,afterHTML) {
                //grab selected node and remove it. it will copy to first column
                var selectedNode = edit.selection.getNode();
                self.dom.remove(selectedNode);

                edit.insertContent( beforeHTML + selectedNode.outerHTML + afterHTML );

                var row  = getRow();
                execColumns(row);

                //append default lorem text if needed
                if(edit.dom.isEmpty(selectedNode)) {
                    appendDefaultText(row);
                }
            }

            edit.addCommand('gsf_column_2', function () {
                handleColumn('<div class="row gsf-shortcode-row gsf-shortcode-row-2-column"><div class="col-xs-6 gsf-shortcode-col">',
                    '</div><div class="col-xs-6 gsf-shortcode-col">'+ lorem +'</div></div>');
            });
            edit.addCommand('gsf_column_3', function () {
                handleColumn(
                    '<div class="row gsf-shortcode-row gsf-shortcode-row-3-column"><div class="col-xs-4 gsf-shortcode-col">',
                    '</div><div class="col-xs-4 gsf-shortcode-col">' + lorem + '</div><div class="col-xs-4 gsf-shortcode-col">' + lorem + '</div></div>'
                );
            });
            edit.addCommand('gsf_column_4', function () {
                handleColumn(
                    '<div class="row gsf-shortcode-row gsf-shortcode-row-4-column"><div class="col-xs-3 gsf-shortcode-col">',

                    '</div><div class="col-xs-3 gsf-shortcode-col">' + lorem + '</div><div class="col-xs-3 gsf-shortcode-col">' + lorem +
                    '</div><div class="col-xs-3 gsf-shortcode-col">' + lorem + '</div></div>'
                );
            });
        })();
    },
    get_parent_by_class: function(reference_node, className) {
        var root    = this.dom.getRoot(),
            parent  = reference_node,
            breaked = false;
        while (parent && parent.parentNode && parent.parentNode != root) {
            parent = parent.parentNode;
            if(className && this.editor.dom.hasClass(parent, className)){
                breaked = true;
                break;
            }
        }
        if(! className || breaked) {
            return parent;
        }
    },
    get_parent_node: function (node, parent_tag_name) {
        var root = this.dom.getRoot(),
            parent = node,
            breaked = false;
        if( parent_tag_name ) {
            parent_tag_name = parent_tag_name.toString().toUpperCase();
        }
        while (parent && parent.parentNode && parent.parentNode != root) {
            parent = parent.parentNode;
            if( parent_tag_name && parent.tagName === parent_tag_name) {
                breaked = true;
                break;
            }
        }
        if(! parent_tag_name || breaked)
            return parent;
    },
    replace_vars: function (value, vars) {
        if (typeof value != "string") {
            value = value(vars);
        } else if (vars) {
            value = value.replace(/%(\w+)/g, function (str, name) {
                return vars[ name ] || str;
            });
        }

        return value;
    },
    check_active:function(condition) {
        if(!condition)
            return false;

        var active = 1,
            node = this.editor.selection.getNode(),
            parent = condition.tagName && !this.dom.isBlock(condition.tagName)
                ? node : this.get_parent_node(node,condition.parent);

        if( !parent)
            return false;

        if (condition.tagName) {
            active = condition.tagName.toUpperCase() === parent.tagName;
        }
        if (condition.classes) {
            active = this.editor.dom.hasClass(parent, condition.classes);
        }

        return Boolean(active);
    },
    post_render_event: function (util_Class) {
        var self = this, fmt, values,
            opt = util_Class.settings;

        self.editor.on(opt.command, function () {
            var cond;

            fmt = self.get_formatter(self.get_formatter_name(opt));
            if( fmt ) {
                values = self.get_formatter_value(opt);
                cond = {tagName: fmt.block || fmt.inline, classes: self.replace_vars(fmt.classes, values)};
            } else if( opt.activeConditions ) {
                cond = opt.activeConditions;
            } else {
                return ;
            }

            var is_active = self.check_active(cond);
            util_Class.active( is_active );
        });
    },
    trigger_sub_menu: function (menu_object) {
        var self = this;
        self.each(menu_object, function (obj) {
            if (obj.command) {
                self.editor.fire(obj.command);
            }
        });
    },
    command_click_event:function(util_Class) {
        var currentCmd = util_Class.settings.command;
        if(! currentCmd) {
            return ;
        }
        var self = this,
            cmd2remove = {name: ''};

        self.each(util_Class.parent().settings.items, function (settings) {
            cmd2remove.name = settings.command;

            if (cmd2remove.name !== currentCmd && self.check_active(settings.activeConditions)) {
                self.editor.execCommand(cmd2remove.name, false);
            }
        });

        self.editor.execCommand(currentCmd, false);
    },
    formatter_click_event: function (util_Class) {
        var self = this,
            currentFmt,
            fmt2remove = {
                name: '',
                value: ''
            };
        //remove another formatters
        currentFmt = self.get_formatter_name(util_Class.settings);
        this.each(util_Class.parent().settings.items, function (settings) {
            fmt2remove.name = self.get_formatter_name(settings);
            fmt2remove.value = self.get_formatter_value(settings);
            if (fmt2remove.name !== currentFmt) {
                var fmt = self.formatter.get(fmt2remove.name);
                if (self.formatter.match(fmt2remove.name, fmt2remove.name) &&
                    (!('toggle' in fmt[ 0 ]) || fmt[ 0 ].toggle)) {
                    self.formatter.remove(fmt2remove.name, fmt2remove.name);
                }
            }
        });

        this.dispatchEvent('before-formatter', currentFmt, util_Class);
        this.editor.execCommand('gsf-formatter', false, util_Class.settings);
        this.dispatchEvent('after-formatter', currentFmt, util_Class);
    },
    raw_js_before_click_event:function(util_Class) {
        this.dispatchEvent('before-raw-js-click', util_Class.settings, util_Class);
    },
    raw_js_after_click_event:function(util_Class) {
        this.dispatchEvent('after-raw-js-click', util_Class.settings, util_Class);
    },
    toggleClass: function (classes, removeClassPattern, node) {
        var self = this,
            currentClasses,
            nodes    = node ? [node] : self.editor.selection.getSelectedBlocks();

        self.each(nodes, function (node) {
            currentClasses = self.dom.getAttrib(node, 'class', false);
            if (currentClasses) {
                self.each(currentClasses.split(' '), function (removeClass) {
                    self.each(classes.split(' '), function (toggledClass) {
                        if (toggledClass !== removeClass && removeClassPattern.test(removeClass)) {
                            self.dom.toggleClass(node, removeClass);
                        }
                    });
                });
            }
            self.dom.toggleClass(node, classes);
        });
    }
};
