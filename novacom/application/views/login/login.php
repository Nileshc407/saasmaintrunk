<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.ico" type="image/x-icon">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
	<link href="http://novacomdemo.ehpdemo.online/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://novacomdemo.ehpdemo.online/assets/css/slider.css" rel="stylesheet" type="text/css" />
	<script src="http://novacomdemo.ehpdemo.online/assets/js/jquery.min.js"></script>		
	<link href="http://novacomdemo.ehpdemo.online/css/login.css" rel="stylesheet">
	<script src="http://novacomdemo.ehpdemo.online/assets/js/bootstrap.js"></script>
	<script src="http://novacomdemo.ehpdemo.online/assets/js/common.js"></script>
	<link href="http://novacomdemo.ehpdemo.online/assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />	
	<script src="http://novacomdemo.ehpdemo.online/assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="http://novacomdemo.ehpdemo.online/assets/bootstrap-dialog/js/alert_function.js"></script>	
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
<?php
if (isset($_REQUEST['error'])) {
?>
	<script>
	  var Title = "Application Information";
	  var msg = 'Invalid username or password..!!';
	  runjs(Title, msg);
	</script>
<?php
} ?>
<?php
if (@$this->session->flashdata('messege')) {
?>
	<script>
	  var Title = "Application Information";
	  var msg = '<?php echo $this->session->flashdata('messege'); ?>';
	  runjs(Title, msg);
	</script>
<?php
} ?>
    <div class="container">
        <div class="card card-container" style="padding: 5px 40px;">	
            <img id="profile-img" class="profile-img-card" src="<?php echo base_url(); ?>images/novacomlogo.png" />			
            <p id="profile-name" class="profile-name-card" style="font-size:20px;text-align:left;margin-bottom: 10px;">Welcome Back <?php if((isset($_REQUEST['Member_login'])) || ($Member_flag==1)){ ?><?php } else { ?>Business (DEMO) <?php } ?> </p>	
			<p style="color: gray;font-size:12px;">Sign with your user email address and password</p>			
			<?php if((isset($_REQUEST['Member_login'])) || ($Member_flag==1)){ $Forgot_flag=1; ?>
            <form class="form-signin" action="<?php echo base_url();?>index.php/login" method="post">
				<input type="email" name="email" id="email" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="Email address" required autofocus>
				<br><span><?php echo form_error('username'); ?></span>
				
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
				<br><span><?php echo form_error('password'); ?></span>
				
                <button class="btn btn-warning" style="background-color:#332005;color:#fff;" type="submit" value="Login">Sign in</button>
				<input type="hidden" name="flag" value="2">
				<div id="m"></div>
            </form><!-- /form -->
			<?php echo form_close(); ?>
			<p>Are you a Member? <a href="#lost" data-dismiss="modal" data-toggle="modal" data-target="#myModal3" style="color:#26ba9d;">Sign up</a></p>
			
			
<!-- sIGN uP -->
		<div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body modal-body-sub_agile">
						<div class="col-md-12 modal_body_left modal_body_left1">
							 <img id="profile-img" class="profile-img-card" src="<?php echo base_url(); ?>images/logo.png" />	
							<p id="profile-name" class="profile-name-card" style="font-size:20px;text-align:left;margin-bottom: 10px;">Sign Up Now</p>	
							<div class="wrap-box"></div>
							<form action="<?php echo base_url()?>index.php/Cust_home/enroll_new_member_website" method="post" >
								<div class="styled-input agile-styled-input-top">
								<label for="inputName"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;First Name
									</label>
									<input type="text" name="first_name" required="" class="form-control" placeholder="Enter First Name">
									<br>
								</div>

								<div class="styled-input agile-styled-input-top">
									
									<label for="inputName"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Last Name
									</label>
									
									<input type="text" name="last_name" required="" class="form-control" placeholder="Enter Last Name">
									<br>
								</div>

								<div class="styled-input agile-styled-input-top">
									<label for="inputName"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Mobile No.
										&nbsp;&nbsp;<span style="font-size: 9px; font-style: italic; color: red;">(* Enter without Dial Code)</span>
									</label>
									<input type="text" name="phno" id="phno" required="" class="form-control"  placeholder="Enter Mobile no." onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="9">
									<br>
								</div>

								<div class="styled-input">
									
									<label for="inputName"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Email ID
									</label>
									
									<input type="email" name="email"   id="userEmailId" required="" class="form-control" placeholder="Enter Email ID">
									<br>
								</div>

								<input type="submit" value="Register" class="btn btn-warning" style="background-color:#332005;color:#fff;">
								
								
								<input type="hidden" class="form-control"  name="Country" id="Country" value="<?php echo $Country; ?>" >
								<input type="hidden"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
								<br>
								<span style="font-size: 12px; font-style: italic; color: red;float: right;">(* Required Fields)</span>
							</form>
	
							<div class="clearfix"></div>
						</div>

						<div class="clearfix"></div>
					</div>
				</div>
				<!-- //Modal content-->
			</div>
		</div>
<!-- //Modal3 -->
			
			
			<?php }else{   $Forgot_flag=2; ?>
			
			<form class="form-signin" action="<?php echo $this->config->item('base_url2')?>index.php/login" method="post">
				<input type="email" name="username" id="username" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="Email address" required autofocus>
				<br><span><?php echo form_error('username'); ?></span>
				
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
				<br><span><?php echo form_error('password'); ?></span>
				<input type="hidden" name="Outlet_Website" id="Outlet_Website" value="<?php  echo $Outlet_Website; ?>" >
                <button class="btn btn-warning" style="background-color:#332005;color:#fff;" type="submit" value="Login">Sign in1</button>
				<input type="hidden" name="flag" value="2">
				<div id="m"></div>
            </form><!-- /form -->
			<?php echo form_close(); ?>
						
			
		<?php } ?>
        
		<a href="#myModal14" data-toggle="modal" data-target="#myModal14" class="forgot-password success">Forgot password?</a>		
			
			<!-----------------Member Forgot Password Modal--------------------------------------->
		<?php if((isset($_REQUEST['Member_login'])) || ($Member_flag==1)){ ?> 	
		<form action="<?php echo base_url()?>index.php/Cust_home/forgot/?Forgot_flag=<?php echo $Forgot_flag;?>" method="post"  class="login-form">
		<?php } else { ?>
		<form action="<?php echo $this->config->item('base_url2')?>index.php/Login/Send_password_website" method="post" class="login-form">
		<?php } ?>
		<div id="myModal14" class="modal fade" role="dialog" >
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
						
						  <div class="modal-header">
							<h4 class="modal-title" style="background-color:#332005;color:#fff;text-align:center">Forgot Password</h4>
						  </div>
						  <div class="modal-body">
							  <div class="form-group has-feedback1" id="has-feedback1">
							  <label for="exampleInputEmail1"><font color='#337ab7'>Email Address</font></label>
							  <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address">
							  <span class="glyphicon" id="glyphicon1" aria-hidden="true"></span>						
							  <div class="help-block1" id="help-block1" ></div>
						   
						  </div>
							
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
							<input type="hidden" name="Company_id" id="Company_id" value="<?php  echo $Company_id; ?>" >
								<input type="hidden" class="form-control"  name="flag"  value="2" >
								
								<input type="submit" value="Submit" class="btn btn-default" >
						  </div>
						</div>

					</div>
				</div>
		</form>		
			<!----------------------------------------------------------->
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
			url: "<?php echo $this->config->item('base_url2')?>index.php/Login/check_email_address",
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
			url: "<?php echo $this->config->item('base_url2')?>index.php/Login/Send_password",
			success: function(data)
			{
				
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
	<?php if((isset($_REQUEST['Member_login'])) || ($Member_flag==1)){ ?>
 background-image: url("<?php echo base_url(); ?>images/CustomerLogin.jpg"); 
	<?php }else{ ?>
 background-image: url("<?php echo base_url(); ?>images/MaintrunkLogin.jpg"); 
 <?php } ?>
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
   background-repeat: no-repeat;
   
   
   
 
}
.card{
	background-color: #fefdf8 !IMPORTANT;
}
.btn-warning {
    border-color: #332005 !IMPORTANT;
</style>

<?php /***** Hide cahnge Ravi------2409-2019------ ?>
<?php 

$this->load->helper('form');
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
$ci_object->load->model('Igain_model');
$ci_object->load->model('Users_model');
foreach($Company_details as $Company1)
{
	$Cust_apk_link = $Company1['Cust_apk_link'];
	$Cust_ios_link = $Company1['Cust_ios_link'];
	$Company_name = $Company1['Company_name'];
	$Currency_name = $Company1['Currency_name'];
	$Company_address = $Company1['Company_address'];
	$Company_primary_email_id = $Company1['Company_primary_email_id'];
	$Call_center_flag = $Company1['Call_center_flag'];
	$Website = $Company1['Website'];
	$Company_primary_phone_no = $Company1['Company_primary_phone_no'];
}
?>
<html>
<head>
<title>Kukito</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.ico" type="image/x-icon">
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Nova/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/my-style.css">
  <script src="<?php echo base_url(); ?>assets/Nova/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/Nova/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/Nova/bootstrap.min.js"></script>
  
  <?php
	if(@$this->session->flashdata('login_success'))
	{
	?>
		<script>
		$(document).ready(function() {
			
			var msg = '<?php echo $this->session->flashdata('login_success'); ?>';
			//alert(msg);
			$('#inputMsg').html(msg);
			$("#myMsgModal").modal();
		  });
  
		</script>
	<?php
	}
	?>
	
  <?php
	if(@$this->session->flashdata('error_code'))
	{
		$error_msg = $this->session->flashdata('error_code');
		
		$this->session->set_flashdata('error_code',"");
	?>
		<script>
		$(document).ready(function() {
			
			// var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
			var msg = '<?php echo $error_msg; ?>';
			//alert(msg);
			$('#inputMsg').html(msg);
			$("#myMsgModal").modal();
		  });
  
		</script>
	<?php
	}
	?>
	
  <script type="text/javascript">

		function Merchant_login(password,username)
		{
			// alert('username'+username);
			//alert('password'+password);
			if(username=="")
			{
				var msg = "Please Enter User Email ID !!!";
				$('#merchant_error_msg').html(msg);
				return false;
			}
			if(password=="")
			{
				var msg = "Please Enter Password !!!";
				$('#merchant_error_msg').html(msg);
				//runjs(Title,msg);
				return false;
			}

			var Company_id=<?php echo $Company_id; ?>;
			//document.getElementById("loadingDiv").style.display="";
			window.location='<?php echo $this->config->item('base_url2')?>index.php/Login/?username='+username+'&password='+password+'&Company_id='+Company_id;
		}
		function Member_login(password,username,callcenterticket,redeemflag)
		{
			var callcenterticket=0;
			var redeemflag=0;
			
			redeemflag=document.getElementById('redeemflag').value;
				
			if(username=="")
			{
				var msg = "Please Enter User Email ID !!!";
				$('#member_error_msg').html(msg);
				//runjs(Title,msg);
				return false;
			}

			filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (filter.test(username)) {
			  // Yay! valid
			 // return true;
			}
			else
			  {
					var msg = "Please Enter valid Email ID !!!";
					$('#member_error_msg').html(msg);
					//runjs(Title,msg);
					return false;
				}

			if(password=="")
			{
				var msg = "Please Enter Password !!!";
				$('#member_error_msg').html(msg);
				//runjs(Title,msg);
				return false;
			}

			//document.getElementById("loadingDiv").style.display="";
			document.getElementById('callcenterticket').value;
            callcenterticket=document.getElementById('callcenterticket').value;
			
			window.location='<?php echo base_url()?>index.php/login/?flag=2&email='+username+'&password='+password+'&callcenterticket='+callcenterticket+'&redeemflag='+redeemflag;
		}

	</script>

</head>
<body>

<!-- The Success msg Modal -->
  <div class="modal fade" id="myMsgModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Application Information</h4>
        
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="inputMsg">
         
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        
		   <a  href="<?php echo base_url()?>index.php" class="btn btn-danger" > Close </a>
        </div>
        
      </div>
    </div>
  </div>
 <!-- The Modal --> 
  
<div class="header my-header">
	 <?php $ci_object->load->view('header.php'); ?>
</div>
<div class="my-homebg">
	<div class="container text-center hero">
        <h1>Order Online or Dine at our Outlets</h1><br>
        <h5 class="font-white space-xs">Become a Loyal Member and Enjoy much more!!</h5>
	</div>
</div><hr>
	<div id="foods">
	
		<div class="text-center px-20">
			<div class="container">
			<span><b>Popular Delicious Foods Here:<span class="primary-color"> All over Nairobi</span></b>
			</span>
			</div>
		</div>
		<br>
		<div class="title text-center mb-30">
			<h2>Popular This Month In Your City</h2>
			<p class="lead">The easiest way to get your favourite food</p>
		</div>

	<div class="container">
		<div class="row">
		
		 <?php
              // print_r($Redemption_Items);
		  if ($Redemption_Items != NULL) {
			foreach ($Redemption_Items as $product) {

				$Company_merchandise_item_id = $product['Company_merchandise_item_id'];
				
				$Get_Partner_details = $ci_object->Igain_model->Get_Company_Partners_details($product["Partner_id"]);
			  $Partner_state = $Get_Partner_details->State;
			  $Partner_Country = $Get_Partner_details->Country_id;
			  if ($product['Size_flag'] == 1) {
				$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id, $product['Company_merchandize_item_code']);
				$Billing_price = $Get_item_price->Billing_price;
				$Item_size = $Get_item_price->Item_size;
			  } else {
				$Item_size = "0";
				$Billing_price = $product['Billing_price'];
			  }
			  ?>
			<div class="col-sm-12 col-md-6 col-lg-4 mb-5">
				<div class="card" style="width:300px; height:380px;" id="Source_img_<?php echo $product["Company_merchandise_item_id"]; ?>">
				
				<a href="#">
					<img class="card-img-top" src="<?php echo $product['Thumbnail_image1']; ?>" alt="Item Preview" style="width:100%;  height:220px;">
				</a>
					<div class="card-body">
					  <h6 class="card-title">
						<?php echo $product['Merchandize_item_name']; ?>
					  </h6>
					  
					   <b class="card-title"><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $Billing_price; ?></b>
					   
					  <a  href="#" data-toggle="modal" data-target="#myModal1" class="btn" >Order Now</a>
					 
					</div>
				</div>
			</div>
			<?php }
			} ?>

		</div>
		
	</div>
	</div>
	<hr>
	<div class="container" id="loyalty">
		<div class="title text-center mb-30">
			<h2>About Loyalty Program</h2>
			<p>Earn Points  whenever you eat from any of our outlets or order Online. You can redeem at our outlets. You get Major discounts if you are any of our member.  So hurry and become a member and enjoy  the benefits.  Go to any of out outlets and enroll yourself or from the sign up from above portal  ( as member). 
</p>
		</div>

		<div class="row pr-5">
			<div class="col-sm-12 col-md-6 col-lg-4 mb-5">
			<div class="card" style="width:100%; height:280px;">
				<img class="card-img-top" src="<?php echo base_url()?>images/bronze-member.png" alt="Card image" style="width:100%; height:180px;">
					<div class="card-body">
					  <p class="card-text"><b>For every Transaction you do ( online or at outlet) you will earn 1% points on every Transaction's Paid Amount</b></p>
					</div>
				</div>
			</div>
			  
			<div class="col-sm-12 col-md-6 col-lg-4 mb-5"> 
			<div class="card" style="width:100%; height:280px;">
				<img class="card-img-top" src="<?php echo base_url()?>images/silver-member.png" alt="Card image" style="width:100%; height:180px;">
					<div class="card-body">
					  <p class="card-text"><b>For every Transaction you do ( online or at outlet) you will earn 2% points on every Transaction's Paid Amount </b></p>
					</div>
				</div>
			</div> 

			<div class="col-sm-12 col-md-6 col-lg-4 mb-5">
			<div class="card" style="width:100%; height:280px;">
				<img class="card-img-top" src="<?php echo base_url()?>images/gold-member.png" alt="Card image" style="width:100%; height:180px;">
					<div class="card-body">
					  <p class="card-text"><b>For every Transaction you do ( online or at outlet) you will earn 3% points on every Transaction's Paid Amount </b></p>
					</div>
				</div>			
			</div>			

		</div>
	</div>
	<hr>

	<!-- How it works block starts -->
        <section class="how-it-works">
            <div class="container">
                <div class="text-center">
					<h2>Easy 3 Steps to Order Online</h2>
                    <!-- 3 block sections starts -->
                    <div class="row how-it-works-solution">
                        <div class="col-xs-12 col-sm-12 col-md-4 how-it-works-steps white-txt col1">
                            <div class="how-it-works-wrap">
                                <div class="step step-1">
                                    <div class="icon" data-step="1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 483 483" width="512" height="512">
                                            <g fill="#FFF">
                                                <path d="M467.006 177.92c-.055-1.573-.469-3.321-1.233-4.755L407.006 62.877V10.5c0-5.799-4.701-10.5-10.5-10.5h-310c-5.799 0-10.5 4.701-10.5 10.5v52.375L17.228 173.164a10.476 10.476 0 0 0-1.22 4.938h-.014V472.5c0 5.799 4.701 10.5 10.5 10.5h430.012c5.799 0 10.5-4.701 10.5-10.5V177.92zM282.379 76l18.007 91.602H182.583L200.445 76h81.934zm19.391 112.602c-4.964 29.003-30.096 51.143-60.281 51.143-30.173 0-55.295-22.139-60.258-51.143H301.77zm143.331 0c-4.96 29.003-30.075 51.143-60.237 51.143-30.185 0-55.317-22.139-60.281-51.143h120.518zm-123.314-21L303.78 76h86.423l48.81 91.602H321.787zM97.006 55V21h289v34h-289zm-4.198 21h86.243l-17.863 91.602h-117.2L92.808 76zm65.582 112.602c-5.028 28.475-30.113 50.19-60.229 50.19s-55.201-21.715-60.23-50.19H158.39zM300 462H183V306h117v156zm21 0V295.5c0-5.799-4.701-10.5-10.5-10.5h-138c-5.799 0-10.5 4.701-10.5 10.5V462H36.994V232.743a82.558 82.558 0 0 0 3.101 3.255c15.485 15.344 36.106 23.794 58.065 23.794s42.58-8.45 58.065-23.794a81.625 81.625 0 0 0 13.525-17.672c14.067 25.281 40.944 42.418 71.737 42.418 30.752 0 57.597-17.081 71.688-42.294 14.091 25.213 40.936 42.294 71.688 42.294 24.262 0 46.092-10.645 61.143-27.528V462H321z" />
                                                <path d="M202.494 386h22c5.799 0 10.5-4.701 10.5-10.5s-4.701-10.5-10.5-10.5h-22c-5.799 0-10.5 4.701-10.5 10.5s4.701 10.5 10.5 10.5z" /> </g>
                                        </svg>
                                    </div>
                                    <h3>Choose a tasty dish</h3>
                                    <p>We"ve got your covered with menus from over 345 delicious foods online.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 how-it-works-steps white-txt col2">
                            <div class="step step-2">
                                <div class="icon" data-step="2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 380.721 380.721">
                                        <g fill="#FFF">
                                            <path d="M58.727 281.236c.32-5.217.657-10.457 1.319-15.709 1.261-12.525 3.974-25.05 6.733-37.296a543.51 543.51 0 0 1 5.449-17.997c2.463-5.729 4.868-11.433 7.25-17.01 5.438-10.898 11.491-21.07 18.724-29.593 1.737-2.19 3.427-4.328 5.095-6.46 1.912-1.894 3.805-3.747 5.676-5.588 3.863-3.509 7.221-7.273 11.107-10.091 7.686-5.711 14.529-11.137 21.477-14.506 6.698-3.724 12.455-6.982 17.631-8.812 10.125-4.084 15.883-6.141 15.883-6.141s-4.915 3.893-13.502 10.207c-4.449 2.917-9.114 7.488-14.721 12.147-5.803 4.461-11.107 10.84-17.358 16.992-3.149 3.114-5.588 7.064-8.551 10.684-1.452 1.83-2.928 3.712-4.427 5.6a1225.858 1225.858 0 0 1-3.84 6.286c-5.537 8.208-9.673 17.858-13.995 27.664-1.748 5.1-3.566 10.283-5.391 15.534a371.593 371.593 0 0 1-4.16 16.476c-2.266 11.271-4.502 22.761-5.438 34.612-.68 4.287-1.022 8.633-1.383 12.979 94 .023 166.775.069 268.589.069.337-4.462.534-8.97.534-13.536 0-85.746-62.509-156.352-142.875-165.705 5.17-4.869 8.436-11.758 8.436-19.433-.023-14.692-11.921-26.612-26.631-26.612-14.715 0-26.652 11.92-26.652 26.642 0 7.668 3.265 14.558 8.464 19.426-80.396 9.353-142.869 79.96-142.869 165.706 0 4.543.168 9.027.5 13.467 9.935-.002 19.526-.002 28.926-.002zM0 291.135h380.721v33.59H0z" /> </g>
                                    </svg>
                                </div>
                                <h3>Fill your location</h3>
                                <p>We"ve got your covered with menus from over 345 delicious foods online.</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 how-it-works-steps white-txt col3">
                            <div class="step step-3">
                                <div class="icon" data-step="3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 612.001 612">
                                        <path d="M604.131 440.17h-19.12V333.237c0-12.512-3.776-24.787-10.78-35.173l-47.92-70.975a62.99 62.99 0 0 0-52.169-27.698h-74.28c-8.734 0-15.737 7.082-15.737 15.738v225.043h-121.65c11.567 9.992 19.514 23.92 21.796 39.658H412.53c4.563-31.238 31.475-55.396 63.972-55.396 32.498 0 59.33 24.158 63.895 55.396h63.735c4.328 0 7.869-3.541 7.869-7.869V448.04c-.001-4.327-3.541-7.87-7.87-7.87zM525.76 312.227h-98.044a7.842 7.842 0 0 1-7.868-7.869v-54.372c0-4.328 3.541-7.869 7.868-7.869h59.724c2.597 0 4.957 1.259 6.452 3.305l38.32 54.451c3.619 5.194-.079 12.354-6.452 12.354zM476.502 440.17c-27.068 0-48.943 21.953-48.943 49.021 0 26.99 21.875 48.943 48.943 48.943 26.989 0 48.943-21.953 48.943-48.943 0-27.066-21.954-49.021-48.943-49.021zm0 73.495c-13.535 0-24.472-11.016-24.472-24.471 0-13.535 10.937-24.473 24.472-24.473 13.533 0 24.472 10.938 24.472 24.473 0 13.455-10.938 24.471-24.472 24.471zM68.434 440.17c-4.328 0-7.869 3.543-7.869 7.869v23.922c0 4.328 3.541 7.869 7.869 7.869h87.971c2.282-15.738 10.229-29.666 21.718-39.658H68.434v-.002zm151.864 0c-26.989 0-48.943 21.953-48.943 49.021 0 26.99 21.954 48.943 48.943 48.943 27.068 0 48.943-21.953 48.943-48.943.001-27.066-21.874-49.021-48.943-49.021zm0 73.495c-13.534 0-24.471-11.016-24.471-24.471 0-13.535 10.937-24.473 24.471-24.473s24.472 10.938 24.472 24.473c0 13.455-10.938 24.471-24.472 24.471zm117.716-363.06h-91.198c4.485 13.298 6.846 27.54 6.846 42.255 0 74.28-60.431 134.711-134.711 134.711-13.535 0-26.675-2.045-39.029-5.744v86.949c0 4.328 3.541 7.869 7.869 7.869h265.96c4.329 0 7.869-3.541 7.869-7.869V174.211c-.001-13.062-10.545-23.606-23.606-23.606zM118.969 73.866C53.264 73.866 0 127.129 0 192.834s53.264 118.969 118.969 118.969 118.97-53.264 118.97-118.969-53.265-118.968-118.97-118.968zm0 210.864c-50.752 0-91.896-41.143-91.896-91.896s41.144-91.896 91.896-91.896c50.753 0 91.896 41.144 91.896 91.896 0 50.753-41.143 91.896-91.896 91.896zm35.097-72.488c-1.014 0-2.052-.131-3.082-.407L112.641 201.5a11.808 11.808 0 0 1-8.729-11.396v-59.015c0-6.516 5.287-11.803 11.803-11.803 6.516 0 11.803 5.287 11.803 11.803v49.971l29.614 7.983c6.294 1.698 10.02 8.177 8.322 14.469-1.421 5.264-6.185 8.73-11.388 8.73z" fill="#FFF" /> </svg>
                                </div>
                                <h3>Food Delivery</h3>
                                <p>Get your food delivered! And enjoy your meal! Pay Cash on delivery</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3 block sections ends -->
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p class="pay-info">Pay by Cash on delivery</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- How it works block ends -->
	<div id="contactus">
		<?php $ci_object->load->view('footer.php'); ?>
	</div>
	
	<!-- Modal1 -->
		<div class="modal fade" id="myModal1" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
						<div class="modal-body modal-body-sub_agile">
						<div class="col-md-12 modal_body_left modal_body_left1">
							<h3 class="agileinfo_sign" style="color:#26ba9d;text-align:center">Log In <span>And<br>  Get Reward benefits</span></h3>
								<div class="wrap-box text-danger" id="member_error_msg"></div>

									<div class="styled-input">
										<input type="text" name="email" id="cust_email"  required="">
										<label>Email</label>
										<span></span>
									</div>
									<div class="styled-input">
										<input type="password" name="password" id="Cust_password"  required="">
										<label>Password</label>
										<span></span>
									</div>
									<input type="hidden" class="form-control" id="callcenterticket"  name="callcenterticket"  value="0">
									<input type="hidden" class="form-control" id="redeemflag"  name="redeemflag"  value="0">
									<input type="hidden" name="flag" value="2" >
									<input type="submit" value="Login" onclick="javascript:Member_login(Cust_password.value,cust_email.value,callcenterticket.value,redeemflag.Value);">

								<div class="clearfix"></div>
								<p><a href="#lost"data-dismiss="modal" data-toggle="modal" data-target="#myModal14" style="color:#26ba9d;">Forgot your Password?</a></p>
								<p>Are you a Member? <a href="#lost" data-dismiss="modal" data-toggle="modal" data-target="#myModal3" style="color:#26ba9d;">Sign up</a></p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<!-- //Modal content-->
			</div>
		</div>
<!-- //Modal1 -->

<!-- Modal2 -->
		<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body modal-body-sub_agile">
						<div class="col-md-12 modal_body_left modal_body_left1">
							<h3 class="agileinfo_sign" style="color:#26ba9d;">Login In <span>Now</span></h3>
							<div class="wrap-box text-danger" id="merchant_error_msg"></div>

								<div class="styled-input">
									<input type="email" name="username" id="username"  required="">
									<label>Email</label>
									<span></span>
								</div>
								<div class="styled-input">
									<input type="password" name="password"  id="password"  required="">
									<label>Password</label>
									<span></span>
								</div>
								<input type="submit" value="Login" onclick="javascript:Merchant_login(password.value,username.value);">

							<div class="clearfix"></div>
							<p><a href="#lost"data-dismiss="modal" data-toggle="modal" data-target="#myModal14" style="color:#26ba9d;">Forgot your Password?</a></p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<!-- //Modal content-->
			</div>
		</div>
<!-- //Modal2 -->

<!-- Modal3 -->
		<div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body modal-body-sub_agile">
						<div class="col-md-12 modal_body_left modal_body_left1">
							<h3 class="agileinfo_sign" style="color:#26ba9d;">Sign Up <span>Now</span></h3>
							<div class="wrap-box"></div>
							<form action="<?php echo base_url()?>index.php/Cust_home/enroll_new_member_website" method="post" >
								<div class="styled-input agile-styled-input-top">
									<input type="text" name="first_name" required="">
									<label>First Name</label>
									<span></span>
								</div>

								<div class="styled-input agile-styled-input-top">
									<input type="text" name="last_name" required="">
									<label>Last Name</label>
									<span></span>
								</div>

								<div class="styled-input agile-styled-input-top">
									<input type="text" name="phno" id="phno" required="">
									<label>Mobile no.</label>
									<span></span>
								</div>

								<div class="styled-input">
									<input type="email" name="userEmailId"   id="userEmailId" required="">
									<label>Email</label>
									<span></span>
								</div>

								<input type="submit" value="Register">
								<input type="hidden" class="form-control"  name="Country" id="Country" value="<?php echo $Country; ?>" >
								<input type="hidden" class="form-control"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
							</form>
	
							<div class="clearfix"></div>
						</div>

						<div class="clearfix"></div>
					</div>
				</div>
				<!-- //Modal content-->
			</div>
		</div>
<!-- //Modal3 -->


<!-- Raise Ticket Forgot Password starts -->

	<div class="modal fade" id="myModal14" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body modal-body-sub_agile">
						<div class="col-md-12 modal_body_left modal_body_left1">
							<h3 class="agileinfo_sign" style="color:#26ba9d;">Forgot Password</h3>
							<div class="wrap-box"></div>
							<form action="<?php echo base_url()?>index.php/Cust_home/forgot" method="post"  class="login-form">
								<div class="styled-input">
									<input type="email" name="email" id="Merchant_email"  required="">
									<label>Email</label>
									<span></span>
								</div>

								<input type="hidden" class="form-control"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
								<input type="hidden" class="form-control"  name="flag"  value="2" >
								<input type="submit" value="Send">
							</form>
							<div class="clearfix"></div>
							<p><a href="#lost"data-dismiss="modal" data-toggle="modal" data-target="#myModal14" style="color:#26ba9d;">Forgot your Password?</a></p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<!-- //Modal content-->
			</div>
		</div>
		
	
<!-- Raise Ticket Forgot Password ended -->

	
</body>

<?php */ ?>
