<?php
    
    /*create shortcode for display movies*/
if ( ! function_exists('cart_shortcode') ) {

    function cart_shortcode() {
        $product_html='';
        $product_html   .= '<div class="container cart-listing"><div class="row">';
        if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items'])){

        
            
            $total=0;
            $product_html.='<table class="cart-table">
                
                <tr>
                <th></th>
                <th></th>
                <th>'.__('Product Name','ecommerce').'</th>
                <th>'.__('Price','ecommerce').'</th>
                <th>'.__('Quantity','ecommerce').'</th>
                <th>'.__('Total','ecommerce').'</th>
                </tr>';
                
            foreach ($_SESSION['cart_items'] as $value) {

                    $product_id=$value['product_id'];
                    $qty=$value['qty'];
                    $product_html .= '<tr>';
                    $product_html .= '<td><button type="button" class="close" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button></td>';
                  
                    if(has_post_thumbnail($product_id)){
                        $product_html .= '<td>';
                        $product_html .= '<a href="'. get_permalink($product_id) .'">';
                        $product_html.='<img src="'.get_the_post_thumbnail_url($product_id,'thumbnail').'">';
                    }else{
                        
                        $product_html.='<img src="'.plugin_dir_url( dirname( __FILE__ ) ).'assets/images/movie-placeholder.png"></a>';
                        $product_html .= '</td>';
                    }
                    
                    $product_html .= '<td>';
                    $product_html.='<h3><a href="'. get_permalink($product_id) .'" class="product-title">'. get_the_title($product_id) .'</h3></a>';
                    $product_html .= '</td>';
                    $product_html .= '<td>';
                    $productprice = get_post_meta( $product_id,'product-price',true);
                    if(!empty($productprice)){ 
                      $product_html.=$productprice;
                    }
                    $product_html .= '</td>';    
                    
                    $product_html .= '<td>';
                         $productquantity = get_post_meta($product_id,'product-quantity',true);
                         $product_html .= '<input type="number" class="quantity-field" name="quantity" value="'.$qty.'" total_qty="'.$productquantity.'" prod-id="'.$product_id.'" onblur="checkValue(this)">';
                    
                    $product_html .= '</td>';

                    $product_html .= '<td>';
                        $product_html .= $qty*$productprice;
                    $product_html .= '</td>';
                     
                    $product_html.='</tr>';    
                    $total+=$qty*$productprice;        
           
            }
            $product_html.='<tr>
            <td colspan="6"><a href="javascript:void(0);" class="button update-cart-btn">'.__('Update cart','ecommerce').'</a></td>
            </tr>';
           $product_html.='</table>';

           $product_html.='<h3>'.__('Cart Total','ecommerce').'</h3>';
           $product_html.='<table class="total-tbl">
                <tr>
               
                <td >'.__('Subtotal','ecommerce').'</td>
                <td class="subtotal">'.$total.'</td>
                </tr>
                <td>'.__('Total','ecommerce').'</td>
                <td  class="total">'.$total.'</td>
                </tr>';
            $product_html.='</table>';       
        } else{
           $product_html  .= '<p>'.__('Your cart is empty.','ecommerce').'</p>';
        }  
        $product_html  .= '</div></div>';   
        return $product_html;
    }
    add_shortcode( 'product_cart', 'cart_shortcode' );    
}
?>