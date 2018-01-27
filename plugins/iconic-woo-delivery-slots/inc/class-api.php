<?php

if ( !defined('ABSPATH') ) { exit; }

/**
 * WDS API Interface class.
 */

if( !class_exists('Iconic_WDS_API') ) {

    class Iconic_WDS_API {

        /**
         * Init
         */
        public static function init() {

            add_filter( "woocommerce_rest_prepare_shop_order", array( __CLASS__, "prepare_shop_order" ), 10, 3 );

        }

        /**
         * Prepare shop order API response
         */
        public static function prepare_shop_order( $response, $post, $request ) {

            if( empty( $response->data ) )
                return $response;

            $response->data['iconic_delivery_meta'] = array(
                'date' => get_post_meta( $post->ID, 'jckwds_date', true),
                'timeslot' => get_post_meta( $post->ID, 'jckwds_timeslot', true),
                'timestamp' => get_post_meta( $post->ID, 'jckwds_timestamp', true)
            );

            return $response;

        }

    }

}