jQuery(function() {
	var ajaxurl = maakapay_payment.ajaxurl;

	jQuery("#maakapay-settings-form").validate({

		rules: {

			mail_address: {
				required: true,
				email: true
			},

		},

		messages: {

			mail_address: {
				required: "Please enter email address",
				email: "Please enter a valid email address.",
			}

		},

		submitHandler: function() {

			var postdata = jQuery("#maakapay-settings-form").serialize();

			postdata += "&action=admin_ajax_request&param=update_settings";

			jQuery.post(ajaxurl, postdata, function(response) {

				var data = jQuery.parseJSON(response);

				if(data.status == 1) {

					alert(data.message);

					setTimeout(function() {
						location.reload();
					}, 1000);
				}

			});

		}

	});
});
