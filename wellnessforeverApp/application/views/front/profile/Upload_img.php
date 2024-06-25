<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu'); 

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
<div class="custom-body setting-body">
	<div class="container">
		<div class="profile-box">
			<div class="avtar">
				<img src="<?php echo $Photograph; ?>" alt="">
			</div>
			<h2><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></h2>
			<div class="point">
				<span><?php echo $Current_point_balance; ?> <?php echo $Company_Details->Currency_name; ?></span>
			</div>
		</div>
	</div>
	<div class="login-box mt-0">
		<div class="cart_list p-0">
			<form  name="Update_profile" method="POST" action="<?php echo base_url()?>index.php/Cust_home/Update_img" enctype="multipart/form-data" onsubmit="return form_submit();">	
			<div class="box p-0 mb-5">	
				<h2>Change profile picture</h2>
					<div class="upload-field">
						<div class="img" id="profile_pic">
							<img src="<?php echo $Photograph; ?>" id="image2" alt=""/>
						</div>
						<div class="upload_btn_set">
							<div class="upload_btn">
								<input type="file" name="image1" id="image1" onchange="readImage(this,'#image2');" required />
								<span class="btn btn-primary">Upload Photo</span>
							</div>
							<!--<a href="#" class="btn btn-primary btn-remove">Remove</a>-->
						</div>
						<h6>Max size 500kb.</h6>
					</div>
			</div>
			<div class="box p-0 mb-5">	
				<div class="submit-field">
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
					<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
					<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>">
					<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
					<button type="submit" class="submit-btn">Save</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<?php $this->load->view('front/header/footer');  ?>

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<script>
$(document).ready(function() 
{
	setTimeout(function(){ $('#msgBox').hide(); }, 3000);
});
function readImage(input,div_id) 
{
	document.getElementById('profile_pic').style.display="";
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$(div_id)
				.attr('src', e.target.result)
				.height(100);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>