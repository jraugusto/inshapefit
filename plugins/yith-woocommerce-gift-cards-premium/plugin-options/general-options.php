<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
$general_options = array(

	'general' => array(

		array(
			'name' => __( 'General settings', 'yith-woocommerce-gift-cards' ),
			'type' => 'title',
		),
		'ywgc_permit_free_amount'     => array(
			'name'    => __( 'Allow variable amount', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_permit_free_amount',
			'desc'    => __( 'Allow your customers to add any amount in addition to those already set.', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_permit_its_a_present'   => array(
			'name'    => __( 'Enable the "Gift this product" option', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_permit_its_a_present',
			'desc'    => __( 'Allow users to create a gift card from the product page and suggest this product in the gift-card email.', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_permit_its_a_present_product_image'   => array(
			'name'    => __( 'Show the button "Use product image"', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_permit_its_a_present_product_image',
			'desc'    => __( 'In case "Gift this product" is enable, allow users to use the image of the product to create the gift-card email.', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_physical_details'    => array(
			'name'    => __( 'Allow recipient details for physical gift card', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_physical_details',
			'desc'    => __( 'Add a form to the physical gift cards with recipient name, sender name and message', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_physical_details_mandatory'    => array(
			'name'    => __( 'Physical recipient details is mandatory', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_physical_details_mandatory',
			'desc'    => __( 'Choose if the recipient name is mandatory for physical gift cards.', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_permit_modification'    => array(
			'name'    => __( 'Allow editing', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_permit_modification',
			'desc'    => __( 'Allow your users to edit the message and the receiver of the gift card', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_notify_customer'        => array(
			'name'    => __( 'Purchase notification', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_notify_customer',
			'desc'    => __( 'Notify customers when a gift card they have purchased is used', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_enable_send_later'      => array(
			'name'    => __( 'Enable send later', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_enable_send_later',
			'desc'    => __( 'Let your customer to set a delivery date for the gift cards purchased', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_recipient_mandatory'    => array(
			'name'    => __( 'Recipient email is mandatory', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_recipient_mandatory',
			'desc'    => __( 'Choose if the recipient email is mandatory for digital gift cards.', 'yith-woocommerce-gift-cards' ),
			'default' => 'yes',
		),
		'ywgc_blind_carbon_copy'      => array(
			'name'    => __( 'BCC email', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_blind_carbon_copy',
			'desc'    => __( 'Send the email containing the gift card code to the admin with Blind Carbon Copy', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_auto_discount'          => array(
			'name'    => __( 'Link to auto discount', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_auto_discount',
			'desc'    => __( 'Let the customer click the link in the received email in order to have the discount applied automatically in the cart', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),/*
        'ywgc_restricted_usage'          => array (
            'name'    => __ ( 'Restricted usage', 'yith-woocommerce-gift-cards' ),
            'type'    => 'checkbox',
            'id'      => 'ywgc_restricted_usage',
            'desc'    => __ ( 'Choose if the gift card can be used only by the user (identified by the email address) that is the recipient of it', 'yith-woocommerce-gift-cards' ),
            'default' => 'no',
        ),*/
		'ywgc_custom_design'          => array(
			'name'    => __( 'Allow custom design', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_custom_design',
			'desc'    => __( 'Allow your users to upload a custom picture to be used as the gift card design', 'yith-woocommerce-gift-cards' ),
			'default' => 'yes',
		),
		'ywgc_template_design'        => array(
			'name'    => __( 'Allow template design', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_template_design',
			'desc'    => __( 'Allow your users to choose from a selection of templates.', 'yith-woocommerce-gift-cards' ) .
			             ' <a href="' . admin_url( 'edit-tags.php?taxonomy=giftcard-category&post_type=attachment' ) . '" title="' . __( 'Set your template categories', 'yith-woocommerce-gift-cards' ) . '">' . __( 'Set your template categories', 'yith-woocommerce-gift-cards' ) . '</a>',
			'default' => 'yes',
		),
		'ywgc_allow_multi_recipients' => array(
			'name'    => __( 'Allow multiple recipients', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_allow_multi_recipients',
			'desc'    => __( 'Allows you to set multiple recipients for single gift cards', 'yith-woocommerce-gift-cards' ),
			'default' => 'yes',
		),
		'ywgc_order_cancelled_action' => array(
			'name'    => __( 'Action to perform on order cancelled', 'yith-woocommerce-gift-cards' ),
			'type'    => 'select',
			'id'      => 'ywgc_order_cancelled_action',
			'desc'    => __( 'Choose what happens to gift cards purchased on an order that is set as cancelled', 'yith-woocommerce-gift-cards' ),
			'options' => array(
				'nothing' => __( 'Do nothing', 'yith-woocommerce-gift-cards' ),
				'disable' => __( 'Disable the gift cards', 'yith-woocommerce-gift-cards' ),
				'dismiss' => __( 'Dismiss the gift cards', 'yith-woocommerce-gift-cards' ),
			),
			'default' => 'nothing',
		),
		'ywgc_order_refunded_action'  => array(
			'name'    => __( 'Action to perform on order refunded', 'yith-woocommerce-gift-cards' ),
			'type'    => 'select',
			'id'      => 'ywgc_order_refunded_action',
			'desc'    => __( 'Choose what happens to gift cards purchased on an order that is set as refunded', 'yith-woocommerce-gift-cards' ),
			'options' => array(
				'nothing' => __( 'Do nothing', 'yith-woocommerce-gift-cards' ),
				'disable' => __( 'Disable the gift cards', 'yith-woocommerce-gift-cards' ),
				'dismiss' => __( 'Dismiss the gift cards', 'yith-woocommerce-gift-cards' ),
			),
			'default' => 'nothing',
		),
		'ywgc_enable_pre_printed'     => array(
			'name'    => __( 'Pre-printed physical gift cards', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'id'      => 'ywgc_enable_pre_printed',
			'desc'    => __( 'Choose if the physical gift cards are pre-printed. In this case the gift card code will not be generated automatically', 'yith-woocommerce-gift-cards' ),
			'default' => 'no',
		),
		'ywgc_usage_expiration'       => array(
			'id'                => 'ywgc_usage_expiration',
			'name'              => __( 'Make the gift card expire', 'yith-woocommerce-gift-cards' ),
			'desc'              => __( 'Choose whether to make the gift card expire or not. Set the number of months it is valid for since the date it is purchased. Set 0 to make it never expire.', 'yith-woocommerce-gift-cards' ),
			'type'              => 'number',
			'default'           => 0,
			'custom_attributes' => array(
				'min' => 0,
			)
		),
		'ywgc_show_recipient_on_cart' => array(
			'id'      => 'ywgc_show_recipient_on_cart',
			'name'    => __( 'Show recipient email in cart details', 'yith-woocommerce-gift-cards' ),
			'desc'    => __( 'Choose whether to show the recipient email of the gift card on cart details.', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'default' => 'no',
		),
		'ywgc_show_preset_title'      => array(
			'id'      => 'ywgc_show_preset_title',
			'name'    => __( 'Show preset title', 'yith-woocommerce-gift-cards' ),
			'desc'    => __( 'Choose whether to show the image title next to the preset images when the user choose to select a design.', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'default' => 'no',
		),
		'ywgc_enable_internal_notes'  => array(
			'id'      => 'ywgc_enable_internal_notes',
			'name'    => __( 'Internal notes', 'yith-woocommerce-gift-cards' ),
			'desc'    => __( 'Add internal notes field in gift card edit page. It is used only on admin side for internal scope.', 'yith-woocommerce-gift-cards' ),
			'type'    => 'checkbox',
			'default' => 'no',
		),
		'ywgc_code_pattern'           => array(
			'id'      => 'ywgc_code_pattern',
			'name'    => __( 'Code pattern', 'yith-woocommerce-gift-cards' ),
			'desc'    => __( "Choose the pattern to use when generating new gift card codes. Use '*' as placeholder that will be replaced by a random character or 'D' for a single digit. Leave blank for default pattern '****-****-****-****'.", 'yith-woocommerce-gift-cards' ),
			'type'    => 'text',
			'default' => '****-****-****-****',
		),
		array(
			'type' => 'sectionend',
		),
	),
);

return $general_options;
