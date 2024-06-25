		
		<?php 
		$this->load->view('header/header');
		if(($Logged_user_id == 2 && $Super_seller == 0) || $Logged_user_id == 5 || $Logged_user_id == 6 )//|| $Logged_user_id == 4
		{
		?>
        <div class="row">
			<div class="col-md-12">
				<input type="text" name="member_id" tabindex="1" id="member_id" value="" style="border: 0px solid white; color: #fff; outline: none;"/>
				<img src="<?php echo base_url()?>images/landing_page.png" class="img-responsive" style="margin: 0px auto;" />
			</div>
		</div>
<?php
}
else
{
?>
       <div class="content-i">
            <div class="content-box">
			
				<?php  
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code'); ?>
							</div>
				<?php 	} 
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
				<?php 	} ?>
				<div class="row">
					<div class="col-sm-12">
					  <div class="element-wrapper">
						<h6 class="element-header">Renew/Upgrade Plan</h6>
					   
							  <div class="element-box-tp">
						  <div class="table-responsive">
						   <table class="table table-padded">
							  <thead>
							 
								<tr>
								 
								  <th class="text-center">
									Features
								  </th>
									<th class="text-center" <?php  if($Company_License_type==121){ ?>  style="background-color:green;color:white;" <?php } ?>>
									BASIC <span  class="smaller lighter" <?php if($Company_License_type==121){ ?>  style="font-size: 0.50rem;color:white !important;" <?php } ?>  style="font-size: 0.50rem;">(Free)</span>
								  </th>
								  <th class="text-center" <?php  if($Company_License_type==253){ ?>  style="background-color:green;color:white;" <?php } ?>>
									STANDARD<!--<br><span  class="smaller lighter" <?php if($Company_License_type==253){ ?>  style="font-size: 0.50rem;color:white !important;" <?php } ?> style="font-size: 0.50rem;" >($<?php echo $Standard_Monthly_Price; ?>/month)</span>-->
								  </th>
								  
								 
								  <th class="text-center" <?php  if($Company_License_type==120){ ?>  style="background-color:green;color:white;" <?php } ?>>
									ENHANCED<!--<span  class="smaller lighter"  <?php if($Company_License_type==120){ ?>  style="font-size: 0.50rem;color:white !important;" <?php } ?> style="font-size: 0.50rem;">($<?php echo $Enhance_Monthly_Price; ?>/month)</span>-->
								  </th>
								 
								 
								 
								</tr>
							  </thead>
							  <tbody>
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Enrollments</a><br>
										 <span  class="smaller lighter">( Members enrolled in Tiers)</span>
										
									</td>
									<td class="text-center smaller lighter">
									Upto <?php echo $Basic_limit; ?> members

									</td>
									<td class="text-center smaller lighter">
									Upto <?php echo $Standard_limit; ?> members


									</td>
									<td class="text-center smaller lighter">
									Upto <?php echo $Enhance_limit; ?> members


									</td>
											  
								</tr>
							
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >CSV / Excel Data Upload</a><br>
										 <span  class="smaller lighter">( Enrollment and Transaction)</span>
										
									</td>
								<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Loyalty Portal</a><br>
										 <span  class="smaller lighter">(  For Business and Members of Business)</span>
										
									</td>
								
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Loyalty Campaigns</a><br>
										 <span  class="smaller lighter">(   Loyalty Rule, Referral Rule, Gift Cards, Offers (Stamps))</span>
										
									</td>
									
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Gamifications</a><br>
										 <span  class="smaller lighter">(  Promo Campaign, Auction Bidding)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Discounts</a><br>
										 <span  class="smaller lighter">(  Implement Discount Rules)</span>
										
									</td>
								<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Personalization of Email Notifications</a><br>
										 <span  class="smaller lighter">(  Emails sent to Members can be customized with own design etc.)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Create Merchandizing Redemption Catalogue</a><br>
										 <span  class="smaller lighter">(Create own Merchandizing Catalogue Items to be made available for members to Redeem)</span>
										
									</td>
									
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >3rd Party eGifting Catalogue</a><br>
										 <span  class="smaller lighter">(E-Vouchers and E-Gift Cards from 12000 brands made available.
The value of those consumed by the members of the business will be billed to the Business at the End of Month)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Surveys</a><br>
										 <span  class="smaller lighter">(Create own Surveys and send to Customers and know your Promoters , Detractors and passive Customers)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Call Center</a><br>
										 <span  class="smaller lighter"></span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Loyalty APP</a><br>
										 <span  class="smaller lighter">( Android and iOS APP for Members of the Business)</span>
										
									</td>
								<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Basic Reporting</a><br>
										 <span  class="smaller lighter">( Dashboard, Enrollment Report, Transaction Report)</span>
										
									</td>
									
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Enhanced Reporting & Segmentation</a><br>
										 <span  class="smaller lighter">( Basic Reporting + Segmentation Feature, Audit Tracking, Company Liability, High Value , Order Report etc.)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							 
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >3rd Party API Integration</a><br>
										 <span  class="smaller lighter">( if the Business needs integration with any 3rd party System e.g. PoS, E-commerce etc. We make APIs available and help in integration)</span>
										
									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/close-thick.svg">

									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							 
							  <tr>
								  
									<td>
										<a class="badge badge-primary-inverted" >Support & Help</a><br>
										 <span  class="smaller lighter">( Made available through Email and Chat )</span>
										
									</td>
									
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
									<td class="text-center smaller lighter">
									<img src="<?php echo base_url();?>images/check-bold.svg">


									</td>
											  
								</tr>
							
							  <tr>
								  
									<td>
										&nbsp;
										
									</td>
									
									<td class="text-center smaller lighter">
									
									</td>
									<td class="text-center smaller lighter">
									<?php if($Company_License_type!=120){ ?>
									 <button class="btn btn-primary" data-dismiss="modal" type="button" <?php if($Company_License_type==253){ ?> style="background-color: green;border-color: green;" <?php } ?> id="standard" ><?php if($Company_License_type==253){ echo 'Renew Now'; }elseif($Company_License_type==120){echo 'Subscribe';}else{echo 'Upgrade';}?></button>
									<?php }?>
									</td>
									<td class="text-center smaller lighter">
									 <button class="btn btn-primary" <?php if($Company_License_type==120){ ?> style="background-color: green;border-color: green;" <?php } ?> data-dismiss="modal" type="button" id="enhance"><?php if($Company_License_type==120){ echo 'Renew Now'; }else{echo 'Upgrade';}?></button>

									</td>
											  
								</tr>
							
							  
							  </tbody>
							</table>
						  </div>
						</div>
					  
						 
						</div>
						</div>
					  
					
					  
					  
					  </div>
			   
					 
            </div>
        </div>

<html>  			  
			  
	<?php 
}
		$this->load->view('header/footer');
	?>
	
<script>
$('#standard').click(function()
{
	
	window.location.href='<?php echo base_url()?>index.php/Register_saas_company/License_billing/?Standard';
	
});
$('#enhance').click(function()
{
	
		window.location.href='<?php echo base_url()?>index.php/Register_saas_company/License_billing/?Enhance';
	
});
</script>
	<style>
	.el-tablo .value
	{
		font-size: 1.43rem !important;
	}
	</style>
	
