<?php 

add_action( 'wp_enqueue_scripts', 'product_enqueue' );
function product_enqueue(){
	wp_enqueue_script("jquery");
	wp_register_style('product-bootstrap-min', plugins_url('/assets/css/bootstrap.min.css',dirname( __FILE__ ) ));
	wp_enqueue_style('product-bootstrap-min');
	wp_register_style('product-custom-css', plugins_url('/assets/css/custom.css',dirname( __FILE__ ) ));
    wp_enqueue_style('product-custom-css');
	wp_enqueue_script( 'bootstrap-js', plugins_url('/assets/js/bootstrap.min.js',dirname( __FILE__ ) ), '', E_VERSION );
	wp_enqueue_script( 'product-main-js', plugins_url('/assets/js/product-main.js',dirname( __FILE__ ) ),array('jquery'), '',true);
	  
	  wp_localize_script('product-main-js','ec_ajax_object',
	    array(
	      'ajaxurl' => admin_url( 'admin-ajax.php' ),
	    )
	  );
	
}
?>