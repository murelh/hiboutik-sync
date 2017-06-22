<?php
/* HiboutikSync Configuration  */

$config = array(
    /* Start WooCommerce configuration */
    'woocommerce' => array(
        // Your Store URL, example: http://woo.dev/
        'url' => 'http://www.example.com',
        // Your API consumer key
        'consumer_key' => 'ck_x...',
        // Your API consumer secret
        'consumer_secret' => 'cs_x...',
    ),
    /* End WooCommerce configuration */
    
    /* Start Hiboutik configuration */
    'hiboutik' => array(
        /* Hiboutik account. E.G. "bestwear" from "bestwear.hiboutik.com" */
        'account' => 'example',
        /* User email */
        'user' => 'user@mail.com',
        /* API Key related to the user */
        'key' => 'your api key here'
    )
    /* End Hiboutik configuration */
);