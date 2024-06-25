<?php $this->load->view('front/header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}		
$Photograph = $Enroll_details->Photograph;
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}
?> 
<header>
	<div class="container">
		<div class="text-center">
			<div class="back-link">
				<a href="<?php echo base_url();?>index.php/Cust_home/front_home"><span>Settings</span></a>
			</div>
		</div>
	</div>
</header>
<div class="custom-body setting-body">
	<div class="container">
		<!--<div class="s_box mb-3">
			<form>
				<div class="field">
					<div class="icon">
						<img src="<?php echo base_url()?>/assets/images/search-icon.svg" alt="">
					</div>
					<input type="text" placeholder="Search">
				</div>
			</form>
		</div>-->
		<div class="profile-box">
			<div class="avtar">
				<img src="<?php echo $Photograph; ?>" alt="">
			</div>
			<h2><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></h2>
			<!--<h4><?php //echo $Trans_details->Tier_name; ?>Platinum Member</h4>-->
		</div>
	</div>
	<div class="login-box mt-0">
		<div class="cart_list p-0">
			<!--<div class="box p-0 mb-5">	
				<h2>Change profile picture</h2>
				<form>
					<div class="upload-field">
						<div class="img">
							<img src="<?php echo $Photograph; ?>" alt=""/>
						</div>
						<div class="upload_btn_set">
							<div class="upload_btn">
								<input type="file" />
								<span class="btn btn-primary">Upload Photo</span>
							</div>
							<a href="#" class="btn btn-primary btn-remove">Remove</a>
						</div>
						<h6>Max size 2mb.</h6>
					</div>
				</form>
			</div>-->
			<div class="box p-0 mb-5">	
				<h2>Notification Preferences</h2>
				<ul class="swith-list">
					<li>
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" name="onoffswitch" id="myonoffswitch" <?php if($Enroll_details->Communication_flag ==1){ ?> checked <?php } ?> >
							<label class="custom-control-label" for="myonoffswitch">Allow Offers & Marketing Notifications</label>
							<span class="onoffswitch-inner" style="display:block;"></span>
								<span class="onoffswitch-switch"></span>
						</div>
					</li>
					<!--<li>
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="customSwitch3">
							<label class="custom-control-label" for="customSwitch3">New Coupons Notifications</label>
						</div>
					</li>
					<li>
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="customSwitch2">
							<label class="custom-control-label" for="customSwitch2">Weekly Newsletter</label>
						</div>
					</li>-->
				</ul><br>
				<div id="Notification_Div"></div>
			</div>
			
			<!--<div class="box p-0">	
				<h2>Notification Preferences</h2>
				<ul class="swith-list">
					<li>
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="customSwitch4">
							<label class="custom-control-label" for="customSwitch4">Lorem Ipsum Dolor</label>
						</div>
					</li>
					<li>
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="customSwitch5">
							<label class="custom-control-label" for="customSwitch5">Sit Amet</label>
						</div>
					</li>
					<li>
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="customSwitch6">
							<label class="custom-control-label" for="customSwitch6">Lorem Ipsum Dolor</label>
						</div>
					</li>
				</ul>
			</div>-->
		</div>
	</div>
</div>
<?php $this->load->view('front/header/footer');  ?>		
<script>
 $(document).ready(function(){
	 
	 var Comm_flag=0;
	$('input[type="checkbox"]').click(function(){
		if($(this).prop("checked") == true){
			$.ajax({
					type: "POST",
					data: {Comm_flag:1},
					url:"<?php echo base_url(); ?>index.php/Cust_home/allow_communication",
					success: function(data)
					{					
						// console.log(data);
						$("#Notification_Div").html("Your have activated to receive Offers & Marketing Notifications");
						
						// myApp.alert('Your hav Activate Send/Receive Communication ', 'Information');
						
					}
				});

		} else if($(this).prop("checked") == false){
				$.ajax({
							type: "POST",
							data: {Comm_flag:0},
							url:"<?php echo base_url(); ?>index.php/Cust_home/allow_communication",
							success: function(data)
							{				
								$("#Notification_Div").html("Your have de-activated to receive Offers & Marketing Notifications");
								// console.log(data);
								// myApp.alert('Your hav Activate Send/Receive Communication ', 'Information');
								
							}
					});

		}
		
		setTimeout(function() {
			$("#Notification_Div").html("");
		}, 3000);
		
	});
});

$("#myonoffswitch").on('change', 'input', function() 
{ 
	console.log('change');
	/* var Comm_flag=0;
	if ($$(this)[0].checked === true) 
	{
		$$('.allowDisable').addClass('disabled'); 
	
					$$.ajax({
								type: "POST",
								data: { EnrollId: $$('#Enrollement_id').val(), Companyid:$$('#Company_id').val(),Comm_flag:1},
								url: Base_url+"index.php/Cust_home/allow_communication",
								success: function(data)
								{						
									myApp.alert('Your hav Activate Send/Receive Communication ', 'Information');
									
								}
							});


		
	} 
	else 
	{ 
					$$('.allowDisable').removeClass('disabled'); 
					$$.ajax({
								type: "POST",
								data: { EnrollId: $$('#Enrollement_id').val(), Companyid:$$('#Company_id').val(),Comm_flag:0},
								url: Base_url+"index.php/Cust_home/allow_communication",
								success: function(data)
								{						
									myApp.alert('Your have De-activated Send/Receive Communication ', 'Information');
									
								}
							});
		
	} */	
})
</script>