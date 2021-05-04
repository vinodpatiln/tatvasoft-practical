<?php
    
    /*create shortcode for display movies*/
if ( ! function_exists('product_shortcode') ) {

    function product_shortcode() {
         $product_html='';
        $product_html   .= '<div class="container cart-listing"><div class="row">';
        $args   =   array(
                    'post_type'         =>  'e-product',
                    'post_status'       =>  'publish',
                    'order' => 'ASC',
                    'posts_per_page' => -1,
                    );
                    
        $postslist = new WP_Query( $args );
        global $post;
       
        if ( $postslist->have_posts() ) :
       
        
            while ( $postslist->have_posts() ) : $postslist->the_post();         
                $product_html .= '<div class="col-md-4">';
                    $product_html .= '<a href="'. get_permalink() .'">';
                    if(has_post_thumbnail()){
                        
                        $product_html.='<img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'">';
                    }else{
                        
                        $product_html.='<img src="'.plugin_dir_url( dirname( __FILE__ ) ).'assets/images/movie-placeholder.png">';
                    }
                
                    
                    $product_html.='</a><h3><a href="'. get_permalink() .'">'. get_the_title() .'</h3></a>';
                    $productprice = get_post_meta( get_the_ID(),'product-price',true);
                        
                    if(!empty($productprice)){ 
                      $product_html.='<strong>Price: '.$productprice.'</strong><br/>';
                    }


                    $productquantity = get_post_meta( get_the_ID(),'product-quantity',true);
                        
                    /*if(!empty($productquantity)){ 
                      $product_html.='<strong>Quantity: '.$productquantity.'</strong><br/>';
                    }*/
                    /*$terms = get_the_terms($post->ID, 'product-cat');
                    if(!empty($terms));
                    foreach($terms as $term){
                        $product_html.='<strong>Genres: '. $term->name. '</strong><br/>';
                    }*/ 

                    //$product_html.=wp_trim_words( get_the_content(), 20, '...' );
                    
                    $product_html.='<a href="javascript:void(0);" class="button addto-cart-btn" data-pid="'.get_the_ID().'">'.__('Add to cart','ecommerce').'</a>';    
                    $product_html.='</div>';            
            endwhile;
            wp_reset_postdata();
        else:

           $product_html  .= '<p>'.__('Product not fount.','ecommerce').'</p>';
                   
        endif;    
         $product_html  .= '</div></div>';    
        return $product_html;

    }
    add_shortcode( 'product_list', 'product_shortcode' );    
}
?>