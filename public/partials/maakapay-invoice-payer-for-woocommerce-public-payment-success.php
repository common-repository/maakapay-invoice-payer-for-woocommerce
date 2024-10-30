<?php

/**
 * Provide a public invoice success status view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/public/partials
 */


get_header(); ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            margin: 0 auto;
            font-family: sans-serif;
        }
        p{
            margin: 0px;
            margin-bottom: 30px;
            color: #707070;
            line-height: 1.5;
        }
        .btn{
            display: inline-block;
        }
        .wrap{
            text-align: center;
            width: 80%;
            margin:0 auto;
            padding: 80px 40px;
        }
        .icon {
            height: 100px;
            width: 100px;
            margin: 0 auto;
            margin-bottom: 30px;
        }
        .icon .success{
            fill: none;
            stroke: #4caf50;
            height: 100%;
            width: 100%;
        }
        p.response {
            font-size: 60px;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            transition: .4s;
        }
        .btn-success {
            background: #4caf50;
            color: #fff;
            margin-bottom: 30px;
            padding: 15px 35px;
            box-shadow: 2px 2px 12px rgba(0,0,0,0.3);
            text-transform: uppercase;
        }
        .btn-success:hover{
            background: #348f38;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }
        .btn-error {
            background: #e50000;
            color: #fff;
            margin-bottom: 30px;
            padding: 15px 35px;
            box-shadow: 2px 2px 12px rgba(0,0,0,0.3);
            text-transform: uppercase;
        }
        .btn-error:hover{
            background: #b40303;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }
        .btn-warn {
            background: #e58900;
            color: #fff;
            margin-bottom: 30px;
            padding: 15px 35px;
            box-shadow: 2px 2px 12px rgba(0,0,0,0.3);
            text-transform: uppercase;
        }
        .btn-warn:hover{
            background: #d17d00;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }

        .btn-back{
            color: #707070;
        }
        .btn-back:hover{
            color: #000;
        }
        .btn-back span{
            margin-right: 5px;
        }
        /*media queries*/
        @media(max-width: 768px){
            .icon{
                height: 70px;
                width: 70px;
            }
            p.response{
                font-size: 42px;
            }
        }
        @media(max-width: 475px){
            p{
                margin-bottom: 20px;
            }
            .icon{
                height: 50px;
                margin-bottom: 20px;
            }
            p.response{
                font-size: 36px;
                margin-bottom: 20px;
            }
            .btn-success{
                padding: 12px 25px;
                font-size: 13px;
                margin-bottom: 20px;
            }

        }
    </style>


    <!-- success template -->

<?php if(isset($_GET['transaction_code']) && ! empty (sanitize_text_field( $_GET['transaction_code'] ) )) :?>

    <?php $transaction_code = explode("?", esc_attr( $_GET['transaction_code']) ) ?>

    <section class="wrap">
        <div class="icon">
            <svg height="24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg" class="success"><path d="M22 11.07V12a10 10 0 1 1-5.93-9.14"/><polyline points="23 3 12 14 9 11"/></svg>
        </div>
        <div class="msg">
            <p class="response">Thank You !</p>
            <p class="desc">Thank you paying your invoice. Our System admin will soon contact you.</p>
            <p class="desc">You Transaction code is: <?php echo esc_attr( $transaction_code[0] ); ?></p>
            <p class="desc"><strong>Please save the transaction code so that if any payment related dispute arrives we can verify it later.</strong></p>
        </div>
        <div class="btn-sec">
            <a href="<?php echo get_site_url() ?>" class="btn btn-back"><span>&larr;</span>Back to home</a>
        </div>
    </section>

<?php endif; ?>

<?php get_footer(); ?>