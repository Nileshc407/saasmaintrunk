<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Membership</title>	
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
                <p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">Membership</p>
            </div>
                <div class="row pricing-tables">
                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">        
                            <div class="pricing-details">
                                <ul>
                                    <a href="<?php echo base_url();?>index.php/Beneficiary/Add_Beneficiary_Category">
                                        <li>
                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/membership.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font">Add Loyalty Programs</span>
                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
                                        </li>
                                    </a>
                                    <a href="<?php echo base_url();?>index.php/Beneficiary/Added_Beneficiary_accounts">
                                        <li>
                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/card.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"> My Loyalty Programs</span>
                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
                                        </li>
                                    </a>
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