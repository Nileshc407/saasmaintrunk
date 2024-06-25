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
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/front_home';"><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Set Password</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
            <div class="col-12 px-0 settingWrapper">
                <ul class="settingMenu">
                    <li class="redTxt"><b>General Settings</b></li>
                    <li>
                        <a class="w-100" href="<?php echo base_url();?>index.php/Cust_home/profile">
                            <div class="d-flex align-items-center">
                                <div class="titleTxtMain">Edit Profile</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="w-100" href="<?php echo base_url();?>index.php/Cust_home/changepassword">
                            <div class="d-flex align-items-center">
                                <div class="titleTxtMain">Change Password</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
					<!--<li>
                        <a class="w-100" href="<?php echo base_url()?>index.php/Cust_home/send_pin">
                            <div class="d-flex align-items-center">
                                <div class="titleTxtMain">Send Pin</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
					<li>
                        <a class="w-100" href="<?php echo base_url()?>index.php/Cust_home/Load_Change_Pin">
                            <div class="d-flex align-items-center">
                                <div class="titleTxtMain">Change Pin</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>-->
                    <li>
                        <div class="d-flex align-items-center w-100">
                            <div class="titleTxtMain">Notifications</div>
                            <div class="ml-auto">
                                <label class="switch">
                                    <input type="checkbox" name="onoffswitch" id="myonoffswitch" <?php if($Enroll_details->Communication_flag ==1){ ?> checked <?php } ?>>
                                    <span class="slider round"></span>
                                </label>
								<span class="onoffswitch-inner" style="display:block;"></span>
								<span class="onoffswitch-switch"></span>
                            </div>
                        </div>
                    </li>
					<div id="Notification_Div"></div>
                </ul>

                <ul class="settingMenu">
                    <li class="redTxt"><b>Support</b></li>
                    <li>
                        <a class="w-100" href="<?php echo base_url();?>index.php/Cust_home/terms_conditions">
                            <div class="d-flex align-items-center">
                                <div class="titleTxtMain">Terms & Conditions</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="w-100" href="<?php echo base_url();?>index.php/Cust_home/privacy_policy">
                            <div class="d-flex align-items-center">
                                <div class="titleTxtMain">Privacy Policy</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="w-100" href="<?php echo base_url();?>index.php/Cust_home/signout">
                            <div class="d-flex align-items-center">
                                <div class="titleTxtMain">Signout</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                </ul>

            </div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>	
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