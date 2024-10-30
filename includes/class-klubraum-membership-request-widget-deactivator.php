<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://klubraum.com
 * @since      1.0.0
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/includes
 * @author     Steffen Haak <info@klubraum.com>
 */
class Klubraum_Membership_Request_Widget_Deactivator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

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
     * Delete tables from database which were created during installation.
     */
    public static function delete_tables_from_db() {
        global $wpdb;
        $table_prefix = $wpdb->prefix."kr_mr_";

        if(static::table_exists('membership_requests')) {
            $qs1 = 'DROP TABLE `' . $table_prefix . 'membership_requests`;';
            $wpdb->query($qs1);
        }
    }

}
