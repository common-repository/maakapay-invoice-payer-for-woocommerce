<?php

/**
 * Provide a public invoice decline status view for the plugin
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

<meta charset="UTF-8">
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
    #icon-61-warning{
        fill:#e58900;
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

    }
</style>


<!-- decline template -->
<?php if(isset($_GET['transaction_code']) && ! empty (sanitize_text_field( $_GET['transaction_code'] ) )) :?>

    <?php $transaction_code = explode("?", esc_attr( $_GET['transaction_code']) ) ?>

    <section class="wrap">
        <div class="icon">
            <svg  version="1.1" viewBox="0 0 32 32" class="warning" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="#157EFB" id="icon-61-warning"><path d="M15.4242327,5.14839275 C16.2942987,3.74072976 17.707028,3.74408442 18.5750205,5.14839275 L29.3601099,22.59738 C30.5216388,24.4765951 29.6755462,26 27.4714068,26 L6.5278464,26 C4.32321557,26 3.47386317,24.4826642 4.63914331,22.59738 L15.4242327,5.14839275 L15.4242327,5.14839275 Z M16.353181,5.5229211 C16.7005152,4.96165163 17.2647678,4.9634187 17.6110318,5.52292108 L28.6162937,23.3055078 C29.1954663,24.2413498 28.7622271,24.9999996 27.6746349,24.9999996 L6.29039231,25 C5.19115596,25 4.76644971,24.2463265 5.34866262,23.3055082 L16.353181,5.5229211 L16.353181,5.5229211 Z M17,11 C16.4477153,11 16,11.4530363 16,11.9970301 L16,18.0029699 C16,18.5536144 16.4438648,19 17,19 C17.5522847,19 18,18.5469637 18,18.0029699 L18,11.9970301 C18,11.4463856 17.5561352,11 17,11 L17,11 Z M17,23 C17.5522848,23 18,22.5522848 18,22 C18,21.4477152 17.5522848,21 17,21 C16.4477152,21 16,21.4477152 16,22 C16,22.5522848 16.4477152,23 17,23 L17,23 Z" id="warning"/></g></g>
            </svg>
        </div>
        <div class="msg">
            <p class="response">Declined !</p>
            <p class="desc">Sorry the payment was declined. Please try again later.</p>
            <p class="desc">You Transaction code is: <?php echo esc_attr( $transaction_code[0] ); ?></p>
            <p class="desc">You might have entered wrong card number, expiry date or CVV code.</p>
            <p class="desc">You might have entered wrong OTP / Verification code.</p>
            <p class="desc">Your card issuing bank declined the card processing. Please ask your bank to enable “Online Transaction” in your card.</p>
            <p class="desc"><strong>Please save the transaction code so that if any payment related dispute arrives we can verify it later.</strong></p>
        </div>
        <div class="btn-sec">
            <a href="<?php echo get_site_url() ?>" class="btn btn-back"><span>&larr;</span>Back to home</a>
        </div>
    </section>

<?php endif; ?>

<?php get_footer(); ?>
