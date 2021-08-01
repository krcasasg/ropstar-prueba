<?php
/**
 * Plugin Name: Ropstar prueba
 * Plugin URI: https://desarrollode.com
 * Description: Plugin para prueba de ropstar
 * Version: 1.0.0
 * Author: Raúl Cassas
 * Author URI: http://desarrollode.com/
 * Developer: Raúl Casas
 * Developer URI: http://desarrollode.com/
 * Text Domain: woocommerce-extension
 * Domain Path: /languages
 *
 * Woo: 12345:342928dfsfhsf8429842374wdf4234sfd
 * WC requires at least: 2.2
 * WC tested up to: 2.3
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
define('ROPSTARBASE', plugin_dir_path( __FILE__ ));

require ROPSTARBASE . 'src/RopstarPrueba.php';
require ROPSTARBASE . 'src/MovieDbApi.php';
require ROPSTARBASE . 'src/RopstarFront.php';
require ROPSTARBASE . 'src/RopstarCheckout.php';



if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

register_activation_hook(__FILE__, array('RopstarPrueba', 'activate'));

register_deactivation_hook(__FILE__,  array('RopstarPrueba', 'deactivate'));

add_action( 'woocommerce_loaded', array('RopstarPrueba', 'init'));

add_action('wp_enqueue_scripts', 'ropstar_enqueue_scripts');

function ropstar_enqueue_scripts(){
    if(!is_product()){
        return;
    }
    wp_register_script( 'ropstar_script', ROPSTARBASE . 'scripts/ropstar_script.js',array(), null, true );
    wp_enqueue_script( 'ropstar_script');
    wp_localize_script('ropstar_script', 'ropstar_vars', ['ajaxurl'=>admin_url('admin-ajax.php')]);
}

