<!DOCTYPE html>
<html lang="en">
<head>
<title><?=$title?></title>	
<?php 
$this->load->view('front/header/header'); 
$ci_object = &get_instance();
$ci_object->load->helper(array('encryption_val'));
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
		
?> 
</head>
<body>        
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
      <div class="container">
            <div class="section-header">          
				<p><a href="<?=base_url()?>index.php/Shopping/select_outlet?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $_SESSION['delivery_outlet']; ?>" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Select Delivery Address</p>
            </div>
			
			
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">  

			<?php if($Customer_current_address) { ?>
			
              <div class="pricing-details">				
                <ul>	
						<?php if($Customer_current_address) { 
							/* $str_arr = explode(",",$Customer_current_address->Address);
							$str_arr0 =App_string_decrypt($str_arr[0]);
							$str_arr1 =App_string_decrypt($str_arr[1]);
							$str_arr2 =App_string_decrypt($str_arr[2]);
							$str_arr3 =App_string_decrypt($str_arr[3]);	 */
							
							$Current_address=App_string_decrypt($Customer_current_address->Address);
							/* $str_arr2 = explode(",",$Current_address);
							$str_arr20 =$str_arr2[0];
							$str_arr21 =$str_arr2[1];
							$str_arr22	=$str_arr2[2];
							$str_arr23	=$str_arr2[3];
							
							$Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3; */
						?>		
							
							<p id="Extra_large_font">Current Address</p>
							<li>
								<a href="<?php echo base_url();?>index.php/Shopping/checkout_cart_details?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $_SESSION['delivery_outlet']; ?>&Address_type=<?php echo $Customer_current_address->Address_type; ?>">	
									<div class="d-flex">
										<div class="d-flex justify-content-start">										
											<span id="Medium_font"><b style="color:red"><?php echo $Customer_current_address->Contact_person; ?></b> 
											<br><?php echo $Customer_current_address->Contact_person; ?>
											<br><?php echo $Current_address; ?>
											<br><?php echo $Customer_current_address->state_name.' '.$Customer_current_address->city_name.' '.$Customer_current_address->country_name; ?>-<?php echo $Customer_current_address->Zipcode; ?>
											</span>
										</div>
											
									</div>
								
									<div class="d-flex">
										<div class="d-flex justify-content-center">										
											<button type="button" id="button1" style="width:230px" class="b-items__item__add-to-cart">Deliver to this address</button>
										</div>
									</div>
								</a>
								<br>
								<!--<div>
									<div class="d-flex justify-content-start">										
										<button type="button" id="button1" class="b-items__item__add-to-cart" >Edit</button>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<button type="button" id="button1" class="b-items__item__add-to-cart" >Delete</button>
									</div>	
								</div>-->										
							</li>
							<?php 
							}
							?>
							<br>
							<?php if($Customer_work_address) { 
							
								/* $str_arr1 = explode(",",$Customer_work_address->Address);
								$str_arr10 =App_string_decrypt($str_arr1[0]);
								$str_arr11 =App_string_decrypt($str_arr1[1]);
								$str_arr12 =App_string_decrypt($str_arr1[2]);
								$str_arr13 =App_string_decrypt($str_arr1[3]);							
								$Work_address=$str_arr10.",".$str_arr11.",".$str_arr12.",".$str_arr13; */
								
								$Work_address=App_string_decrypt($Customer_work_address->Address);
							?>			
							<p id="Extra_large_font">Work Address</p>
							
							<li>
								<a href="<?php echo base_url();?>index.php/Shopping/checkout_cart_details?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $_SESSION['delivery_outlet']; ?>&Address_type=<?php echo $Customer_work_address->Address_type; ?>">		
									<div class="d-flex">
										<div class="d-flex justify-content-start">										
											<span id="Medium_font"><b style="color:red"><?php echo $Customer_work_address->Contact_person; ?></b> 
											<br><?php echo $Customer_work_address->Contact_person; ?>
											<br><?php echo $Work_address; ?>
											<br><?php echo $Customer_work_address->state_name.' '.$Customer_work_address->city_name.' '.$Customer_work_address->country_name; ?>-<?php echo $Customer_work_address->Zipcode; ?>
											</span>
										</div>
											
									</div>
								
									<div class="d-flex">
										<div class="d-flex justify-content-center">										
											<button type="button" id="button1" style="width:230px" class="b-items__item__add-to-cart" >Deliver to this address</button>
										</div>
									</div>
								</a>
								<br>
								<div>
									<div class="d-flex justify-content-start">										
										<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return add_new_address(<?php echo $_SESSION['delivery_outlet']; ?>,109,<?php echo $_SESSION['delivery_type']; ?>);">Edit</button>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="delete_address(<?php echo $Customer_work_address->Address_id; ?>)" >Delete</button>
									</div>	
								</div>										
							</li>
							<?php 
							} else { ?>
									
									<p id="Extra_large_font">Work Address</p>									
									<li>
										
										<div class="d-flex">
											<div class="d-flex justify-content-center">										
												<button type="button" id="button1" style="width:230px" class="b-items__item__add-to-cart" onclick="return add_new_address(<?php echo $_SESSION['delivery_outlet']; ?>,109,<?php echo $_SESSION['delivery_type']; ?>);" >Add New address</button>
											</div>
										</div>
										
																				
									</li>
									
									
							<?php }
							?>
							<br>
							<?php if($Customer_other_address) { 
							
								/* $str_arr2 = explode(",",$Customer_other_address->Address);
								$str_arr20 =App_string_decrypt($str_arr2[0]);
								$str_arr21 =App_string_decrypt($str_arr2[1]);
								$str_arr22 =App_string_decrypt($str_arr2[2]);
								$str_arr23 =App_string_decrypt($str_arr2[3]);							
								$Other_address=$str_arr20.",".$str_arr21.",".$str_arr22.",".$str_arr23; */
								
								$Other_address=App_string_decrypt($Customer_other_address->Address);
								
							?>			
							<p id="Extra_large_font">Other Address</p>
							<li>
								<a href="<?php echo base_url();?>index.php/Shopping/checkout_cart_details?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $_SESSION['delivery_outlet']; ?>&Address_type=<?php echo $Customer_other_address->Address_type; ?>">		
									<div class="d-flex">
										<div class="d-flex justify-content-start">										
											<span id="Medium_font"><b style="color:red"><?php echo $Customer_other_address->Contact_person; ?></b> 
											<br><?php echo $Customer_other_address->Contact_person; ?>
											<br><?php echo $Other_address; ?>
											<br><?php echo $Customer_other_address->state_name.' '.$Customer_other_address->city_name.' '.$Customer_other_address->country_name; ?>-<?php echo $Customer_other_address->Zipcode; ?>
											</span>
										</div>
											
									</div>
								
									<div class="d-flex">
										<div class="d-flex justify-content-center">										
											<button type="button" id="button1" style="width:245px" class="b-items__item__add-to-cart">Deliver to this address</button>
										</div>
									</div>
								</a>
								<br>
								<div>
									<div class="d-flex justify-content-start">										
										<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return add_new_address(<?php echo $_SESSION['delivery_outlet']; ?>,110,<?php echo $_SESSION['delivery_type']; ?>);" >Edit</button>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="delete_address(<?php echo $Customer_other_address->Address_id; ?>)" >Delete</button>
									</div>	
								</div>									
							</li>
							<?php 
							} else { ?>
									
									<p id="Extra_large_font">Other Address</p>	<br>								
									<li>										
										<div class="d-flex">
											<div class="d-flex justify-content-center">										
												<button type="button" id="button1" style="width:245px" class="b-items__item__add-to-cart" onclick="return add_new_address(<?php echo $_SESSION['delivery_outlet']; ?>,110,<?php echo $_SESSION['delivery_type']; ?>);" >Add New address</button>
											</div>
										</div>								
									</li>
									
									
							<?php }
							?>
						
					
						
                </ul>
				</div>
				
				
				

				<div class="pricing-details">
					<div class="row">
						<div class="col-xs-12 main-xs-12" style="width: 100%;">
							<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_cart_details(<?php echo $_SESSION['delivery_type']; ?>);" >Back</button>
						</div>
						
					</div>
				</div>
				
				<?php } else {  ?>
				
				<div class="pricing-details">
					<div class="row">
						<div class="col-xs-12 main-xs-12 text-center" style="width: 100%;">
							<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_profile();" style="width: 200px;" >Please update your primary address in profile.</button>
						</div>						
					</div>
				</div>
				
				<?php }  ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Pricing Table Section-->
	
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
   <link rel="stylesheet" type="text/css"  href="<?php echo base_url();?>assets/css/jquery-confirm.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-confirm.js"></script>
	
<script>
function Go_to_profile()
{ 

    setTimeout(function() 
    {
        $('#myModal').modal('show');
			window.location.href='<?php echo base_url(); ?>index.php/Cust_home/Edit_profile';		
		
    }, 0);
    setTimeout(function() 
    { 
        $('#myModal').modal('hide');
       
    },5000);
}
function Go_to_cart_details(delivery_type)
{ 

    setTimeout(function() 
    {
        $('#myModal').modal('show');
        window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type;
		
		
    }, 0);
    setTimeout(function() 
    { 
        $('#myModal').modal('hide');
       
    },2000);
}
function delete_address(Address_id)
{
	
/* $.confirm({
	
		title: 'Item Delete Confirmation',
		content: 'Are you sure to delete this address',
		icon: 'fa fa-question-circle',
		animation: 'scale',
		closeAnimation: 'scale',
		opacity: 0.5,
		buttons: {
			
			'confirm': {
				text: 'OK',
				btnClass: 'btn-default',
				action: function () { */
					$.confirm({
						
						title: 'Are you sure to delete this address.',
						content: 'Please click on OK to Continue.',
						icon: 'fa fa-warning',
						animation: 'scale',
						closeAnimation: 'zoom',
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
											data:{Address_id:Address_id},
											// url: "<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue",
											url: "<?php echo base_url()?>index.php/Shopping/delete_address",
											success: function(data)
											{
												// window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
												 location.reload();
											}				
									});
								}
							},
							cancel: function () {
								//$.alert('you clicked on <strong>cancel</strong>');
							}
						}
					});
					/* 
				}
			},
			cancel: function () {
			},
		} 
	});*/
}
</script>
   <script>
	/* var delivery_type='<?php echo $delivery_type; ?>';
	var delivery_outlet='<?php echo $delivery_outlet; ?>';
	var Address_type='<?php echo $Address_type; ?>'; */
	function add_new_address(delivery_outlet,Address_type,delivery_type)
	{ 

		setTimeout(function() 
		{
			$('#myModal').modal('show');
			// window.location.href='<?php echo base_url(); ?>index.php/Shopping/checkout_cart_details';
			window.location.href='<?php echo base_url(); ?>index.php/Shopping/edit_address?delivery_outlet='+delivery_outlet+'&Address_type='+Address_type+'&delivery_type='+delivery_type;
			
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');
		   
		},2000);
	}
   </script>
