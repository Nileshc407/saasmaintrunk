<?php $this->load->view('header/header');?>
<?php echo form_open_multipart('Cust_home/merchantoffers'); ?>			
	<section class="content-header">
	  <h1>
		Merchant Offers
		<small></small>
	  </h1>         
	</section>
	<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
		<script>
				BootstrapDialog.show({
				closable: false,
				title: 'Application Information',
				message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
				buttons: [{
					label: 'OK',
					action: function(dialog) {
						window.location='<?php echo base_url()?>index.php/Cust_home/home';
					}
				}]
			});
			runjs(Title,msg);
		</script>
	<?php } ?>
        <!-- Main content -->
	<section class="content">
	<?php 
				$LTY_Offers_flag=0;
				foreach($SellerLoyaltyOffers as $LTY_Offers)
				{
					if($LTY_Offers)
					{
						$LTY_Offers_flag=1;
					}
				}						
				// echo"LTY_Offers_flag-----------".$LTY_Offers_flag;	
				
				if($LTY_Offers_flag==1)
				{
				?>
				<div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Merchant Campaigns</h3>                 
                </div>         		
				<div class="row">	
					<?php 
					foreach($SellerLoyaltyOffers as $LTY_Offers) 
					{
					
						if($LTY_Offers)
						{
							$result_loyalty= mb_substr($LTY_Offers[0]['Loyalty_name'], 0, 20);
							$Photograph = $LTY_Offers[0]['Photograph'];
							if($Photograph=="")
							{
								$Photograph='images/no_image.jpeg';
							}
					?>
					<div class="col-md-4">				
						<div class="box box-widget widget-user-2">
							<div class="widget-user-header" id="offerDiv">					
								<div class="widget-user-image">
									<img class="img-circle" src="<?php echo $this->config->item('base_url2')?><?php echo $Photograph; ?>" alt="User Avatar">
									<h4 class="widget-user-username" style="line-height: 1.5em; height: 3em; overflow: hidden;"><?php echo $LTY_Offers[0]['First_name'].' '.$LTY_Offers[0]['Last_name']; ?></h4>
									<h5 style="line-height: 1.5em; height: 3em;       
										overflow: hidden;" class="widget-user-desc"><?php echo $LTY_Offers[0]['Current_address']; ?></h5>	
								</div>
							</div>							
							<div class="box-footer no-padding">
								<ul class="nav nav-stacked">
									
									<li><a href="javascript:void(0);"><strong>City</strong> <span class="pull-right"><?php echo $LTY_Offers[0]['city_name']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>District</strong> <span class="pull-right"><?php echo $LTY_Offers[0]['District']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>State</strong> <span class="pull-right"><?php echo $LTY_Offers[0]['state_name']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Phone Number</strong> <span class="pull-right"><?php echo $LTY_Offers[0]['Phone_no']; ?></span></a></li>	
									<li><a href="javascript:void(0);" onclick="promo_file_details('<?php echo $LTY_Offers[0]['Enrollement_id']; ?>','<?php echo $LTY_Offers[0]['Company_id'];?>');"><span class="label label-info">See More</span></a></li>
								</ul>							  
							</div>
						</div>
					</div>
				<?php 
						}
					}
				?>		
				</div>		
				</div>		
				<?php 
				}						    
			?>
			<?php 
				$Referral_Offers_flag=0;
				foreach($SellerReferralOffers as $Referral_Offers)
				{
					if($Referral_Offers != false)
					{
						$Referral_Offers_flag=1;
					}
				}			
		if($Referral_Offers_flag==1)
		{
				?>
			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Referral Campaigns</h3>                 
				</div>         		
			<div class="row">	
			<?php 
			foreach($SellerReferralOffers as $Referral_Offers)
			{
				if($Referral_Offers != false)
				{
					$Photograph=$Referral_Offers[0]['Photograph'];
					if($Photograph=="")
					{
						$Photograph='images/no_image.jpeg';
					}
					?>
				<div class="col-md-4">
					<div class="box box-widget widget-user-2">
						<div class="widget-user-header" id="offerDiv">
							<div class="widget-user-image">
								<img class="img-circle" src="<?php echo $this->config->item('base_url2')?><?php echo $Photograph; ?>" alt="User Avatar">
								<h4 class="widget-user-username" style="line-height: 1.5em; height: 3em; overflow: hidden;"><?php echo $Referral_Offers[0]['First_name'].' '.$Referral_Offers[0]['Last_name']; ?></h4>
								<h5 style="line-height: 1.5em; height: 3em; overflow: hidden;" class="widget-user-desc" ><?php echo $Referral_Offers[0]['Current_address']; ?></h5>	
							</div>
						</div>							
						<div class="box-footer no-padding"> 
							<ul class="nav nav-stacked">
								<li><a href="javascript:void(0);"><strong>City</strong> <span class="pull-right"><?php echo $Referral_Offers[0]['city_name']; ?></span></a></li>
								<li><a href="javascript:void(0);"><strong>District</strong> <span class="pull-right"><?php echo $Referral_Offers[0]['District']; ?></span></a></li>
								<li><a href="javascript:void(0);"><strong>State</strong> <span class="pull-right"><?php echo $Referral_Offers[0]['state_name']; ?></span></a></li>
								<li><a href="javascript:void(0);"><strong>Phone Number</strong> <span class="pull-right"><?php echo $Referral_Offers[0]['Phone_no']; ?></span></a></li>	
								
								<li><a href="javascript:void(0);" onclick="referral_details('<?php echo $Referral_Offers[0]['Seller_id']; ?>','<?php echo $Referral_Offers[0]['Company_id'];?>');">
								<span class="label label-info">Click for Details</span>
								</a></li>
							</ul>
						</div>
					</div>
				</div>
		<?php 
				}
			}
			?>			
		</div>		
		</div>		
		<?php 			
		}
		?>
		<?php 
			$COMM_Offers_flag=0;
			foreach($SellerCommunicationOffers as $COMM_Offers) 
			{
				if($COMM_Offers)
				{	
						$COMM_Offers_flag=1;
				}
			}
			// echo"COMM_Offers_flag-----------".$COMM_Offers_flag;	
				
			if($COMM_Offers_flag==1)
			{
			?>
			 <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Merchant Communication Offers</h3>                 
                </div>         		
			<div class="row">
			<?php 
				foreach($SellerCommunicationOffers as $COMM_Offers) 
				{
					$Photograph=$COMM_Offers[0]['Photograph'];
					if($Photograph=="")
					{
						$Photograph='images/no_image.jpeg';
					}
					if($COMM_Offers)
					{
						$result_offer= mb_substr($COMM_Offers[0]['communication_plan'], 0, 20);
						// echo $result."<br>";
			?>
				<div class="col-md-4">
					<div class="box box-widget widget-user-2">
						<div class="widget-user-header" id="offerDiv">
							<div class="widget-user-image">
								<img class="img-circle" src="<?php echo $this->config->item('base_url2')?><?php echo $Photograph; ?>" alt="User Avatar">
								<h4 class="widget-user-username" style="line-height: 1.5em; height: 3em; overflow: hidden;"><?php echo $COMM_Offers[0]['First_name'].' '.$COMM_Offers[0]['Last_name']; ?></h4>
								<h5 style="line-height: 1.5em; height: 3em; overflow: hidden;" class="widget-user-desc"><?php echo $COMM_Offers[0]['Current_address']; ?></h5>	
							</div>
						</div>						
						<div class="box-footer no-padding">  
							<ul class="nav nav-stacked">	
								<li><a href="javascript:void(0);"><strong>City</strong> <span class="pull-right"><?php echo $COMM_Offers[0]['city_name']; ?></span></a></li>
								<li><a href="javascript:void(0);"><strong>District</strong> <span class="pull-right"><?php echo $COMM_Offers[0]['District']; ?></span></a></li>
								<li><a href="javascript:void(0);"><strong>State</strong> <span class="pull-right"><?php echo $COMM_Offers[0]['state_name']; ?></span></a></li>
								<li><a href="javascript:void(0);"><strong>Phone Number</strong> <span class="pull-right"><?php echo $COMM_Offers[0]['Phone_no']; ?></span></a></li>								
								<li><a href="javascript:void(0);" onclick="promo_file_details_second('<?php echo $COMM_Offers[0]['Enrollement_id']; ?>','<?php echo $COMM_Offers[0]['Company_id'];?>');"><span class="label label-info">See More</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			<?php
					}
				}
				?>				
			</div>
			</div>
	<?php   } ?>
	</section>	
	<div id="detail_myModal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 90%;" id="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
							
			  </div>
				<div class="modal-body1">
					<div class="table-responsive" id="show_promo_file_details"></div>						
				</div>
				<div class="modal-footer">
					<button type="button" id="close_modal" class="btn btn-default"  data-dismiss="modal">Close</button>
				</div>					
			</div>

		</div>
	</div>
<!-- referral_details Modal -->
	<div id="referral_Modal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 90%;" id="referral_details">

		<!-- Modal content-- 
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title text-center">Detail Transactions of : <?php //echo $Full_name; ?></h2>
				</div>
				<div class="modal-body1">
					<div class="table-responsive" id="show_transaction_receipt"></div>
				</div>
				<div class="modal-footer">
					<button type="button" id="print_modal" onclick="window.print();" class="btn btn-primary">Print</button>
					<button type="button" id="close_modal" class="btn btn-primary">Cancel</button>
				</div>
			</div>-->
		<!-- Modal content-->
			
		</div>
	</div>
	<!--Modal-->	
	<div id="detail_myModal_1" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 90%;" id="modal-dialog">
		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
				
			
			  </div>
				<div class="modal-body1">
					<div class="table-responsive" id="show_promo_file_details_1"></div>
					
				</div>
				<div class="modal-footer">
					<button type="button" id="close_modal2" class="btn btn-default"  data-dismiss="modal">Close</button>
				</div>
				
			</div>

		</div>
	</div>
	<!-- Modal -->	
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
<div id="loadingDiv" style="display:none;">
	<div>
		<h7>Please wait...</h7>
	</div>
</div>	 
<style>
modal
{
    display: block !important; /* I added this to see the modal, you don't need this */
}

/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body1
{
    height: 250px;
    overflow-y: auto;
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
#offerDiv
{
  background: -webkit-linear-gradient(#A5DBEA , #A5DBEA );
}
</style>
<script type="text/javascript">
function promo_file_details(enrollId,comp_id)
{	
 // document.getElementById("loadingDiv").style.display="";
	$.ajax({
		type: "POST",
		data: {enrollId: enrollId, comp_id:comp_id},
		url: "<?php echo base_url()?>index.php/Cust_home/merchant_loyalty_offer",
		success: function(data)
		{
			$("#show_promo_file_details").html(data.transactionDetailHtml);	
			$('#detail_myModal').show();
			$("#detail_myModal").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
function referral_details(Seller_id,Company_id)
{	
 // document.getElementById("loadingDiv").style.display="";
	$.ajax({
		type: "POST",
		data: {Seller_id:Seller_id, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Cust_home/show_referral_offers",
		success: function(data)
		{
			$("#referral_details").html(data.referralDetailHtml);	
			$('#referral_Modal').show();
			$("#referral_Modal").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
function promo_file_details_second(enrollId,comp_id)
{	
	 //document.getElementById("loadingDiv").style.display="";
		$.ajax({
		type: "POST",
		data: {enrollId: enrollId, comp_id:comp_id},
		url: "<?php echo base_url()?>index.php/Cust_home/show_Communication_offer",
		// url: "<?php echo base_url()?>index.php/Cust_home/merchantoffers",
		success: function(data)
		{
			$("#show_promo_file_details_1").html(data.transactionDetailHtml);	
			$('#detail_myModal_1').show();
			$("#detail_myModal_1").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		 $('#detail_myModal').hide();
		$("#detail_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal2" ).click(function(e)
	{
		 $('#detail_myModal_1').hide();
		$("#detail_myModal_1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>