<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://maakapay.com
 * @since      1.0.0
 *
 * @package    Maakapay_Invoice_Payer_For_Woocommerce
 * @subpackage Maakapay_Invoice_Payer_For_Woocommerce/admin/partials
 */

require_once ( ABSPATH . 'wp-admin/includes/class-wp-list-table.php');


class MaakapayAdminDisplay extends WP_List_Table {

    public function wp_list_table_data( $orderBy = '', $order = '', $search_term = '' ) {

        global $wpdb;

        $table_name = "{$wpdb->prefix}maakapay_transactions_logs";
        $app_mode = get_option( 'maakapay_mode' );

        if( !empty( $search_term ) ) {

            $transactions = $wpdb->get_results("SELECT * from {$table_name} WHERE transaction_code LIKE '%$search_term%' OR invoice_number LIKE '%$search_term%' OR amount LIKE '%$search_term%' OR status LIKE '%$search_term'");

        } else {

            if( $orderBy == "invoice_number" && $order == "asc" ) {

                $transactions = $wpdb->get_results("SELECT * from {$table_name} ORDER BY invoice_number ASC");

            } elseif( $orderBy == "invoice_number" && $order == "desc" ) {

                $transactions = $wpdb->get_results("SELECT * from {$table_name} ORDER BY invoice_number DESC");

            } elseif( $orderBy == "date" && $order == "asc" ) {

                $transactions = $wpdb->get_results("SELECT * from {$table_name} ORDER BY order_created_at ASC");

            } elseif( $orderBy == "date" && $order == "desc" ) {

                $transactions = $wpdb->get_results("SELECT * from {$table_name} ORDER BY order_created_at DESC");

            } else {

                $transactions = $wpdb->get_results("SELECT * from {$table_name} ORDER BY order_created_at DESC");

            }

        }

        $transaction_array = array();

        if( count( $transactions ) > 0 ) {

            foreach( $transactions as $index => $transaction ) {

                $status = strtoupper( $transaction->status );
                if( $status == "SUCCESS" ) {
                    $status = "<span style=' text-decoration: none;
                    background-color: green;
                    color: white;
                    font-size: 15px;
                    padding: 2px 6px 2px 6px;
                    border-top: 1px solid #CCCCCC;
                    border-right: 1px solid #333333;
                    border-bottom: 1px solid #333333;
                    border-left: 1px solid #CCCCCC;
                    border-radius: 8px;'>Success</span>";
                } elseif( $status == "DECLINE" ) {
                    $status = "<span style=' text-decoration: none;
                    background-color: red;
                    color: white;
                    font-size: 15px;
                    padding: 2px 6px 2px 6px;
                    border-top: 1px solid #CCCCCC;
                    border-right: 1px solid #333333;
                    border-bottom: 1px solid #333333;
                    border-left: 1px solid #CCCCCC;
                    border-radius: 8px;'>Decline</span>";
                } elseif( $status == "CANCEL" ) {
                    $status = "<span style=' text-decoration: none;
                    background-color: orange;
                    color: white;
                    font-size: 15px;
                    padding: 2px 6px 2px 6px;
                    border-top: 1px solid #CCCCCC;
                    border-right: 1px solid #333333;
                    border-bottom: 1px solid #333333;
                    border-left: 1px solid #CCCCCC;
                    border-radius: 8px;'>Cancel</span>";
                } else {
                    $status = "<span style=' text-decoration: none;
                    background-color: white;
                    color: black;
                    font-size: 15px;
                    padding: 2px 6px 2px 6px;
                    border-top: 1px solid #CCCCCC;
                    border-right: 1px solid #333333;
                    border-bottom: 1px solid #333333;
                    border-left: 1px solid #CCCCCC;
                    border-radius: 8px;'>Pending</span>";
                }
                $transaction_array[] = array(
                    "transaction_code" => $transaction->transaction_code,
                    "invoice_number" => $transaction->invoice_number,
                    "amount" => $transaction->amount,
                    "currency" => $transaction->currency,
                    "status" => $status,
                    "date" => $transaction->order_created_at
                );

            }

        }

        return $transaction_array;

    }

    public function prepare_items() {

        $orderBy = isset( $_GET[ 'orderby'] ) ? trim( sanitize_text_field(  $_GET[ 'orderby' ] ) ) : "";

        $order = isset( $_GET[ 'order'] ) ? trim( sanitize_text_field( $_GET[ 'order' ] ) ) : "";

        $search_term = isset( $_POST['s'] ) ? trim( sanitize_text_field( $_POST['s'] ) ) : "";

        $datas = $this->wp_list_table_data( $orderBy, $order, $search_term );

        $per_page = 25;

        $current_page = $this->get_pagenum();

        $total_items = count( $datas );

        $this->set_pagination_args( array(
            "total_items" => $total_items,
            "per_page" => $per_page
        ));

        $this->items = array_slice( $datas, ( ( $current_page - 1 ) * $per_page ), $per_page );

        $columns = $this->get_columns();

        $hidden = $this->get_hidden_columns();

        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable );
    }


    public function get_hidden_columns() {

        return array();

    }

    public function get_sortable_columns() {

        return array(
            "invoice_number" => array("invoice_number", true),
            "date" => array("date", false)
        );

    }

    public function get_columns() {

        $columns = array(
            "invoice_number" => "Invoice Number",
            "transaction_code" => "Transaction Code",
            "currency" => "Currency",
            "amount" => "Amount",
            "status" => "Status",
            "date" => "Transaction Date",
            "action" => "Action"
        );

        return $columns;

    }

    public function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'transaction_code':
            case 'invoice_number':
            case 'currency':
            case 'amount':
            case 'status':
            case 'date':
                return $item[ $column_name ];
            case 'action':
                return '<a href="?page=' . esc_attr( $_GET[ 'page' ] ) . '&action=maakapay-view&transaction_code=' . esc_attr( $item[ 'transaction_code' ] ) . '"><button class="button button-primary">View</button></a>';
            default:
                return "No Transaction Data was found";

        }

    }

}


function maakapay_table_layout() {

    $table = new MaakapayAdminDisplay();

    // Prepair the table for display.
    $table->prepare_items();

    echo "<h1>Maakapay Transaction Listing page</h1>";

    echo "<br><b>View all of your transaction's status in once place done using Maakapay Invoice Payer- Woocommerce</b>";

    echo "<form method='post' name='transaction_search_form' action='" . esc_attr( $_SERVER['PHP_SELF'] ) . "?page=maakapay-dashboard'>";

    $table->search_box("Search Transaction(s)", "search_transaction_code");

    echo "</form>";

    $table->display();

}

maakapay_table_layout();
