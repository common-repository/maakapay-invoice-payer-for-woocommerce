<?php

/**
 * Provide a public invoice payment form area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/public/partials
 */

get_header();

global $woocommerce;

$first_name = $last_name = $email = $number = $invoice = $amount = $order = null;
$currency = get_woocommerce_currency();

if(isset($_GET['order_number'])) {
    $invoice = trim( esc_attr( $_GET['order_number'] ) );
    $order = wc_get_order( $invoice );
    if( $order ) {
        $first_name = $order->get_billing_first_name();
        $last_name = $order->get_billing_last_name();
        $email = $order->get_billing_email();
        $number = $order->get_billing_phone();
        $amount = $order->get_total();
        $currency = $order->get_currency();
    }
 }

if(isset($_SESSION['errors'])) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ( array_map(  'esc_attr', $_SESSION['errors'] ) as $key => $value ) : ?>
                <li><?php echo esc_attr( ucwords( str_replace( '_', ' ', $value ) ) ); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php session_destroy(); endif; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="maakapay-website-logo"><?php the_custom_logo(); ?></div>
                <?php endif; ?>
                <h2 class="text">Pay Invoice</h2>
            </div>
        </div>

        <form class="maakapay-payment-form" action="javascript:void(0)" id="maakapay-payment-form">

            <h3>Invoice Details</h3>
            <br>
            <div class="row">
                <div class="maakapay-form-group form-group col-md-6">
                    <label class="maakapay-form-label" for="maakapayFirstName">First Name <span
                                class="imp">*</span></label>
                    <input type="text" name="first_name" class="maakapay-form-control form-control" value="<?php echo esc_attr( $first_name ); ?>" required>
                </div>

                <div class="maakapay-form-group form-group col-md-6">
                    <label class="maakapay-form-label" for="maakapayLastName">Last Name <span
                                class="imp">*</span></label>
                    <input type="text" name="last_name" class="maakapay-form-control form-control" value="<?php echo esc_attr( $last_name ); ?>" required>
                </div>

            </div>

            <div class="row">

                <div class="maakapay-form-group form-group col-md-6">
                    <label class="maakapay-form-label" for="email">Email <span class="imp">*</span></label>
                    <input type="email" name="email" class="maakapay-form-control form-control" id="maakapayEmail"
                           value="<?php echo esc_attr( $email ); ?>" placeholder="john.doe@gmail.com" required>
                </div>

                <div class="maakapay-form-group form-group col-md-6">
                    <label class="maakapay-form-label">Phone Number <span class="imp">*</span></label>
                    <br/>
                    <input type="text" name="phone" class="maakapay-form-control form-control" id="phone" value="<?php echo esc_attr( $number ); ?>"
                           placeholder="Phone" required>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4">

                    <div class="maakapay-form-group form-group">
                        <label class="maakapay-form-label" for="invoice_number">Invoice Number <span
                                    class="imp">*</span></label>
                        <input type="number" name="invoice_number" class="maakapay-form-control form-control" value="<?php echo esc_attr( $invoice ); ?>" required>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="maakapay-form-group form-group">
                        <label class="maakapay-form-label" for="amount">Amount : <?php echo esc_attr( $currency ); ?></label>
                        <input type="number" name="amount" class="maakapay-form-control form-control " value="<?php echo esc_attr( $amount ); ?>" placeholder="<?php echo get_woocommerce_currency_symbol( $currency ); ?>100"
                               required min="0.01" step="0.01">
                    </div>
                </div>

            </div>

            <div class="maakapay-form-group form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check-inline">
                            <div id="transaction-error"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="maakapay-form-group form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check-inline">
                            <?php if (get_option('maakapay_mode') == "test") : ?>
                                <span class="info">This is form is currently in test mode.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 text-right">
                    <button type="submit" class="btn btn-success form-control pay-now" style="
                position: initial; margin-bottom:10px;">PAY NOW
                    </button>
                </div>
            </div>
    </div>

    </form>
    </div>

<?php
get_footer();