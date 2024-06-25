<?php 
	
	$this->load->view('front/header/header'); 
	$session_data = $this->session->userdata('cust_logged_in');
	$data['Walking_customer'] = $session_data['Walking_customer'];
	// echo"--Walking_customer---".$data['Walking_customer']."--<br>"; 
		$cart_check = $this->cart->contents();
			// var_dump($cart_check);
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				$grand_total = 0; 
				$item_count = COUNT($cart); 
			}
		
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			$item_count = $item_count;
		}				
		
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {
			
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			
			foreach ($wishlist as $item2) {
				
				$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		}		
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}
		
		/*   */
?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/cart-bg.jpg')">
	<div id="wrapper">
	
		
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url(); ?>index.php/Shopping"></a>
					</div>
					<h2>My Cart</h2>
				</div>
			</div>
		</div>
		<div class="custom-body transparent">
			<?php  if($Enroll_details->Current_address != "" && $Enroll_details->City != ""  && $Enroll_details->Country != ""  ) { ?>	<!-- 1 card -->
			<?php if(!empty($cart_check)) { ?>	<!-- 1 card -->
			<div class="my-cart">
			<?php echo form_open_multipart('Shopping/update_cart'); ?>
				<?php 
					// var_dump($cart);
						foreach ($cart as $item) { 
					
						$Product_details = $this->Shopping_model->get_products_details($item['id']);
						$Partner_state=$item["options"]["Partner_state"];
						$Partner_Country_id=$item["options"]["Partner_Country_id"];
						if($item["options"]["Redemption_method"]==29)
						{
							$Exist_Delivery_method=1;
							$Weight_in_KG=0;
							$Weight=0;
							foreach($cart as $rec) 
							{
								 // echo '<br>if('.$rec["options"]["Partner_state"].'=='.$Partner_state.')';
								
								if(($rec["options"]["Partner_state"]==$Partner_state) && ($rec["options"]["Redemption_method"]==29))
								{
									
									 //echo "<br><br><b>Item Weight </b>".$rec["options"]["Item_Weight"]."<b>  Quantity </b>".$rec["qty"]."<b>  Weight_unit_id </b>".$rec["options"]["Weight_unit_id"];
									// $Total_weight_same_location=$Weight+($rec["options"]["Item_Weight"]*$item["qty"]);
									
									$Total_weight_same_location=($rec["options"]["Item_Weight"]*$rec["qty"]);
									
									// echo "<br><br><b>Total_weight_same_location </b>".$Total_weight_same_location;
									
									$lv_Weight_unit_id=$rec["options"]["Weight_unit_id"];
									$kg=1;
									switch ($lv_Weight_unit_id)
									{
										case 2://gram
										$kg=0.001;break;
										case 3://pound
										$kg=0.45359237;break;
									}
									// $Total_weight_same_location=array_sum($Total_weight_same_location);
									$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
									  // echo "<br><br><b>Total_weight_same_location </b>".$Total_weight_same_location."<b>  Weight_unit_id </b>".$lv_Weight_unit_id."<b>  Weight_in_KG </b>".$Weight_in_KG;
									  // $Weight=$Total_weight_same_location;
									  // $Weight=$Weight_in_KG;
								}
								
								
							}
							
							/*******Single Weight convert into KG****/

							$kg2=1;
							switch ($item["options"]["Weight_unit_id"])
							{
								case 2://gram
								$kg2=0.001;break;
								case 3://pound
								$kg2=0.45359237;break;
							}
							
							/**************************/
							
							
							$Single_Item_Weight_in_KG=($item["options"]["Item_Weight"]*$item["qty"]*$kg2);
							
							  // echo "<br><b>Merchandize_item_name </b>".$Product_details->Merchandize_item_name." <br><b>Item_Weight </b>".$item["options"]["Item_Weight"]." <br><b>Single_Item_Weight_in_KG </b>".$Single_Item_Weight_in_KG." Quantity </b>".$item["qty"]." <br><b>Weight_unit_id </b>".$item["options"]["Weight_unit_id"]." <br><b>Same State Weight_in_KG </b>".$Weight_in_KG." <br><b>Partner_state</b> ".$Partner_state;
						}
						else
						{
							$Total_Weighted_avg_shipping_cost[]=0;
							$Weighted_avg_shipping_cost="-";
						}
						if($Shipping_charges_flag==2)//Delivery_price
						{
							if($item["options"]["Redemption_method"]==29)
							{
								$Get_shipping_cost = $this->Igain_model->Get_delivery_price_master($Partner_Country_id,$Partner_state,$To_Country,$To_State,$Weight_in_KG,1);
								$Shipping_cost= $Get_shipping_cost->Delivery_price;
								 $Weighted_avg_shipping_cost=(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
								$Weighted_avg_shipping_cost=number_format((float)$Weighted_avg_shipping_cost, 2);
								$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
							 // echo "<br><b>Shipping_cost </b>".$Shipping_cost;
							}
						}
						elseif($Shipping_charges_flag==1)//Standard Charges
						{
							if($item["options"]["Redemption_method"]==29)
							{
								$Cost_Threshold_Limit2=round($Cost_Threshold_Limit);
								if($item['subtotal'] >= $Cost_Threshold_Limit2)
								{	
									$Shipping_cost=round($Standard_charges);
									$Weighted_avg_shipping_cost=round(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
									$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
								}
								else
								{
									$Shipping_cost=0;
									$Weighted_avg_shipping_cost=0;
									$Total_Weighted_avg_shipping_cost[]=0;
								}
								// echo "<br><b>Standard_charges </b>".$Standard_charges;
							}
						}
						else
						{
							$Shipping_cost=0;
							$Weighted_avg_shipping_cost=0;
							$Total_Weighted_avg_shipping_cost[]=0;
						}
						
						if($item['options']['Item_size'] == 1)
						{
						  $size = "Small";
						}
						elseif($item['options']['Item_size'] == 2)
						{	
							$size = "Medium";
						}
						elseif($item['options']['Item_size'] == 3)
						{
							$size = "Large";
						}
						elseif($item['options']['Item_size'] == 4)
						{
							$size = "Extra Large";
						}
						else
						{
							$size = "-";
						}
						// echo $size;
						
						// echo"--id--".$item['id']."---qty--".$item['qty']."<br>";
					?>
					
					<?php	
						if($Product_details->Combo_meal_flag ==1 ) {
				
						$MerchandizeIteName = explode('+', $Product_details->Merchandize_item_name);
						$itemName= $MerchandizeIteName[0];
						} else {
						
						$itemName= $Product_details->Merchandize_item_name;
						}
					?>
					
					<div class="menu-box">
						<a href="JavaScript:void(0);" class="close" onclick="delete_item('<?php echo $item['rowid']; ?>','<?php echo $Product_details->Merchandize_item_name; ?>')" >
							<img src="<?php echo base_url(); ?>assets/img/close-dark.png">
						</a>
						<!--<div class="img">
							<img src="<?php //echo $Product_details->Thumbnail_image1; ?>" alt="" />
						</div>-->
						<div class="dtc">
							<h2><?php echo substr($itemName, 0, 20)."...";?></h2>
							<p><?php 
									if($item["options"]["remark2"]) {
										// echo $item["options"]["remark2"];
										echo "+".$item["options"]["remark2"];
									}
								?>
							</p>
							<p><?php 
									if($item["Main_item"] != NULL)
									{
										foreach($item["Main_item"] as $b3){
											if($b3["Merchandize_item_name"] != NULL)
											{
												echo "+".$b3["Merchandize_item_name"];
											}
										}
									}
								?> 		
							</p>
							<?php $grand_total = $grand_total + $item['subtotal']; ?>
							<div class="clr-green">
								<b><?php echo $Symbol_of_currency." ".number_format((float)$item['subtotal'], 2);
								?></b>
							</div>
							<div class="clr-green">
							
								<b><?php if($item['MainItem_TotalPrice'] != "" && $item['SideCondiments_TotalPrice'] != "") { ?>
									<strong id="Value_font" style="float: right;" ><?php
										 echo $Symbol_of_currency.' '.number_format( ($item['MainItem_TotalPrice'] + $item['SideCondiments_TotalPrice']) * $item['qty'], 2);
										?>
									</strong>
									<?php  } ?>
								</b>
							</div>
						</div>
						<div class="kes_wrap align-self-end">
							<div id="input_div" class="prodinput">
							<!------onclick="minus3()"-----onclick="plus3()"---->
								<input class="minus" type="button" value="-"  onclick="Update_item_cart('<?php echo $item['rowid']; ?>','<?php echo $item['id']; ?>',0);"  id="Best_decr">
								<input class="productqty" type="text" size="25" value="<?php echo $item['qty']; ?>" id="qty_<?php echo $item['id']; ?>"  name="cart[<?php echo $item['id']; ?>][qty]" readonly>
								<!-----id="count3"----->
								<input class="plus" type="button" value="+" id="Best_incr" onclick="Update_item_cart('<?php echo $item['rowid']; ?>','<?php echo $item['id']; ?>',1);" >
							</div>
						</div>
					</div>
				<?php }
				$_SESSION['Sub_total']=number_format((float)$grand_total, 2);
				$_SESSION['Grand_total']=($grand_total);
				?>
					
				<?php echo form_close();  ?>
				<div class="checkout-total">Total: <span class="float-right"><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo  number_format($_SESSION['Grand_total'],2); ?></span>
				</div>
				<div class="checkout-btn-wrap d-flex">
					<button type="button" class="btn btn-light bordered mr-3" name="submit" onclick="window.location.href='<?php echo base_url(); ?>index.php/Shopping'" >Add Items</button>
					<button type="button" class="btn btn-light" name="submit" onclick="return Chekout();">Proceed</button>
				</div>
				<br>
			</div>
			
			<?php } else { 
			
				$_SESSION['delivery_type']=""; 
				$_SESSION['delivery_outlet']="";
				$_SESSION['Address_type']="";
				$_SESSION['TableNo']="";
			?>
									
						<h4 class="text-white text-center">Your cart is empty.</h4>
						<br>
						<div class="checkout-btn-wrap d-flex">
							<button type="button" class="btn btn-light bordered m-3" name="submit" onclick="window.location.href='<?php echo base_url(); ?>index.php/Shopping'" >Add Items</button>
							
						</div>
				
			<?php } ?>
			
			
			<?php } else { 
		
			$_SESSION['delivery_type']=""; 
			$_SESSION['delivery_outlet']="";
			$_SESSION['Address_type']="";
			$_SESSION['TableNo']="";
		?>
								
					<h4 class="text-white text-center">Please update your primary address in profile.</h4>
					<br>
					<div class="checkout-btn-wrap d-flex">
						<button type="button" class="btn btn-light bordered m-3" name="submit" onclick="window.location.href='<?php echo base_url(); ?>index.php/Cust_home/myprofile'" >Profile</button>
						
					</div>
			
		<?php } ?>
	</div>
		
	<?php $this->load->view('front/header/footer');  ?>
	
	<link rel="stylesheet" type="text/css"  href="<?php echo base_url();?>assets/alert_css/jquery-confirm.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>assets/alert_css/jquery-confirm.js"></script>
	
	<?php foreach ($cart as $item) { 
$item['id']; ?>
<script>
$(".<?php echo $item['id']; ?>").click(function(){
	
		setTimeout(function() 
		{
			$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');	
		},2000);
	
	if ($(this).hasClass('incr'))
        $("#qty_<?php echo $item['id']; ?>").val(parseInt($("#qty_<?php echo $item['id']; ?>").val())+1);
	
    else if ($("#qty_<?php echo $item['id']; ?>").val()>1)
        $("#qty_<?php echo $item['id']; ?>").val(parseInt($("#qty_<?php echo $item['id']; ?>").val())-1);
	
	
	var new_val=( $('#qty_<?php echo $item['id']; ?>').val()* 40);
	if(new_val > 2000)
	{
		// $("#Best_incr").css('display','none');
		return false;
	}
	else
	{
		// $("#Best_incr").css('display','');
		$("#best_equi").html(new_val);
	}
});


function Update_item_cart(RowId,id,type)
{
		setTimeout(function() 
		{
			$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');	
		},2000);
	// console.log(RowId);
    var Quantity = $('#qty_'+id).val();
	// alert(type);
	if(type==0)
	{
		Quantity=parseInt(Quantity) - 1;
	}
	else if(type==1)
	{
		Quantity=parseInt(Quantity) + 1;
	}
	
	// Quantity=parseInt(Quantity) + 1;
	// console.log(Quantity);
    var Symbol_of_currency = '<?php echo $Symbol_of_currency; ?>';
    // alert(Symbol_of_currency);
    $.ajax(
    {
        type: "POST",
        data: { Quantity:Quantity, RowId:RowId },
        url: "<?php echo base_url()?>index.php/Shopping/Update_item_quantity",
        success: function(data)
        {
			
			// alert(data.Error_flag);
			// location.reload(); 
			// console.log(data.Error_flag);
            if(data.Error_flag == 0)
            {
               /* $('#Item_unitprice_'+RowId).html('<b>' + Symbol_of_currency +'</b> ' + data.Item_unitprice);
                $('#Item_subtotal_'+RowId).html('<b>' + Symbol_of_currency +'</b> ' + data.Item_subtotal);
                $('#Cart_grandTotal').html('<b>' + Symbol_of_currency +'</b> ' + data.grand_total);
                */
                // ShowPopup('Quantity Updated Successfuly..!!');
                $('#Update_div_'+RowId).hide();
				location.reload(true);
            }
            else if(data.Error_flag == -2)
            {
                // ShowPopup('Error Updataing Quantity. Quantity should be greater than 0. Please Tray Again.');
                $('#Update_div_'+RowId).hide();
				location.reload(true);
            }
            else
            {
                // ShowPopup('Error Updataing Quantity. Please Tray Again.');
                $('#Update_div_'+RowId).hide();
				location.reload(true);
            }
			// location.reload(); 
        }
    });
}

    $("#button1").click(function()
    { 
        setTimeout(function() 
        {
                $('#myModal').modal('show');	
        }, 0);
        setTimeout(function() 
        { 
                $('#myModal').modal('hide');	
        },2000);
    }); 
    
   function Chekout()
    { 
		localStorage.clear(); // nilesh 9-7-2020
		var Walking_customer =<?php echo $data['Walking_customer']; ?>;
        setTimeout(function() 
        {
                // $('#myModal').modal('show');	
               
			   if(Walking_customer == 0){
				   
				   // window.location.href='<?php echo base_url()?>index.php/Shopping/delivery_type';	
				   window.location.href='<?php echo base_url()?>index.php/Shopping/checkout_cart_details';	
				   
			   } else {
				   
				    window.location.href='<?php echo base_url()?>index.php/Shopping/select_outlet?delivery_type=107';	
			   }
                 
                
        }, 0);
        setTimeout(function() 
        { 
            // $('#myModal').modal('hide');
           
        },2000);
    }
    
</script>
<?php } ?>
	
	
	
	<!--Plus Minus Products -->
	<script type="text/javascript">
		var count = 1;
		var countEl = document.getElementById("count");
		function plus(){
			count++;
			countEl.value = count;
		}
		function minus(){
		  if (count > 1) {
			count--;
			countEl.value = count;
		  }  
		}
		
		var count2 = 1;
		var countE2 = document.getElementById("count2");
		function plus2(){
			count2++;
			countE2.value = count2;
		}
		function minus2(){
		  if (count2 > 1) {
			count2--;
			countE2.value = count2;
		  }  
		}

		var count3 = 1;
		var countE3 = document.getElementById("count3");
		function plus3(){
			count3++;
			countE3.value = count3;
		}
		function minus3(){
		  if (count3 > 1) {
			count3--;
			countE3.value = count3;
		  }  
		}
		
		
		/*------------ Update item cart ----------*/
		
			function Update_item_cart(RowId,id,type)
			{
					/* setTimeout(function() 
					{
						$('#myModal').modal('show');	
					}, 0);
					setTimeout(function() 
					{ 
						$('#myModal').modal('hide');	
					},2000);
				// console.log(RowId); */
				var Quantity = $('#qty_'+id).val();
				// alert(type);
				if(type==0)
				{
					Quantity=parseInt(Quantity) - 1;
				}
				else if(type==1)
				{
					Quantity=parseInt(Quantity) + 1;
				}
				
				// Quantity=parseInt(Quantity) + 1;
				// console.log(Quantity);
				var Symbol_of_currency = '<?php echo $Symbol_of_currency; ?>';
				// alert(Symbol_of_currency);
				$.ajax(
				{
					type: "POST",
					data: { Quantity:Quantity, RowId:RowId },
					url: "<?php echo base_url()?>index.php/Shopping/Update_item_quantity",
					success: function(data)
					{
						
						// alert(data.Error_flag);
						// location.reload(); 
						// console.log(data.Error_flag);
						if(data.Error_flag == 0)
						{
						   /* $('#Item_unitprice_'+RowId).html('<b>' + Symbol_of_currency +'</b> ' + data.Item_unitprice);
							$('#Item_subtotal_'+RowId).html('<b>' + Symbol_of_currency +'</b> ' + data.Item_subtotal);
							$('#Cart_grandTotal').html('<b>' + Symbol_of_currency +'</b> ' + data.grand_total);
							*/
							// ShowPopup('Quantity Updated Successfuly..!!');
							$('#Update_div_'+RowId).hide();
							location.reload(true);
						}
						else if(data.Error_flag == -2)
						{
							// ShowPopup('Error Updataing Quantity. Quantity should be greater than 0. Please Tray Again.');
							$('#Update_div_'+RowId).hide();
							location.reload(true);
						}
						else
						{
							// ShowPopup('Error Updataing Quantity. Please Tray Again.');
							$('#Update_div_'+RowId).hide();
							location.reload(true);
						}
						// location.reload(); 
					}
				});
			}
		/*------------ Update item cart ----------*/
		
		/*------------ Delete item ----------*/
		
		function delete_item(rowid,Item_name)
		{	
		$.confirm({
				title: 'Item Delete Confirmation',
				content: 'Are you sure to delete '+Item_name+' item from the cart? Please click on OK to Continue',
				icon: '<?php echo base_url(); ?>assets/img/ord.png',
				animation: 'scale',
				closeAnimation: 'scale',
				opacity: 0.5,
				buttons: {
					
					
							confirm: {
								text: 'OK',
								btnClass: 'btn-default',
								action: function () {
									
									setTimeout(function() 
									{
											$('#myModal').modal('show');	
									}, 0);
									setTimeout(function() 
									{ 
											$('#myModal').modal('hide');	
									},2000); 
									
									$.ajax({
											type:"POST",
											data:{rowid:rowid},
											// url: "<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue",
											url: "<?php echo base_url()?>index.php/Shopping/remove",
											success: function(data)
											{
												window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
											}				
									});
								}
							},
							cancel: function () {
								//$.alert('you clicked on <strong>cancel</strong>');
							}
				}
			});
		}
		/*------------ Delete item ----------*/
	</script>
	<style>
		
	</style>