(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).on("click", "#kr_mr_settings_submit_button", function(e) {
		e.preventDefault();

		let introduction_text = $("#kr_mr_introduction_text").val();
		let api_token = $("#kr_mr_api_token").val();
		if (api_token === "") {
			kr_mr_showResponseMessage("message_kr_mr_settings", "✘ "+klubraum_membership_request_widget_admin_object.msgApiTokenMissing, "danger");
			return;
		}

		$.ajax({
			url: klubraum_membership_request_widget_admin_object.url,
			type: "POST",
			dataType: "json",
			data: {
				action: "kr_mr_store_settings",
				api_token: api_token,
				introduction_text: introduction_text,
			},
			success: function(response) {
				$("#kr_mr_settings_submit_button").prop("disabled", false);
				if (response.success) {
					kr_mr_showResponseMessage("message_kr_mr_settings", "✔ "+response.message, "success");
				} else {
					kr_mr_showResponseMessage("message_kr_mr_settings", "✘ "+response.message, "danger");
				}
			}
		});
	});

	function kr_mr_showResponseMessage(el_id, message, alert_type, duration=2000) {
		$("#"+el_id).html("<div class='kr-mr-alert-dashboard kr-mr-alert-dashboard-"+alert_type+"'>"+message+"</div>");
		setTimeout(function () {
			$("#"+el_id).html("");
		}, duration);
	}
})( jQuery );