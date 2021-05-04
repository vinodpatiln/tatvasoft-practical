<?php
add_action( 'init', 'create_product_posttype' );
 function create_product_posttype() {
		$labels = array(
			'name'                => __( 'Product', 'ecommerce' ),
			'singular_name'       => __( 'Product', 'ecommerce' ),
			'add_new'             => _x( 'Add New Product', 'ecommerce', 'ecommerce' ),
			'add_new_item'        => __( 'Add New Product', 'ecommerce' ),
			'edit_item'           => __( 'Edit Product', 'ecommerce' ),
			'new_item'            => __( 'New Product', 'ecommerce' ),
			'view_item'           => __( 'View Product', 'ecommerce' ),
			'search_items'        => __( 'Search Products', 'ecommerce' ),
			'not_found'           => __( 'No Products found', 'ecommerce' ),
			'not_found_in_trash'  => __( 'No Products found in Trash', 'ecommerce' ),
			'parent_item_colon'   => __( 'Parent Product:', 'ecommerce' ),
			'menu_name'           => __( 'Products', 'ecommerce' ),
		);
		$args = array(
			'labels'                   => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-products',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title', 'editor', 'thumbnail',
				)
		);
		register_post_type( 'e-product', $args );

		$labels = array(
		    'name' => _x( 'Product Category', 'taxonomy general name' ),
		    'singular_name' => _x( 'Product Category', 'taxonomy singular name' ),
		    'search_items' =>  __( 'Search Product Category' ),
		    'all_items' => __( 'All Product Category' ),
		    'parent_item' => __( 'Parent Product Category' ),
		    'parent_item_colon' => __( 'Parent Product Category:' ),
		    'edit_item' => __( 'Edit Product Category' ), 
		    'update_item' => __( 'Update Product Category' ),
		    'add_new_item' => __( 'Add New Product Category' ),
		    'new_item_name' => __( 'New Product Category Name' ),
		    'menu_name' => __( 'Product Category' ),
		  );    
		 
		// Now register the taxonomy
		  register_taxonomy('product-cat',array('e-product'), array(
		    'hierarchical' => true,
		    'labels' => $labels,
		    'show_ui' => true,
		    'show_in_rest' => true,
		    'show_admin_column' => true,
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'product-cat' ),
		  ));
}

// Add movie meta functions here
function product_meta() {
  add_meta_box( 'product_meta', __( 'Product Details ', 'buddyboss' ), 'product_meta_callback', array('e-product'), 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'product_meta' );

function product_meta_callback(){
  global $post;
  $productprice = get_post_meta( $post->ID,'product-price',true);
  $p_price='';
  if(!empty($productprice)){ 
  	$p_price=$productprice;
  }

  $productquantity = get_post_meta( $post->ID,'product-quantity',true);
  $p_qty='';
  if(!empty($productquantity)){ 
  	$p_qty=$productquantity;
  }
  
  
  ?>
  <label><?php _e('Product Price','ecommerce');?></label>
  <input type="text" name="product-price" value="<?php echo $p_price; ?>" />
  <label><?php _e('Product Quantity','ecommerce');?></label>
  <input type="text" name="product-quantity" value="<?php echo $p_qty; ?>" />
  <?php
}

function product_meta_save( $post_id ) {
 
  // Checks for input and saves - save checked as yes and unchecked at no
  
  if( isset( $_POST[ 'product-price' ] ) ) {
    update_post_meta( $post_id, 'product-price', $_POST['product-price'] );
  }else{
    delete_post_meta($post_id,'product-price');
  } 

  if( isset( $_POST[ 'product-quantity' ] ) ) {
    update_post_meta( $post_id, 'product-quantity', $_POST['product-quantity'] );
  }else{
    delete_post_meta($post_id,'product-quantity');
  } 

}
add_action( 'save_post', 'product_meta_save' );
?>