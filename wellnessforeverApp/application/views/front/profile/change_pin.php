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
				<div><h1>Change Pin</h1></div>
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
                <p class="text-center">Enter your old Pin below and enter new Pin to change your Pin</p>
				 <?php 
				 $data = array('onsubmit' => "return Change_pin('old_pin.value,new_pin.value,confirm_pin.value');");  
				echo form_open_multipart('Cust_home/changepin', $data);?>
                    <div class="form-group">
					<label class="font-weight-bold">Old Pin</label>
                        <input type="password" class="form-control" name="old_pin" id="old_pin" placeholder="Enter old pin" required=""maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')" required>
						<div class="help-block" style="float:center;"></div>
                    </div>
                    <div class="form-group">
					<label class="font-weight-bold">New Pin</label>
                        <input type="password" class="form-control" name="new_pin" id="new_pin" placeholder="Enter new pin" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')"required>
						<div class="help-block1" style="float:center;"></div>
						
                    </div>
                    <div class="form-group">
					<label class="font-weight-bold">Confirm Pin</label>
                        <input type="password" class="form-control" name="confirm_pin" id="confirm_pin" placeholder="Enter confirm pin" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')" required>
						<div class="help-block2" style="float:center;"></div>
                    </div>
                    <!--<a href="javascript:Change_password()" onclick="document.getElementById('Updatepassword').submit();" class="redBtn w-100 text-center mt-5">Submit</a>-->
					<button type="submit" class="redBtn w-100 text-center mt-5">Submit</button>
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
		
$(document).ready(function() {
  $("#showHide").click(function() {
	if ($("#new_pin").attr("type") == "password") {
      $("#new_pin").attr("type", "text");

    } else {
      $("#new_pin").attr("type", "password");
    }
  });
});
$('#old_pin').blur(function()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var old_pin = $('#old_pin').val();
	
	if( $("#old_pin").val() == "" )
	{
		var msg = 'Old Pin does not Match.';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { old_pin: old_pin, Company_id:Company_id,Enrollment_id: Enrollment_id},
			url: "<?php echo base_url()?>index.php/Cust_home/checkoldpin",
			success: function(data)
			{			
				if(data == 0)
				{
					$("#old_pin").val("");
					var msg1 = 'Pin not Match..Please Enter Correct Pin';
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
function Change_pin(old_pin,new_pin,confirm_pin)
{
	
	if( $('#old_pin').val() == "")
	{
		var msg = 'Please enter old Pin.';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	else if( $('#new_pin').val() !=  $('#confirm_pin').val())
	{
		$('#confirm_pin').val('');
		var msg = 'Confirm Pin should be same as New Pin.';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
		return false;
	}
	else if($('#new_pin').val() == "" && $('#confirm_pin').val() == "")
	{
		var msg = 'New Pin should not be blank.';
		$('.help-block2').show();
		$('.help-block2').css("color","red");
		$('.help-block2').html(msg);
		setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		return false;
	}
	else 
	{
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
		
		// document.Change_Pin.submit();
	}
}
	</script>