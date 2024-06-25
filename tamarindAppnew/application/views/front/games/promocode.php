<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Promo Code</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
  </head>
<body> 
<form  name="PromoCode" method="POST" action="<?php echo base_url()?>index.php/Cust_home/update_promocode_App" enctype="multipart/form-data" onsubmit="return sumbitPromoCode();">	
    <div id="application_theme" class="section pricing-section" style="min-height: 500px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?=base_url()?>index.php/Cust_home/Load_playGame_App" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Promo Code</p>
			</div>
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row ">
										<div class="col-xs-12 " style="width: 100%;">
											<address>
												<img src="<?php echo base_url(); ?>assets/icons/scratch.png" alt="" class="img-rounded img-responsive" style="width:50%; border-radius: 3%;">
											</address>
											<address>
												<strong id="Value_font">
													<input type="text" name="promo_code" placeholder="Enter Promo Code"  onblur="check_promo_code();" id="promo_code" class="txt">
												</strong> <br>
												<div class="help-block" style="float:center;"></div>
											</address> 	
											<address> 
											<button type="submit"  onclick="check_promo_code();" id="button">Submit</button>
											</address>
																						
											<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" />
											<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" />
											<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" >
											<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
											<input type="hidden" name="Current_balance" value="<?php echo $Current_balance=$Enroll_details->Total_balance; ?>" >
											<input type="hidden" name="Current_balance" value="<?php echo $Current_balance=$Enroll_details->Current_balance; ?>">											
										</div>										
									</div>
								</div>
							</div>
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
				   <div class="modal-body" style="padding: 10px 0px;">
					 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
    <!-- Loader -->
	
</form>
   <?php $this->load->view('front/header/footer'); ?> 
<style>
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
		text-align: center;
	}
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	address{
		font-size: 13px;
	}
	
	.card-span {

		color: #1fa07f !important;
		font-size: 12px !important;
		display: inline;
	}
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
	.X{
		color:#1fa07f;
	}
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
		
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 3% 2% 0% 3%;
		outline: none;
		width: 85%;
		margin-left: 0%;
		border-radius:10px;
	}
	.txt{
		border-left: none;
		border-left: none;
		border-top: none;
		padding: 3% 2% 0% 3%;
		outline: none;
		width: 85%;
		margin-left: 0%;
		border-radius:10px;
	}
	#prodname {
		color: #7d7c7c;
	}
	#detail{
		line-height: 160%;
		width: 100%;
	}
</style>
<script>		
function check_promo_code()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var membership_id = '<?php echo $Enroll_details->Card_id; ?>';
	var Currentbalance = '<?php echo $Enroll_details->Current_balance; ?>';
	var promo_code = $('#promo_code').val();
	
	if( $("#promo_code").val() == "" )
	{	
		var msg1 = 'Please Enter Valid Promo Code';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { promo_code: promo_code, Company_id:Company_id,Enrollment_id: Enrollment_id,Current_balance:Currentbalance,membership_id:membership_id },
			url: "<?php echo base_url()?>index.php/Cust_home/check_promo_code",
			success: function(data)
			{
				if(data == 0)
				{	
					$("#promo_code").val("");
					 var msg1 = 'In-valid Promo Code';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
				}
				else
				{
				
				}
			}
		});	
	}
}
function sumbitPromoCode()
{ 
	if($("#promo_code").val() =="")
	{
		var msg1 = 'Please Enter Valid Promo Code';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	else
	{	
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
		
		// document.PromoCode.submit();
	}
}
 </script>
