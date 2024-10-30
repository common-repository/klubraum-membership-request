<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://klubraum.com
 * @since      1.0.0
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/public
 * @author     Steffen Haak <info@klubraum.com>
 */
class Klubraum_Membership_Request_Widget_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/klubraum-membership-request-widget-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/klubraum-membership-request-widget-public.js', array( 'jquery' ), $this->version, false );

        wp_localize_script($this->plugin_name, 'klubraum_membership_request_widget_object', array(
            'url' => admin_url('admin-ajax.php')
        ));
	}

    /**
     * Store settings info.
     *
     * @param $args
     * @return array
     */
    function store_settings_info($args) {
        $email = filter_var($args["email"], FILTER_SANITIZE_STRING);
        $api_token = get_option("kr_mr_api_token");
        $target_url = 'https://api.klubraum.com/api-v1/user/membershipRequest/public';
        if (empty($api_token)) {
            return [
                "success" => false,
                "message" => __("Failed to request membership!", "klubraum-membership-request-widget")
            ];
        }

        /* Get the expiration info. */
        $response = wp_remote_post($target_url, [
            'method'      => 'POST',
            'headers'     => [
                "Content-Type"  => "application/json",
                "X-Auth-Token"  => $api_token
            ],
            'body'        => wp_json_encode([
                "loginId" => $email
            ])
        ]);
        if (isset($response["body"])) {
            $data = json_decode($response["body"]);
            if (isset($data->success) and $data->success) {
                $timezone_str = get_option('timezone_string');
                if (!empty($timezone_str)) {
                    date_default_timezone_set($timezone_str);
                }
                /* Update the latest request info. */
                $timestamp = date("Y-m-d H:i:s", $data->expiresAt);
                update_option("kr_mr_latest_membership_request", $email);
                update_option("kr_mr_latest_expire_at", $timestamp);
                /* Store the latest subscription info. */
                global $wpdb;
                $wpdb->insert($wpdb->prefix."kr_mr_membership_request", [
                    "email"         => $email,
                    "expires_at"    => $timestamp
                ]);

                return [
                    "success" => true,
                    "message" => __("Membership requested successfully!", "klubraum-membership-request-widget")
                ];
            }
        }

        return [
            "success" => false,
            "message" => __("Failed to request membership!", "klubraum-membership-request-widget")
        ];

    }

    /**
     * Get the html content for the membership_request widget.
     *
     * @return string
     */
    function get_shortcode_html() {
        $api_token = get_option("kr_mr_api_token");

        if (!isset($api_token) || empty($api_token)) {
          return null;
        }

        $introduction_text = get_option("kr_mr_introduction_text");
        $introduction_text_container = "";
        if (isset($introduction_text) and !empty($introduction_text)) {
            $introduction_text_container = '<div class="kr-mr-introduction-text-container">'. $introduction_text .'</div>';
        }
        $html = '<div class="kr-mr-container">
            <div class="kr-mr-wrap">
                <div class="kr-mr-row" style="width:100%;overflow: auto;">
                    <div class="kr-mr-logo-container">
                        <a href="https://klubraum.com">
                          <img src="' . plugin_dir_url( __FILE__ ) .'images/klubraum_logo_blue.png" alt="Klubraum Logo" id="klubraum-membership-request-widget-logo"/>
                        </a>
                    </div>
                    '.$introduction_text_container.'
                    <div class="kr-mr-form-wrap">                
                        <div id="message_kr_mr_membership_request" class="kr-mr-message-div"></div>
                        <form method="POST" id="kr_mr_settings_form" class="kr-mr-settings-form" style="display: inline;">
                            <div class="form-field form-required term-name-wrap" style="width: 100%; float: left;">
                                <input type="text" id="kr_mr_name" class="kr-mr-nd" name="name" placeholder="Your name"/>
                            </div>
                            <div class="form-field form-required term-name-wrap" style="width: 100%; float: left;">
                                <input type="text" id="kr_mr_email" class="kr-mr-d" name="email" placeholder="'.__("E-Mail", "klubraum-membership-request-widget").'"/>
                            </div>
                            <div class="form-field form-required term-name-wrap" style="width: 100%; float: left;">
                                <input type="text" id="kr_mr_address" class="kr-mr-nd" name="address" placeholder="Your address"/>
                            </div>
                            <div class="form-field form-required term-name-wrap" style="width: 100%; float: left;">
                                <button type="submit" class="button button-primary kr-mr-submit-button" id="kr_mr_membership_request_submit_button">
                                    '.__("Request Membership", "klubraum-membership-request-widget").'
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
        return $html;
    }
}

/**
 * Store new request. Handle ajax request.
 */
add_action("wp_ajax_kr_mr_store_membership_request", "kr_mr_store_membership_request");
add_action("wp_ajax_nopriv_kr_mr_store_membership_request", "kr_mr_store_membership_request");
function kr_mr_store_membership_request() {
    $error_msg = __("Failed to request membership!", "klubraum-membership-request-widget");
    if (empty($_POST["name"]) and empty($_POST["address"])) {
        if (isset($_POST["email"]) and !empty($_POST["email"])) {
            $plugin_admin = new Klubraum_Membership_Request_Widget_Public( "klubraum-membership-request-widget", KLUBRAUM_MEMBERSHIP_REQUEST_WIDGET_VERSION );
            $result = $plugin_admin->store_settings_info($_POST);
            echo json_encode([
                "success" => $result["success"],
                "message" => __($result["message"])
            ]);
            wp_die();
        } else {
            $error_msg = __("Please enter a valid email.", "klubraum-membership-request-widget");
        }
    }
    echo json_encode([
        "success" => false,
        "message" => $error_msg
    ]);
    wp_die();
}

/**
 * Shortcode for membership_request widget in frontend.
 */
add_shortcode('klubraum_membership_request_widget', 'kr_mr_display_membership_request_widget');
function kr_mr_display_membership_request_widget() {
    $plugin_admin = new Klubraum_Membership_Request_Widget_Public( "klubraum-membership-request-widget", KLUBRAUM_MEMBERSHIP_REQUEST_WIDGET_VERSION );
    return $plugin_admin->get_shortcode_html();
}