<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Brand</title>	
<?php $this->load->view('front/header/header');

// echo "--Seller_id----".$Seller_id;

/* if($Seller_id==12){
	
} */

 ?> 	



</head>
<script>
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
</script>
<body>

<div id="application_theme" class="section pricing-section" style="min-height:970px;" >
    <div class="container" id="top_container">
        <div class="section-header" style="margin-bottom:1px;">    
			<p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Brand Dashboard</p>
        </div>
	
		<div class="row pricing-tables" id="front_head">
		
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/restaurant">
					<div class="item-boxes" style="height:100px;width:142px;background-color:#322210">						
						<div class="center">
							<strong style="color:#fff">RESTAURANT NEAR YOU</strong>
						</div>
					</div>
				</a>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Shopping">
					<div class="item-boxes" style="height:100px;width:142px;background-color:#322210">
						<div class="center">
							<strong style="color:#fff">MENU</strong>
						</div>
					</div>
				</a>
			</div>
			
			
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/MerchantCommunication">
					<div class="item-boxes" style="height:100px;width:142px;background-color:#322210">
						
						<div class="center">
							<strong style="color:#fff">MY OFFERS</strong>
						</div>
					</div>
				</a>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-6" >
				<a href="<?php echo base_url()?>index.php/Shopping/MyDiscountVouchers?Sort_by_merchant_flag=<?php echo $Seller_id; ?>" >
					<div class="item-boxes" style="height:100px;width:142px;background-color:#322210">
						<div class="center">
							<strong style="color:#fff">MY VOUCHERS </strong>
						</div>
					</div>
				</a>
			</div>  
		
		</div>
		<div class="row" id="front_head">
			<?php foreach($Sub_Seller_details as $seller) {

						$Photograph = $seller['Photograph'];

						//$Photograph='qr_code_profiles/'.$enroll.'profile.png';
						
						if($Photograph=="")
						{
							// $Photograph='images/No_Profile_Image.jpg';
							$Photograph="images/dashboard_profile.png";
						}
						/* style="background-image: url(<?php echo $this->config->item('base_url2').$Photograph; ?>);background-repeat: no-repeat;background-position: center; height:200px; padding:2px;"

						<?php echo base_url()?>index.php/Beneficiary/Load_beneficiary
						
						*/
					?>
					
					<div class="col-md-12 col-sm-12 col-xs-12" style="width:100%;">
						<a href="#">
							<div class="item-boxes">
								<h2 id="Medium_font" style="padding-top: 16px;"><?php echo $seller['First_name'].' '.$seller['Last_name']; ?> </h2>
								<img class="d-block w-100" style="padding: 10px;" src="<?php echo $this->config->item('base_url2').$Photograph; ?>"  width="50">
							</div>
						</a>
					</div>
						<br>
				<?php } ?>
		
			
		</div>
		
	</div>
</div>
	
	
	  <!-- Loader -->	
		<div class="container" >
			<div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-sm" style="margin-top: 65%;">
				  <!-- Modal content-->
				  <div class="modal-content" id="loader_model">
						<div class="modal-body" style="padding: 10px 0px;;">
						  <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
						</div>							
				  </div>						  
				</div>
			</div>					  
		</div>
		<!-- Loader -->	
    </section>
<?php $this->load->view('front/header/footer'); ?> 	
<style>
<?php /* if($Company_id ==3){
	?>
	#icon{width:65% !important}
	<?php
} else if($Company_id ==4) {
	?>
	#icon{width:100% !important;}
	<?php
}  */?>

.center {
	width: 111px;
	padding-top: 33px;
	padding-left: 25px;
}

#icon{
	/* width:65% !important; */
    width: 45% !important;
    margin-top: 18px;}
	
	.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9 {
		position: relative;
		width: 50%;
		min-height: 1px;
		padding: 7px;
		margin-bottom: -21px;
	}	
	@media only screen and (min-width: 320px) 
	{
		.top-right 
		{
			position: absolute;
			top: 6px;
			right: 42px;
			color:white;
		}
		.bottom-right 
		{
			position: absolute;
			bottom: 8px;
			right: 16px;
			color:white;
		}
	}	
	@media only screen and (min-width: 768px) 
	{
		.top-right 
		{
			position: absolute;
			top: 6px;
			right: 70px;
			color:white;
		}
		.bottom-right
		{
			position: absolute;
			bottom: 8px;
			right: 16px;
			color:white;
		}
	}	
	#dot 
	{
		height: 26%;
		width: 20%;
		background-color: #322210;
		border-radius: 23%;
		display: inline-block;
		padding: 6px;
	}
    #notify_count
	{
		text-align: center;
		margin: 0 auto;
    }
	.item-boxes 
	{
		text-align: center;
		padding: 0px;
		border-radius: 4px;
		margin-bottom: 15px;
		webkit-transition: all 0.3s ease 0s;
		-moz-transition: all 0.3s ease 0s;
		transition: all 0.3s ease 0s;
	}
	.section 
	{
		/* padding: 80px 0; */
		padding: 0px 0 0px 0;
	}
	/* .selected{
     box-shadow:0px -2px 1px 3px <?php echo $General_details[0]['Theme_color']; ?>; 
	} */
</style>
<script>
	$('img').click(function(){
		// $('.selected').removeClass('selected');
		// $(this).addClass('selected');
		
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
	});	
</script>