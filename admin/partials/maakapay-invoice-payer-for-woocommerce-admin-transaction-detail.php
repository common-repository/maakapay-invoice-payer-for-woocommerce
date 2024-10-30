<?php


/**
 * Provide an admin area individual transaction view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/admin/partials
 */

global $wpdb;

$table_name = "{$wpdb->prefix}maakapay_transactions_logs";

$transaction = $wpdb->get_results("SELECT * from {$table_name} WHERE transaction_code = '{$transaction_code}' LIMIT 1", ARRAY_A);

if( !empty( $transaction ) ) :

?>

    <div class="wpbody-content">
        <div class="wrap">
            <h1>Transaction Detail page</h1>
            <div class="wp-core-ui">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <label for="api">API Mode</label>
                        </th>
                        <td>
                            <b><?php echo strtoupper( esc_attr( $transaction[0]['app_mode'] ) ); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="name">Name</label>
                        </th>
                        <td>
                            <?php echo ( isset( $transaction[0]['name'] ) ) ? esc_attr( $transaction[0]['name'] ) : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="contact">Contact NUmber</label>
                        </th>
                        <td>
                            <?php echo ( isset( $transaction[0]['contact_number'] ) ) ? esc_attr( $transaction[0]['contact_number'] ) : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="email">Email Address</label>
                        </th>
                        <td>
                            <?php echo ( isset( $transaction[0]['email'] ) ) ? esc_attr( $transaction[0]['email'] ) : '';?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="total">Total Amount</label>
                        </th>
                        <td>
                            <?php  echo ( isset( $transaction[0]['currency'] ) ) ? esc_attr( $transaction[0]['currency'] ) : ''; echo ( isset( $transaction[0]['amount'] ) ) ?  ' ' . esc_attr( $transaction[0]['amount'] ) : ''; echo '/-'; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="status">Payment Status</label>
                        </th>
                        <td>
                            <strong><?php echo ( isset( $transaction[0]['status'] ) ) ? strtoupper( esc_attr( $transaction[0]['status'] ) ) : ''; ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="transaction_code">Transaction Code</label>
                        </th>
                        <td>
                            <?php echo ( isset( $transaction[0]['transaction_code'] ) ) ?  esc_attr( $transaction[0]['transaction_code'] ) : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="api_live_key">Invoice Number</label>
                        </th>
                        <td>
                            <?php echo ( isset( $transaction[0]['invoice_number'] ) ) ?  esc_attr( $transaction[0]['invoice_number'] ) : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="order_created_at">Request Order created At</label>
                        </th>
                        <td>
                            <?php echo ( isset( $transaction[0]['order_created_at'] ) ) ? esc_attr( $transaction[0]['order_created_at'] ) :''; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="order_updated_at">Request Order updated At</label>
                        </th>
                        <td>
                            <?php echo ( isset( $transaction[0]['order_updated_at'] ) ) ? esc_attr( $transaction[0]['order_updated_at'] ) : ''; ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button type="button" class="button button-primary" onclick="goBack()">Go Back</button>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
<?php
else:
    echo "<h1>Transaction Not Found</h1>";

endif;