<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://maakapay.com
 * @since             1.0.0
 * @package           Maakapay_Invoice_Payer_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Maakapay Invoice Payer for Woocommerce
 * Plugin URI:        https://maakapay.com/plugins/maakapay-invoice-payer-for-woocommerce
 * Description:       Integrate <strong>Nabil Bank</strong> Payment Gateway to Woocommerce for directly accepting the card <strong>Debit/Credit</strong> and paying the invoice.
 * Version:           1.0.1
 * Author:            Maakapay
 * Author URI:        https://maakapay.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       maakapay-invoice-payer-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Make sure WooCommerce is Installed And Active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    die( 'Woocommerce not found. Please install woocommerce before installing this plugin' );
}

// Check if Maakapay Exists
if( in_array( 'maakapay-invoice-payer/maakapay-wordpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    die( 'Maakapay Invoice Payer Exists in your system. You need to disable Maakapay Invoice Payer before installing this plugin. Don\'t worry your settings and transactions log are safe and can be accessed using this same plugin' );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_VERSION', '1.0.1' );
define( 'MAAKAPAY_INVOICE_PAYER_FOR_WOOCOMMERCE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-maakapay-invoice-payer-for-woocommerce-activator.php
 */
function activate_maakapay_invoice_payer_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-maakapay-invoice-payer-for-woocommerce-activator.php';
	Maakapay_Invoice_Payer_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-maakapay-invoice-payer-for-woocommerce-deactivator.php
 */
function deactivate_maakapay_invoice_payer_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-maakapay-invoice-payer-for-woocommerce-deactivator.php';
	Maakapay_Invoice_Payer_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_maakapay_invoice_payer_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_maakapay_invoice_payer_for_woocommerce' );

add_action('activated_plugin','maakapay_invoice_for_payer_woocommerce_error_log');

function maakapay_invoice_for_payer_woocommerce_error_log() {
    file_put_contents(dirname(__file__).'/error_activation.txt', ob_get_contents());
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-maakapay-invoice-payer-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_maakapay_invoice_payer_for_woocommerce() {

	$plugin = new Maakapay_Invoice_Payer_For_Woocommerce();
	$plugin->run();

}
run_maakapay_invoice_payer_for_woocommerce();
