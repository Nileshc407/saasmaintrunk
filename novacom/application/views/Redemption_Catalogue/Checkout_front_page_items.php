		

<?php 
header("Access-Control-Allow-Origin: *");
$this->load->helper('form'); ?>
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
	
		<link href="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/alert_function.js"></script>			
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/bootstrap.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	

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
							<li class="scroll active"><a  href="<?php echo base_url(); ?>" >Home</a></li>
							<li class="scroll"><a href="<?php echo base_url(); ?>#services">Loyalty Rewards</a></li>
							<li class="scroll"><a href="<?php echo base_url(); ?>#portfolio">Our Outlets</a></li>
							<li class="scroll"><a href="<?php echo base_url(); ?>#about">About Program</a></li>
							<li class="scroll"><a href="<?php echo base_url(); ?>#catelogue">Catalog</a></li>
							<li class="scroll"><a href="<?php echo base_url(); ?>#meet-team">Contact Us</a></li>
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
				}
					#loadingDiv{
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

				</style>
				<?php
					$Total1[]=0;
					$total_items[]=0;
					foreach ($this->cart->contents() as $items)
					{ 
						if($items['options']['E_commerce_flag']==0)		
						{
							$Total1[]=($items['price']*$items['qty']);
							$total_items[]=1;
						}
					}
				?>
				<div class="col-sm-1" >            
					<div class="collapse navbar-collapse navbar-right">
						<ul class="nav navbar-nav">
							<li> 
								<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Checkout_front_page_items/?Company_id=<?php echo $Company_id;?>">Cart<img style="width:30%;" src="<?php echo $this->config->item('base_url2'); ?>images/Ecommerce-Shopping-Cart-icon.png"><div id="lblCartCount"><?php echo array_sum($total_items); ?></div></a>
								
							</li>
												   
						</ul>
					</div>
                </div>	
				
            </div><!--/.container-->
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->
	
		<!-----------AMIT 12-07-2017---------------------->
<script>
		var Title = "Application Information";
		var msg = '<?php echo $errr_message; ?>';
		runjs(Title,msg);
	</script>
	<br><br><br>
	<br><br> 
		<div id="loadingDiv" style="display:none;">
							<div>
								<h7>Please wait...</h7>
							</div>
						</div>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">
						<div class="row">
							<div class="col-xs-2">
								<h5><span class="glyphicon glyphicon-shopping-cart"></span> Redemption Cart</h5>
							</div>
							<div class="col-xs-2">
								<button type="button" class="btn btn-primary btn-sm btn-block" onclick="window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/View_all_items/?Company_id=<?php echo $Company_id;?>';">
									<span class="glyphicon glyphicon-circle-arrow-left"></span> Continue Redeem
								</button>
							</div>
							<div class="col-xs-8" style="height:10%;">
								<div class="row" style="height:10%;">	
										<div class="col-md-6 col-md-offset-3" id="popup" style="width: 35%;font-size: 13px; margin-left: 30%;height:10%;display:none;">
											<div class="alert alert-success text-center" role="alert" id="popup_info">Cart Updated Successfully !!!</div>
										</div>
								</div>
								
							</div>
							
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row" style="line-height:17px !important;">
						
						<div class="col-xs-3">
						Item Name
						</div>
						
						<div class="col-xs-3">
						Delivery Method
						</div>
						
						<div class="col-xs-2">
						Item size
						</div>
						
						<div class="col-xs-3">
						Points	
						</div>
					</div>
					<?php 
					if($this->cart->total()==0){echo "Your Redemption Cart is empty";}
					?>
					
					<?php 
						$Total[]=0;
						foreach ($this->cart->contents() as $items)
								{ 
									if($items['options']['E_commerce_flag']==0)		
									{
										$Total[]=($items['price']*$items['qty']);
										
										
								?>
								<hr>
					<div class="row">
						
						<div class="col-xs-3">
						
							<img class="img-responsive" src="<?php echo $items['options']['Item_image1']; ?>" width="10%">
							<h5 class="product-name"><strong><?php echo $items['name']; ?></strong></h5>
						
						</div>
						
						<div class="col-xs-3">
							<h6 class="product-name"><?php if($items['options']['Redemption_method']==28){echo "Pick up";}else{echo "Home Delivery";} ?></h6>
						</div>
						
						<div class="col-xs-2">
						<?php
							if($items['options']['Size'] == 1)
							{
							  $size = "Small";
							}
							elseif($items['options']['Size'] == 2)
							{	
								$size = "Medium";
							}
							elseif($items['options']['Size'] == 3)
							{
								$size = "Large";
							}
							elseif($items['options']['Size'] == 4)
							{
								$size = "Extra Large";
							}
							else
							{
								$size = "-";
							}
							//echo $items['options']['Size']; ?>
							<h6 class="product-name"> <?php echo $size; ?> </h6>
						</div>
						
						<div class="col-xs-4" >
							<div class="col-xs-2" id="price">
								<h6><strong><?php echo $items['price']; ?> <span class="text-muted">x</span></strong></h6>
							</div>
							<div class="col-xs-3" id="qty">
								<input type="text" onkeypress='return isNumberKey2(event)' class="form-control input-sm" value="<?php echo $items['qty']; ?>" onchange="Update_front_page_item_cart(this.value,'<?php echo $items['rowid']; ?>')">
							</div>
							<div class="col-xs-1">
								<a href="javascript:void(0);" onclick="Remove_front_page_item('<?php echo $items['rowid']; ?>')"><span class="glyphicon glyphicon-trash"> </span></a>
								
							</div>
						</div>
					</div>
								<?php } }?>
					<hr>
					<div class="row">
						<div class="text-center">
							<div class="col-xs-10">
								<h6 class="text-right">Total:</h6>
							</div>
							<div class="col-xs-2">
							
								<button type="button" class="btn btn-default btn-sm btn-block" style=" font-size: 15px;">
									<div id="total"><?php echo array_sum($Total);//echo $this->cart->total(); ?></div>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row text-center">
						<div class="col-xs-10">
						</div>
						<div class="col-xs-2">
							<button type="button" class="btn btn-success btn-block"  data-toggle="modal" data-target="#Cust_login_Modal">
								Finish
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="Cust_login_Modal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">			
				<div class="login-box">					
					<div class="login-box-body">
						<p class="login-box-msg" style="font-size: 20px;"><strong>Member Sign In</strong></p>
						<form action="<?php echo base_url()?>index.php/login/?checkout_flag" method="post" >
							<div class="form-group has-feedback">
								<input type="email" name="email" class="form-control" placeholder="Email" required>
								<span><?php echo form_error('email'); ?></span>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>							
							<div class="form-group has-feedback">
								<input type="password" name="password"  class="form-control" placeholder="Password" required>
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
								<span><?php echo form_error('password'); ?></span>
							</div>							
							<div class="row">
								<div class="col-xs-6">
									<button type="submit"  class="btn btn-primary btn-block btn-flat">Sign In</button>		
									<input type="hidden" name="flag" value="2" >
									
								</div>								
								<div class="col-xs-6">
									<button type="button" class="btn btn-primary btn-block btn-flat" data-dismiss="modal">Cancel</button>
								</div>
							
							</div>							
							<br>
							<hr class="style-eight">
							<!--<div class="row">
								<div class="col-xs-12">								
									Are you a Member? &nbsp;<a href="#" data-toggle="modal" data-target="#New_Membership_Registration" id="NewRegistration"> Sign Up Here </a>
								</div>
							</div>-->
							</div>
							<br>													
						</form>
					</div>
				</div>				
			</div>		
			<!-- Modal content-->		  
		</div>
		
	<script>
	 function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	$('#error_display').show();
	setTimeout('HidePopup()', 6000);
}
function HidePopup()
{
	$('#popup').hide();
	$('#error_display').hide();
}
	function Update_front_page_item_cart(Input_Qty,rowid)
		{	
			/* alert("--rowid--"+rowid);
			alert("--Input_Qty--"+Input_Qty); */
			document.getElementById("loadingDiv").style.display="";
			if(Input_Qty<=0)
			{
				Remove_front_page_item(rowid);
			}
			$.ajax({
				type: "POST",
				data: {rowid: rowid,Input_Qty:Input_Qty},
				url: "<?php echo base_url()?>index.php/Redemption_Catalogue/Update_front_page_item_cart",
				success: function(data)
				{
					// alert(data);
					ShowPopup('Cart Updated Successfuly !!!');
					$("#lblCartCount").html(data.total_items);	
					$("#total").html(data.total);	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
					location.reload();
				}
			});
			
		}
	function Remove_front_page_item(rowid)
		{	
			var Company_id=<?php echo $Company_id;?>;
			document.getElementById("loadingDiv").style.display="";
			window.location="<?php echo base_url()?>index.php/Redemption_Catalogue/Remove_front_page_item/?rowid="+rowid+"&Company_id="+Company_id;
			ShowPopup('Cart Deleted Successfuly !!!');
		}
function isNumberKey2(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
 
  if (charCode == 46 || charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}
		
	</script>