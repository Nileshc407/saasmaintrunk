<!doctype html>
<html lang="">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
	<title>Dashboard</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.min.css">
	<!-- Fonts CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font/font.css">
	<!-- Custome CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
	
	
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
			
			background: url(<?php echo base_url(); ?>assets/images/Main.gif) center no-repeat #fffaf2;
		}
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
	<script>
		//paste this code under head tag or in a seperate js file.
		// Wait for window load
		$(window).load(function() {
			// Animate loader off screen
			$(".se-pre-con").fadeOut("slow");;
		});
	</script>
</head>
<body>
		<!-- Paste this code after body tag -->
			<div class="se-pre-con"></div>
		<!-- Ends -->
	<div id="wrapper">
		