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
<title>Novacom Loyalty</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Nova/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/my-style.css">
 <script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/Nova/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/Nova/bootstrap.min.js"></script>
  	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>


    <style>
  .widget{
	 border: 1px solid #eaebeb;
	 background: #fafaf8;
	 border-radius: position: relative;
	 margin-bottom: 4%;
  }
  .widget-body{
	  padding: 20px;
  }
  /*.btn{
	  background-color: #f30;
    color: #fff;
    border: 1px solid #f30;
  } */
  .btn {
    background-color: #fab900;
    color: #fff;
    border: 1px solid #fab900;
}
  </style>
</head>
<body>

<div class="header my-header">
	 <?php $ci_object->load->view('header.php'); ?>
</div>


<style>

.bg {
  /* The image used */
  background-image: url("<?php echo $this->config->item('base_url2')?>assets_fos/images/decouvrez-l-experience-food-d-airbnb.jpg");

  /* Full height */
  height: 20%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
              <div class="bg"></div><br>
		
		 <section class="contact-page inner-page">
               <div class="container">
                  <div class="row">
                     <!-- REGISTER -->
                     <div class="col-md-8">
                        <div  class="widget">
                           <div   class="widget-body text-xs-center text-sm-left">
                             
                                 <div class="row">
                                    <div class="form-group col-sm-6">
                                       <label for="exampleInputEmail1">Order Number</label>
									<input type="text" name="ordernumber" id="ordernumber" class="form-control" placeholder="Your Order Number"   onblur="VoucherNo_validation(this.value);"
														  required="true"  data-error="Please Enter Valid Order No." >
									<div  id="ordernumber2"  style="color:red;font-size:12px;"></div>						  
                                    </div> 
								</div>
                                                    
                                 
                                 <div class="row">
                                    <div class="col-sm-4">
                                      <button type="submit" name="login" class="btn theme-btn m-t-15" onblur="VoucherNo_validation(ordernumber.value);"><i class="ft-user"></i>Track </button>
                                    </div>
                   
                                 </div>
                              
								
							  
                           </div>
                           <!-- end: Widget -->
                        </div>
						<br><br>
									 <div class="widget" id="records" style="display:none;"></div>
									
                        <!-- /REGISTER -->
                     </div>
                     <!-- WHY? -->
                    <div class="col-md-4">
                        <h4>Track your order by using order number.</h4>
                        <hr>
                        <img src="<?php echo $this->config->item('base_url2') ?>assets_fos/images/12633.jpg" alt="" class="img-fluid">
                        <p></p>
                   
                   
                        <!-- end:Panel -->
                        <h4 class="m-t-20">Contact Customer Support</h4>
                        <p> If you"re looking for more help or have a question to ask, please </p>
                        <p> <a href="#footer_fos" class="btn theme-btn m-t-15">Contact us</a> </p>
                     </div>
                     <!-- /WHY? -->
                  </div>
				  
				  
               </div>
			   
			   
            </section>
	
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
									<input type="email" name="username" id="Merchant_email"  required="">
									<label>Email</label>
									<span></span>
								</div>
								<div class="styled-input">
									<input type="password" name="password"  id="password"  required="">
									<label>Password</label>
									<span></span>
								</div>
								<input type="submit" value="Login" onclick="javascript:Merchant_login(password.value,Merchant_email.value);">

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
							<ul class="social-nav model-3d-0 footer-social w3_agile_social top_agile_third">
								<li></li>
								<li><a href="#" class="facebook">
									<div class="front"><i class="fa fa-facebook" aria-hidden="true" style="font-size:28px;"></i></div>
									<div class="back"><i class="fa fa-facebook" aria-hidden="true" style="font-size:28px;"></i></div></a>
								</li>
								<li><a href="#" class="pinterest">
									<div class="front"><i class="fa fa-google-plus-official" aria-hidden="true" style="font-size:28px;"></i></div>
									<div class="back"><i class="fa fa-google-plus-official" aria-hidden="true" style="font-size:28px;"></i></div></a>
								</li>
								<li></li>

							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="clearfix"></div>
					</div>
				</div>
				<!-- //Modal content-->
			</div>
		</div>
<!-- //Modal3 -->
		
</body>

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


<script>
function VoucherNo_validation(Order)
	{
		
		if( Order == "" )
		{
			$("#ordernumber2").html("Please Enter Order No.");
		}
		else
		{
			var Company_id='<?php echo $Company_id; ?>';
			
			$.ajax({
				type:"POST",
				data:{Order:Order,Company_id:'<?php echo $Company_id; ?>'},
				url: "<?php echo base_url()?>index.php/Login/Voucher_validation",
				success : function(data)
				{
					//alert(data);
					if(data == 0)//14
					{
						$("#ordernumber").val("");
						$("#ordernumber2").html("Invalid Order No.");
						document.getElementById("records").innerHTML="";
						document.getElementById("records").style.display="none";
					}
					else
					{
						
						/*  $('#Item_image').attr("src", data.Item_image);
						$("#Ordernumber3").html(data.Voucher_no);
						$("#Orderdate").html(data.Trans_date);
						$("#Orderstatus").html(data.Voucher_status);
						$("#ordernumber2").html(""); */
						document.getElementById("records").style.display="";
						$("#ordernumber2").html("");
						document.getElementById("records").innerHTML=data.ordered_items;
						/* $("#prog").show();
						if(data.Voucher_status=='Ordered')
						{
							$("#order_class").addClass( "progtrckr-done" );
							$("#shipped_class").addClass( "progtrckr-todo" );
							$("#delivered_class").addClass( "progtrckr-todo" );
							
							$("#shipped_class").removeClass( "progtrckr-done" );
							$("#delivered_class").removeClass( "progtrckr-done" );
							$("#order_class").removeClass( "progtrckr-todo" );
							
						}
						else if(data.Voucher_status=='Shipped')
						{
							$("#order_class").addClass( "progtrckr-done" );
							$("#shipped_class").addClass( "progtrckr-done" );
							$("#delivered_class").addClass( "progtrckr-todo" );
							
							$("#delivered_class").removeClass( "progtrckr-done" );
							$("#order_class").removeClass( "progtrckr-todo" );
							$("#shipped_class").removeClass( "progtrckr-todo" );
						}
						else if(data.Voucher_status=='Delivered')
						{
							$("#order_class").addClass( "progtrckr-done" );
							$("#shipped_class").addClass( "progtrckr-done" );
							$("#delivered_class").addClass( "progtrckr-done" );
							
							$("#order_class").removeClass( "progtrckr-todo" );
							$("#shipped_class").removeClass( "progtrckr-todo" );
							$("#delivered_class").removeClass( "progtrckr-todo" );
						}
						else
						{
							$("#prog").hide();
						}
						 */
					}
				}
			});

		}
	}

</script>
