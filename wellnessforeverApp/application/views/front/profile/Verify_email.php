<?php $this->load->view('front/header/header'); ?>
	
	<header>
		<div class="container">
			<div class="row">
				<div class="col-12" style="height: 22px;"></div>
				<div class="col-12 d-flex justify-content-between align-items-center hedMain">
					<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/myprofile';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
					<div><h1>Confirm Email</h1></div>
					<div class="leftRight"><!--<button><img src="<?php echo base_url(); ?>assets/img/edit-icon.svg"></button>--></div>
				</div>
			</div>
		</div>
	</header>
	<main class="padTop padBottom">
		<div class="container">
			
			<?php echo form_open_multipart('Cust_home/Verified_email'); ?>
				<div class="col-12 perDetailsWrapper">	
						<div class="form-group">
								<label class="font-weight-bold">Confirm your email address</label>
								<input type="text" class="form-control" name="userEmailId" id="userEmailId" value="<?php echo $User_email_id; ?>" readonly required>
								<div class="line"></div>
								<div class="help-block" style="float: center;"></div>
							</div>
						
						 <button type="submit" class="redBtn w-100 text-center">Submit</button>
					
				</div>
				<?php echo form_close(); ?>
			
		</div>
	</main>
<?php $this->load->view('front/header/footer'); ?> 
<script>
$('#userEmailId').change(function()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var userEmailId = $('#userEmailId').val();
	
	var validEmailId=ValidateEmail(userEmailId);
	
	if( $("#userEmailId").val() == "" || validEmailId == false)
	{	
		// alert(validEmailId);
		var msg1 = 'Please Enter Valid Email Id';
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
</script>