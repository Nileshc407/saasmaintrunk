<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Loyalty Programs</title>
    <?php $this->load->view('front/header/header'); ?>   
    <?php echo form_open_multipart('Beneficiary/Add_Beneficiary');?>
<div id="application_theme" class="section pricing-section" style="min-height:520px;">
        <div class="container">
            <div class="section-header">
               <p><a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_publisher_menu" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">Add Loyalty Programs</p>
            </div>
            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
                    <!-- 1st Card -->
                   <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">					  
						<div class="pricing-details">
							<!--<a href="<?php //echo base_url();?>index.php/Beneficiary/Added_Beneficiary_accounts">
								<button type="button" id="button" style="align:center;">My Loyalty Programs</button> </a> -->
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
									<a href="<?php echo base_url();?>index.php/Beneficiary/Add_Beneficiary?Publishers_category=<?php echo $CategoryID; ?>">
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
												<button type="button" id="button1" onclick="window.location.href='<?php echo base_url(); ?>index.php/Cust_home/front_home'">No Publisher Found</button>
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
   
    <?php echo form_close(); ?>
    <?php $this->load->view('front/header/footer');?>
<style>
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}
	
	.pricing-table
	{
		/* padding: 12px 12px 0 12px; */
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	address{font-size: 13px;}
	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}		
	#icon{
		float: right;
		margin: 11px 11px auto;
	}
	#icon2{
	   width: 25%; 
	}
</style>
<?php
    if(@$this->session->flashdata('success'))
    {
        ?>
        <script>
                var msg1 = '<?php echo $this->session->flashdata('success'); ?>';
                // alert(msg);
                // var msg1 = 'Please enter all details..!!';
                $('#Beneficiary_div').show();
                $('#Beneficiary_div').css("color","<?php echo $Small_font_details[0]['Small_font_color']; ?>");
                $('#Beneficiary_div').css("font-family","<?php echo $Small_font_details[0]['Small_font_family']; ?>");
                $('#Beneficiary_div').css("font-size","<?php echo $Small_font_details[0]['Small_font_size']; ?>");
                $('#Beneficiary_div').css("padding-bottom","20px");
                $('#Beneficiary_div').html(msg1);
                setTimeout(function(){ $('#Beneficiary_div').hide(); }, 3000);
        </script>
        <?php
    }
?>