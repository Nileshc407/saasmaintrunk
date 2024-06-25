<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>iGainSpark| Forgot Password</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url()?>dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/iCheck/square/blue.css">

	<!--------------------------------------------Alert-------------------------------------------------->
	
	
	<script src="<?php echo base_url()?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/bootstrap-dialog/js/alert_function.js"></script>			
	<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url()?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url()?>assets/js/common.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/bootstrap-dialog/js/alert_function.js"></script>
	<script type="text/javascript">  
	 $(document).ready(function () {  
            $('.dropdown-toggle').dropdown(); 
			
			$(".launch-modal").click(function(){
				$("#myModal").modal({
					backdrop: 'static'
				});
			});
        });  
	</script>
	
	<!--------------------------------------------Alert-------------------------------------------------->
		
		
		
		<link href="<?php echo base_url()?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
  </head>
  <?php echo form_open_multipart('Cust_home/forgot');	?>
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
	<body class="hold-transition login-page" style="background:#d2d6de">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo base_url()?>"><b>iGainSpark</b>Spark</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Enter Your Email Address</p>
          <div class="form-group has-feedback">
            <input type="email" class="form-control"  name="email" id="email"  placeholder="Email" required>
            <input type="hidden" class="form-control"  name="Company_id" id="Company_id" value="3" >
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			<div class="help-block"></div>
          </div>          
          <div class="row">           
            <div class="col-xs-4">
             <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button> 
            </div><!-- /.col -->
			<div class="col-xs-4">              
             <a href="<?php echo base_url()?>index.php/Cust_home/index" class="btn btn-primary btn-block btn-flat" > Back</a>
            </div><!-- /.col -->
		 </div>
        <!--</form>-->
	</div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

   
	 <?php echo form_close(); ?>
  </body>
</html>