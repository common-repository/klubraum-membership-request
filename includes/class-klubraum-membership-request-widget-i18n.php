<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://klubraum.com
 * @since      1.0.0
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/includes
 * @author     Steffen Haak <info@klubraum.com>
 */
class Klubraum_Membership_Request_Widget_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'klubraum-membership-request-widget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
