<?php
if ( !defined('ABSPATH') ) { exit; }

/**
 * WDS autoloader class.
 */

if( !class_exists('Iconic_WDS_Autoloader') ) {

    class Iconic_WDS_Autoloader {

        /**
         * Class prefix
         */
        private static $class_prefix = "Iconic_WDS_";

        /**
         * Construct.
         */
        public function __construct() {

            spl_autoload_register( array( $this, 'autoload' ) );

        }

        /**
         * Autoloader
         *
         * Classes should reside within /inc and follow the format of
         * Iconic_The_Name ~ class-the-name.php or {{class-prefix}}The_Name ~ class-the-name.php
         *
         * @param str $class_name
         */
        private static function autoload( $class_name ) {

            /**
             * If the class being requested does not start with our prefix,
             * we know it's not one in our project
             */
            if ( 0 !== strpos( $class_name, 'Iconic_' ) && 0 !== strpos( $class_name, self::$class_prefix ) )
                return;

            $file_name = strtolower( str_replace(
                array( self::$class_prefix, 'Iconic_', '_' ),      // Prefix | Plugin Prefix | Underscores
                array( '', '', '-' ),                              // Remove | Remove | Replace with hyphens
                $class_name
            ) );

            // Compile our path from the current location
            $file = dirname( __FILE__ ) . '/class-'. $file_name .'.php';

            // If a file is found
            if ( file_exists( $file ) ) {
                // Then load it up!
                require( $file );
            }

        }

    }

    new Iconic_WDS_Autoloader();

}