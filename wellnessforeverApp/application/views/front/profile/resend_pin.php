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
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/settings';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Resend Pin</h1></div>
				<div class="leftRight"><button></button></div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom passChanWrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
			<?php
					if(@$this->session->flashdata('error_code'))
					{
					?>
						<div class="alert bg-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
						</div>
					<?php
					}
				?>
                <!--<h1 class="text-center pb-4">Change password</h1>-->
                
				 <?php 
				 $data = array('onsubmit' => "return Change_password()");  
				echo form_open_multipart('Cust_home/send_pin', $data);?>
                    <div class="form-group">
					<label class="font-weight-bold">User Email</label>
                        <input type="text" class="form-control" readonly required="" name="User_email_id" id="User_email_id" value="<?php echo $User_email_id; ?>" required>
						<div class="help-block" style="float:center;"></div>
                    </div>
                    <div class="form-group">
					<label class="font-weight-bold">Phone Number</label>
                        <input type="text" class="form-control" readonly name="Phone_No"  id="txt" value="<?php echo $Phone_no; ?>" required>
						<div class="help-block2" style="float:center;"></div>
                    </div>                   
					<button type="submit" class="redBtn w-100 text-center mt-5">Send Pin</button>
			  <?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main> 

<?php $this->load->view('front/header/footer');  ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<!--Click to Show/Hide Input Password JS-->
	<script type="text/javascript">
/* 		
function send_pin()
{
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';				
	$.ajax
	({
		type: "POST",
		data:{Company_id:Company_id,Enrollment_id:Enrollment_id},
		url: "<?php echo base_url()?>index.php/Cust_home/send_pin",
		success: function(data)
		{	
			// location.reload(); 
		}
	});
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
	
	// document.Update_profile.submit();
} */
</script>