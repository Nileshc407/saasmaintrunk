<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.ico" type="image/x-icon">
	<title>Term&Conditions</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
	<link href="<?php echo $this->config->item('base_url2')?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $this->config->item('base_url2')?>/assets/css/slider.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->config->item('base_url2')?>/assets/js/jquery.min.js"></script>		
	<link href="<?php echo $this->config->item('base_url2')?>/css/login.css" rel="stylesheet">
	<script src="<?php echo $this->config->item('base_url2')?>/assets/js/bootstrap.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>/assets/js/common.js"></script>
	<link href="<?php echo $this->config->item('base_url2')?>/assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />	
	<script src="<?php echo $this->config->item('base_url2')?>/assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>/assets/bootstrap-dialog/js/alert_function.js"></script>	
</head>
<body style="">
	<div class="container">
	<div class="se-pre-con"></div>
		<!--<div class="card card-container" style="padding: 5px 40px; max-width: 1350px;">	
			<img id="profile-img" class="profile-img-card" src="<?php echo base_url(); ?>images/novacomlogo.png" />			
			<h3> Terms and Conditions</h3>
			<p style="color: gray;font-size:14px;">Welcome to our website. If you continue to browse and use this website, you are
				agreeing to comply with and be bound by the following terms and conditions of use, </p>			
		</div>-->
	</div>
</body>
</html>

<style>
	/* Paste this css to your style sheet file or under head tag */
	/* This only works with JavaScript, 
	if it's not present, don't show loader */
	.no-js #loader { display: none;  }
	.js #loader { display: block; position: absolute; left: 100px; top: 0; }
	.se-pre-con {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		
		background: url(<?php echo base_url(); ?>images/Main.gif) center no-repeat #fffaf2;
	}
</style>
<script>
$( document ).ready(function() 
{
	location.replace("https://tamarind.co.ke/loyalty.php")
});
$(window).load(function() {
	// Animate loader off screen
	$(".se-pre-con").fadeOut("slow");;
});
</script>