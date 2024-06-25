<!DOCTYPE html>
<html lang="en">
<head>
<title>My Transaction</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 
?> 
</head>	
<body>
<form  name="Issuance_details" method="POST" action="<?php echo base_url()?>index.php/Cust_home/Search_issuance_details" enctype="multipart/form-data">	
<div id="application_theme" class="section pricing-section" style="min-height: 500px;">
    <div class="container">
        <div class="section-header ">     
			<p><a href="<?=base_url()?>index.php/Cust_home/dashboard" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">My Transaction</span>
        </div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">    <div class="pricing-details">   
					<address style="margin-left:-15px; margin-bottom:10px;"> 
						<a href="<?php echo base_url(); ?>index.php/Cust_home/Issuance_details"><span id="button5" onclick="Page_refresh();"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/refresh.png" style="width: 20px"></span></a>						
					   <input type="text" name="Search_key" placeholder="Search" id="Search_mail" class="txt1" autocomplete="off">
					   <a href="#">
						<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png" id="search" onclick="form_submit();">
					   </a>
					</address>
				<?php
				if($Trans_details!=NULL)
				{ 
					foreach($Trans_details as $row) 
					{ ?>
					 
					<div class="row" >
						<div class="col-md-12"> 
							<a href="<?php echo base_url();?>index.php/Cust_home/IssuanceTransactionDetails?Bill_no=<?php echo $row->Bill_no;?>&Seller_id=<?php echo $row->Seller; ?>&Trans_id=<?php echo $row->Trans_id; ?>&Company_id=<?php echo $row->Company_id;?>">
							<div class="row" id="Lulu">
								<?php 
									$Photograph = $row->Photograph;							
									if($Photograph=="")
									{
										$Photograph='images/No_Profile_Image.jpg';
									} 
									
									// echo "---Trans_id-----".$row->Trans_id."---<br>";
								?>								
								
								<?php /* ?>
									<div class="col-xs-4" style="padding: 10px;">
										<img src="<?php echo $this->config->item('base_url2').'/'.$Photograph; ?>" alt="" class="img-rounded img-responsive" width="60">
									</div>
								<?php */ ?>
								
                                    <div class="col-xs-8 text-left" id="detail" style="width: 70%;">
									<strong id="Large_font"><?php echo $row->First_name.' '.$row->Last_name;?></strong><br />
									<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right" style="margin-left: 70px;">	<!--								
									<span style="color: #1fa07f; margin-bottom: 0; font-size: 10px; float: right; margin-left: 25px;"><strong style="margin-right:-32px;">Issued</strong></span>-->
									<?php if($row->TransType==1) { ?>
											<span style="margin-bottom: 0;">
											<strong id="Value_font">
												<?php echo $row->Topup_amount; ?> <?php echo $Company_Details->Currency_name; ?></strong></span>&nbsp;
											
									<?php } else if($row->TransType==2 || $row->TransType==12) { ?>
												<br/> 
												<span style="margin-bottom: 0;">
													<strong id="Medium_font">  Bill No.</strong>&nbsp;<strong id="Value_font"><?php echo $row->Bill_no; ?> </strong>
												</span>
												<br/> 
												<span style="margin-bottom: 0;">
													<strong id="Medium_font">  Bill Amount</strong>&nbsp;<strong id="Value_font"><?php echo $row->Purchase_amount; ?> </strong>
												</span>
												
									<?php /* if($row->Redeem_points > 0) { ?>	
									
												<br><span style="margin-bottom: 0;">
													<strong id="Medium_font"><strong id="Value_font"><?php echo $Company_Details->Currency_name; ?></strong> Redeemed</strong>&nbsp;<strong id="Value_font"><?php echo $row->Redeem_points; ?> </strong>
												</span>&nbsp;
									<?php } */ ?>
									
									
									<br/> <?php } ?>
									<span style="margin-bottom: 0;"><strong id="Small_font"><?php echo date('Y-M-d', strtotime($row->Trans_date)); ?></strong></span>
								</div>
							</div>
							</a>
			
						</div>
					</div> <hr>	
					
			<?php 	}
				}
				else
				{ ?>				
					  <div class="pricing-details">
						<div class="row">
							<div class="col-md-12">			
								<address>
									<strong id="prodname" style="color:<?php echo $Value_font_details[0]['Value_font_color']; ?>;">No Record Found</strong><br>
								</address>
							</div>
						</div>
					</div>
		<?php   } ?>
				</div>
            </div>
		</div>	 
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
			<!-- Modal content-->
		  </div>
	 </div>       
</div>
<!-- Loader -->
	
<form>
<?php $this->load->view('front/header/footer'); ?> 
<style>	
	.X{
		color:#1fa07f;
	}
	#icon{
		width: 8%;
		margin-top: 2%;
	}		
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		outline: none;
		width: 100%;
		margin-left: 0%;
		border-radius:10px;
	}
	.txt{
		border-left: none;
		border-left: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		outline: none;
		width: 100%;
		margin-left: 0%;
		border-radius:10px;
	}
	#datepicker1
	{
		color:<?=$Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?=$Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?=$Value_font_details[0]['Value_font_size']; ?>
	}
	#datepicker2
	{
		color:<?=$Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?=$Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?=$Value_font_details[0]['Value_font_size']; ?>
	}
	::-moz-placeholder {
    color:<?php echo $Placeholder_font_details[0]['Placeholder_font_color'];?>;
    font-family:<?php echo $Placeholder_font_details[0]['Placeholder_font_family'];?>;
    font-size:<?php echo $Placeholder_font_details[0]['Placeholder_font_size'];?>;
    opacity: 1;
		/* Firefox */
	}
	::-webkit-input-placeholder {
    color:<?php echo $Placeholder_font_details[0]['Placeholder_font_color'];?>;
    font-family:<?php echo $Placeholder_font_details[0]['Placeholder_font_family'];?>;
    font-size:<?php echo $Placeholder_font_details[0]['Placeholder_font_size'];?>;
    opacity: 1;
	/* Chrome */		
</style>
<script>	  
function form_submit()
{
	setTimeout(function() 
	{
			$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
			$('#myModal').modal('hide'); 
	},2000);

	document.Issuance_details.submit();
} 
function Page_refresh()
{
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
	
	// window.location.reload();
} 
</script>