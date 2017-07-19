<?php
/*
  Plugin Name: Hiboutik Sync
  Plugin URI: http://murelh.info/blog/hiboutik-sync
  Description: Un plugin permettant de synchroniser les stocks WooCommerce et Hiboutik
  Version: 0.1
  Author: Murelh Ntyandi
  Author URI: http://murelh.info
  License: GPL2
 */
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/hiboutik.php';

use Automattic\WooCommerce\Client;

add_action('parse_request', 'hiboutikSync');

function hiboutikSync($query) {
    if ($query->request === 'hiboutik-woocommerce-sync') {
        /* This page must be call by Hiboutik URL Callback wich will $_POST order data (http://www.logiciel-caisse-gratuit.com/api-rest-hiboutik-url-de-callback/) */
        include(__DIR__ . '/settings.php');
        // Login WooCommerce API
        $woocommerce = new Client($config['woocommerce']['url'], $config['woocommerce']['consumer_key'], $config['woocommerce']['consumer_secret'], ['wp_api' => true, 'version' => 'wc/v1']);
        // Login Hiboutik API
        $hiboutik = new hiboutik($config['hiboutik']['account'], $config['hiboutik']['user'], $config['hiboutik']['key']);
        
        $orderDetail = $hiboutik->getOrderById($_POST['order_id']); // To get Order object from Hiboutik wich will give us all item id inside.
        
        if (is_array($orderDetail)) {
            // Hiboutik order is not empty. We have to retrieve all products objects.
            foreach ($orderDetail[0]->line_items as $item) {
                $theProduct = $hiboutik->getProductById($item->product_id); // To get product object from Hiboutik
                /* Reminder : Hiboutik product and WooCommerce product are linked with barcode (Hiboutik) and SKU (WooCommerce)  */
                $theWcProductId = intval(wc_get_product_id_by_sku($theProduct[0]->product_barcode)); // To get Woocommerce product id from Hiboutik product barcode
                if ($theWcProductId > 0) {
                    // Product barcode was successfully found in WooCommerce database.
                    $theWcProduct = $woocommerce->get('products/' . $theWcProductId); // To get WooCommerce product object
                    $newStockAmount = $theWcProduct['stock_quantity'] - $item->quantity;
                    wc_update_product_stock($theWcProductId, $newStockAmount); // To update Woocommerce Product stock quantity
                }
            }
        } else {
            echo 'La synchronisation n\'a pas pu être efectuée.<br>Données recu par Hiboutik Sync:<br>';
            var_dump($orderDetail); // No sale with the given ID
        }
      exit(); // this will prevent Wordpress to send a 404 error code
    }
}
