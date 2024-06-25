<!DOCTYPE html>
<html lang="en">
<head>
<title><?=$title?></title>	
<?php 
$this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
$session_data = $this->session->userdata('cust_logged_in');
	$data['Walking_customer'] = $session_data['Walking_customer'];
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
		
		
		// echo"--delivery_type---".$_SESSION['delivery_type']."--<br>"; 
?> 
</head>
<body>        
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
      <div class="container">
            <div class="section-header">  
				<?php if($session_data['Walking_customer'] == 0) { ?>
					<p><a href="<?=base_url()?>index.php/Shopping/delivery_type" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<?php } else { ?> 
				<p>
				</p>
				<?php }?>
				<p id="Extra_large_font">Select Outlet</p>
            </div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">    
				<!----Search Box---->
						<div class="pricing-details">
						<form  name="Search_items" method="POST" action="<?php echo base_url()?>index.php/Shopping/search_outlet" enctype="multipart/form-data">
							<address style="margin-left:-15px;"> 
								<a href="<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type=<?php echo $_SESSION['delivery_type']; ?>"><span id="button5" onclick="Page_refresh();"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/refresh.png" style="width: 20px"></span></a>						
							   <input type="text" name="Search_key" placeholder="Search" id="Search_mail" class="txt" autocomplete="off">
							   <a href="#">
								<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png" id="search" onclick="form_submit();">
							   </a>
							</address> 
							
						</form>
						</div>
					<!----Search Box---->
					
              <div class="pricing-details">				
                <ul>	
				<?php  //print_r($Sellerdetails); ?>
				
					<?php
					$Outlet_status_flag=0;
					$Current_time = date("H:i:s");
					$Current_day = date("l");
					$day_of_week = date('N', strtotime($Current_day));
					
												
					$ci_object = &get_instance(); 
					$ci_object->load->model('Igain_model');
					$ci_object->load->model('shopping/Shopping_model');
					$ci_object->load->helper(array('encryption_val'));
					foreach($Sellerdetails as $row)
					{						
					
						
						$Table_no_flag=$row['Table_no_flag'];
						// $Table_no_flag=1;
						
						$Get_city_name = $ci_object->Igain_model->Get_cities($row['State']);
						foreach($Get_city_name as $City)
						{
							if($City->id==$row['City'])
							{
								$City_name=$City->name;
							}
							
						}						
						if($Enroll_details->City == $row['City']) {
							
							
							$Get_outlet_working_hours = $ci_object->Shopping_model->Get_outlet_working_hours($row['Enrollement_id'],$day_of_week);			
							// echo"---Get_outlet_working_hours---".$Get_outlet_working_hours."---<br>";
							$Get_outlet_working_hours=1;
							if($Get_outlet_working_hours==2)
							{
								$Outlet_status = " : Closed";
								$Outlet_status_flag =0;								
							}
							else
							{
								$Outlet_status = " : Open";
								$Outlet_status_flag =1;
								
							}
							
							/* $str_arr = explode(",",$row['Current_address']);
							$str_arr0 =App_string_decrypt($str_arr[0]);
							$str_arr1 =App_string_decrypt($str_arr[1]);
							$str_arr2 =App_string_decrypt($str_arr[2]);
							$str_arr3 =App_string_decrypt($str_arr[3]); */
							
							// $Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3;
							$Current_address=App_string_decrypt($row['Current_address']);
							$str_arr = explode(",",$Current_address);
							$str_arr0 =$str_arr[0];
							$str_arr1 =$str_arr[1];
							// $str_arr2 =$str_arr[2];
							// $str_arr3 =$str_arr[3];
							$Current_address=$str_arr0.",".$str_arr1;
							
							
							
							// print_r($Current_address);
							
							// echo "<br>--Current_address--".$Current_address;
							// echo"---Outlet_status_flag---".$Outlet_status_flag."---<br>";
						?>
							
							
							
							<?php if($Outlet_status_flag == 0){ ?>
							
								<a href="javascript:void(0)">	
							
							<?php } else { ?> 
								
								
								<?php if($_SESSION['delivery_type'] == 107) { ?> 								
								
									<a href="javascript:void(0)" onclick="return Go_to_next(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $row['Enrollement_id']; ?>,'<?php echo $row['First_name'].'_'.$row['Last_name'].'_'.$Current_address; ?>',<?php echo $Table_no_flag; ?>);" >
								
								
								<?php  } else { ?> 
								
										<a href="<?php echo base_url();?>index.php/Shopping/select_address?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $row['Enrollement_id']; ?>" >
								
								<?php } ?>
								
								
								
								
							<?php } ?>
							
								<li <?php if($_REQUEST['delivery_outlet']==$row['Enrollement_id']){echo "style='background: #13a89e36;'";}?>>
									<div class="d-flex">
										<div class="d-flex justify-content-start">					
											
											
											<span id="Medium_font" style="font-size: 14px;">
											
											<?php echo "<b style=\"color:red\">".$row['First_name'].' '.$row['Last_name'].'</b> <br> '.$Current_address; ?>  <?php echo $Outlet_status; ?>
											<!--(<?php //echo $City_name; ?>) <br>--->
											
											<?php if($Outlet_status_flag == 0){ ?>
											
												<font style="color:red;font-size:10px;">Currently not processing online Orders!</font>
												
											<?php } ?>
											</span>
											
											
										</div>
											
										
										<?php if($Outlet_status_flag == 1){ ?>
											<div class="d-flex justify-content-end" style="width: 50%;margin: auto;margin-right: 1px;">
											<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" style="width: 20px;    height: 20px;" > 
										</div>
										<?php } ?>
									</div>										
								</li>
							</a>
						<?php }
					}
					?>
					<?php
					$Outlet_status_flag2=0;
					foreach($Sellerdetails as $row)
					{		
						
						$Table_no_flag=$row['Table_no_flag'];
						// $Table_no_flag=1;
						
						$Get_city_name = $ci_object->Igain_model->Get_cities($row['State']);
						foreach($Get_city_name as $City)
						{
							if($City->id==$row['City'])
							{
								$City_name=$City->name;
							}
							
						}		
							
						if($Enroll_details->City != $row['City']) {
							
						

							$Get_outlet_working_hours_2 = $ci_object->Shopping_model->Get_outlet_working_hours($row['Enrollement_id'],$day_of_week);	
							
							$Get_outlet_working_hours_2=1;
							
							// echo"---Get_outlet_working_hours_2---".$Get_outlet_working_hours_2."---<br>";
							
							if($Get_outlet_working_hours_2==2)
							{
								$Outlet_status = " : Closed";
								$Outlet_status_flag2 =0;								
							}
							else
							{
								$Outlet_status = " : Open";
								$Outlet_status_flag2 =1;
								
							}
							
							
							/* $str_arr1 = explode(",",$row['Current_address']);
							$str_arr10 =App_string_decrypt($str_arr1[0]);
							$str_arr11 =App_string_decrypt($str_arr1[1]);
							$str_arr12 =App_string_decrypt($str_arr1[2]);
							$str_arr13 =App_string_decrypt($str_arr1[3]);
							
							$Current_address1=$str_arr10.",".$str_arr11.",".$str_arr12.",".$str_arr13; */
							
							// $str_arr1 = explode(",",$row['Current_address']);
							
							$Current_address1=App_string_decrypt($row['Current_address']);
							$str_arr = explode(",",$Current_address1);
							$str_arr0 =$str_arr[0];
							$str_arr1 =$str_arr[1];
							// $str_arr2 =$str_arr[2];
							$str_arr3 =$str_arr[3];
							$Current_address1=$str_arr0.",".$str_arr1;
							
						?>
							
							
							<?php if($Outlet_status_flag2 == 0){ ?>							
								<a href="javascript:void(0)">							
							<?php } else { ?> 
								
								<a href="<?php echo base_url();?>index.php/Shopping/select_address?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $row['Enrollement_id']; ?>" <?php if($_SESSION['delivery_type'] == 107) { ?> onclick="return Go_to_next(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $row['Enrollement_id']; ?>,'<?php echo $row['First_name'].'_'.$row['Last_name'].'_'.$Current_address1; ?>',<?php echo $Table_no_flag; ?>);"  <?php } ?>>
								
							<?php } ?>
							
								<li <?php if($_REQUEST['delivery_outlet']==$row['Enrollement_id']){echo "style='background: #13a89e36;'";}?>>
									<div class="d-flex">
										<div class="d-flex justify-content-start">
											<span id="Medium_font" style="font-size: 14px;"><?php echo "<b style=\"color:red\">".$row['First_name'].' '.$row['Last_name'].'</b> <br> '.$Current_address1; ?>  <?php echo $Outlet_status2; ?>
											<!-----(<?php //echo $City_name; ?>) <br>--->
											
											<?php if($Outlet_status_flag2 ==0){ ?>
											
												<font style="color:red;font-size:10px;">Currently not processing online Orders!</font>
												
											<?php } ?>
											
											</span>
											
											
										</div>
										
										
										<?php if($Outlet_status_flag2 == 1){ ?>
											<div class="d-flex justify-content-end">
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" style="width: 20px;    height: 20px;margin-top: 20px;" > 
											</div>	
										<?php } ?>
									</div>										
								</li>
							</a>
						<?php }
					}
					?>
						
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
	
	<!-- Table No -
	<div class="container" >
		 <div class="modal fade" id="TableNoModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
						Enter Table No:
				   </div>       
				</div>    
				<!-- Modal content-
			  </div>
		 </div>       
	</div>
	
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
							<label for="TableNo" id="Medium_font">You are placing a In-Store Order </label><br>					
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
   <style>
   .form-control {	   
		color:#515050;
   }
   </style>
<script>
	
	
	$(function() {
    $('#TableNo').on('click', function() {
        $("#procced_div").css('display','');
        $("#InStore_div").css('display','none');
		
    });

   
});


	function Go_to_next(delivery_type,Enrollement_id,address,Table_no_flag)
	{ 

		// console.log('---Table_no_flag----'+Table_no_flag);
		if(Table_no_flag == 0 ){			
			Go_next(99,delivery_type,Enrollement_id)
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
		
		// console.log('---Go_next TableNo----'+TableNo);
		
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
	
	function Go_to_cart_details()
	{ 
		var Walking_customer= <?php echo $session_data['Walking_customer']; ?>;
		setTimeout(function() 
		{
			$('#myModal').modal('show');
			 if(Walking_customer == 0 ) {
				 
				 window.location.href='<?php echo base_url(); ?>index.php/Shopping/delivery_type';
			 } else {
				 window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
			 }
			
			
			//window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type;
			// window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
			
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');
		   
		},2000);
	}   
	function form_submit()
	{
		setTimeout(function() 
		{
				$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
				$('#myModal').modal('hide'); 
		},2000);

		document.Search_items.submit();
	} 
	
	function Page_refresh()
	{
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
		
		// window.location.reload();
	}
</script>