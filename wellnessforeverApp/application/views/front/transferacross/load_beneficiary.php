<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Publisher </title>	
	<?php $this->load->view('front/header/header');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }	
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	?> 
  </head>
  <body>
         
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
		<div class="container">
            <div class="section-header">          
                <p><a href="<?php echo base_url(); ?>index.php/Cust_home/home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">Loyalty Publisher</p>
            </div>
			<div class="row pricing-tables">
			  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">        
				  <div class="pricing-details">
					<ul>
					<?php 
					if($Publishers_Category!=NULL)
					{
						foreach($Publishers_Category as $Category)
						{  
							$CategoryID=$Category->Code_decode_id; 
							if($CategoryID==47)
							{
								$icon_name='air.png';
							}
							else if($CategoryID==48)
							{
								$icon_name='hospitality.png';
							}
							else if($CategoryID==49)
							{
								$icon_name='retail.png';
							}
							else if($CategoryID==50)
							{
								$icon_name='telecom.png';
							}
							else if($CategoryID==51)
							{
								$icon_name='car.png';
							}
							else
							{
							  $icon_name='';
							}
						?>		
							<a href="<?php echo base_url();?>index.php/Beneficiary/Beneficiary_Points_Transfer?Publishers_category=<?php echo $CategoryID; ?>">
								<li>
									<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/<?php echo $icon_name;?>" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"><?php echo $Category->Code_decode; ?></span>
									<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
								</li>
							</a>
				<?php	} 
					}
					else 
					{ ?>
						 <div class="pricing-details">
							<div class="row">
								<div class="col-md-12">			
									<address>
										<button type="button" id="button1" onclick="window.location.href='<?php echo base_url(); ?>index.php/Cust_home/home'">No Publisher Found</button>
									</address>
								</div>
							</div>
						</div>
	<?php			} ?> 
					</ul>
				  </div>
				  
				</div>
			  </div>
			</div>
		</div>
    </div>
    <!-- End Pricing Table Section-->
		
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
<?php $this->load->view('front/header/footer'); ?> 
<style>	
#icon{
	float: right;
	margin: 11px 11px auto;
}
	#icon2{
	   width: 25%; 
	}
</style>