<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://klubraum.com
 * @since      1.0.0
 *
 * @package    Klubraum_Membership_Request_Widget
 * @subpackage Klubraum_Membership_Request_Widget/admin/partials
 */

add_action('admin_menu', 'klubraum_membership_request_widget_admin_menu');
function klubraum_membership_request_widget_admin_menu() {
    add_menu_page(
        __("Klubraum Membership Request", "klubraum-membership-request-widget"),
        __("Klubraum Membership Request", "klubraum-membership-request-widget"),
        'manage_options',
        'klubraum-membership-request-widget',
        'klubraum_membership_request_widget_admin_page',
        'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+Cjxzdmcgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDQwMCA0MDAiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM6c2VyaWY9Imh0dHA6Ly93d3cuc2VyaWYuY29tLyIgc3R5bGU9ImZpbGwtcnVsZTpldmVub2RkO2NsaXAtcnVsZTpldmVub2RkO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoyOyI+CiAgICA8ZyB0cmFuc2Zvcm09Im1hdHJpeCgxLjM0NjAyLDAsMCwxLjM0NjAyLC0zOTUuNzQ2LC0zMi4zNTI2KSI+CiAgICAgICAgPGcgdHJhbnNmb3JtPSJtYXRyaXgoLTEuNTI3MjYsMCwwLDEuNTI3MjYsODkxLjUwMiwtMTA2LjQ5MSkiPgogICAgICAgICAgICA8ZyB0cmFuc2Zvcm09Im1hdHJpeCgxNDkuNjY4LDAsMCwxNDkuNjY4LDI5MC4wNDEsMjM1LjEzOCkiPgogICAgICAgICAgICAgICAgPHBhdGggZD0iTTAuMjQsLTBMMC4wNiwtMEwwLjA2LC0wLjdMMC4yNCwtMC43TDAuMjQsLTAuNDI1TDAuMzMsLTAuNDI1TDAuNDg2LC0wLjdMMC42NzYsLTAuN0wwLjQ4LC0wLjM1NUwwLjY3NSwtMEwwLjQ4NSwtMEwwLjMzLC0wLjI4NUwwLjI0LC0wLjI4NUwwLjI0LC0wWiIgc3R5bGU9ImZpbGwtcnVsZTpub256ZXJvOyIvPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgICAgIDxnIHRyYW5zZm9ybT0ibWF0cml4KDEuMDQ2NSwwLDAsMS4wNDY1LC00Mi4yMDY5LDEuNDUxNDYpIj4KICAgICAgICAgICAgPGcgdHJhbnNmb3JtPSJtYXRyaXgoMjE4LjM2MywwLDAsMjE4LjM2Myw0NTQuNTc3LDIzOS45OTIpIj4KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0wLjA2LC0wLjdMMC40OCwtMC43QzAuNTUsLTAuNyAwLjYwMSwtMC42ODQgMC42MzMsLTAuNjUzQzAuNjY0LC0wLjYyMSAwLjY4LC0wLjU3IDAuNjgsLTAuNUwwLjY4LC0wLjQxQzAuNjgsLTAuMzU1IDAuNjcxLC0wLjMxMiAwLjY1MywtMC4yODFDMC42MzQsLTAuMjUgMC42MDUsLTAuMjMgMC41NjUsLTAuMjJMMC42OSwtMEwwLjQ5NSwtMEwwLjM4LC0wLjIxTDAuMjQsLTAuMjFMMC4yNCwtMEwwLjA2LC0wTDAuMDYsLTAuN1pNMC41LC0wLjVDMC41LC0wLjU0IDAuNDgsLTAuNTYgMC40NCwtMC41NkwwLjI0LC0wLjU2TDAuMjQsLTAuMzVMMC40NCwtMC4zNUMwLjQ4LC0wLjM1IDAuNSwtMC4zNyAwLjUsLTAuNDFMMC41LC0wLjVaIiBzdHlsZT0iZmlsbC1ydWxlOm5vbnplcm87Ii8+CiAgICAgICAgICAgIDwvZz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPgo=',
        66
    );
}

function klubraum_membership_request_widget_admin_page() {
    $last_submission_info = "";
    $latest_request = get_option("kr_mr_latest_membership_request");
    if (!empty($latest_request)) {
        $latest_expiration_time = get_option("kr_mr_latest_expire_at");
        if (!empty($latest_expiration_time)) {
            $last_submission_info = __("Expires at", "klubraum-membership-request-widget") . " " . date("F d, Y H:i A", strtotime($latest_expiration_time)) . " (" . __("last request", "klubraum-membership-request-widget") .  ": \"$latest_request\")";
        }
    } else {
        $last_submission_info = __("No expiry information as no membership request has been made yet.","klubraum-membership-request-widget");
    }
?>
    <div class="wrap">
        <div class="row" style="width:100%;overflow: auto;">
            <h1 class="wp-heading-inline"><?php echo __("Klubraum Membership Request", "klubraum-membership-request-widget") ?></h1>
            <hr/>
        </div>
        <div class="row" style="width:100%;overflow: auto;">
            <h3><?php echo __("Settings", "klubraum-membership-request-widget") ?></h3>
            <hr/>
            <ul>
                <li><?php echo __("Please provide the API token which you can find in the app under: Settings - Klubraum - API Token. Only available for Klubraum admins.", "klubraum-membership-request-widget") ?></li>
                <li><?php echo __("Optionally you can customize the text which is shown in addition to the form.", "klubraum-membership-request-widget") ?></li>
            </ul>
        </div>
        <div class="row" style="width:100%;overflow: auto;">
            <h3><?php echo __("Shortcode", "klubraum-membership-request-widget") ?></h3>
            <hr/>
            <ul>
                <li><?php echo __("To integrate the membership request form, use the shortcode:", "klubraum-membership-request-widget") ?> [klubraum_membership_request_widget]</li>
            </ul>
        </div>
        <div class="row" style="width:100%;overflow: auto;">
            <h3><?php echo __("Expiry Date API token", "klubraum-membership-request-widget") ?></h3>
            <hr/>
            <ul>
                <li><?php echo $last_submission_info;?></li>
            </ul>
        </div>
    </div>
<?php
}

add_action('admin_menu', 'kr_mr_admin_settings');
function kr_mr_admin_settings() {
    add_submenu_page(
        'klubraum-membership-request-widget',
	    __("Settings","klubraum-membership-request-widget"),
	    __("Settings","klubraum-membership-request-widget"),
        'manage_options',
        'klubraum-membership-request-widget-settings',
        'kr_mr_admin_display_settings',
        68
    );
}

function kr_mr_admin_display_settings() {
    $api_token = get_option("kr_mr_api_token");
    if (!isset($api_token) || empty($api_token)) {
        $api_token = "";
    }
    $introduction_text = get_option("kr_mr_introduction_text");
?>
    <div class="wrap">
        <div class="row" style="width:100%;overflow: auto;">
            <h1 class="wp-heading-inline"><?php echo __("Settings","klubraum-membership-request-widget") ?></h1>
            <hr/>
            <div id="message_kr_mr_settings" class="kr-mr-message-div"></div>
            <div class="form-wrap">
                <form method="POST" class="kr-mr-settings-form" style="display: inline;">
                    <div class="form-field form-required term-name-wrap "
                         style="width: 100%; float: left;">
                        <label><?php echo __("API token","klubraum-membership-request-widget") ?></label>
                        <textarea id="kr_mr_api_token" placeholder="" style="width:30%;" rows="5"><?php echo $api_token;?></textarea>
                    </div>

                    <div class="form-field form-required term-name-wrap "
                         style="width: 100%; float: left;">
                        <label><?php echo __("Introduction text","klubraum-membership-request-widget") ?></label>
                        <textarea id="kr_mr_introduction_text" placeholder="<?php echo __("Some explaining words about the Klubraum widget","klubraum-membership-request-widget") ?>" style="width:30%;" rows="5"><?php echo $introduction_text;?></textarea>
                    </div>

                    <div class="form-field form-required term-name-wrap" style="width: 100%; float: left;">
                        <button type="submit" class="button button-primary" id="kr_mr_settings_submit_button">
	                        <?php echo __("Submit","klubraum-membership-request-widget") ?>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
<?php
}
?>