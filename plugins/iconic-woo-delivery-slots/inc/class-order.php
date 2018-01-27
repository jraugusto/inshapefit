<?php

if ( !defined('ABSPATH') ) { exit; }

/**
 * Iconic_WDS_Order class.
 */

if( !class_exists('Iconic_WDS_Order') ) {

    class Iconic_WDS_Order {

        /**
         * Get ID
         *
         * @param WC_Order $order
         * @return str
         */
        public static function get_id( $order ) {

            return method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

        }

        /**
         * Get billing first name
         *
         * @param WC_Order $order
         * @return str
         */
        public static function get_billing_first_name( $order ) {

            return method_exists( $order, 'get_billing_first_name' ) ? $order->get_billing_first_name() : $order->billing_first_name;

        }

        /**
         * Get billing last name
         *
         * @param WC_Order $order
         * @return str
         */
        public static function get_billing_last_name( $order ) {

            return method_exists( $order, 'get_billing_last_name' ) ? $order->get_billing_last_name() : $order->billing_last_name;

        }

        /**
         * Get billing email
         *
         * @param WC_Order $order
         * @return str
         */
        public static function get_billing_email( $order ) {

            return method_exists( $order, 'get_billing_email' ) ? $order->get_billing_email() : $order->billing_email;

        }

    }

}