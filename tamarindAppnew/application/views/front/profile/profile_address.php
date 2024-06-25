<?php 
$this->load->view('front/header/header');
// $this->load->view('front/header/menu'); 
?>
<?php
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
if($Current_point_balance<0){
	$Current_point_balance=0;
}else{
	$Current_point_balance=$Current_point_balance;
}  
$Photograph = $Enroll_details->Photograph;
	if($Photograph=="")
	{
		// $Photograph='images/No_Profile_Image.jpg';
		// $Photograph="images/dashboard_profile.png";
		$Photograph=base_url()."assets/images/profile.jpg";
		
	} else {
		
		$Photograph=$this->config->item('base_url2').$Photograph;
		
	}
?>
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url();?>index.php/Cust_home/myprofile"><span>Address Details</span></a>
				</div>
			</div>
		</div>
	</header>
		<div class="custom-body">
			<div class="container">
				<div class="profile-box">
					<div class="avtar sm">
						<img src="<?php echo $Photograph; ?>" />
					</div>
					<h2><?php echo ucwords($Enroll_details->First_name).' '.ucwords($Enroll_details->Last_name); ?></h2>
					<div class="point">
						<span><?php echo $Current_point_balance.'  '.$Company_Details->Currency_name; ?></span>
					</div>
				</div>
			</div>
			
			<div class="login-box">
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
				<?php  echo form_open_multipart('Cust_home/profile_address'); ?>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" onkeyup="validate(1);"  name="currentAddress1" id="currentAddress1"value="<?php echo $str_arr0; ?>" class="form-control" placeholder="Building / Estate" required >
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.968" height="15.967" viewBox="0 0 15.968 15.967"><g transform="translate(27.636 27.625) rotate(180)"><path d="M26.091,13.2a5.271,5.271,0,0,0-8.485,6l-5.5,5.5a.441.441,0,0,0-.124.248l-.311,2.175a.44.44,0,0,0,.5.5l2.176-.31a.439.439,0,0,0,.377-.435v-.8h.8a.439.439,0,0,0,.439-.439v-.8h.8a.439.439,0,0,0,.311-.129l3.012-3.012a5.271,5.271,0,0,0,6-8.485Zm-.621,6.836a4.406,4.406,0,0,1-5.247.727.442.442,0,0,0-.525.073l-3.111,3.11H15.526a.439.439,0,0,0-.439.439v.8h-.8a.439.439,0,0,0-.439.439v.862l-1.218.174.207-1.45L18.455,19.6a.439.439,0,0,0,.073-.525,4.393,4.393,0,1,1,6.942.968Z" transform="translate(0 0)" fill="#b7b7b7"/><path d="M58.512,22.581a1.758,1.758,0,1,0,2.485,0,1.8,1.8,0,0,0-2.485,0Zm1.864,1.864a.9.9,0,0,1-1.243,0,.879.879,0,1,1,1.243,0Z" transform="translate(-36.15 -8.134)" fill="#b7b7b7"/></g></svg>
						</div>
						<div class="line"></div>
						<div class="help-block_currentAddress1" style="float: center;"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" value="<?php echo $str_arr1; ?>" class="form-control" onkeyup="validate(2);" name="currentAddress2" id="currentAddress2" required placeholder="House Number / Floor"/>
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.366" height="16" viewBox="0 0 15.366 16"><g transform="translate(-6.783 -5)"><path d="M30.489,13.437A4.219,4.219,0,1,0,26.27,9.219,4.223,4.223,0,0,0,30.489,13.437Zm0-7.563a3.344,3.344,0,1,1-3.344,3.344A3.348,3.348,0,0,1,30.489,5.875Z" transform="translate(-16.023 0)" fill="#322210"/><path d="M14.466,59.355c-6.3,0-7.683,3.173-7.683,4.4a1.937,1.937,0,0,0,1.969,1.942H20.18a1.937,1.937,0,0,0,1.969-1.942C22.149,62.528,20.769,59.355,14.466,59.355Zm5.714,5.462H8.752A1.059,1.059,0,0,1,7.658,63.75c0-.914,1.251-3.52,6.808-3.52s6.808,2.607,6.808,3.52A1.059,1.059,0,0,1,20.18,64.817Z" transform="translate(0 -44.692)" fill="#322210"/></g></svg>
						</div>
						<div class="line"></div>
						<div class="help-block_currentAddress2" style="float: center;"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" value="<?php echo $str_arr2; ?>" class="form-control" onkeyup="validate(3);" name="currentAddress3" id="currentAddress3" required placeholder="Street / Road"/>
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.366" height="16" viewBox="0 0 15.366 16"><g transform="translate(-6.783 -5)"><path d="M30.489,13.437A4.219,4.219,0,1,0,26.27,9.219,4.223,4.223,0,0,0,30.489,13.437Zm0-7.563a3.344,3.344,0,1,1-3.344,3.344A3.348,3.348,0,0,1,30.489,5.875Z" transform="translate(-16.023 0)" fill="#322210"/><path d="M14.466,59.355c-6.3,0-7.683,3.173-7.683,4.4a1.937,1.937,0,0,0,1.969,1.942H20.18a1.937,1.937,0,0,0,1.969-1.942C22.149,62.528,20.769,59.355,14.466,59.355Zm5.714,5.462H8.752A1.059,1.059,0,0,1,7.658,63.75c0-.914,1.251-3.52,6.808-3.52s6.808,2.607,6.808,3.52A1.059,1.059,0,0,1,20.18,64.817Z" transform="translate(0 -44.692)" fill="#322210"/></g></svg>
						</div>
						<div class="line"></div>
						<div class="help-block_currentAddress3" style="float: center;"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" class="form-control" onkeyup="validate(4);" name="currentAddress4" id="currentAddress4" value="<?php echo $str_arr3; ?>" placeholder="Additional Details"/>
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="16.689" height="10.908" viewBox="0 0 16.689 10.908">
						  <g id="noun_envelope_309620" transform="translate(-0.7 -6)"><g id="Group_455" data-name="Group 455" transform="translate(0.7 6)"><path id="Path_159" data-name="Path 159" d="M16.953,16.908H1.136A.43.43,0,0,1,.7,16.471V6.382A.463.463,0,0,1,1.136,6H16.953a.43.43,0,0,1,.436.436v10.09A.421.421,0,0,1,16.953,16.908ZM1.573,16.09h15V6.818h-15Z" transform="translate(-0.7 -6)" fill="#b7b7b7"/></g><g id="Group_456" data-name="Group 456" transform="translate(10.941 10.949)"><rect id="Rectangle_294" data-name="Rectangle 294" width="7.744" height="0.818" transform="matrix(0.738, 0.675, -0.675, 0.738, 0.552, 0)" fill="#b7b7b7"/></g><g id="Group_457" data-name="Group 457" transform="translate(0.892 10.949)"><rect id="Rectangle_295" data-name="Rectangle 295" width="0.818" height="7.744" transform="matrix(0.675, 0.738, -0.738, 0.675, 5.714, 0)" fill="#b7b7b7"/></g><g id="Group_458" data-name="Group 458" transform="translate(0.734 6)"><path id="Path_160" data-name="Path 160" d="M9.073,13.526c-.109,0-.164-.055-.273-.109L.947,6.709a.365.365,0,0,1-.164-.436A.41.41,0,0,1,1.165,6H16.926a.41.41,0,0,1,.382.273.424.424,0,0,1-.109.436L9.346,13.417A.3.3,0,0,1,9.073,13.526ZM2.31,6.818,9.073,12.6l6.763-5.781Z" transform="translate(-0.762 -6)" fill="#b7b7b7"/></g></g>
						</svg>
						</div>
						<div class="line"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<select name="city" class="form-control" required >				
							<?php 
							foreach($City_array as $rec)
							{?>
								<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
							<?php } ?>	
						</select>
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="15.968" height="15.967" viewBox="0 0 15.968 15.967"><g transform="translate(27.636 27.625) rotate(180)"><path d="M26.091,13.2a5.271,5.271,0,0,0-8.485,6l-5.5,5.5a.441.441,0,0,0-.124.248l-.311,2.175a.44.44,0,0,0,.5.5l2.176-.31a.439.439,0,0,0,.377-.435v-.8h.8a.439.439,0,0,0,.439-.439v-.8h.8a.439.439,0,0,0,.311-.129l3.012-3.012a5.271,5.271,0,0,0,6-8.485Zm-.621,6.836a4.406,4.406,0,0,1-5.247.727.442.442,0,0,0-.525.073l-3.111,3.11H15.526a.439.439,0,0,0-.439.439v.8h-.8a.439.439,0,0,0-.439.439v.862l-1.218.174.207-1.45L18.455,19.6a.439.439,0,0,0,.073-.525,4.393,4.393,0,1,1,6.942.968Z" transform="translate(0 0)" fill="#b7b7b7"/><path d="M58.512,22.581a1.758,1.758,0,1,0,2.485,0,1.8,1.8,0,0,0-2.485,0Zm1.864,1.864a.9.9,0,0,1-1.243,0,.879.879,0,1,1,1.243,0Z" transform="translate(-36.15 -8.134)" fill="#b7b7b7"/></g></svg>
						</div>
						<div class="line"></div>
					</div>
				</div>
				
				
				<div class="submit-field">
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
					<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
					<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>">
					<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
					<input type="hidden" name="Password" value="<?php echo $Enroll_details->User_pwd; ?>">
					<button type="submit" class="submit-btn">Submit</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
<?php $this->load->view('front/header/footer');  ?>