<?php

if ( !defined('ABSPATH') ) { exit; }

/**
 * WDS Ajax class.
 */

if( !class_exists('Iconic_WDS_Ajax') ) {

    class Iconic_WDS_Ajax {

        /**
         * Init
         */
        public static function init() {

            self::add_ajax_events();

        }

        /**
         * Hook in methods - uses WordPress ajax handlers (admin-ajax).
         */
        public static function add_ajax_events() {

            // iconic_wds_{event} => nopriv
            $ajax_events = array(
                'get_chosen_shipping_method' => true,
                'reserve_slot' => true,
                'remove_reserved_slot' => true,
                'get_slots_on_date' => true,
                'get_upcoming_bookable_dates' => true
            );

            foreach ( $ajax_events as $ajax_event => $nopriv ) {

                add_action( 'wp_ajax_iconic_wds_' . $ajax_event, array( __CLASS__, $ajax_event ) );

                if ( $nopriv )
                    add_action( 'wp_ajax_nopriv_iconic_wds_' . $ajax_event, array( __CLASS__, $ajax_event ) );

            }

        }

        /**
         * Get chosen shipping method
         */
        public static function get_chosen_shipping_method() {

            $data = array(
                'chosen_method' => jckWooDeliverySlots::get_chosen_shipping_method()
            );

            wp_send_json( $data );

        }

        /**
         * Reserve a slot
         */
        public static function reserve_slot() {

            global $jckwds;

            $jckwds->add_reservation( array(
                'datetimeid' => $_POST['slot_id'],
                'date' => $_POST['slot_date'],
                'starttime' => $_POST['slot_start_time'],
                'endtime' => $_POST['slot_end_time']
            ) );

            wp_send_json( array( 'success' => true ) );
        }

        /**
         * Remove a reserved slot
         */
        public static function remove_reserved_slot() {

            global $wpdb, $jckwds;

            $wpdb->delete(
                $jckwds->reservations_db_table_name,
                array(
                    'processed' => 0,
                    'user_id' => $jckwds->user_id
                ),
                array(
                    '%d',
                    '%s'
                )
            );

            wp_send_json( array( 'success' => true ) );

        }

        /**
    	 * Get available timeslots on posted date
    	 *
    	 * Date format is always Ymd to cater for multiple languages. This
    	 * is set when a date is selected via the datepicker script
    	 */
    	public static function get_slots_on_date() {

        	global $jckwds;

    		$response = array('success' => false, 'reservation' => false);

    		if( empty( $_POST['date'] ) )
    		    wp_send_json( $response );

    		$timeslots = $jckwds->slots_available_on_date( $_POST['date'] );

    		if( $timeslots ){

    			$response['success'] = true;

    			$response['html'] = '';

    			$available_slots = array();

    			foreach( $timeslots as $timeslot ) {

    				$response['html'] .= '<option value="'.esc_attr($timeslot['value']).'">'.$timeslot['formatted_with_fee'].'</option>';

    			}

    			$response['slots'] = $timeslots;

    		}

    		if( $reservation = $jckwds->has_reservation() ) {

    			$slot_id_exploded = explode('_', $reservation->datetimeid);
    			$timeslot_id = $slot_id_exploded[1];
    			$timeslot = $jckwds->get_timeslot_data( $timeslot_id );

    			$response['reservation'] = $timeslot['value'];

    		}

    		wp_send_json( $response );

    	}

    	/**
    	 * Get upcoming bookable dates
    	 */
        public static function get_upcoming_bookable_dates() {

            global $jckwds;

            $response = array(
                'success' => true,
                'bookable_dates' => $jckwds->get_upcoming_bookable_dates("d/m/Y")
            );

            wp_send_json( $response );

        }

    }

}