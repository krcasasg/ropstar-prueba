<?php
require ROPSTARBASE . 'src/RopstarAttribute.php';

Class RopstarPrueba
{
    /**
     * Load plugin
     */
    public static function init()
    {
        add_filter('the_content', array('RopstarFront', 'renderMovies'));
        add_action('woocommerce_add_cart_item_data', array('RopsartCheckout', 'beforeCheckout'));
    
    }
    /**
     * Activate plugin
     */
    public static function activate()
    {
        if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            RopstarAttribute::setAttribute();
        }else{
            wp_die('This plugin requires woocommerce installed');
        }
        
    }

    /**
     * Deactivate plugin
     */
    public static function deactivate()
    {
        //echo 'el plugin ha sido desactivado';
        
    }
}