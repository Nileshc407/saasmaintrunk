<?php $this->load->view('front/header/header'); ?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/select-location.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url();?>index.php/Cust_home/front_home"></a>
					</div>
					<h2>Order Type</h2>
				</div>
			</div>
		</div>
		<div class="custom-body order-type-body">
				<?php
					if(@$this->session->flashdata('error_code'))
					{
					?>
						<div class="alert bg-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
						</div>
					<?php
					}
				?>
			<div class="accordion" id="accordion">
			
				
				<?php /* foreach($ShippingMethods as $Methods) { 
							
							//Take Away==28, Home Delivery=29, In Store=107
							
							if($Methods['Code_decode_id']!= 29) {
								
								if($session_data['Walking_customer'] == 0) {
									 
									?>				
										

											<a href="<?php echo base_url();?>index.php/Shopping/select_outlet_shopping?delivery_type=<?php echo $Methods['Code_decode_id']; ?>" onclick="Show_loader();">
											
																		
										
										
										
											<li>
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $img; ?>" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"><?php echo $Methods['Code_decode']; ?></span>
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
											</li>
										</a>
										
									<?php 
								
								} else { 
								
										?>
											<a href="<?php echo base_url();?>index.php/Shopping/select_outlet_shopping?delivery_type=<?php echo $Methods['Code_decode_id']; ?>" onclick="Show_loader();">
											
										
											
												<li>
													<img src="<?php echo base_url(); ?>assets/icons/<?php echo $img; ?>" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"><?php echo $Methods['Code_decode']; ?></span>
													<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
												</li>
											</a>
										 
										<?php 
										
								}
							}							
						} */ ?>
						
				<?php foreach($ShippingMethods as $Methods) { 
					
					// echo"<br>----Code_decode_id-----".$Methods['Code_decode_id'];
				} 
				
				// var_dump($Enroll_details);
				?>	
				
					<!-- Accordion item 1 -->
				<?php /* ?>	
				<div class="item">
					<?php echo form_open_multipart('Shopping/select_outlet_shopping'); ?>				
						<div class="accordion-header">
							<button class="btn" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" onclick="Call_loader();">
								<span class="icon" style="background-color:#4CD964;">
									<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0)">
										<path d="M8.08048 6.25002C7.86173 6.25002 7.64506 6.15939 7.48985 5.98127C7.20756 5.65522 7.24194 5.16147 7.56798 4.87918C7.74298 4.7271 7.82839 4.53647 7.80964 4.34064C7.79089 4.12918 7.64819 3.93231 7.42214 3.80106C6.75131 3.41356 6.32839 2.77814 6.25964 2.05731C6.19298 1.35626 6.47423 0.676056 7.03256 0.191681C7.3586 -0.0926941 7.85131 -0.0583191 8.13569 0.268764C8.41798 0.594806 8.3836 1.08856 8.05756 1.37085C7.88256 1.52293 7.79714 1.71356 7.81589 1.90939C7.83569 2.12085 7.97735 2.31772 8.20444 2.44897C8.87423 2.83647 9.29715 3.47189 9.3659 4.19272C9.43256 4.89377 9.15131 5.57397 8.59298 6.05939C8.44402 6.18647 8.26277 6.25002 8.08048 6.25002Z" fill="white"/>
										<path d="M13.2885 6.25018C13.0697 6.25018 12.8531 6.15956 12.6979 5.98143C12.4156 5.65539 12.4499 5.16164 12.776 4.87935C12.951 4.72727 13.0364 4.53664 13.0177 4.34081C12.9979 4.12935 12.8562 3.93248 12.6291 3.80123C11.9593 3.41373 11.5364 2.77831 11.4677 2.05748C11.401 1.35643 11.6822 0.676225 12.2406 0.190809C12.5666 -0.0925248 13.0593 -0.0581498 13.3427 0.268934C13.6249 0.594975 13.5906 1.08873 13.2645 1.37102C13.0895 1.5231 13.0041 1.71373 13.0229 1.90956C13.0427 2.12102 13.1843 2.31789 13.4114 2.44914C14.0812 2.83664 14.5041 3.47206 14.5729 4.19289C14.6395 4.89393 14.3583 5.57414 13.7999 6.05956C13.652 6.18664 13.4708 6.25018 13.2885 6.25018Z" fill="white"/>
										<path d="M17.9688 25H2.86458C1.28437 25 0 23.7156 0 22.1354V21.0938C0 20.6625 0.35 20.3125 0.78125 20.3125H20.0521C20.4833 20.3125 20.8333 20.6625 20.8333 21.0938V22.1354C20.8333 23.7156 19.549 25 17.9688 25Z" fill="white"/>
										<path d="M3.95033 19.2708H16.8951C17.4649 18.7281 17.9691 18.1125 18.3899 17.4302C18.417 17.3979 18.441 17.3635 18.4628 17.3271C19.3326 15.8698 19.792 14.2 19.792 12.5V8.59375C19.792 8.1625 19.442 7.8125 19.0107 7.8125H1.82324C1.39199 7.8125 1.04199 8.1625 1.04199 8.59375V12.5C1.04199 15.1615 2.16283 17.5625 3.95033 19.2708Z" fill="white"/>
										<path d="M20.8331 9.6355V11.7188C21.9821 11.7188 22.9165 12.6532 22.9165 13.8022C22.9165 14.3647 22.7019 14.8845 22.2988 15.2803C21.9154 15.6709 21.3956 15.8855 20.8331 15.8855H20.2467C20.0123 16.5688 19.73 17.2365 19.3571 17.8605C19.3352 17.898 19.3092 17.9324 19.2842 17.9688H20.8331C21.9592 17.9688 23.0061 17.5324 23.7717 16.7532C24.5633 15.9751 24.9998 14.9282 24.9998 13.8022C24.9998 11.5042 23.1311 9.6355 20.8331 9.6355Z" fill="white"/>
										</g>
										<defs>
										<clipPath id="clip0">
										<rect width="25" height="25" fill="white"/>
										</clipPath>
										</defs>
									</svg>
								</span>
								In Store
							</button>
						</div>
						<!--<div id="collapse1" class="collapse show" data-parent="#accordion">
							<div class="card-body">
								<div class="notification-body">
									
									<div class="proceed-btn-wrap">									
										<a href="#" class="cust-btn btn-block">PROCEED</a>
									</div>
								</div>
							</div>
						</div>-->
						<input type="hidden" name="delivery_type" value="107">
					<?php echo form_close(); ?>
				</div>
				
				<?php */ ?>
				<!-- Accordion item 2  onclick="Call_loader();"-->
				<div class="item">
					<?php //echo form_open_multipart('Shopping/select_outlet_shopping'); ?>
						<div class="accordion-header">
							<button class="btn" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" id="PickUp">
								<span class="icon" style="background-color:#007AFF;">
									<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.4998 22.2435C10.7654 22.2435 9.22656 21.2805 8.51743 19.7998H6.35645L6.72168 23.9999H18.2778L18.643 19.7998H16.482C15.7729 21.2805 14.2341 22.2435 12.4998 22.2435Z" fill="white"/>
									<path d="M18.49 0H6.51167L5.54102 3.1162H19.4606L18.49 0Z" fill="white"/>
									<path d="M4.13379 4.52246H20.8666V6.8484H4.13379V4.52246Z" fill="white"/>
									<path d="M15.2844 13.3709C14.8974 12.2023 13.7787 11.4172 12.5005 11.4172C11.2223 11.4172 10.1036 12.2023 9.7166 13.3709L9.55435 13.861H5.84082L6.23491 18.3937H9.55435L9.7166 18.8838C10.1036 20.0523 11.2223 20.8374 12.5004 20.8374C13.7786 20.8374 14.8973 20.0523 15.2843 18.8838L15.4465 18.3937H18.766L19.1601 13.861H15.4465L15.2844 13.3709Z" fill="white"/>
									<path d="M5.7187 12.4547H8.51826C9.22734 10.974 10.7663 10.011 12.5006 10.011C14.235 10.011 15.7739 10.974 16.483 12.4547H19.2826L19.6478 8.25464H5.35352L5.7187 12.4547Z" fill="white"/>
									</svg>
								</span>
								Pick Up
							</button>
						</div>
						<!--<div id="collapse2" class="collapse" data-parent="#accordion">
							<div class="card-body">
								<div class="notification-body">
									<div class="proceed-btn-wrap">
										<a href="#" class="cust-btn btn-block">PROCEED</a>
									</div>
								</div>
							</div>
						</div>-->
						<input type="hidden" name="delivery_type" value="28">
					<?php //echo form_close(); ?>
				</div>
				<?php /*****/ ?>
				<!-- Accordion item 3 Delivery Method ---->
				<div class="item">
					
						<div class="accordion-header">
							<button class="btn" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" >
								<span class="icon" style="background-color:#FF2D55;">
									<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M23.6066 24.0745L21.6261 16.8289C21.5816 16.6659 21.4821 16.5233 21.3445 16.4253C18.2053 14.1897 19.2344 14.9226 16.5507 13.0115C17.5694 11.9647 18.1566 10.5496 18.1566 9.06826C18.1566 6.11514 18.1762 5.95352 18.0897 5.41475C18.0577 2.32334 15.7147 0 12.6139 0H12.3861C9.28541 0 6.94239 2.32334 6.91041 5.41479C6.82384 5.95356 6.84347 6.11504 6.84347 9.06831C6.84347 10.5496 7.43068 11.9647 8.44938 13.0116C5.05328 15.4299 7.03766 14.0168 3.65553 16.4254C3.51793 16.5234 3.41842 16.666 3.37389 16.8289L1.39347 24.0745C1.26617 24.5403 1.61739 25 2.09996 25H11.7676V17.2599L12.5001 16.7787L13.2325 17.2599V25H22.9002C23.383 25 23.7338 24.5399 23.6066 24.0745ZM12.0217 2.37314H12.9783C13.3828 2.37314 13.7108 2.70107 13.7108 3.10557C13.7108 3.51006 13.3828 3.83799 12.9783 3.83799H12.0217C11.6172 3.83799 11.2893 3.51006 11.2893 3.10557C11.2893 2.70107 11.6172 2.37314 12.0217 2.37314ZM11.7677 15.5072L10.1566 16.5657L8.00753 15.1245L9.65314 13.9526C10.3258 14.345 11.0524 14.5797 11.7677 14.6718V15.5072ZM12.5001 13.2539C10.1736 13.2539 8.30831 11.3659 8.30831 9.06831C8.30826 8.5438 8.30768 8.10972 8.30719 7.74624L8.70094 8.32109C8.83746 8.52046 9.06354 8.6396 9.30519 8.6396H15.6949C15.9365 8.6396 16.1626 8.52046 16.2991 8.32109L16.6929 7.74624C16.6924 8.10967 16.6918 8.5438 16.6918 9.06831C16.6918 11.3453 14.8472 13.2539 12.5001 13.2539ZM13.2324 15.5072V14.6717C13.9859 14.5749 14.7067 14.3261 15.3469 13.9526L16.9925 15.1245L14.8435 16.5657L13.2324 15.5072ZM18.7221 21.8795H16.1538C15.7493 21.8795 15.4214 21.5516 15.4214 21.1471C15.4214 20.7426 15.7493 20.4147 16.1538 20.4147H18.7221C19.1266 20.4147 19.4545 20.7426 19.4545 21.1471C19.4545 21.5516 19.1266 21.8795 18.7221 21.8795Z" fill="white"/>
									</svg>
								</span>
								Delivery
							</button>
						</div>
						<div id="collapse3" class="collapse" data-parent="#accordion">
							<?php 
								// $attributes = array('onSubmit' => 'return ValidateForm();');
								// echo form_open_multipart('Shopping/select_outlet_shopping',$attributes); ?>
								<div class="card-body">
									<div class="notification-body">
										
										<?php if($Customer_current_address){ ?>
											<div class="notification-check">									
												<label>
													<input type="radio" id="Address_type" name="Address_type" value="108" onclick="Get_address(<?php echo $Enroll_details->Enrollement_id; ?>,108)">
													<span>Current Address</span>
												</label>
											</div>
											<div class="card-body" id="108" style="display:none;    word-break: break-all;">
											</div>
										<?php } ?>
										<?php if($Customer_work_address){ ?>
										<div class="notification-check">
											<label>
												<input type="radio" id="Address_type" name="Address_type" value="109" onclick="Get_address(<?php echo $Enroll_details->Enrollement_id; ?>,109)">
												<span>Work Address</span>
											</label>
										</div>
										
										
											<div class="card-body" id="109" style="display:none;    word-break: break-all;">
																								
											</div>
										
										<div class="card-body">
											<div class="point-field">
												<span>
													<a href="JavaScript:VOID(0);" onclick="return add_new_address(109);" style="text-align:right;color:var(--dark);">Edit</a>												
												</span>
											</div>													
										</div>
										
										
										
										
										
										
										
										<?php } else { ?> 
											
												
												
												<div class="add-new-wrap">
													<a href="#" class="cust-btn btn-block btn-active"  onclick="return add_new_address(109);">+ Add Work Address</a>
												</div>
											
										<?php } ?>
										<?php if($Customer_other_address){ ?>
											<div class="notification-check">
												<label>
													<input type="radio" id="Address_type" name="Address_type" value="110" onclick="Get_address(<?php echo $Enroll_details->Enrollement_id; ?>,110)">
													<span>Other Address</span>
												</label>
											</div>	
											<div class="card-body" id="110" style="display:none;    word-break: break-all;">
																								
											</div>
											
											<div class="card-body">
												<div class="point-field">
													<span>
														<a href="JavaScript:VOID(0);" onclick="return add_new_address(110);" style="text-align:right;color:var(--dark);">Edit</a>
													</span>
												</div>													
											</div>
											
												
											
										<?php } else { ?>
												<div class="add-new-wrap">
													<a href="#" class="cust-btn btn-block btn-active"  onclick="return add_new_address(110);">+ Add Other Address</a>
												</div>											
										<?php } ?>
										
											<div class="proceed-btn-wrap">
												<div id="Gift_card_msg" style="text-align:center;"></div>
												<input type="hidden" name="delivery_type" value="29">
												<button class="cust-btn btn-block btn-active" onclick="ValidateForm()" id="Delivery">PROCEED</button>
											</div>
										
									</div>
								</div>
							
							<?php //echo form_close(); ?>
						</div>
						
				</div>
				
				<?php /*******/ ?>
			</div>
		</div>
	<?php $this->load->view('front/header/footer');  ?>
	<?php /* ?>	
	<div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 60%;">
				<!-- Modal content--->
				<div class="modal-content" id="loader_model" style="width: 93%;">
				   <div class="modal-body" style="height: 175px;">
					 <img src="<?php echo base_url(); ?>assets/img/gif-300x300.gif" alt="" class="img-rounded img-responsive" style="max-width: 47%;height: auto;width: auto;">
						<p style="color: var(--dark);font-weight: bolder;">Please, wait</p>	
				   </div>
							   
				</div>    
				<!-- Modal content-->
				
				<!--<div class="loader">
					<div id="ld3">
					  <div>
					  </div>
					  <div>
					  </div>
					  <div>
					  </div>
					  <div>
					  </div>
					</div>
				</div> -->
				
			  </div>
		 </div>       
	</div>

	<?php */ ?>	
	
	
	
	
	
		<!-- Loader Modal -->
			<div class="modal fade" id="loader-modal" data-keyboard="false" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="loaderlabel">
			  <div class="vertical-alignment-helper">
				<div class="modal-dialog modal-dialog-centered">
				  <div class="modal-content" style="height: 180px;">
					<div class="modal-header custom">
					  <div class="modal-body">
						<div class="loadingSpinner"><div class="spinner-wave"><div></div><div></div><div></div><div></div><div></div></div><span class="text-center"><b>Please, wait...</b></span></div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		<!-- /Loader Modal -->

		<!--<ul class="list-group">
		  <li class="list-group-item">
			<a href="#" class="btn-openOrd">
				<h4 class="pghead" style="color: var(--dark);">Click to Fire Modal</h4>
			</a>
		  </li>
		</ul> -->
	<!-- Loader Modal -->
	
	<script>
	
	/* Add Address */
	
	
	
	$(function() {
		
		$('#PickUp').on('click', function() {
		
        var loaderModal = $('#loader-modal');
        loaderModal.find('.modal-body').html('<div class="loadingSpinner"><div class="spinner-wave"><div></div><div></div><div></div><div></div><div></div></div><span class="text-center"><b>Please, wait...</b></span></div>');
			loaderModal.modal('show');
			setTimeout(function() {
				window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet_shopping?delivery_type=28';
			}, 5000);
		});
		
		
		
		
		
	});
	
	
	
	
	function Get_address(Eneroll,addressType)
	{
		// alert(Eneroll);
		// alert(addressType);
		
		$("#108").css('display','none'); 
		$("#109").css('display','none'); 
		$("#110").css('display','none'); 
		
		$.ajax({
			type: "POST",
			data: {EnerollId:Eneroll,addressType:addressType},
			url: "<?php echo base_url(); ?>index.php/Shopping/get_address_details",
			success: function(data)
			{
				// console.log(data.response);	
				
				// var response2 = JSON.parse(data.response);
				// console.log(response2);
				
				$("#"+addressType+"").css('display','block'); 
				$("#"+addressType+"").html(data.response); 
				// $("#Show_Cities").html(data.City_data);	
				
			}
		});
	}
		function add_new_address(Address_type)
		{ 

			setTimeout(function() 
			{
				// $('#myModal').modal('show');
				// window.location.href='<?php echo base_url(); ?>index.php/Shopping/checkout_cart_details';
				window.location.href='<?php echo base_url(); ?>index.php/Shopping/edit_address?Address_type='+Address_type;
				
			}, 0);
			setTimeout(function() 
			{ 
				// $('#myModal').modal('hide');
			   
			},2000);
		}
	
	/* Add Address */
	
	
	/* function Call_loader()
	{
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},200000000000); 
	} */
	
	
	function ValidateForm(){
		
		if ($("input[type=radio]:checked").length > 0) {
				
			/* setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},200000000); */
			
			
			// var Address_type = $("input[type=radio]:checked").length
			
			var Address_type = $("input[name='Address_type']:checked").val();
			 // console.log(Address_type);
			 // return false;
			// $('#Delivery').on('click', function() {
				
				var loaderModal = $('#loader-modal');
				loaderModal.find('.modal-body').html('<div class="loadingSpinner"><div class="spinner-wave"><div></div><div></div><div></div><div></div><div></div></div><span class="text-center"><b>Please, wait...</b></span></div>');
					loaderModal.modal('show');
					setTimeout(function() {
						
						window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet_shopping?delivery_type=29&Address_type='+Address_type;
						
						// loaderModal.modal('hide');
						
						
						
						
					}, 5000);
					
				// });
			
			
			return true;
			
			
		} else {   

			// alert(' Please select address');
			var msg = 'Please select address';
			  $('#Gift_card_msg').show();
			  $('#Gift_card_msg').css("color", "red");
			  $('#Gift_card_msg').html(msg);
			  setTimeout(function() {
					$('#Gift_card_msg').hide();
			  }, 3000);
			return false
		}
		return true;
	}
	</script>
	<style>
		.order-type-body .proceed-btn-wrap{
			    padding: 50px 0 10px;
		}
	</style>