<?php


    function my_theme_enqueue_styles() {
      wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
      wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
    }

    add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


    function custom_variable_price_html( $price, $product ) {
    	$price = '';

    	if ( ! $product->min_variation_price || $product->min_variation_price !== $product->max_variation_price ) {
    		$price .= '<span class="from">' . __( 'a partir de' ) . ' </span>';
    	}

    	$price .= woocommerce_price( $product->get_price() );

    	return $price;
    }

    add_filter( 'woocommerce_variable_price_html', 'custom_variable_price_html', 10, 2 );
