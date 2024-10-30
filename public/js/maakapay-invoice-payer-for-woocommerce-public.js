jQuery(function () {

    var ajaxurl = maakapay_payment_request.ajaxurl;

    jQuery("#maakapay-payment-form").validate({

        rules: {

            first_name: "required",

            last_name: "required",

            email: {
                required: true,
                email: true
            },

            phone: "required",

            invoice_number: "required",

            amount: "required"

        },

        messages: {

            first_name: "Enter First Name",

            last_name: "Enter Last Name",

            email: {
                required: "Please enter email address",
                email: "Please enter a valid email address.",
            },

            phone: "Enter Phone number",

            invoice_number: "Enter Invoice Number",

            amount: "Enter Amount"

        },

        submitHandler: function () {

            public_payment_submit_request();

            var postdata = jQuery("#maakapay-payment-form").serialize();

            postdata += "&action=public_ajax_request&param=maakapay_payment_request";

            jQuery.post(ajaxurl, postdata, function (response) {

                var data = jQuery.parseJSON(response);

                if (data.status == 301) {

                    window.location.replace(data.url);

                } else {
                    var message = "We are unable to process your request please contact to the Site admin";
                    if (data.status == 400) {
                        message = data.message;
                    }

                    // Reset all the changes that was done to hide the screen

                    jQuery('.overlay-styles').remove();
                    jQuery('.overlay-content-styles avoid-clicks').remove();
                    var paynow = document.querySelector('.pay-now');
                    paynow.innerHTML = "Pay Now";
                    paynow.classList.remove('spinning', 'avoid-clicks');
                    jQuery('#overlay-message').remove();
                    var transaction_error = document.querySelector('#transaction-error');
                    transaction_error.innerHTML = "<span class='alert alert-danger'>" + message + "</span>";
                    enableScrolling();
                }

            });

        }

    });

    // Change the Pay now to please and block the whole screen while request is sent for processing

    var paynow = document.querySelector('.pay-now');

    paynow.addEventListener("click", function () {

        paynow.innerHTML = "Please Wait";
        paynow.classList.add('spinning');
        paynow.classList.add('avoid-clicks');

    }, false);

    function public_payment_submit_request() {

        disableScroll();

        var overlay = jQuery('<div></div>');
        jQuery("body").append(overlay);
        overlay.fadeIn(100).addClass('overlay-styles');

        var overlayContent = jQuery('<div>')
            .html('<snap id="overlay-message">Please Wait While we process your request</snap>')
            .addClass('overlay-content-styles avoid-clicks');

        overlay.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",
            function () {
                jQuery('body').append(overlayContent);
            }
        );
    };

    function disableScroll() {
        // Get the current page scroll position
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

        // if any scroll is attempted, set this to the previous value
        window.onscroll = function () {
            window.scrollTo(scrollLeft, scrollTop);
        };
    }

    function enableScrolling() {
        window.onscroll = function () {
        };
    }

    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        // any initialisation options go here
    });
});
