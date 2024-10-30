<?php

/**
 * Fired during plugin activation
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/includes
 * @author     Maakapay <ashwin@maakapay.com>
 */
class Maakapay_Invoice_Payer_For_Woocommerce_Activator {

    /**
     * Generate the dynamic table for storing all the transaction records.
     *
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "maakapay_transactions_logs";

        $charset_collate = '';
        if ( !empty( $wpdb->charset ) )
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        if ( !empty( $wpdb->collate ) )
            $charset_collate .= " COLLATE {$wpdb->collate}";

        $table_query = "CREATE TABLE {$table_name} (
				id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				transaction_code varchar(250) NOT NULL,
				invoice_number bigint NOT NULL,
				order_created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				order_updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				name varchar(65) NOT NULL,
				contact_number varchar(20) NOT NULL,
				email varchar(55) NOT NULL,
				amount varchar(65) NOT NULL,
				currency varchar(65) NOT NULL,
				client_ip varchar(100) NOT NULL,
				app_mode varchar(5) NOT NULL,
				status varchar(20) DEFAULT 'pending' NOT NULL,
				PRIMARY KEY id (id),
				UNIQUE KEY id (id),
				UNIQUE KEY transaction_code (transaction_code),
				INDEX index_transaction_code (transaction_code),
				INDEX index_invoice_number (invoice_number)
			) $charset_collate;
		";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        maybe_create_table( $table_name, $table_query );

        // Check if options exits and add that to the setting
        add_option( 'maakapay_test', ( get_option( 'maakapay_test' ) ) ? get_option( 'maakapay_test' ) : '' );
        add_option( 'maakapay_live', ( get_option( 'maakapay_live' ) )? get_option( 'maakapay_live' ) : '' );
        add_option( 'maakapay_mode', ( get_option( 'maakapay_mode' ) ) ? get_option( 'maakapay_mode' ) : '' );
        add_option( 'maakapay_admin_mail', ( get_option( 'maakapay_live' ) ) ? get_option( 'maakapay_admin_mail' ) : get_option( 'admin_email' ) );
        self::create_pages();
    }

    /**
     * Create pages for payment form, transaction success, declined or cancel.
     *
     *
     * @since    1.0.0
     */
    public static function create_pages()
    {
        global $wpdb;
        $page = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}posts WHERE post_name = %s",
                'maakapay-form'
            )
        );

        if (empty($page)) {
            $payment_form_page = [
                "post_title" => "Pay your invoice",
                "post_name" => "maakapay-form",
                "post_status" => "publish",
                "post_author" => 1,
                "post_content" => "Maakapay payment form for clients",
                "post_type" => "page"
            ];

            wp_insert_post($payment_form_page);

            $payment_success_page = [
                "post_title" => "Paid invoice successfully",
                "post_name" => "maakapay-success",
                "post_status" => "publish",
                "post_author" => 1,
                "post_content" => "Paid invoice successfully",
                "post_type" => "page"
            ];

            wp_insert_post($payment_success_page);

            $payment_cancel_page = [
                "post_title" => "Payment Cancelled",
                "post_name" => "maakapay-cancel",
                "post_status" => "publish",
                "post_author" => 1,
                "post_content" => "Sorry to hear you Cancelled the payment request",
                "post_type" => "page"
            ];

            wp_insert_post($payment_cancel_page);

            $payment_decline_page = [
                "post_title" => "Oops! Payment declined",
                "post_name" => "maakapay-decline",
                "post_status" => "publish",
                "post_author" => 1,
                "post_content" => "Oops! There is some issue and your payment request is declined",
                "post_type" => "page"
            ];

            wp_insert_post($payment_decline_page);
        }
    }

}
