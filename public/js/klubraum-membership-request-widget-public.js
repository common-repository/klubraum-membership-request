(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

	$(document).on("click", "#kr_mr_membership_request_submit_button", function(e) {
		e.preventDefault();
		$("#kr_mr_membership_request_submit_button").prop("disabled", true);

		$.ajax({
			url: klubraum_membership_request_widget_object.url,
			type: "POST",
			dataType: "json",
			data: {
				action: "kr_mr_store_membership_request",
				name: $("#kr_mr_name").val(),
				email: $("#kr_mr_email").val(),
				address: $("#kr_mr_address").val()
			},
			success: function(response) {
				$("#kr_mr_membership_request_submit_button").prop("disabled", false);
				if (response.success) {
          $("#kr_mr_email").val("");
					kr_mr_showResponseMessage("message_kr_mr_membership_request", "✔ "+response.message, "success");
				} else {
					kr_mr_showResponseMessage("message_kr_mr_membership_request", "✘ "+response.message, "danger");
				}
			}
		});
	});

	function kr_mr_showResponseMessage(el_id, message, alert_type, duration=2000) {
		$("#"+el_id).html("<div class='kr-mr-alert kr-mr-alert-"+alert_type+"'>"+message+"</div>");
		setTimeout(function () {
			$("#"+el_id).html("");
		}, duration);
	}
})( jQuery );
