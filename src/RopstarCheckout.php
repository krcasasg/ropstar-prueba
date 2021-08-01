<?php

class RopsartCheckout
{
    /**
     * constructor
     */
    public function __construct() {
        
    }

    public static function beforeCheckout()
    {
        global $product;
        global $woocommerce;
        var_dump($woocommerce->session);
    }
}