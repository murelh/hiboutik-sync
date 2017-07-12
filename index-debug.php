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
 /*
	This file is a debug version of the original index file. It will not update your stock.
	For safety purposes, you should delete it once you are ready to publish your website
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
        
		$hiboutikOrderId = 0; // Type a correct value here
		
        $orderDetail = $hiboutik->getOrderById($hiboutikOrderId); // To get Order object from Hiboutik wich will give us all item id inside.
        var_dump($orderDetail); // Displaying order data
    }
}