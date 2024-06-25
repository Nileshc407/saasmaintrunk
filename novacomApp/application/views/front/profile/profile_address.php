<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile</title>	
<?php $this->load->view('front/header/header');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }

	$Photograph = $Enroll_details->Photograph;
	
	//$Photograph='qr_code_profiles/'.$enroll.'profile.png';
	
	if($Photograph=="")
	{
		// $Photograph='images/No_Profile_Image.jpg';
		$Photograph="images/dashboard_profile.png";
	}
?> 	
<!----Profile Completion Progress Bar---->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/profile-progress.css">
<style>
	.progress
	{
		background-image: url('<?php echo $this->config->item('base_url2').$Photograph; ?>');
	}
	.progress .progress-bar 
	{
	 
	 <?php  if (!empty($General_details[0]['Application_image_flag']=='yes')) 
			{ ?>
                color:#89CFF0;
<?php  		}
			else 
			{ ?>
			color:#89CFF0;
			 <!--color:<?php //echo $General_details[0]['Theme_color']; ?>;-->
	<?php   }    ?>;
	}
	.progress .progress-value
	{
	 
	     <?php  if (!empty($General_details[0]['Application_image_flag']=='yes')) 
			{ ?>
                color:#89CFF0;
<?php  		}
			else 
			{ ?>
				color:#89CFF0;
			 <!--color:<?php //echo $General_details[0]['Theme_color']; ?>;-->
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
	<?php   }    ?>;
	
	}
</style>
<!----Profile Completion Progress Bar---->
</head>
<body>    
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
    <div class="container">
        <div class="section-header ">    
			<p><a href="<?=base_url()?>index.php/Cust_home/profile" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Profile</p>
        </div>

        <div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
				<!----Profile Completion Progress Bar---->	
					<?php if($Customer_profile_status > 90 && $Customer_profile_status < 99)
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
				<!----Profile Completion Progress Bar---->
					<div class="pricing-details">
						<h2 id="Large_font"><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name;?></h2>
						
						<?php /***** Hide cahnge Ravi--24-09-2019------ <h2 id="Medium_font"><?php echo $Company_Details->Alise_name.' Id: '.$Enroll_details->Card_id;?></h2> 
							<h2 id="Medium_font"><?php echo $Tier_details->Tier_name.' Tier';?></h2> 
								----------Hide cahnge Ravi--24-09-2019-------********/ 
								
								/* maxlength="10" */
								
							
								// $str_arr = explode (",",$Enroll_details->Current_address);
								?>
						<strong>
							<span>
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/profile">Key Details</a>
							</span> |
							<span id="ud">
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/profile_address">Address </a>
							</span> |
							<span>
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/profile_other_details">Other Details</a>
							</span>
						</strong>
						<br>
						<table align="center" style="text-align: left;">
							<tr>
								<td><span id="Small_font">Estate/ Building No</span></td>
								<td id="tabbleTD" ><span id="Value_font">:<?php echo $str_arr0; ?></span></td>										  
							</tr>
							<tr>
								<td><span id="Small_font">House Number/ Floor</span></td>
								<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr1; ?></span></td>										  
							</tr>
							<tr>
								<td><span id="Small_font">Street/ Road</span></td>
								<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr2; ?></span></td>										  
							</tr>
							<tr>
								<td><span id="Small_font">Additional</span></td>
								<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr3; ?></span></td>										  
							</tr>
							<tr>
								<td><span id="Small_font">City</span></td>
								<td id="tabbleTD"><span id="Value_font">:<?php echo $Enroll_details->city_name; ?></span></td>										  
							</tr>
							<tr>
								<td><span id="Small_font">Country</span></td>
								<td id="tabbleTD"><span id="Value_font">:<?php echo $Enroll_details->country_name; ?></span></td>										  
							</tr>
						</table>
						<?php /*  ?><ul>
							<li id="Small_font">Estate/ Building No&nbsp;&nbsp;&nbsp;: 
								<font id="Value_font"><?php echo $str_arr[0]; ?></font>
							</li>
							<li id="Small_font">House Number/ Floor&nbsp;&nbsp;&nbsp;: 
								<font id="Value_font"><?php echo $str_arr[1]; ?></font>
							</li>
							<li id="Small_font">Street/ Road&nbsp;&nbsp;&nbsp;: 
								<font id="Value_font"><?php echo $str_arr[2]; ?></font>
							</li>
							<li id="Small_font">Additional&nbsp;&nbsp;&nbsp;: 
								<font id="Value_font"><?php echo $str_arr[3]; ?></font>
							</li>
							<li id="Small_font">City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
								<font id="Value_font"><?php echo $Enroll_details->city_name; ?></font>
							</li>
							<?php /*  ?><li id="Small_font">State &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
								<font id="Value_font"><?php echo $Enroll_details->state_name; ?></font>
							</li>
							<li id="Small_font">Country &nbsp;&nbsp;:
								<font id="Value_font"><?php echo $Enroll_details->country_name; ?></font>
							</li>
							
							<li id="Small_font">Zip Code&nbsp;:
								<font id="Value_font"><?php echo $Enroll_details->Zipcode; ?></font>
							</li>
							
							
							<li id="Small_font">
								<a href="<?php echo base_url();?>index.php/Cust_home/Issuance_details">
								<button type="submit" id="button" style="margin-left:-3%;">Issuance Details</button> </a>
								<a href="<?php echo base_url();?>index.php/Cust_home/Usage_details">
								<button type="submit" id="button" style="float:right; margin-right:-3%;" >Usage Details</button></a>  								
							</li>
							<?php  */?>
						</ul>
					</div>
					<div align="right">  
					  <a href="<?php echo base_url();?>index.php/Cust_home/Edit_profile" id="Small_font" ><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/edit.png" width="20" >Edit</a>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php $this->load->view('front/header/footer'); ?> 
<style>
	#icon {
		width: 21px;
		margin-top: 0%;
	}
	#ud{
		border-bottom: 1px solid #d8d5d5;
	}
	
	a {
		color: #7d7c7c;
	}
</style>