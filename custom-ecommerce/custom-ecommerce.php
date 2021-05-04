<?php
/*
Plugin Name: Custom Ecommerce
Description: Create custom ecommerce functionality.
Version: 1.0
Author: Vinod Patil
*/
?>

<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}
if (!session_id()) {
    session_start();
}


// Define Constant
define( 'E_VERSION', '1.0' );
define( 'E_FILE', __FILE__ );
define( 'E_PATH', plugin_dir_path( __FILE__ ) );


// Include library files
include_once( E_PATH . 'includes/enquie-style-js.php' );
include_once( E_PATH . 'includes/product-post-type.php' );
include_once( E_PATH . 'includes/product-listing-shortcode.php' );
include_once( E_PATH . 'includes/cart-shortcode.php' );
include_once( E_PATH . 'includes/add-cart-ajax.php' );

add_action( 'plugins_loaded', 'my_plugin_override' );
 
function my_plugin_override() {
    if( !session_id() )
        session_start();
}

