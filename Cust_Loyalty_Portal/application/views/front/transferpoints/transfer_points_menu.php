<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Transfer</title>	
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
                <p><a href="<?php echo base_url(); ?>index.php/Cust_home/home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/left.png" id="arrow"></a></p>
                <p id="Extra_large_font">Transfer With <?php echo $Company_Details->Alise_name; ?></p>
            </div>
                <div class="row pricing-tables">
                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">        
                            <div class="pricing-details">
                                <ul>
                                    <a href="<?php echo base_url();?>index.php/Cust_home/transferpointsApp">
                                        <li>
                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/transfer.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font">Transfer to Member in <?php echo $Company_Details->Alise_name; ?></span>
                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
                                        </li>
                                    </a>
                                    <a href="<?php echo base_url();?>index.php/Transfer_publisher/From_publisher">
                                        <li>
                                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/transfer_across.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"> Transfer from Publishers</span>
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
	<div class="footer">
		<div class="row" id="foot1">
			<div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url(); ?>index.php/Cust_home/home">
				<img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/home.png" class="img-responsive" id="flat"><br />
				<span id="foot_txt">Home</span></a>
			</div>
			 <div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url()?>index.php/Beneficiary/Load_beneficiary">
					<img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/buyjoy.png" alt="" class="img-responsive" id="flat"><br />
					<span id="foot_txt">Buy with-<?php echo $Company_Details->Alise_name; ?></span>
				</a>
			</div>
			<div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/Redeemption_menu">
				<img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/redeem.png" class="img-responsive" id="flat"><br />
				<span id="foot_txt">Redeem with-<?php echo $Company_Details->Alise_name; ?></span></a>
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
<?php $this->load->view('front/header/footer'); ?> 
<style>	
#icon{
	float: right;
	 width: 6%;
	margin: 11px 11px auto;
}
	#icon2{
	   width: 25%; 
	}
</style>