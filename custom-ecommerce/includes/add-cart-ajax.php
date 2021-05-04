<?php 
add_action("wp_ajax_add_to_cart", "add_to_cart");
add_action("wp_ajax_nopriv_add_to_cart", "add_to_cart");

function add_to_cart() {

	$product_id=$_POST["product_id"];
	$product_data   = get_post( $product_id );
	$cart_array=array();
	//$_SESSION['cart_items']='';
	if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items']) ) {
		
		$cart_array=$_SESSION['cart_items'];
		
		if(!array_search($product_id, array_column($cart_array, 'product_id'))){
			
			$data=array('product_id'=>$product_id, 'qty'=>1 );
			$cart_array[]=$data;
			
			$_SESSION['cart_items']=$cart_array;
		}
		
		
		
	}else{
		
		$data=array('product_id'=>$product_id, 'qty'=>1 );
		$cart_array[]=$data;
		
		$_SESSION['cart_items'] = $cart_array;
	}
   
	die();
}

add_action("wp_ajax_update_to_cart", "update_to_cart");
add_action("wp_ajax_nopriv_update_to_cart", "update_to_cart");

function update_to_cart() {

	$product_data = json_decode(stripslashes($_POST['product_data']), true);
	//$cart_data=json_decode($product_data);
	//print_r($product_data);
	$_SESSION['cart_items']=$product_data;
	$total=0;
	$product_html='';
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
            <td colspan="6"><a href="javascript:void(0);" class="button update-cart-btn" data-pid="'.get_the_ID().'">'.__('Update cart','ecommerce').'</a></td>
            </tr>';  

    echo json_encode(array('html'=>$product_html,'total'=>$total));
	
   
	die();
}
?>