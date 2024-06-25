<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile</title>	
<?php $this->load->view('front/header/header'); 
	// $Photograph = $Enroll_details->Photograph;
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	
	$this->load->view('front/header/header');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
$icon_src="black";

	// $Photograph='qr_code_profiles/'.$enroll.'profile.png';
	$Photograph=$Enroll_details->Photograph;
	
	
	// echo "----Photograph-----".$Photograph."---<br>";
	
	if($Photograph=="")
	{
		// $Photograph='images/No_Profile_Image.jpg';
		// $Photograph="images/dashboard_profile.png";
		$Photograph=base_url()."images/User2.png";
		
	} else {
		
		$Photograph=$this->config->item('base_url2').$Photograph;
		
	}
?>
<!----Profile Completion Progress Bar---->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/profile-progress.css">
<style>
	.progress
	{
            background-image: url('<?php echo $Photograph; ?>');
	}
	.pricing-table .pricing-details span
	{
	 
	<?php  	if (!empty($General_details[0]['Application_image_flag']=='yes')) 
			{ ?>
                color:#89CFF0;
	<?php  	}
			else 
			{ ?>
				color:#89CFF0;
				<!--color:<?php //echo $General_details[0]['Theme_color']; ?>;-->
	<?php   }    ?>;
	}
	.pricing-table .pricing-details span
	{
	 
	     <?php  if (!empty($General_details[0]['Application_image_flag']=='yes')) 
			{ ?>
                color:#89CFF0;
<?php  		}
			else 
			{ ?>
				color:#89CFF0;
				<!-- color:<?php // echo $General_details[0]['Theme_color']; ?>;-->
	<?php   }    ?>;
	}
	#Complet_val
	{	
	     <?php  if (!empty($General_details[0]['Application_image_flag']=='yes')) 
			{ ?>
                color:#89CFF0;
<?php  		}
			else 
			{ ?>
				color:#89CFF0;			
			 <!--color:<?php //echo $General_details[0]['Theme_color']; ?>;-->
	<?php   }  ?>;	
	}
</style>
<!----Profile Completion Progress Bar----> 
</head>	
<body>
<?php $this->load->view('front/header/menu'); ?>
<form  name="Update_profile" method="POST" action="<?php echo base_url()?>index.php/Cust_home/updateprofile" enctype="multipart/form-data" onsubmit="return form_submit();">	
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
    <div class="container">
        <div class="section-header ">    
			<!--<p><a href="<?=base_url()?>index.php/Cust_home/profile" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/back.png" id="arrow"></a></p>-->
			<p id="Extra_large_font" style="margin-left: -3%;">Edit Profile</span>
        </div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">      
				<div class="pricing-details"> 
					
						<!----Profile Completion Progress Bar---->
									
						<?php 
							if($Customer_profile_status > 90 && $Customer_profile_status < 99)
							{
								$Customer_profile_status = 90;
							}
							else
							{
								$Customer_profile_status = ceil($Customer_profile_status / 10) * 10; 
							}

						?>
						 <div class="progress-value">
							<div id="Complet_val" style="font-size:11px;">
								<?php echo $Customer_profile_status.'%'; ?>
							</div>
						</div>	
						<div class="col-md-12">
							<div class="progress" data-percentage="<?php echo $Customer_profile_status; ?>">
								<span class="progress-left">
									<span class="progress-bar"></span>
								</span>
								<span class="progress-right">
									<span class="progress-bar"></span>
								</span>
							</div>
						</div>
						
				<!----Profile Completion Progress Bar--->
						<br> <input type="file" name="image1" id="image1" style="margin-left: 24px;"/>
                                                <br>
                                                <br> <span  id="Small_font">Image should be less than dimension 1000 X 1000 pixels!! </span>
					<ul> 
						<li align="left" id="Small_font" class="text-left"><br/>							
							<strong id="Value_font">
								<input type="text" name="firstName" id="firstName" placeholder="Enter first name" class="txt"  value="<?php echo $Enroll_details->First_name?>" onkeyup="validate(5);" autocomplete="off">
							</strong>	
							<div class="help-block3" style="float: center;"></div>							
						</li>	
						<?php /* ?>							
						<li align="left" id="Small_font" class="text-left"><br/>						
							<strong id="Value_font">
								<input type="text" name="middleName" placeholder="Enter middle name" class="txt"  value="<?php echo $Enroll_details->Middle_name?>" onkeyup="this.value=this.value.replace(/[0-9]+/g, '')" autocomplete="off">
							</strong>						
						</li>
						onkeyup="this.value=this.value.replace(/[0-9]+/g, '')"
							<?php */ ?>	
						<li align="left" id="Small_font" class="text-left"><br/>					
							<strong id="Value_font">
								<input type="text" name="lastName" id="lastName" placeholder="Enter last name" class="txt"  value="<?php echo $Enroll_details->Last_name?>" onkeyup="validate(6);"  autocomplete="off">
							</strong>
						<div class="help-block4" style="float: center;"></div>							
						</li> 
						<li align="left" id="Small_font" class="text-left"><br/>						
							<strong id="Value_font">
								<input type="text" name="Profession" placeholder="Enter profession" class="txt"  value="<?php echo $Enroll_details->Qualification?>" onkeyup="this.value=this.value.replace(/[0-9]+/g, '')" autocomplete="off">
							</strong> 						
						</li>
						<?php /* ?>							
						
											
						<li align="left" id="Small_font" class="text-left"> 
							<span style="font-size: 12px; font-style: italic; color: red;">(In Years)</span><br/>
							<strong id="Value_font">
								<input type="tel" name="Experience" placeholder="Enter experience" class="txt"  value="<?php echo $Enroll_details->Experience?>" onkeyup="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
							</strong>
						</li>
						<?php */ ?>						
						<li align="left" id="Small_font" class="text-left"> <br/>					
							<strong id="Value_font">
								<input type="email" name="userEmailId" placeholder="Enter email" class="txt" id="userEmailId" value="<?php echo $User_email_id; ?>" autocomplete="off">
							</strong>
								<div class="help-block" style="float: center;"></div>
						</li>				
						<li align="left" id="Small_font" class="text-left">
							<span style="font-size: 9px; font-style: italic; color: red;">(Enter Phone No without Dial Code)</span><br/>						
							<strong id="Value_font">
								<input type="tel" name="phno" placeholder="Enter phone no." class="txt" id="phno" value="<?php echo $phnumber; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="9" autocomplete="off">
							</strong> 
							<div class="help-block1" style="float: center;"></div>
						</li>
						<?php 
							// $str_arr = explode(",",$Enroll_details->Current_address);						
						?>
						<li align="left" id="Small_font" class="text-left"> <br/>						
							<strong id="Value_font">  
								<textarea class="txt"  rows="2" cols="50" maxlength="32" onkeyup="validate(1);"  name="currentAddress1" id="currentAddress1" placeholder="Estate/ Building No" ><?php echo $str_arr0; ?></textarea>
							</strong>
							<div class="help-block_currentAddress1" style="float: center;"></div>
						</li>
						<li align="left" id="Small_font" class="text-left"> <br/>						
							<strong id="Value_font">  
								<textarea class="txt"  rows="2" cols="50" maxlength="32" onkeyup="validate(2);" name="currentAddress2" id="currentAddress2" placeholder="House Number/ Floor" ><?php echo $str_arr1; ?></textarea>
							</strong>
							<div class="help-block_currentAddress2" style="float: center;"></div>
						</li>
						<li align="left" id="Small_font" class="text-left"> <br/>						
							<strong id="Value_font">  
								<textarea class="txt"  rows="2" cols="50" maxlength="32" onkeyup="validate(3);" name="currentAddress3" id="currentAddress3" placeholder="Street/ Road" ><?php echo $str_arr2; ?></textarea>
							</strong>
							<div class="help-block_currentAddress3" style="float: center;"></div>
						</li>
						<li align="left" id="Small_font" class="text-left"> <br/>						
							<strong id="Value_font">  
								<textarea class="txt"  rows="2" cols="50" maxlength="32"  onkeyup="validate(4);" name="currentAddress4" id="currentAddress4" placeholder="Additional" ><?php echo $str_arr3; ?></textarea>
							</strong>
						</li>
						
						<li align="left" id="Small_font" class="text-left"><br/>						
							<strong id="Value_font">
								<select  name="country" class="txt"  onchange="Get_states(this.value);">								
									<option value="<?php echo $Enroll_details->Country;?>"><?php echo $Enroll_details->country_name;?></option>						
								</select>
							</strong>
						</li>					
						<li align="left" id="Small_font" class="text-left"><br/>
							<strong id="Show_States" class="Value_font">
								<strong>
									<select class="txt"  name="state" onchange="Get_cities(this.value);">
								<?php 
										foreach($States_array as $rec)
										{?>
											<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
								<?php 	} ?>	
									</select>
								</strong>
							</strong> 
						</li>					
						<li align="left" id="Small_font" class="text-left"><br/>
							<strong id="Show_Cities" class="Value_font"> 
								<strong>
									<select name="city" class="txt" >				
									<?php 
										foreach($City_array as $rec)
										{?>
											<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
								  <?php } ?>	
									</select>
								</strong> 
							</strong>
						</li>
					<?php /* ?>							
						<li align="left" id="Small_font" class="text-left"><br/>							
							<strong id="Value_font">
								<input type="text" name="district" placeholder="Enter district" class="txt"  value="<?php echo $Enroll_details->District; ?>" onkeyup="this.value=this.value.replace(/[0-9]+/g, '')" autocomplete="off">
							</strong>
						</li>
					<?php */ ?>	
					
					<?php /* ?>							
						<li align="left" id="Small_font" class="text-left"><br/>						
							<strong id="Value_font">
								<input type="tel" name="zip" placeholder="Enter zip code" class="txt"  value="<?php echo $Enroll_details->Zipcode; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="6" autocomplete="off">
							</strong>
						</li>
						<?php */ ?>		
						<li align="left" id="Small_font" class="text-left"><br/>						
							<strong id="Value_font">
							
									<?php 
								
									if($Enroll_details->Date_of_birth != "" ) {
									?>
										<input class="txt" id="datepicker1" name="dob" readonly value="<?php echo date('d-M-Y', strtotime($Enroll_details->Date_of_birth));; ?>" placeholder="Date of birth" onchange="Change_anniversary_date(this.value);">
										
									<?php	} else {
									?>										
										<input class="txt" id="datepicker1" name="dob" onchange="Change_anniversary_date(this.value);"  
										 readonly placeholder="Date of birth">							
									<?php }									
									// echo"---Date_of_birth----".$Date_of_birth."--<br>";

									?>
								
							</strong>
							<div class="help-block_dob" style="float: center;"></div>
						</li>					
											
						<li align="left" id="Small_font" class="text-left"><br/>
							<strong id="Value_font" >
							  <select class="txt" name="Sex">
									<option value="">Select Gendar</option>
									
									<?php if($Enroll_details->Sex=='Male') 
									{ 
									?>	
										<option selected value="Male">Male</option> 
										<option value="Female" >Female</option>
									<?php  
									} 										
									else if($Enroll_details->Sex=='Female') 
									{
									?>										
										<option  value="Male">Male</option> 
										<option value="Female" selected >Female</option>
									<?php 
									}
									else 
									{
									?>
										<option  value="Male">Male</option> 
										<option value="Female" >Female</option>
									<?php 
									}											
									?>						
								</select>
							</strong> 
						</li>					
						<li align="left" id="Small_font" class="text-left"><br/>					
							<strong id="Value_font">
								<select class="txt"  name="Marital_status" onchange="hide_anniversary(this.value);">
									<option value="">Select Marital Status</option>
									
									<?php if($Enroll_details->Married=='Single') 
									{ 
									?>	
										<option selected value="Single">Single</option> 
										<option value="Married" >Married</option>
									<?php  
									} 										
									else if($Enroll_details->Married=='Married') 
									{
									?>										
										<option value="Married" selected>Married</option>
										<option value="Single">Single</option> 
									<?php 
									}
									else 
									{
									?>
										<option value="Married" >Married</option>
										<option value="Single">Single</option> 
									<?php 
									}											
									?>						
								</select>
							</strong> 
						</li>
						<div id="annversary_div">
						<li align="left" id="Small_font" class="text-left"><br/>						
							<strong id="Value_font">
							
								<?php 
								
									if($Enroll_details->Wedding_annversary_date != "" ) {
									?>
										<input class="txt" id="datepicker2" name="Wedding_annversary_date" readonly value="<?php echo date('d-M-Y', strtotime( $Enroll_details->Wedding_annversary_date)); ?>" placeholder="Anniversary Date">
										
									<?php	} else {
									?>										
										<input class="txt" id="datepicker2" name="Wedding_annversary_date" readonly placeholder="Anniversary Date">							
									<?php }									
										//echo"---Date_of_birth----".$Date_of_birth."--<br>";

									?>
									
								
							</strong>
							<div class="help-block_ann" style="float: center;"></div>
						</li>
						</div>
					</ul>		
					<?php if($Profile_complete_flag==1 && $Customer_profile_status!=100) { ?>
						<h4 class="text-center" id="Large_font">Complete Profile Status 100% and Get <?php echo round($Profile_complete_points); ?> <?php echo $Company_Details->Currency_name; ?>.</h4>
					<?php } ?>					
			</div>
			
			<?php 
				
				$Cust_min_age=$Company_Details->Cust_min_age;
				if($Cust_min_age != ""){
					$Cust_min_age= $Cust_min_age;
				} else {
					$Cust_min_age=18;
				}
			
				
				if($Enroll_details->Date_of_birth != ""){
					$Date_of_birth= date('Y', strtotime($Enroll_details->Date_of_birth));
					$today_DOB = date('Y');
					$yearDiff= $today_DOB - $Date_of_birth;
					$yearDiff_1 = $yearDiff - $Cust_min_age;
					$time = strtotime("-$yearDiff_1 year", time());
					$dateYear = date("Y", $time);
				}
				
			?>
				
				
				
				
				
				<button type="submit" id="button">Update</button>
				
				<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
				<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
				<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>">
				<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
				<input type="hidden" name="Password" value="<?php echo $Enroll_details->User_pwd; ?>">			
            </div>
		</div>	 
	</div>
	</div>
</div>
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
<form>
<?php $this->load->view('front/header/footer'); ?> 
<style>	
	
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		
		width: 100%;
		margin-left: 0%;
		border-radius:0px;
	}
	.txt{
		border-left: none;
		border-left: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		
		width: 100%;
		margin-left: 0%;
		border-radius:0px;
	}
	
	#datepicker1
	{
		color:<?=$Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?=$Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?=$Value_font_details[0]['Value_font_size']; ?>
	}
	#datepicker2
	{
		color:<?=$Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?=$Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?=$Value_font_details[0]['Value_font_size']; ?>
	}
	::-moz-placeholder {
    color:<?php echo $Placeholder_font_details[0]['Placeholder_font_color'];?>;
    font-family:<?php echo $Placeholder_font_details[0]['Placeholder_font_family'];?>;
    font-size:<?php echo $Placeholder_font_details[0]['Placeholder_font_size'];?>;
    opacity: 1;
		/* Firefox */
	}
	::-webkit-input-placeholder {
    color:<?php echo $Placeholder_font_details[0]['Placeholder_font_color'];?>;
    font-family:<?php echo $Placeholder_font_details[0]['Placeholder_font_family'];?>;
    font-size:<?php echo $Placeholder_font_details[0]['Placeholder_font_size'];?>;
    opacity: 1;
		/* Chrome */
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">


function Change_anniversary_date(dobDate){
	
	console.log(dobDate);	
	var DOBarr = dobDate.split('/');	
	console.log(DOBarr[2]);
	var Anniversary =parseInt(DOBarr[2]) + parseInt(18);
	console.log(Anniversary);
	var Year= new Date().getFullYear();	
	$( "#datepicker2" ).datepicker({      
		changeMonth: true,	   
		yearRange: ''+Anniversary+':'+Year+'',
		changeYear: true
    });
}

		


 $(function() {
  
    $( "#datepicker1" ).datepicker({
      changeMonth: true,
	   // yearRange: "-90:-16",
	   yearRange: "-70:-<?php echo $Company_Details->Cust_min_age; ?>",
      changeYear: true
    });
	
	
	/* $( "#datepicker2" ).datepicker({
      changeMonth: true,	   
	   yearRange: '<?php echo $dateYear; ?>:<?php echo $today_DOB; ?>',
      changeYear: true
    }); */
	
	var DOB='<?php echo $Date_of_birth; ?>';	
	if(DOB) {
		
		var AnniversaryYear =parseInt(DOB) + parseInt(18);	
		var Year= new Date().getFullYear();
		
		$( "#datepicker2" ).datepicker({		  
			changeMonth: true,	   
			yearRange: ''+AnniversaryYear+':'+Year+'',
			changeYear: true
		});
	}
	
  });
</script>
<script>
function hide_anniversary(InputVal){	
	if(InputVal=='Single'){
		
		$('#annversary_div').css('display','none');
		
	} else{
		$('#annversary_div').css('display','block');
	}
}
function validate(inputID) {
	
	if(inputID==1){
		var element = document.getElementById('currentAddress1');
	} 
	if(inputID==2){
		var element = document.getElementById('currentAddress2');
	}
	if(inputID==3){
		var element = document.getElementById('currentAddress3');
	}
	if(inputID==4){
		var element = document.getElementById('currentAddress4');
	}
	if(inputID==5){
		var element = document.getElementById('firstName');
	}if(inputID==6){
		var element = document.getElementById('lastName');
	}    
    element.value = element.value.replace(/[^a-zA-Z0-9 ]+/, '');	
};

function IsAlphaNumeric(e) {	
            var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >=48 && k <= 57));
}

function form_submit()
{
	
	
	var userEmailId = $('#userEmailId').val();
	var currentAddress1 = $('#currentAddress1').val();
	var currentAddress2 = $('#currentAddress2').val();
	var currentAddress3 = $('#currentAddress3').val();
	var phno = $('#phno').val();	
	if( $("#currentAddress1").val() == "" )
	{	  
		
		var msg1 = 'Please Enter Estate/ Building No';
		$('.help-block_currentAddress1').show();
		$('.help-block_currentAddress1').css("color","red");
		$('.help-block_currentAddress1').html(msg1);
		setTimeout(function(){ $('.help-block_currentAddress1').hide(); }, 3000);
		$( "#currentAddress1" ).focus();
		return false;
	}
	if( $("#currentAddress2").val() == "" )
	{	  
		var msg1 = 'Please Enter House Number/ Floor';
		$('.help-block_currentAddress2').show();
		$('.help-block_currentAddress2').css("color","red");
		$('.help-block_currentAddress2').html(msg1);
		setTimeout(function(){ $('.help-block_currentAddress2').hide(); }, 3000);
		$( "#currentAddress2" ).focus();
		return false;
	}
	if( $("#currentAddress3").val() == "" )
	{	  
		var msg1 = 'Please Enter Street/ Road';
		$('.help-block_currentAddress3').show();
		$('.help-block_currentAddress3').css("color","red");
		$('.help-block_currentAddress3').html(msg1);
		setTimeout(function(){ $('.help-block_currentAddress3').hide(); }, 3000);
		$( "#currentAddress3" ).focus();
		return false;
	}
	if( $("#firstName").val() == "" )
	{	  
		var msg1 = 'Please Enter first Name';
		$('.help-block3').show();
		$('.help-block3').css("color","red");
		$('.help-block3').html(msg1);
		setTimeout(function(){ $('.help-block3').hide(); }, 3000);
		$( "#firstName" ).focus();
		return false;
	}
	if( $("#lastName").val() == "" )
	{	
		var msg1 = 'Please Enter last Name';
		$('.help-block4').show();
		$('.help-block4').css("color","red");
		$('.help-block4').html(msg1);
		setTimeout(function(){ $('.help-block4').hide(); }, 3000);
		$( "#lastName" ).focus();
		return false;
	}
	if( $("#userEmailId").val() == "" )
	{	
		var msg1 = 'Please Enter Email Id';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		$( "#userEmailId" ).focus();
		return false;
	}
	if( ValidateEmail($("#userEmailId").val()) == false )
	{	
		var msg1 = 'Please Enter Valid Email Id';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		$( "#userEmailId" ).focus();
		return false;
	}
	if( $("#phno").val() == "" )
	{
		var msg1 = 'Please Enter Phone Number';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg1);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
		$( "#phno" ).focus();
		return false;
	}
	if (phno.length < 9 || phno.length > 9) {
		
		var msg1 = 'Please Valid Phone Number';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg1);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
		$( "#phno" ).focus();
		return false;
		
		
	}
	if( $("#datepicker1").val() == "" || $("#datepicker1").val() == "0000-00-00 00:00:00" || $("#datepicker1").val() == "1970-01-01 00:00:00" )
	{
		var msg1 = 'Please select Date of birth';
		$('.help-block_dob').show();
		$('.help-block_dob').css("color","red");
		$('.help-block_dob').html(msg1);		
		setTimeout(function(){ $('.help-block_dob').hide(); }, 3000);
		$( "#datepicker1" ).focus();
		return false;
	}
	// console.log($("#datepicker1").val());
	// console.log($("#datepicker2").val());
	var DOB_year = $("#datepicker1").val(); 
	var Anni_year = $("#datepicker2").val(); 
	
		// var myString = "23/05/2013";
		var DOBarr = DOB_year.split('/');
		var Anniarr = Anni_year.split('/');		
		
		
		var Cust_min_age=<?php echo $Company_Details->Cust_min_age; ?>;		
		var Anniversary =parseInt(DOBarr[2]) + parseInt(Cust_min_age);
		if(Anniarr[2] < Anniversary ){
			
			var msg1 = 'Anniversary date should be greater than  '+Cust_min_age+' years from Date of birth';
			$('.help-block_ann').show();
			$('.help-block_ann').css("color","red");
			$('.help-block_ann').html(msg1);		
			setTimeout(function(){ $('.help-block_ann').hide(); }, 3000);
			$( "#datepicker2" ).focus();
			return false;
		}
		
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
	
	// document.Update_profile.submit();
}

function Get_states(Country_id)
{
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url()?>index.php/Cust_home/Get_states",
		success: function(data)
		{
			$("#Show_States").html(data.States_data);			
		}
	});
}

function Get_cities(State_id)
{
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo base_url()?>index.php/Cust_home/Get_cities",
		success: function(data)
		{
			$("#Show_Cities").html(data.City_data);			
		}
	});
}
function ValidateEmail(mail) 
{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
	{
		return true;
	}
    //alert("You have entered an invalid email address!");
	
	var msg1 = 'Please enter valid email id';
	$('.help-block').show();
	$('.help-block').css("color","red");
	$('.help-block').html(msg1);
	setTimeout(function(){ $('.help-block').hide(); }, 3000);
    return false;
}
$('#userEmailId').change(function()
{	
	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var userEmailId = $('#userEmailId').val();
	
	var validEmailId=ValidateEmail(userEmailId);
	// alert(validEmailId);
	// return false;
	if( $("#userEmailId").val() == "" || validEmailId == false)
	{	
		// alert(validEmailId);
		var msg1 = 'Please Enter Email Id';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { userEmailId: userEmailId, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Cust_home/check_email_id",
			success: function(data)
			{				
				if(data == 0)
				{
					$("#userEmailId").val("");					
					var msg1 = 'Email Id Already Exist!';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
				}
				else
				{
					
				}
			}
		});
	}
});

$('#phno').change(function()
{	
	var Country = '<?php echo $Enroll_details->Country; ?>';
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var phno = $('#phno').val();
	
	if( $("#phno").val() == "" )
	{		
		var msg1 = 'Please Enter Phone Number';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg1);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { phno: phno,Company_id:Company_id, Country:Country},
			url: "<?php echo base_url()?>index.php/Cust_home/check_phone_number",
			success: function(data)
			{				
				if(data == 0)
				{
					$("#phno").val('')
					
					var msg1 = 'Phone Number Already Exist!';
					$('.help-block1').show();
					$('.help-block1').css("color","red");
					$('.help-block1').html(msg1);
					setTimeout(function(){ $('.help-block1').hide(); }, 3000);
				}
				else
				{					
				}
			}
		});
	}
});

/************************************************************************/	
</script>

