<?php

/**
 * Fired during plugin activation
 *
 * @link       https://klubraum.com
 * @since      1.0.0
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/includes
 * @author     Steffen Haak <info@klubraum.com>
 */
class Klubraum_Membership_Request_Widget_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    if(! get_option("kr_mr_introduction_text") ) {
      add_option( "kr_mr_introduction_text", __("We are using Klubraum for organizing our community. Do you wanna join?", "klubraum-membership-request-widget") );
    }
	}

    /**
     * Check if a table exists in the database.
     *
     * @param $tableName
     * @return bool
     */
    static function table_exists($tableName) {
        global $wpdb;
        $table_prefix = $wpdb->prefix."kr_mr_";

        $qs = "SHOW TABLES LIKE '" . $table_prefix . $tableName . "'";
        $rows = $wpdb->get_results($qs, ARRAY_A);
        $exists = false;
        if (count($rows))
            $exists = true;

        return $exists;
    }

    /**
     * Create tables in database.
     */
    static function create_db_tables() {
        global $wpdb;
        $table_prefix = $wpdb->prefix."kr_mr_";

        $qs1 = "CREATE TABLE IF NOT EXISTS `" . $table_prefix . "membership_requests` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `expires_at` TIMESTAMP NOT NULL,
        `email` TEXT NOT NULL,
        `updated_at` TIMESTAMP NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        $wpdb->query($qs1);
    }

    /**
     * Create the tables required to store info.
     */
    static function create_necessary_tables_in_db() {
        if (!static::table_exists("membership_requests")) {
            static::create_db_tables();
        }
    }

}
