<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/public
 * @author     Maakapay <ashwin@maakapay.com>
 */
class Maakapay_Invoice_Payer_For_Woocommerce_Public {

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

        global $post;

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Maakapay_Invoice_Payer_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Maakapay_Invoice_Payer_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if ( $post->post_name == 'maakapay-form' || $post->post_name == 'maakapay-success' || $post->post_name == 'maakapay-cancel' || $post->post_name ==  'maakapay-decline' ) {

            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/maakapay-invoice-payer-for-woocommerce-public.css', array(), $this->version, 'all');

            wp_enqueue_style('bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');

            wp_enqueue_style('payment-form', plugin_dir_url(__FILE__) . 'css/maakapay-invoice-payer-for-woocommerce-payment-form.css', array(), $this->version, 'all');

            wp_enqueue_style('phone-css', plugin_dir_url(__FILE__) . 'css/intlTelInput.min.css', array(), $this->version, 'all');

        }
    }

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        global $post;

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Maakapay_Invoice_Payer_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Maakapay_Invoice_Payer_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if ( $post->post_name == 'maakapay-form' || $post->post_name == 'maakapay-success' || $post->post_name == 'maakapay-cancel' || $post->post_name ==  'maakapay-decline' ) {

            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/maakapay-invoice-payer-for-woocommerce-public.js', array('jquery'), $this->version, false);

            wp_enqueue_script('validator', plugin_dir_url(__FILE__) . 'js/jquery.validate.min.js', array('jquery'), $this->version, false);

            wp_localize_script($this->plugin_name, "maakapay_payment_request", array(
                "ajaxurl" => admin_url('admin-ajax.php')
            ));

            wp_enqueue_script('phone-js', plugin_dir_url(__FILE__) . 'js/intlTelInput.min.js', array('jquery'), $this->version, false);

        }

	}

    /**
     * Show the custom template page for payment page and status pages.
     *
     * @since    1.0.0
     */
    public function payment_page_template_handler() {

        global $post;

        $transaction_code = null;
        $hash_value = null;

        if( isset( $_GET['transaction_code'] ) && !empty ( sanitize_text_field( $_GET['transaction_code'] ) )) {

            $params = explode("?", sanitize_text_field( $_GET['transaction_code'] ) );

            if( isset( $params[0] ) && isset( $params[1] ) ) {

                $transaction_code = sanitize_text_field( $params[0] );
                $hash_value = sanitize_text_field( str_replace("validator=", "", $params[1] ) );

            }

        }

        if( $post->post_name == "maakapay-form" ) {

            $page_template = MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH . "public/partials/maakapay-invoice-payer-for-woocommerce-public-payment-form.php";

        }

        if( $post->post_name == "maakapay-success" ) {

            if( isset( $transaction_code ) && !empty( $transaction_code  && isset( $hash_value ) && !empty( $hash_value ) ) ) {

                $this->update_the_status_of_transaction( $transaction_code, $hash_value, "success");

            }

            $page_template = MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH . "public/partials/maakapay-invoice-payer-for-woocommerce-public-payment-success.php";

        }

        if( $post->post_name == "maakapay-cancel" ) {

            if( isset( $transaction_code ) && !empty( $transaction_code  && isset( $hash_value ) && !empty( $hash_value ) ) ) {

                $this->update_the_status_of_transaction( $transaction_code, $hash_value, "cancel");

            }

            $page_template = MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH . "public/partials/maakapay-invoice-payer-for-woocommerce-public-payment-cancel.php";

        }

        if( $post->post_name == "maakapay-decline" ) {

            if( isset( $transaction_code ) && !empty( $transaction_code  && isset( $hash_value ) && !empty( $hash_value ) ) ) {

                $this->update_the_status_of_transaction( $transaction_code, $hash_value, "decline");

            }

            $page_template = MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH . "public/partials/maakapay-invoice-payer-for-woocommerce-public-payment-decline.php";

        }

        return $page_template;

    }


    /**
     * Handel the Payment response from the server and update in the local database.
     *
     * @since    1.0.0
     */
    public function update_the_status_of_transaction($transaction_code, $hash_value, $transaction_status ) {
        global $wpdb;

        $merchant_key = null;
        if( get_option( 'maakapay_mode' ) == "live" ) {

            $merchant_key = get_option( 'maakapay_live' );

        } else {

            $merchant_key = get_option( 'maakapay_test' );

        }

        $hash_hmac = hash_hmac( 'SHA256', $transaction_code ,  $merchant_key, false );
        $value =  strtoupper( $hash_hmac );
        $expected_value = urlencode( $value );

        if( hash_equals( $expected_value, $hash_value ) ) {

            $table_name = "{$wpdb->prefix}maakapay_transactions_logs";

            $result = $wpdb->get_results( "SELECT * from {$table_name} WHERE transaction_code = '{$transaction_code}' LIMIT 1" );

            (isset($result[0])) ? $result = $result[0] : null;

            if( ! is_null($result) && $result->status == 'pending' ) {

                $data = [ "status" => $transaction_status, "order_updated_at" =>  date("Y-m-d H:i:s") ];
                $where = [ "transaction_code" => $transaction_code ];
                $updated = $wpdb->update( $table_name, $data, $where );

                if( $updated == false ) {

                    echo "Unable to update the database. Please try again";
                    wp_die();

                }

                $order = wc_get_order ( $result->invoice_number );

                switch ( $transaction_status ) {
                    case "success":
                        $message = "Invoice has been paid, Order ID: { $result->invoice_number } and Amount Paid: { $result->amount }";
                        break;
                    case "cancel":
                        $message = "Transaction has been canceled by the user. Order ID: {$result->invoice_number}";
                        break;
                    case "decline":
                        $message = "Card has been declined by the bank. Order ID: { $result->invoice_number }";
                        break;
                    default:
                        $message = "Unknown status for Order ID: { $result->invoice_number }";
                }

                $order->add_order_note( $message, ($transaction_status == "success") ? true : false );

            }

        }

    }

    /**
     * Handel ajax request for payment form.
     *
     * @since    1.0.0
     */
    public function handle_ajax_request() {

        $param = isset( $_REQUEST['param'] ) ? trim( sanitize_text_field( $_REQUEST['param'] ) ) : "";

        if( !empty( $param ) ) {

            if( $param == "maakapay_payment_request" ) {

                if( isset( $_SESSION['errors'] ) ) {

                    echo json_encode( array(
                        "status" => 400,
                        "message" => trim( sanitize_text_field( $_SESSION['errors'] ) ),
                        "url" => ''
                    ) );
                }

                $response = $this->handle_request();

                if( !empty($response) ) {

                    echo json_encode( array(
                        "status" => 301,
                        "message" => "Success",
                        "url" => trim( sanitize_text_field( $response ) )
                    ) );

                } else {

                    echo json_encode( array(
                        "status" => 500,
                        "message" => "Something Went Wrong please try again",
                        "url" => ''
                    ) );

                }

            }
        }

        wp_die();
    }

    /**
     * Store the Request Data into the table.
     *
     * @since    1.0.0
     */
    public function handle_request() {

        global $wpdb;

        $exists = false;

        if ( !function_exists( 'wp_generate_uuid4' ) ) {

            require_once ABSPATH . WPINC . '/functions.php';
            $exists = true;

        }

        $invoice_id = trim( sanitize_text_field( $_REQUEST[ 'invoice_number' ] ) );

        $order = wc_get_order( $invoice_id );


        if( ! $order ) {

            echo json_encode( array(
                "status" => 400,
                "message" => "Something went wrong: Invoice Number not found",
                "url" => ''
            ) );

            wp_die();
        }

        $first_name = $this->validate( trim( sanitize_text_field( $_REQUEST[ 'first_name' ] ) ), 'first_name' );
        $last_name = $this->validate( trim( sanitize_text_field( $_REQUEST[ 'last_name' ] ) ), 'last_name' );
        $email = $this->validate( trim( sanitize_email( $_REQUEST[ 'email' ] ) ), 'email' );
        $phone = $this->validate( trim( sanitize_text_field( $_REQUEST[ 'phone' ] ) ), 'phone' );
        $amount =  $this->validate( trim( sanitize_text_field( $_REQUEST[ 'amount' ] ) ), 'amount' );
        $currency = $order->get_currency();
        $client_ip = $this->user_ip_address();


        $name = $first_name. ' '. $last_name;

        $app_mode = get_option( 'maakapay_mode' );

        $transaction_code = ( $exists ) ? strtoupper( wp_generate_uuid4() ) : strtoupper( md5( time() ) );

        date_default_timezone_set('UTC');

        $table_name = $wpdb->prefix . "maakapay_transactions_logs";
        $data = array('name' => $name, 'invoice_number' => $invoice_id, 'transaction_code' => $transaction_code, 'amount' => $amount, 'email'=> $email, 'contact_number' => $phone, 'status' => 'pending', 'app_mode' => $app_mode, 'currency' => $currency, 'client_ip' => $client_ip, 'order_created_at' => date("Y-m-d H:i:s"));
        $format = array('%s','%d');


        $wpdb->insert( $table_name, $data, $format );

        $api_url = null;
        $token = null;

        if( get_option( 'maakapay_mode' ) == "live" ){

            $token = get_option( 'maakapay_live' );
            $api_url = 'https://apiapp.maakapay.com/v1/createOrder';

        }else{

            $token = get_option('maakapay_test');
            $api_url = 'https://apisandbox.maakapay.com/v1/createOrder';

        }

        $params = [
            'currency' => $currency,
            'amount' => $amount,
            'timeout' => 60,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'description' => $invoice_id,
            'transaction_code' => $transaction_code,
            'visitor_ip' => $client_ip,
            'approved' => home_url( '/maakapay-success/' ),
            'canceled' => home_url( '/maakapay-cancel/' ),
            'declined' => home_url( '/maakapay-decline/' ),
            'merchant_key' => $token,
        ];

        $response = wp_safe_remote_post( esc_url_raw( $api_url ), array(

            'body' => $params,

        ));

        if ( is_wp_error( $response ) ) {

            $error_message = $response->get_error_message();
            $data = [
                "data" => [
                    "message" => "Something went wrong: $error_message",
                    "status" => 400
                ]
            ];
            return json_encode( $data );

        } else {

            $body = trim( wp_remote_retrieve_body( $response ) );
            $body = json_decode($body);
            return $body->data;

        }
    }


    /**
     * Validate the Request.
     *
     * @since    1.0.0
     */
    public function validate( $value = '', $name = '' ){

        if( empty( $value ) ) {
            $_SESSION[ 'errors' ][ $name ] = $name .' field is required';
        }

        return $value;

    }

    /**
     * Get User Ip address for security purpose.
     *
     * @since    1.0.0
     */
    public function user_ip_address() {

        if( !empty( $_SERVER[ 'HTTP_CLIENT_IP' ] ) ) {
            $ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
        } elseif( ! empty( $_SERVER[ 'HTTP_X_FORWARD_FOR' ] ) ) {
            $ip = $_SERVER[ 'HTTP_X_FORWARD_FOR' ];
        } else {
            $ip = $_SERVER[ 'REMOTE_ADDR' ];
        }

        return $ip;
    }

}
