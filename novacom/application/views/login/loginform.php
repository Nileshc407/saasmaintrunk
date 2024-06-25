<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url()?>css/login.css" rel="stylesheet">	
	<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url()?>assets/js/bootstrap.js"></script>
	<link href="<?php echo base_url()?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />	
	<script src="<?php echo base_url()?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/bootstrap-dialog/js/alert_function.js"></script>
</head>

<body>

    <div class="container">
        <div class="card card-container">
		
            <img id="profile-img" class="profile-img-card" src="https://igainapp.in/HTML_newimages/logo.png" />
			<p style="font-weight: bold; font-style: italic;text-align:center;">Enabling Merchants to Engage and Retain their Customers</p>
            <p id="profile-name" class="profile-name-card"></p>		
			
            <form class="form-signin" action="<?php echo base_url()?>index.php/login" method="post">
                <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="Email address" required autofocus>
				<br><span><?php echo form_error('username'); ?></span>
				
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
				<br><span><?php echo form_error('password'); ?></span>				
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" value="Login">Sign in</button>
				
				<div id="m"></div>
            </form><!-- /form -->
			<?php echo form_close(); ?>
			
            <a href="#" class="forgot-password">Forgot the password?</a>
			
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
			
        </div><!-- /card-container -->
    </div><!-- /container -->
	
</body>
</html>

