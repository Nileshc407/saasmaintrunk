<?php 
// $this->load->view('header/header');
?>
<script
  src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
// alert("----in---testview ");
var Total=0;
// console.log(localStorage.cart);

if( localStorage.cart != null || localStorage.cart != undefined){
	

		cart = JSON.parse(localStorage.cart);
		console.log(cart);


		var Total_balance=<?php echo $Total_balance; ?>;
		// console.log(Total_balance);
		for (var i in cart) {

			Total  = Total + (cart[i].Qty * cart[i].Price);
		}
		// console.log(Total);

		var deleteID=1;
		for (var i in cart) {
			
			var item = cart[i];
			
			/* console.log("----Product------"+item.Product);
			console.log("----Qty------"+item.Qty);
			console.log("----Price------"+item.Price);
			console.log("----item_code------"+item.item_code);
			console.log("----item_id------"+item.item_id);
			console.log("----Checked_Delivery_method------"+item.Checked_Delivery_method);
			console.log("----partner_branch------"+item.partner_branch);
			console.log("----Size------"+item.Size);
			console.log("----Item_image1------"+item.Item_image1);
			console.log("----Item_Weight------"+item.Item_Weight);
			console.log("----Weight_unit_id------"+item.Weight_unit_id); */
			// alert("---i---"+i);
			// alert("---deleteID---"+deleteID);
			
			$.ajax({
						type: "POST",
						async:false,
						data: { Product: item.Product,Points: item.Price, Qty: item.Qty,Company_merchandize_item_code:item.item_code,item_id:item.item_id,Delivery_method:item.Checked_Delivery_method,location:item.partner_branch,Size:item.Size,Item_image1:item.Item_image1,Item_Weight:item.Item_Weight,Weight_unit_id:item.Weight_unit_id,Total_balance:Total_balance,Current_redeem_points:Total},
						url: "<?php echo base_url()?>index.php/Redemption_Catalogue/add_to_cart",
						success: function(data)
						{	
							// console.log(data.cart_success_flag);
							if(data.cart_success_flag==1)
							{  					
								
							}else{
								
							}						 

						}
					});
			
		}
		 

		
	}
	localStorage.clear();	
	window.location.href="<?php echo base_url();?>index.php/Redemption_Catalogue";
</script>
<?php 
// $this->load->view('header/footer');
?>