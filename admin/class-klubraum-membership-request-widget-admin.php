<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://klubraum.com
 * @since      1.0.0
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/admin
 * @author     Steffen Haak <info@klubraum.com>
 */
class Klubraum_Membership_Request_Widget_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Klubraum_Membership_Request_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Klubraum_Membership_Request_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/klubraum-membership-request-widget-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Klubraum_Membership_Request_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Klubraum_Membership_Request_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/klubraum-membership-request-widget-admin.js', array( 'jquery' ), $this->version, false );
        wp_localize_script($this->plugin_name, 'klubraum_membership_request_widget_admin_object', array(
          'url' => admin_url('admin-ajax.php'),
	        'msgApiTokenMissing' => __("API token is missing!", "klubraum-membership-request-widget")
        ));
	}

    /**
     * Store settings info.
     *
     * @param $args
     * @return array
     */
    function store_settings_info($args) {
      $api_token = filter_var($args["api_token"], FILTER_SANITIZE_STRING);
      $introduction_text = filter_var($args["introduction_text"], FILTER_SANITIZE_STRING);

      if(! get_option("kr_mr_api_token") ) {
        add_option( "kr_mr_api_token", $api_token );
      }
      else {
        update_option("kr_mr_api_token", $api_token);
      }

      if (isset($introduction_text)) {
        if (empty($introduction_text)) {
          if(get_option("kr_mr_introduction_text") ) {
            delete_option("kr_mr_introduction_text");
          }
        } else {
          if(! get_option("kr_mr_introduction_text") ) {
            add_option( "kr_mr_introduction_text", $introduction_text );
          }
          else {
            update_option("kr_mr_introduction_text", $introduction_text);
          }    
        }
      }

      return [
          "success" => true,
          "message" => __("Settings successfully updated!", "klubraum-membership-request-widget")
      ];
    }

}


/**
 * Store the settings. Handle ajax request.
 */
add_action("wp_ajax_kr_mr_store_settings", "kr_mr_store_settings");
add_action("wp_ajax_nopriv_kr_mr_store_settings", "kr_mr_store_settings");
function kr_mr_store_settings() {
    if (isset($_POST["api_token"], $_POST["introduction_text"])) {
        if (!empty($_POST["api_token"])) {
            $plugin_admin = new Klubraum_Membership_Request_Widget_Admin( "klubraum-membership-request-widget", KLUBRAUM_MEMBERSHIP_REQUEST_WIDGET_VERSION );
            $result = $plugin_admin->store_settings_info($_POST);
            echo json_encode([
                "success" => $result["success"],
                "message" => $result["message"]
            ]);
            wp_die();
        }
    }
    echo json_encode([
        "success" => false,
        "message" => __("Failed to store settings!", "klubraum-membership-request-widget")
    ]);
    wp_die();
}