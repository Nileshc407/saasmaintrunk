<!DOCTYPE html>
<html lang="en">
<head>
<title><?=$title?></title>	
<?php 
$this->load->view('front/header/header'); 
$session_data = $this->session->userdata('cust_logged_in');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }

	// echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>"; 
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
		
		
		// echo"---Outlet_status_flag---".$Outlet_status_flag."---<br>";
		
		$SellersCount=count($Sellerdetails);
		// echo"SellersCount---".$SellersCount."---<br>";
		
?> 
</head>
<body>        
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
      <div class="container">
            <div class="section-header">          
				<p><a href="<?=base_url()?>index.php/Shopping/view_cart" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Select Order Type</p>
            </div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">        
				<div class="pricing-details">	
					<ul>	
						<?php /* ?>
							<a href="<?php echo base_url();?>index.php/Shopping/select_outlet?delivery_type=0">
								<li>
									<img src="<?php echo base_url(); ?>assets/icons/delivery.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font">Delivery</span>
									<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
								</li>
							</a>
						<?php */ ?>
						
						
						
						<?php foreach($ShippingMethods as $Methods) { 
							
							if($Methods['Code_decode_id']== 28){  //Take Away 
							
								$img="takeaway.png";
								
							} elseif($Methods['Code_decode_id']== 29){ //Home Delivery
							
								$img="delivery.png";
								
							} elseif($Methods['Code_decode_id']== 107){ //In Store
							
								$img="instore.png";
							}
							if($Methods['Code_decode_id'] != 107 ) {
								
								if($session_data['Walking_customer'] == 0) {
									 
									?>				
										<?php /* if($SellersCount==1) { ?> 
											
											
											
											<a href="JavaScript:void(0);"  onclick="return Go_to_next(<?php echo $Methods['Code_decode_id']; ?>,<?php echo $Enrollement_id; ?>,'<?php echo $First_name.'_'.$Last_name.'_'.$Current_address; ?>',<?php echo $Table_no_flag; ?>);">
											
										<?php } else { */ ?>

											<a href="<?php echo base_url();?>index.php/Shopping/select_outlet?delivery_type=<?php echo $Methods['Code_decode_id']; ?>" onclick="Show_loader();">
											
										<?php //} ?>									
										
										
										
											<li>
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $img; ?>" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"><?php echo $Methods['Code_decode']; ?></span>
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
											</li>
										</a>
										
									<?php 
								
								} else { 
								 
											//if($Methods['Code_decode_id'] == 107) {
										 
										?>
										
										<?php /* if($SellersCount==1) { ?> 
											
											<a href="JavaScript:void(0);" onclick="return Go_to_next(<?php echo $Methods['Code_decode_id']; ?>,<?php echo $Enrollement_id; ?>,'<?php echo $First_name.'_'.$Last_name.'_'.$Current_address; ?>',<?php echo $Table_no_flag; ?>);">
											
											
											
											
										<?php } else { */ ?>

												<a href="<?php echo base_url();?>index.php/Shopping/select_outlet?delivery_type=<?php echo $Methods['Code_decode_id']; ?>" onclick="Show_loader();">
											
										<?php //} ?>
											
												<li>
													<img src="<?php echo base_url(); ?>assets/icons/<?php echo $img; ?>" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"><?php echo $Methods['Code_decode']; ?></span>
													<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
												</li>
											</a>
										 
										<?php 
										
									 // }
								}
							}							
						} ?>
												
					</ul>
				</div> 
					<div class="pricing-details">
							<div class="row">
								<div class="col-xs-12 main-xs-12" style="width: 100%;">
									<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_cart_details();" >Back</button>
								</div>
								
							</div>
					</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Pricing Table Section-->
	
	
	
	
	<!-- TableNoModal -->
		<div id="TableNoModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
				<div class="modal-content text-center">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>				
					</div>
					<div class="modal-body" id="TableNo_div">
						<div class="form-group text-center">
							<label for="TableNo" id="Medium_font">Enter Table No.</label>
							<input type="text" id="TableNo" name="TableNo">						
							<div style="color:red;font-size:12px;" id="TableNo_error"></div>
						</div>
					</div>
					<div class="modal-footer" id="procced_div">
						
						<input type="hidden" class="form-control" id="delivery_type" name="delivery_type" >
						<input type="hidden" class="form-control" id="delivery_outlet" name="delivery_outlet" >
						<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_next(TableNo.value,delivery_type.value,delivery_outlet.value);">Procced</button>					
					</div>				
					<div id="InStore_div" style="display:none">
						<div class="modal-body">
							<div class="form-group text-center">
								<label for="TableNo" id="Medium_font">You are placing a <font id="orderText"> </label><br>					
								<label for="TableNo" id="Small_font">Please confirm you are at</label><br>
								<label for="TableNo" id="Small_font"><span id="Fname"></span></label>	
								<label for="TableNo" id="Small_font"><span id="Lname"></span></label><br>	
								<label for="TableNo" id="Small_font_div">Table No.:<span id="Table"></span></label><br>
								<label for="TableNo" id="Small_font"><span id="Address"></span></label>
							</div>
						</div>
						<div class="modal-footer">
							<div class="col-xs-4 main-xs-6 text-left" style="width: 50%;">
								<button type="button" id="button1" class="b-items__item__add-to-cart"   onclick="return Go_next_next_process(TableNo.value,delivery_type.value,delivery_outlet.value);">I am at the Restaurant</button>
							</div>
							<div class="col-xs-4 main-xs-6 text-right" style="width: 50%;"> 
								<button type="button" id="button1"  class="b-items__item__add-to-cart" onclick="return Go_to_cart_details();" >
									Cancel In-Store Order
								</button>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>

	<!-- TableNoModal -->
	
	
	
	
	<!-- Loader --> 
	<div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
					 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
	</div>
	<!-- Loader -->
   <?php $this->load->view('front/header/footer'); ?> 
   <script>
function Go_to_cart_details()
{ 

    setTimeout(function() 
    {
        $('#myModal').modal('show');
        window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
        //window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type;
		// window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
		
    }, 0);
    setTimeout(function() 
    { 
        $('#myModal').modal('hide');
       
    },2000);
}
function Show_loader(){
	
	 setTimeout(function() 
    {
        $('#myModal').modal('show');       
		
    }, 0);
    setTimeout(function() 
    { 
        $('#myModal').modal('hide');
       
    },2000000);
	
}

	function Go_to_next(delivery_type,Enrollement_id,address,Table_no_flag)
	{ 

		console.log('---Table_no_flag----'+Table_no_flag);
		console.log('---delivery_type----'+delivery_type);
		if(Table_no_flag == 0 ){			
			Go_next(99,delivery_type,Enrollement_id)
		}
		
		if(delivery_type==28){
			
			$("#InStore_div").css('display','');
			$("#TableNo_div").css('display','none');
			$("#procced_div").css('display','none');
			$("#Small_font_div").css('display','none');
			$("#orderText").html('Pick-Up');
		} else{
			$("#orderText").html('In-Store Order');
		}
		$('#TableNoModal').modal('show');
		$('#TableNo').val();
		$('#delivery_type').val(delivery_type);
		$('#delivery_outlet').val(Enrollement_id);
		
		
		var myStringArray = address.split('_');
		
		$('#Fname').html(myStringArray[0]);
		$('#Lname').html(myStringArray[1]);
		$('#Address').html(myStringArray[2]);	
		
	}
	function Go_next(TableNo,delivery_type,Enrollement_id)
	{ 
		
		console.log('---Go_next TableNo----'+TableNo);
		console.log('---Go_next delivery_type----'+delivery_type);
		
		$("#procced_div").css('display','none');
		$("#InStore_div").css('display','');
		
		$("#TableNo_error").html('');
		
		if(TableNo == 99 ){
			
			$("#TableNo_div").css('display','none');
			$("#Small_font_div").css('display','none');
			
		} else {
			
			// console.log('---Go_next TableNo--2--'+TableNo);
			if(TableNo == "") {
			
				// $('#Table').html(TableNo);
				$("#TableNo_error").html('Please Enter valid table No.');
			
			} else {
				
				$("#TableNo_div").css('display','');
				$("#TableNo_error").html('');
				$("#InStore_div").css('display','');			
				$("#Small_font_div").css('display','');			
				$('#Table').html(TableNo);			
			}
		}
		
		
	}	
	function Go_next_next_process(TableNo,delivery_type,Enrollement_id)
	{ 
			
		$("#TableNo_error").html('');
		// console.log('---Go_next_next_process TableNo----'+TableNo);
		if(TableNo==""){
			
			var TableNo=9999;
			
		}else{
			
			TableNo=TableNo;
		}
		
		if(TableNo == ""){
			
			//console.log('---Go_next_next_process TableNo----'+TableNo);
			$("#TableNo_error").html('Please Enter valid table no.');
			
		} else {
			
			$("#TableNo_error").html('');
			$("#InStore_div").css('display','');
			setTimeout(function() 
			{
				window.location.href='<?php echo base_url();?>index.php/Shopping/select_address?delivery_type='+delivery_type+'&delivery_outlet='+Enrollement_id+'&TableNo='+TableNo;		
				
			}, 0);
			
			$('#TableNoModal').modal('hide');
		}
		
		
	}

</script>
