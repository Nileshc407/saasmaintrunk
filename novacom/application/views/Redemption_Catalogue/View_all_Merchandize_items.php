<?php 
header("Access-Control-Allow-Origin: *");
$this->load->helper('form'); 
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
//$Company_id = $this->session->userdata('Company_id');
?>
<!DOCTYPE html>
<html>
<head>

   <meta charset="utf-8">
   <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
    <title>Lipita Loyalty</title>
	<!-- core CSS -->
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/owl.transitions.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/main.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/responsive.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/AdminLTE.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
	
    <link rel="shortcut icon" href="<?php echo $this->config->item('base_url2')?>images/logo_igain.ico">
	 <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.js"></script> 
	 <link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>css_slider/etalage.css">
	<script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/bootstrap.min.js"></script>
	<link href="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/alert_function.js"></script>
	<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
		<!------------------amit 12-07-2017------------>
		<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
		<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
		<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	
		<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.flexisel.js"></script>
		<!--<script src="<?php echo $this->config->item('base_url2')?>css_slider/jquery.min.js"></script>-->
		<!--<script src="<?php echo $this->config->item('base_url2')?>css_slider/jquery.min.js"></script>-->
		
		<link href="<?php echo $this->config->item('base_url2')?>css_slider/style.css" rel="stylesheet" type="text/css" media="all" />	
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<link href='https://fonts.googleapis.com/css?family=Exo:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
		
		<!--------amit end-------------------------------->
</head>

<?php
foreach($Company_details as $Company)
{
	$Company_name = $Company['Company_name'];
	$Company_id = $Company['Company_id'];
	$Company_address = $Company['Company_address'];
	$Company_primary_email_id = $Company['Company_primary_email_id'];
	$Website = $Company['Website'];
	$Company_primary_phone_no = $Company['Company_primary_phone_no'];
	$Company_logo = $Company['Company_logo'];
	$Cust_apk_link = $Company['Cust_apk_link'];
	$Cust_ios_link = $Company['Cust_ios_link'];	
	$Facebook_link = $Company['Facebook_link'];
	$Twitter_link = $Company['Twitter_link'];
	$Linkedin_link = $Company['Linkedin_link'];
	$Googlplus_link = $Company['Googlplus_link'];
	$Country = $Company['Country'];
}

?>
			
<body id="home" class="homepage">

    <header id="header">
        <nav id="main-menu" class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
				 <div class="row">
                <div class="col-sm-1" >            
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo base_url(); ?>" style="background:none;">
							<!--<img src="http://demo.igainspark.com/companyLogos/mumbaikar.jpg" height="57" alt="logo">-->
							<img src="<?php echo $this->config->item('base_url2').$Company_logo; ?>" height="57" alt="logo" >
						</a><br>
						
					</div>
                </div>
				<div class="col-sm-10" >
					<div class="collapse navbar-collapse navbar-right">
						<ul class="nav navbar-nav">
							<li class="scroll active"><a  href="<?php echo $this->config->item('base_url'); ?>" >Home</a></li>
							<li class="scroll"><a href="<?php echo $this->config->item('base_url');?>#services">Loyalty Rewards</a></li>
							<li class="scroll"><a href="<?php echo $this->config->item('base_url');?>#portfolio">Our Outlets</a></li>
							<li class="scroll"><a href="<?php echo $this->config->item('base_url');?>#about">About Program</a></li>
							<li class="scroll"><a href="<?php echo $this->config->item('base_url');?>#catelogue">Catalog</a></li>
							<li class="scroll"><a href="<?php echo $this->config->item('base_url');?>#meet-team">Contact Us</a></li>
							<li class="scroll"><a href="#" data-toggle="modal" data-target="#Cust_login_Modal">Member Login</a></li>  
												   
						</ul>
						
					</div>
				</div>
				<style>
				
				#lblCartCount {
				
					width: 20px;
					height: 20px;
					font-family: Calibri, 'Calibri', sans-serif;
					background-color: #09D218;
					color: #fff;
					font-size: 12px;
					border-radius: 10px;
					text-align: center;
					position: relative;
					z-index: 4;
					top: -29px;
					left: 29px;
					line-height: 1.65;

				</style>
				<?php
					$Total[]=0;
					$total_items[]=0;
					foreach ($this->cart->contents() as $items)
					{ 
						if($items['options']['E_commerce_flag']==0)		
						{
							$Total[]=($items['price']*$items['qty']);
							$total_items[]=1;
						}
					}
				?>
				<div class="col-sm-1" >            
					<div class="collapse navbar-collapse navbar-right">
						<ul class="nav navbar-nav">
							<li> 
								<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Checkout_front_page_items/?Company_id=<?php echo $Company_id;?>" >Cart<img style="width:30%;" src="<?php echo $this->config->item('base_url2'); ?>images/Ecommerce-Shopping-Cart-icon.png"><div id="lblCartCount"><?php echo array_sum($total_items); ?></div></a>
								
							</li>
												   
						</ul>
					</div>
                </div>	
				
            </div><!--/.container-->
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4U1mKm6UducB3tZ3-Fo9NvLxzbkIPk1Y&callback=initMap"
    async defer></script>
		<!-----------AMIT 12-07-2017---------------------->

	<br><br><br>
	<br><br>  
<style>
.img_container {
  position: relative;
  width: 50%;
}

.image {
  display: block;
  width: 200px;
  height: 199px;
   margin-left: -15.2%;
   /*
    margin-left: -8.2%;
	width: 168px;
   */
}

.overlay {
  position: absolute;
  bottom: 0;
  left: -62px;
  right: 0;
  background-color: rgba(0, 0, 0, 0.7);
  overflow: hidden;
 /* width: 99%;*/
  height: 0;
  width: 100%;
  transition: .5s ease;
  border-radius:4.0px;
}

.img_container:hover .overlay {
  height: 125%;
}

.text2 {
  white-space: nowrap; 
  color: white;
  font-size: 18px;
  position: absolute;
  overflow: hidden;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
}

.col-sm-4{
	margin-right:45px;
	margin-left:20px;
	border:solid 1px #dfdedb;
}

.modal-dialog 
{
    z-index: 9999999;
}
.text 
{
	  white-space: nowrap; 
	  color: white;
	  font-size: 20px;
	  position: relative;
	  overflow: hidden;
	  top: 60%;
	  left: 50%;
	  transform: translate(-50%, -50%);
	  -ms-transform: translate(-50%, -50%);
}
		
#loadingDiv
{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  background-image:url('<?php echo $this->config->item('base_url2') ?>images/loading.gif');
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */ 
}

#plus_img
{
	width:15%;
}
			

h5{
	font-weight:normal !important;
	line-height:15px !important;
}

@media screen and (max-width: 360px)
{
	.col-sm-4{
		width: 80.333%  !important;
	}
	.image {
		display: block;
		height: 199px;
		margin-left: -0.2%;
		width: 200px;
	}
	.overlay {
		background-color: rgba(0, 0, 0, 0.7);
		border-radius: 4px;
		bottom: -12px;
		height: 0;
		left: -31px;
		overflow: hidden;
		position: absolute;
		right: 0;
		transition: all 0.5s ease 0s;
		width: 106%;
	}
	#Item_name{
		margin-left: 10% !important;
	}
	.img_container{
		margin-left:7% !important;
	}
	.img_container:hover:.overlay{
		height:122% !important;
	}
	.col-sm-4 jumbotron{
		height: 340px  !important;
	}
}
@media screen and (min-width: 1280px)
{
	.overlay {
	  position: absolute;
	  bottom: 0;
	  left: -24%; 
	  right: 10%;
	  background-color: rgba(0, 0, 0, 0.7);
	  overflow: hidden;
	  width: 120%;
	  height: 0;
	  transition: .5s ease;
	  border-radius:5.5px;
	}
	.image {
	  display: block;
	  width: 200px;
	  height: 200px;
	   margin-left: -5%;
	}
	#Item_name
	{
		margin-left:0%;
	}
	
}
</style>
		 <section id="catelogue" >
				
					<!---->
				<div class="container">		
				<!-- Modal -->
	<div class="modal fade" id="Cust_login_Modal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">			
				<div class="login-box">					
					<div class="login-box-body">
						<p class="login-box-msg" style="font-size: 20px;"><strong>Member Sign In</strong></p>
						<!--<form action="<?php echo base_url()?>index.php/login" method="post" >-->
							<div class="form-group has-feedback">
								<input type="email" name="email" id="cust_email" class="form-control" placeholder="User Email ID" required>
								<span><?php echo form_error('email'); ?></span>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>							
							<div class="form-group has-feedback">
								<input type="password" name="password" id="Cust_password"  class="form-control" placeholder="Password" required>
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
								<span><?php echo form_error('password'); ?></span>
							</div>	
							<input type="hidden" class="form-control" id="callcenterticket"  name="callcenterticket"  value="0">
							<div class="row">
								<div class="col-xs-6">
									<button type="submit"  class="btn btn-primary btn-block btn-flat"  onclick="javascript:Member_login(Cust_password.value,cust_email.value);">Sign In</button>		
									<input type="hidden" name="flag" value="2" >
								</div>								
								<div class="col-xs-6">
									<button type="button" class="btn btn-primary btn-block btn-flat" data-dismiss="modal">Cancel</button>
								</div>
								<div class="col-xs-6">								
									<a href="#" data-toggle="modal" data-target="#Cust_forgot_Modal" id="ForgotPassword">I forgot my password</a>
								</div>
							</div>							
							<br>
							<hr class="style-eight">
							<!--<div class="row">
								<div class="col-xs-12">								
									<?php echo 'Are you a Member?'; ?> &nbsp;<a href="#" data-toggle="modal" data-target="#New_Membership_Registration" id="NewRegistration"> <?php echo 'Sign Up Here'; ?> </a>
								</div>
							</div>-->
							</div>
							<br>													
					<!--	</form>-->
					</div>
				</div>				
			</div>		
			<!-- Modal content-->		  
		</div>
					
	<!-- Modal -->
				
					<div class="section-header">
						<h2 class="section-title text-center wow fadeInDown">Redemption Catalog</h2>
					</div>
					
						
					<div class="row">
						<div class="container">
						<div class="col-md-3 ">
							<div class="form-group">
								<label for="exampleInputEmail1"><h5>Sort by Merchandise Catagory: </h5></label>
								
								<select class="form-control" name="Catagory" id="Catagory" onchange="Sort_by_category(this.value);" style="width:50%;">
									<option value="">Select</option>
									<option value="0"  <?php if(isset($_REQUEST["Sort_by_category_flag"])){if($_REQUEST["Sort_by_category_flag"]==0){echo "selected=selected";}}?>>All</option>
									<?php foreach ($Merchandize_category as $Merchandize_category){?>
									<option value="<?php echo $Merchandize_category->Merchandize_category_id; ?>"    <?php if(isset($_REQUEST["Sort_by_category_flag"])){if($_REQUEST["Sort_by_category_flag"]==$Merchandize_category->Merchandize_category_id){echo "selected=selected";}}?>  ><?php echo $Merchandize_category->Merchandize_category_name; ?></option>
									<?php } ?>
								</select>							
							</div>
					</div>
				<div class="col-md-3 ">
					<div class="form-group" >
						<label for="exampleInputEmail1"><h5>Sort by Merchants: </h5></label>
						
						<select class="form-control" name="Sort_merchants" id="Sort_merchants"  onchange="Sort_by_merchants(this.value);"  style="width:50%;">
							<option value="0">All</option>
							<?php foreach($Sellers as $Sellers) 
							{ 
							
						?>								 
							<option value="<?php echo $Sellers['Enrollement_id']; ?>" <?php if(isset($_REQUEST["Sort_by_merchant_flag"])){if($_REQUEST["Sort_by_merchant_flag"]==$Sellers['Enrollement_id']){echo "selected=selected";}}?>><?php echo $Sellers['First_name'].' '.$Sellers['Last_name']; ?></option>
						
						<?php } ?>
						
						</select>							
					</div>
				</div>
				<div class="col-md-3 ">
					<div class="form-group" >
						<label for="exampleInputEmail1"><h5>Sort by Points: </h5></label>
						
						<select class="form-control" name="Sort_points" id="Sort_points"  onchange="Sort_by_points(this.value);"  style="width:50%;">
							<option value="0">Select</option>
							<option value="1" <?php if(isset($_REQUEST["Sort_by_points_flag"])){if($_REQUEST["Sort_by_points_flag"]==1){echo "selected=selected";}}?>>Points:Low-High </option>
							<option value="2"  <?php if(isset($_REQUEST["Sort_by_points_flag"])){if($_REQUEST["Sort_by_points_flag"]==2){echo "selected=selected";}}?>>Points:High-Low </option>
							<option value="3"  <?php if(isset($_REQUEST["Sort_by_points_flag"])){if($_REQUEST["Sort_by_points_flag"]==3){echo "selected=selected";}}?>>Recently Added </option>
						
						</select>							
					</div>
				</div>
				<!------------------------Sort by brand------------------------->
				<div class="col-md-3 ">
					<div class="form-group" >
						<label for="exampleInputEmail1"><h5>Sort by Brand: </h5></label>
						
						<select class="form-control" name="Sort_brand" id="Sort_brand"  onchange="Sort_by_brand(this.value);"  style="width:50%;">
							<option value="0">All</option>
							<?php
							if($Item_brand != NULL)
							{
							 foreach($Item_brand as $brand)  
							{ 							
						?>								 
							<option value="<?php echo $brand->Item_Brand; ?>" <?php if(isset($_REQUEST["Sort_by_brand_flag"])){if($_REQUEST["Sort_by_brand_flag"]==$brand->Item_Brand){echo "selected=selected";}}?>><?php echo$brand->Item_Brand; ?></option>
						
						<?php } 
						}?>
						
						</select>							
					</div>
				</div>
				<!------------------------Sort by brand------------------------->
				
						<div id="loadingDiv" style="display:none;">
							<div>
								<h7>Please wait...</h7>
							</div>
						</div>
						<?php
				//print_r($Redemption_Items_branches);echo "<br><br>";
				
				if($Redemption_Items != NULL)
				{
					foreach ($Redemption_Items as $product)
					{
						
						$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];
					//style="width:150px;height:170px;"
					//class="price" style="color:#c00704;"
					?>	
							<div class=" col-sm-4 jumbotron" style="width: 26.333%;height:330px;">
							
								<div class="img_container" style="height:200px; width:250px;">
								
								  <img src="<?php echo $product['Item_image1']; ?>" alt="" class="image">
								  
								  <div class="overlay">
								 
									<div class="text2">
										<a href="javascript:void(0);" id="receipt_details" onclick="Show_item_info(<?php echo $product['Company_merchandise_item_id']; ?>);" style="color:white;"><br />
											<div>
												 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span align="center"> <img src="<?php echo $this->config->item('base_url2') ?>images/plus-white.png" alt="" width="25%;">
											</span> 
											</div>
											<br /> &nbsp;
											<div style="margin-top:-50px;">MORE DETAILS</div></a>
									</div>
								  </div>
								  
								</div>
								<div style="width:150px;" id="Item_name"> <!-- style="margin-left:-40%;width:200px;"-->
								<?php  
								if($product['Size_flag'] == 1) 
								{ 
									$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
									$Billing_price_in_points = $Get_item_price->Billing_price_in_points;
									$Item_size=$Get_item_price->Item_size;
								} 
								else 
								{
									$Item_size="0";
									$Billing_price_in_points = $product['Billing_price_in_points'];
									//echo $product['Billing_price_in_points'];
								}
								?>
									<p></p>
									<h5  align="center" style="line-height: 1.5em; height: 2em;       
										overflow: hidden; word-wrap: break-word;"><?php echo $product['Merchandize_item_name']; ?>
									<p></p>
									</h5>
									<h5 align="center" style="word-wrap: break-word;">
									<p style="font-size: 100%;color: #fd5f36;font-weight: 600;"><?php echo $Billing_price_in_points; ?> Points</p>
									
									</h5>
								
								</div>
							</div>
					<?php
					}
				}
				else
				{
					echo "<div align='center' ><h3 style='color:red;'>Sorry,Items not found !!!</h3></</div>";

				}
				?>		
				
					</div>
					</div>
					<div class="panel-footer"><?php echo $pagination; ?></div>
		</div>
		 </section>			
					<!-- Modal -->
	<div id="item_info_modal" class="modal fade" role="dialog" style="overflow:auto;">
		
		<div class="modal-dialog" style="width: 90%;" id="Show_item_info">


			<div class="modal-content" >
				<div class="modal-header">

				<div class="modal-body">
					<div class="table-responsive" id="Show_item_info"></div>
				</div>
				
			</div>
		
		</div>
	</div>
	</div>
		<script type="text/javascript">
		function Member_login(password,username)
		{
			/* alert('username'+username);
			alert('password'+password); */
			
			document.getElementById("loadingDiv").style.display="";
			window.location='<?php echo $this->config->item('base_url')?>index.php/login/?flag=2&email='+username+'&password='+password;
		}
		var Company_id=<?php echo $Company_id;?>;
		function Show_item_info(Company_merchandise_item_id)
		{	
			 document.getElementById("loadingDiv").style.display="";
			//alert("--Company_merchandise_item_id--"+Company_merchandise_item_id);
			$.ajax({
				type: "POST",
				data: {Company_merchandise_item_id: Company_merchandise_item_id},
				url: "<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details_front_page",
				success: function(data)
				{
					 document.getElementById("loadingDiv").style.display="none";
					$("#Show_item_info").html(data.transactionReceiptHtml);	
					$('#item_info_modal').show();
					$("#item_info_modal").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
				}
			});
			
		}
	function Sort_by_category(Merchandize_category)
	{
			 document.getElementById("loadingDiv").style.display="";
		var filter=0;
		var merchant=0;
		var brand=0;
		<?php
			if(isset($_REQUEST["Sort_by_points_flag"]))
			{ ?>
				var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_merchant_flag"]))
			{ ?>
				var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_brand_flag"]))
			{ ?>
				var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
			<?php }
		?>
		window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/View_all_items/?Company_id='+Company_id+'&Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand;
		
	}
	
	function Sort_by_points(filter)
	{
		document.getElementById("loadingDiv").style.display="";
		var Merchandize_category=0;
		var merchant=0;
		var brand=0;
		<?php
			if(isset($_REQUEST["Sort_by_category_flag"]))
			{?>
				var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_merchant_flag"]))
			{ ?>
				var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_brand_flag"]))
			{ ?>
				var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
			<?php }
		?>
		window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/View_all_items/?Company_id='+Company_id+'&Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand;
	
	}
	function Sort_by_merchants(merchant)
	{
		document.getElementById("loadingDiv").style.display="";
		var Merchandize_category=0;
		var filter=0;
		var brand=0;
		<?php
			if(isset($_REQUEST["Sort_by_category_flag"]))
			{?>
				var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_points_flag"]))
			{ ?>
				var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_brand_flag"]))
			{ ?>
				var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
			<?php }
		?>
		window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/View_all_items/?Company_id='+Company_id+'&Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand;
	
	}
	function Sort_by_brand(brand)
	{
		document.getElementById("loadingDiv").style.display="";
		var Merchandize_category=0;
		var filter=0;
		var merchant =0;
		<?php
			if(isset($_REQUEST["Sort_by_category_flag"]))
			{?>
				var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_points_flag"]))
			{ ?>
				var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
			<?php }
		?>
		<?php
			if(isset($_REQUEST["Sort_by_merchant_flag"]))
			{ ?>
				var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
		<?php }
		?>
		
		window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/View_all_items/?Company_id='+Company_id+'&Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand;
	}
	
</script>	

<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/css/jquery-ui.css">
<script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery-ui.js"></script>

<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.etalage.min.js"></script>
	
	    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/mousescroll.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/smoothscroll.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.isotope.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.inview.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/wow.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/main.js"></script>
</body>

												   
					
					
            