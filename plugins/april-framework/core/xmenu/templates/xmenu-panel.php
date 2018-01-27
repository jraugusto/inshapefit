<div class="xmenu-panel-wrapper">
	<input type="hidden" id="xmenu_nonce" name="xmenu-nonce" value="<?php echo wp_create_nonce('XMENU_SAVE'); ?>"/>
	<div class="xmenu-header">
		<div class="xmenu-title"><i class="dashicons dashicons-admin-tools"></i> <span></span></div>
		<button class="xmenu-button-close" type="button"><i class="dashicons dashicons-no-alt"></i></button>
	</div>
	<div class="xmenu-body">
		<div class="xmenu-tabs">
			<ul>
				<li class="active" data-section="xmenu_general"><i class="dashicons dashicons-info"></i> <span><?php esc_html_e('General','april-framework'); ?></span></li>
				<li data-section="xmenu_submenu"><i class="dashicons dashicons-welcome-widgets-menus"></i> <span><?php esc_html_e('Sub Menu','april-framework'); ?></span></li>
			</ul>
			<div class="xmenu-buttons">
				<button type="button" class="button button-primary xmenu-button-save"
				        data-save="<?php esc_html_e('Save','april-framework'); ?>"
				        data-saving="<?php esc_html_e('Saving...','april-framework'); ?>"><i class="fa fa-save"></i> <span><?php esc_html_e('Save','april-framework'); ?></span></button>
				<span class="dashicons dashicons-arrow-down"></span>
				<div class="xmenu-save-all"><?php esc_html_e('Save All','april-framework'); ?></div>
			</div>
		</div>
		<div class="xmenu-sections">
			<div id="xmenu_general" class="xmenu-section-item active">
				<div class="xmenu-row">
					<label for="xmenu_item_url"><?php esc_html_e('URL','april-framework'); ?></label>
					<input type="text" id="xmenu_item_url" name="menu-item-url"/>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_item_title"><?php esc_html_e('Navigation Label','april-framework'); ?></label>
					<input type="text" id="xmenu_item_title" name="menu-item-title"/>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_item_attr_title"><?php esc_html_e('Title Attribute','april-framework'); ?></label>
					<input type="text" id="xmenu_item_attr_title" name="menu-item-attr-title"/>
				</div>
				<div class="xmenu-row">
					<input type="checkbox" id="xmenu_item_target" name="menu-item-target" value="_blank"/>
					<label for="xmenu_item_target"><?php esc_html_e('Open link in a new window/tab','april-framework'); ?></label>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_item_classes"><?php esc_html_e('CSS Classes (optional)','april-framework'); ?></label>
					<input type="text" id="xmenu_item_classes" name="menu-item-classes"/>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_item_xfn"><?php esc_html_e('Link Relationship (XFN)','april-framework'); ?></label>
					<input type="text" id="xmenu_item_xfn" name="menu-item-xfn"/>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_item_description"><?php esc_html_e('Description','april-framework'); ?></label>
					<textarea name="menu-item-description" id="xmenu_item_description" cols="30" rows="5"></textarea>
				</div>
				<hr/>
				<div class="xmenu-row">
					<label for="xmenu_item_featured_style"><?php esc_html_e('Menu Featured','april-framework'); ?></label>
					<div>
						<div style="width: 40%; float: left;">
							<select id="xmenu_item_featured_style" name="menu-item-featured-style">
								<option value=""><?php esc_html_e('Select style...','april-framework'); ?></option>
								<option value="new"><?php esc_html_e('New','april-framework'); ?></option>
								<option value="hot"><?php esc_html_e('Hot','april-framework'); ?></option>
							</select>
						</div>
						<div style="width: 55%; float: right;display: none">
							<input type="text" name="menu-item-featured-text" placeholder="<?php esc_html_e('Feature menu text...','april-framework'); ?>"/>
						</div>
					</div>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_item_description"><?php esc_html_e('Icon','april-framework'); ?></label>
					<div class="xmenu-icon-wrapper">
						<input type="hidden" name="menu-item-icon"/>
						<div class="xmenu-icon">
							<div><i class=""></i></div>
							<span><?php esc_html_e('Set icon','april-framework'); ?></span>
							<span class="xmenu-icon-remove"><i class="dashicons dashicons-no-alt"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div id="xmenu_submenu" class="xmenu-section-item">
				<div class="xmenu-row">
					<label for="xmenu_submenu_width"><?php esc_html_e('Sub Menu Width','april-framework'); ?></label>
					<select id="xmenu_submenu_width" name="menu-submenu-width">
						<option value="auto"><?php esc_html_e('Auto','april-framework'); ?></option>
						<option value="container"><?php esc_html_e('Container','april-framework'); ?></option>
						<option value="fullwidth"><?php esc_html_e('Full Width','april-framework'); ?></option>
						<option value="custom"><?php esc_html_e('Custom','april-framework'); ?></option>
					</select>
				</div>
				<div class="xmenu-row" style="display: none">
					<label for="xmenu_submenu_custom_width"><?php esc_html_e('Sub Menu Width Custom','april-framework'); ?></label>
					<input type="text" id="xmenu_submenu_custom_width" name="menu-submenu-custom-width"/>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_submenu_position"><?php esc_html_e('Sub Menu Position','april-framework'); ?></label>
					<select id="xmenu_submenu_position" name="menu-submenu-position">
						<option value=""><?php esc_html_e('Default','april-framework'); ?></option>
						<option value="left"><?php esc_html_e('Left Of Parent','april-framework'); ?></option>
						<option value="right"><?php esc_html_e('Right Of Parent','april-framework'); ?></option>
					</select>
				</div>
				<div class="xmenu-row">
					<label for="xmenu_submenu_transition"><?php esc_html_e('Sub Menu Transition','april-framework'); ?></label>
					<select id="xmenu_submenu_transition" name="menu-submenu-transition">
						<option value=""><?php esc_html_e('Default','april-framework'); ?></option>
						<option value="none"><?php esc_html_e('None','april-framework'); ?></option>
						<option value="x-fadeIn"><?php esc_html_e('Fade In','april-framework'); ?></option>
						<option value="x-fadeInUp"><?php esc_html_e('Fade In Up','april-framework'); ?></option>
						<option value="x-fadeInDown"><?php esc_html_e('Fade In Down','april-framework'); ?></option>
						<option value="x-fadeInLeft"><?php esc_html_e('Fade In Left','april-framework'); ?></option>
						<option value="x-fadeInRight"><?php esc_html_e('Fade In Right','april-framework'); ?></option>
						<option value="x-flipInX"><?php esc_html_e('Flip In X','april-framework'); ?></option>
						<option value="x-slideInUp"><?php esc_html_e('Slide In Up','april-framework'); ?></option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>