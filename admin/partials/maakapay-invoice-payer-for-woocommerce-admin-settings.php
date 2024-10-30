<?php


/**
 * Provide an admin area setting page for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/admin/partials
 */

?>
<style>
    .error{
        color: red;
    }
</style>
<div class="wpbody-content">
    <div class="wrap">
        <h1>Maakapay Settings</h1>
        <div class="wp-core-ui">
            <form action="javascript:void(0)" id="maakapay-settings-form">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <label for="api">API Mode</label>
                        </th>
                        <td>
                            <select name="api_mode">
                                <option value="test" <?php if( get_option( 'maakapay_mode' ) == "test" ) {  echo "selected"; } ?>>Test</option>
                                <option value="live" <?php if( get_option( 'maakapay_mode' ) == "live" ) { echo "selected"; } ?>>Live</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="api_test_key">Test Key</label>
                        </th>
                        <td>
                            <input type="text" name="api_test_key" value="<?php echo get_option('maakapay_test'); ?>" placeholder="API Test Key">
                            <p class="description" id="api_test_key">Please enter the api test key provided by <strong>Maakapay Payment Service</strong> here.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="api_live_key">Live Key</label>
                        </th>
                        <td>
                            <input type="text" name="api_live_key" value="<?php echo get_option('maakapay_live'); ?>" placeholder="API Live Key">
                            <p class="description" id="api_live_key">Please enter the api key provided by <strong>Maakapay Payment Service</strong> here.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="mail_address">Mail Address</label>
                        </th>
                        <td>
                            <input type="email" name="mail_address" value="<?php echo get_option('maakapay_admin_mail'); ?>" placeholder="example@example.com" required>
                            <p class="description" id="mail_address">Please enter the email address where you will get payment notification after payment is completed.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button type="Submit" class="button button-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>