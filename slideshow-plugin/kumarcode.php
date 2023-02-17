<?php
/**
 * WRITE SOMETHING ABOUT THIS CLASS
 *
 * @package admin
 */

namespace test_name_space {

    /**
     * Class to handle ___
     */
    class SettingAPI
    {
        /**
         * Instance of this class.
         *
         * @since    1.0.0
         *
         * @var object
         */
        protected static $instance = null;

        /**
         * Initialization.
         */
        public function __construct() {
			add_action( 'admin_init', array( $this, 'add_setting_fields' ) );

        }

        /**
         * Returns an instance of this class.
         *
         * @since     1.0.0
         *
         * @return object A single instance of this class.
         */
        public static function get_instance() {
            // If the single instance hasn't been set, set it now.
            if (null == self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

		/**
		 * Registering setting.
		 */
		public function add_setting_fields() {
			//for accepting My field
            register_setting( 'general', 'my_field_1', 'esc_attr' );
            add_settings_field( 'my_field_1', '<label for="my_field_1">'.__( 'My field', 'text_domain' ).'</label>', array( $this, 'my_field_1HTML' ), 'general', 'default' );


        }

		/**
		 * Displaying setting HTML fields.
		 */
		public function my_field_1HTML() {
			$value = get_option( 'my field_1', '' ); //Default value is empty.Change it according to your need.
            echo '<input type="text" class="regular-text" id="my field_1" name="my field_1" value="' . esc_attr( $value ) . '" />';
			echo '<p class="description" id="my_field_1-description">'. __( '', 'text_domain' ). '</p>';

		}


    }
    SettingAPI::get_instance();
}
