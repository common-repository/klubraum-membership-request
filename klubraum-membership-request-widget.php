<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://klubraum.com
 * @since             1.0.0
 * @package           Klubraum_Membership_Request_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Klubraum Membership Request
 * Description:       This plugins allows your web site visitors to request a membership for your Klubraum service.
 * Version:           1.0.3
 * Author:            Klubraum <info@klubraum.com>
 * Author URI:        https://klubraum.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       klubraum-membership-request-widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'KLUBRAUM_MEMBERSHIP_REQUEST_WIDGET_VERSION', '1.0.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-klubraum-membership-request-widget-activator.php
 */
function activate_klubraum_membership_request_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-klubraum-membership-request-widget-activator.php';
	Klubraum_Membership_Request_Widget_Activator::activate();
    Klubraum_Membership_Request_Widget_Activator::create_necessary_tables_in_db();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-klubraum-membership-request-widget-deactivator.php
 */
function deactivate_klubraum_membership_request_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-klubraum-membership-request-widget-deactivator.php';
	Klubraum_Membership_Request_Widget_Deactivator::deactivate();
    Klubraum_Membership_Request_Widget_Deactivator::delete_tables_from_db();
}

register_activation_hook( __FILE__, 'activate_klubraum_membership_request_widget' );
register_deactivation_hook( __FILE__, 'deactivate_klubraum_membership_request_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-klubraum-membership-request-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_klubraum_membership_request_widget() {

    $plugin = new Klubraum_Membership_Request_Widget();
    $plugin->run();

    include_once(plugin_dir_path( __FILE__ ) . 'admin/partials/klubraum-membership-request-widget-admin-display.php');
    include_once(plugin_dir_path( __FILE__ ) . 'public/partials/klubraum-membership-request-widget-public-display.php');

}
run_klubraum_membership_request_widget();
