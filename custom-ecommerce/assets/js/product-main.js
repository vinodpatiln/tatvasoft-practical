jQuery(function($){
	

	$('.addto-cart-btn').on('click',function(){
		var $this = $(this);
		
		$.ajax({
			url:ec_ajax_object.ajaxurl,
			data:{
				product_id:$this.data('pid'),
				action:'add_to_cart'
			},
			type:'post', 
			beforeSend:function(xhr){
				$this.text('Processing...'); 
			},
			success:function(data){
				//console.log(data);
				$this.text('Added'); 
				//$('#movie-list').html(data);
			}
		});
		
	});

	$('.update-cart-btn').on('click',function(){
		var $this = $(this);
		
		var prod_array=[];
		$( ".cart-table .quantity-field" ).each(function() {
		 
		  var data_array={};
		  data_array['product_id']=$( this ).attr('prod-id');
		  data_array['qty']= $( this ).val();
		  prod_array.push(data_array);
		});
		
		var jsonString = JSON.stringify(prod_array);
		$.ajax({
			url:ec_ajax_object.ajaxurl,
			data:{
				product_data:jsonString,
				action:'update_to_cart'
			},
			type:'post', 
			beforeSend:function(xhr){
				$this.text('Processing...'); 
			},
			success:function(result){
				var data = jQuery.parseJSON(result);
				console.log(data);
				jQuery('.cart-table tbody').html(data.html);
				jQuery('.total-tbl .subtotal').html(data.total);
				jQuery('.total-tbl .total').html(data.total);
				alert('Cart updated');
				
			}
		});
		
	});

	
});

function checkValue(sender) {
	var value = parseInt(sender.value);
	var total_qty = parseInt(sender.getAttribute("total_qty"));
  if (value > total_qty) {
     alert('Please enter quantity less then '+total_qty);
  }
}