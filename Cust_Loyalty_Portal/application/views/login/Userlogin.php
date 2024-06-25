<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
	<link href="<?php echo $this->config->item('base_url2'); ?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $this->config->item('base_url2'); ?>assets/css/slider.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->config->item('base_url2'); ?>assets/js/jquery.min.js"></script>		
	<link href="<?php echo $this->config->item('base_url2'); ?>css/login.css" rel="stylesheet">
	<script src="<?php echo $this->config->item('base_url2'); ?>assets/js/bootstrap.js"></script>
	<script src="<?php echo $this->config->item('base_url2'); ?>assets/js/common.js"></script>
	<link href="<?php echo $this->config->item('base_url2'); ?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />	
	<script src="<?php echo $this->config->item('base_url2'); ?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2'); ?>assets/bootstrap-dialog/js/alert_function.js"></script>	
</head>
<body style="">
	<?php /* <div class="carousel slide carousel-fade" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
			<div class="item active"></div>
			<div class="item"></div>
			<div class="item"></div>
			<div class="item"></div>
			<div class="item"></div>
			<div class="item"></div>
		</div>
	</div> */ ?>

    <div class="container">
        <div class="card card-container" style="margin-left: 70%;">	
            <img id="profile-img" class="profile-img-card" src="<?php echo  $this->config->item('base_url2').''.$Company_logo;?>" />			
            <p id="profile-name" class="profile-name-card" style="font-size:20px;text-align:left;margin-bottom: 10px;">Welcome Back</p>	
			<p style="color: gray;font-size:11px;">Sign with your user email address and password</p>			
			
            <form class="form-signin" action="<?php echo $this->config->item('base_url2'); ?>index.php/login" method="post">
				<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="Email address" required autofocus>
				<br><span><?php echo form_error('username'); ?></span>
				
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
				<br><span><?php echo form_error('password'); ?></span>
				
                <button class="btn btn-primary" style="background-color:#0060a9;color:#fff;" type="submit" value="Login">Sign in</button>
				<input type="hidden" name="flag" value="2">
				<div id="m"></div>
            </form><!-- /form -->
			<?php echo form_close(); ?>
			
            <a href="#myModal3" data-toggle="modal" data-target="#myModal3" class="forgot-password success">Forgot password?</a>			
			
			<!-- Modal -->
				<div id="myModal3" class="modal fade" role="dialog" >
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
						
						  <div class="modal-header">
							<h4 class="modal-title" style="background-color:#0060a9;color:#fff;text-align:center">Forgot Password</h4>
						  </div>
						  <div class="modal-body">
							  <div class="form-group has-feedback1" id="has-feedback1">
							  <label for="exampleInputEmail1"><font color='#337ab7'>Email Address</font></label>
							  <input type="text" class="form-control" name="email_id" id="email_id" placeholder="Enter Email Address">
							  <span class="glyphicon" id="glyphicon1" aria-hidden="true"></span>						
							  <div class="help-block1" id="help-block1" ></div>
						   
						  </div>
							
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-default" name="change_pwd" id="change_pwd" onclick="Send_password(email_id.value)" >Submit</button>
						  </div>
						</div>

					</div>
				</div>
			<!-- Modal -->
			
			<?php
			if(@$message)
			{
				echo "<p class='text-center' style='margin: 10px auto; color: red;'>".$message."</p>";
			}
			?>
			
			<?php
			if(@$this->session->flashdata('error_code'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}
			?>
			
        </div>
    </div>
	
		
	
<script>
$('#email_id').blur(function()
{
	var email_id = $('#email_id').val();
	if( email_id == "" )
	{
		document.getElementById("email_id").placeholder="Please Enter Email Address !!!";
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { email_id: email_id},
			url: "<?php echo $this->config->item('base_url2'); ?>index.php/Login/check_email_address",
			success: function(data)
			{
				if(data.length == 7)
				{
					$("#email_id").val("");					
					document.getElementById("email_id").placeholder="Please Enter Correct Email Address";					
				}
			}
		});
	}
});
		
function Send_password(Email_id)
{			
	var email_id = $('#email_id').val();
	if( email_id == "" )
	{
		document.getElementById("email_id").placeholder="Please Enter Email Address !!!";
	}
	else
	{
		show_loader();
		$.ajax(
		{
			type: "POST",
			data:{ Email_id:Email_id,flag:'2'},
			url: "<?php echo $this->config->item('base_url2'); ?>index.php/Login/Send_password",
			success: function(data)
			{
				//alert(data);
				//alert(data.length);
				if(data.length == 25)
				{					
					BootstrapDialog.show({
						closable: false,
						title: 'Valid Data Operation',
						message: 'Password sent to your Email Address Successfuly !!!',
						buttons: [{
							label: 'OK',
							action: function(dialog) 
							{
								location.reload(); 
							}
						}]
					});					
				} 
				else
				{
					BootstrapDialog.show({
						closable: false,
						title: 'In-Valid Data Operation',
						message: 'Password Not Sent!!!',
						buttons: [{
							label: 'OK',
							action: function(dialog) 
							{
								location.reload(); 
							}
						}]
					});
				}
			}
		});	
	}	
}

$( document ).ready( function() {
	$('.carousel').carousel();
});
</script>

</body>
</html>
<style>

body {
 background-image: url("<?php echo $this->config->item('base_url2'); ?>images/home_page_login1.png"); 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
   background-repeat: no-repeat;
   
   
 
}
.card{
	background-color: #fff;
}
</style>