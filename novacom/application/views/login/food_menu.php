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
<title>Novacom System</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Nova/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/my-style.css">
 <script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/Nova/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/Nova/bootstrap.min.js"></script>
  
  <?php /* ?>
  <!---------------------------
      <link href="<?php echo $this->config->item('base_url2')?>assets_fos/css/animsition.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets_fos/css/animate.css" rel="stylesheet">
	   <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/jquery.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/tether.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/animsition.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/bootstrap-slider.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/jquery.isotope.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/headroom.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets_fos/js/foodpicky.min.js"></script>

  -->
  <?php */ ?>
  <!--
   <link href="<?php echo $this->config->item('base_url2')?>assets_fos/css/style.css" rel="stylesheet">
   <link href="<?php echo $this->config->item('base_url2')?>assets_fos/css/bootstrap.min.css" rel="stylesheet">
	-->
</head>
<body>
<div class="header my-header">
	 <?php $ci_object->load->view('header.php'); ?>
</div>


              <div class="bg"></div>
   <!--        
<div class="my-homebg"></div>
-->
<hr>
	<div id="foods">
	<?php
		$total_items=count($Redemption_Items);
		$page = $total_items/10;
		//echo "total_items ".$total_items;
		//echo "page ".$page;
	?>
		
	<div class="container">
	
		<div class="row">
				<div class="col-md-3">
                                <!--<div class="main-block">
                                    <div class="sidebar-title white-txt">
                                        <h6>Show</h6> <i class="fa fa-cutlery pull-right"></i> </div>
                                    <div class="input-group">
										<select  class="form-control search-field" >
											<option >10</option>
										</select>
                                </div>
                                     </div><br>-->
                
				 <form name="search" method="post" action="<?php echo base_url()?>index.php/Login/food_menu/">
                                <div class="main-block">
                                    <div class="sidebar-title white-txt">
                                        <h6>Search Food</h6> <i class="fa fa-cutlery pull-right"></i> </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control search-field" placeholder="Search your favorite food" name="item_name" id="item_name"> <span class="input-group-btn"> </span> </div>
                                     </div>
                   </form>
				    <div class="main-block" style="margin-top: 10%">
                                    <div class="sidebar-title white-txt">
                                        <h6>Food Categories</h6> <i class="fa fa-cutlery pull-right"></i> </div>
                 
										<ul>
										<li>
                                                <label>
                                                    <span><a href="<?php echo base_url()?>index.php/Login/food_menu/?catid=0">All</a></span> </label>
                                            </li>
                                            <?php
											
												foreach($Merchandize_category as $rec)
												{?>
													
											
                                            <li>
                                                <label>
                                                    <span><a href="<?php echo base_url()?>index.php/Login/food_menu/?catid=<?php echo $rec->Merchandize_category_id;?>"><?php echo $rec->Merchandize_category_name;?></a></span> </label>
                                            </li>
                                    
                                           <?php	}
											?>
                                        
                                        </ul>
                           
                                    <div class="clearfix"></div>
                      </div>
			</div>
			<div class="col-md-9">
			<div class="row">
		 <?php
              // print_r($Redemption_Items);
			  //class="col-sm-8 col-md-4 col-lg-3 mb-5"
				$numOfCols = 3;
				$rowCount = 0;
				$bootstrapColWidth = 12 / $numOfCols;
				

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
			  //class="col-sm-12 col-md-3 col-lg-3 mb-5"  style="margin-left:6%;"
			  
			  ?>
			  
			<div class="col-md-<?php echo $bootstrapColWidth; ?> mb-5">
				<div class="card"  id="Source_img_<?php echo $product["Company_merchandise_item_id"]; ?>">
				
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
			
			<?php 
					$rowCount++;
					if($rowCount % $numOfCols == 0) echo '</div><div class="row">'; 
	}
			}else{echo '<div>Items Not Found !!!</div>';} ?>

		</div>
			<!-----------Pagination---------------------------------------->
				<div class="col-xs-12" align="center">
                     <nav aria-label="...">
                        <ul class="pagination" >
							<li class="page-link"><a href="?pageno=1">First</a></li>
							<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-link">
								<a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
							</li>
							<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-link">
								<a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
							</li>
							<li class="page-link"><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
						</ul>
					</nav>
                </div>
			<!-----------Pagination-XXX--------------------------------------->	
		</div>
		
	</div>
	</div>
	<hr>

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
							<!-- <ul class="social-nav model-3d-0 footer-social w3_agile_social top_agile_third">
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

							</ul> -->
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

/* style.css assets_fos*/

.main-block ul li {
    line-height: 10px;
    font-weight: 300;
    display: block;
    border-bottom: 1px solid #eaebeb;
    font-weight: 500;
    color: #414551;
	margin-left: -38px;
}

.main-block ul li a {
    color: #414551;
    display: block;
    font-weight: 500;
    padding: 15px;
}

.main-block ul {
    float: left;
    width: 100%;
    margin-bottom: 0;
}

.main-block ul li:hover {
    background: #fffdfd;
}

.main-block ul li:hover a {
    color: #f30
}

.main-block ul:hover li:last-child {
    border-bottom: 1px solid transparent;
    border-bottom: 1px solid #eaebeb;
}

.main-block ul li:first-of-type {
    border-top: none
}


.main-block .input-group input,
.main-block .input-group-btn {
    height: 55px;
    border-left: none
}




.main-block ul li {
    line-height: 10px;
    font-weight: 300;
    display: block;
    border-bottom: 1px solid #eaebeb;
    font-weight: 500;
    color: #414551;
}

.main-block ul li a {
    color: #414551;
    display: block;
    font-weight: 500;
    padding: 15px;
}

.main-block ul {
    float: left;
    width: 100%;
    margin-bottom: 0;
}

.main-block ul li:hover {
    background: #fffdfd;
}

.main-block ul li:hover a {
    color: #f30
}

.main-block ul:hover li:last-child {
    border-bottom: 1px solid transparent;
    border-bottom: 1px solid #eaebeb;
}

.main-block ul li:first-of-type {
    border-top: none
}
.main-block form ul li {
    padding: 15px
}



.sidebar-title {
    padding: 15px 15px 15px;
    background: #f30;
    float: left;
    width: 100%;
}

.sidebar-title h6 {
    float: left;
    margin-bottom: 0;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    line-height: 20px;
}

.sidebar-title i {
    float: right;
    color: #fff;
    font-size: 15px;
    margin-top: 3px;
}

</style>