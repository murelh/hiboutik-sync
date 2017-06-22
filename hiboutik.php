<?php

class hiboutik {

    private $account = null;
    private $user = null;
    private $key = null;
    private $endpoint = null;

    function __construct($account, $user, $key) {
        $this->account = $account;
        $this->user = $user;
        $this->key = $key;
        $this->endpoint = 'https://' . $account . '.hiboutik.com/apirest/';
    }

    public function getOrderById($orderId) {
        return $this->doRequest('sales/' . intval($orderId));
    }

    public function getProductById($productId) {
        return $this->doRequest('products/' . intval($productId));
    }

    private function doRequest($action, $data = null) {
        $timeout = 10;
        $curl = curl_init($this->endpoint . $action);

        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        if (preg_match('`^https://`i', $this->endpoint)) {
            /* Comment or not the section bellow following your desire to cancel the HTTPS security. Reminder : Default => true */
//    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        }

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Définition de la méthode d'authentification du serveur 
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        // Définition des identifiants 
        curl_setopt($curl, CURLOPT_USERPWD, $this->user . ':' . $this->key);
        // Définition des données
        if (is_array($data) && count($data) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

}
