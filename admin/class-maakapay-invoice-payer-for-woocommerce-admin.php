<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/admin
 * @author     Maakapay <ashwin@maakapay.com>
 */
class Maakapay_Invoice_Payer_For_Woocommerce_Admin {

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
		 * defined in Maakapay_Invoice_Payer_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Maakapay_Invoice_Payer_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/maakapay-invoice-payer-for-woocommerce-admin.css', array(), $this->version, 'all' );

        wp_enqueue_script('validator', plugin_dir_url(__FILE__) . 'js/jquery.validate.min.js', array('jquery'), $this->version, false);

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
		 * defined in Maakapay_Invoice_Payer_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Maakapay_Invoice_Payer_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/maakapay-invoice-payer-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

        wp_enqueue_script('validator', plugin_dir_url(__FILE__) . 'js/jquery.validate.min.js', array('jquery'), $this->version, false);

        wp_localize_script($this->plugin_name, "maakapay_payment", array(
            "ajaxurl" => admin_url('admin-ajax.php')
        ));
	}

    /**
     * Register the menu for the admin area.
     *
     * @since    1.0.0
     */
    public function maakapay_menu()
    {

        add_menu_page('Maakapay Transaction list', 'Maakapay', 'manage_options', 'maakapay-dashboard', array($this, 'maakapay_dashboard'), 'dashicons-analytics');
        add_submenu_page('maakapay-dashboard', "Maakapay Invoice Payer Dashboard", "Dashboard", "manage_options", "maakapay-dashboard", array($this, 'maakapay_dashboard'));
        add_submenu_page('maakapay-dashboard', "Settings", "Settings", "manage_options", "maakapay-settings", array($this, 'maakapay_settings'));

    }

    /**
     * Admin submenu callback.
     *
     * @since    1.0.0
     */
    public function maakapay_dashboard()
    {

        ob_start(); //start buffer.

        $action = isset($_GET['action']) ? trim(sanitize_text_field($_GET['action'])) : "";

        if ($action == "maakapay-view") {

            $transaction_code = isset($_GET['transaction_code']) ? trim(sanitize_text_field($_GET['transaction_code'])) : "";

            require_once MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'admin/partials/maakapay-invoice-payer-for-woocommerce-admin-transaction-detail.php';  // include template.

        } else {

            require_once MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'admin/partials/maakapay-invoice-payer-for-woocommerce-admin-display.php';  // include template.

        }


        $template = ob_get_contents(); // load content.

        ob_end_clean(); //closing and cleaning buffer.

        echo $template;

    }

    /**
     * Admin submenu callback for settings page.
     *
     * @since    1.0.0
     */
    public function maakapay_settings()
    {

        ob_start(); //start buffer.

        require_once MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH . 'admin/partials/maakapay-invoice-payer-for-woocommerce-admin-settings.php';  // include template.

        $template = ob_get_contents(); // load content.

        ob_end_clean(); //closing and cleaning buffer.

        echo $template;
    }

    /**
     * Handel Admin ajax request for settings form.
     *
     * @since    1.0.0
     */
    public function handle_ajax_request_admin()
    {

        $param = isset($_REQUEST['param']) ? sanitize_text_field($_REQUEST['param']) : "";

        if (!empty($param)) {

            if ($param == "update_settings") {

                $mode = trim(sanitize_text_field($_REQUEST['api_mode']));
                $test_key = ($_REQUEST['api_test_key']) ? trim(sanitize_text_field($_REQUEST['api_test_key'])) : '';
                $live_key = ($_REQUEST['api_live_key']) ? trim(sanitize_text_field($_REQUEST['api_live_key'])) : '';
                $mail_email = ($_REQUEST['mail_address']) ? trim(sanitize_email($_REQUEST['mail_address'])) : get_option('maakapay_admin_mail');
                $maakapay_accepting_currencies = ($_REQUEST['maakapay_accepting_currencies']) ? trim(sanitize_text_field($_REQUEST['maakapay_accepting_currencies'])) : get_option('maakapay_accepting_currencies');

                update_option('maakapay_mode', $mode);
                update_option('maakapay_test', $test_key);
                update_option('maakapay_live', $live_key);
                update_option('maakapay_admin_mail', $mail_email);
                update_option('maakapay_accepting_currencies', $maakapay_accepting_currencies);

                echo json_encode(array(
                    "status" => 1,
                    "message" => "Settings Updated Successfully"
                ));

            }
        }

        wp_die();

    }

}
