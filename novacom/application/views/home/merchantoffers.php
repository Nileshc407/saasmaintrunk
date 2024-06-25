<?php $this->load->view('header/header');?>
<?php echo form_open_multipart('Cust_home/merchantoffers'); ?>			
	<section class="content-header">
	  <h1>
		Offers
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
			$Photograph=  base_url()."images/logo-circle.png";
		?>
		
			<div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Campaigns</h3>                 
                </div>         		
				<div class="row">	
				<?php 
					// $Photograph='images/no_image.jpeg';
					$offerCount=Count($MerchantLoyaltyDetails);
					if($MerchantLoyaltyDetails!= Null)
					{
						foreach($MerchantLoyaltyDetails as $offer_details)
						{
							if($i<=$offerCount)
							{
								if($offer_details['Tier_name'] == NULL)
								{
									$Lp_tier_name = "ALL";
								}
								else
								{
									$Lp_tier_name = $offer_details['Tier_name'];
								}
								
								$str = substr($offer_details['Loyalty_name'],0,2);
								if($str=='BA')
								{
									$str1='Paid Amount';
								}
								if($str=='PA')	
								{
									$str1='Amount';
								}
								if($offer_details['Loyalty_at_transaction'] != '0.00')
								{
									// echo $offer_details['Loyalty_name']." ".$offer_details['Loyalty_at_transaction']." %  On Every Transaction ".date('d-M-Y',strtotime($offer_details['From_date']))." To  : ".date('d-M-Y',strtotime($offer_details['Till_date']))."</td><td>'".$Lp_tier_name."' Tier Members ";
									
									$Offer_name=$offer_details['Loyalty_name'];
									
									$Offer_name1=substr($Offer_name,3);
									
									$Offer_detail=$offer_details['Loyalty_at_transaction']." %  On Every Transaction";
									
									$Validity = date('d-M-Y',strtotime($offer_details['From_date']))." To ".date('d-M-Y',strtotime($offer_details['Till_date']));
									
									$For_whom ="'".$Lp_tier_name."' Tier Members";
								}
								else
								{
									// echo $offer_details['Loyalty_name']." Get".$offer_details['discount']." %  discount on  ".$offer_details['Loyalty_at_value']." ".$str1." , ".date('d-M-Y',strtotime($offer_details['From_date']))." To  : ".date('d-M-Y',strtotime($offer_details['Till_date']))." ".$Lp_tier_name."' Tier Members</td></tr>";
									
									$Offer_name=$offer_details['Loyalty_name'];
									
									$Offer_name1=substr($Offer_name,3);
									
									// $Offer_detail=" Get".$offer_details['discount']." %  discount on  ".$offer_details['Loyalty_at_value']." ".$str1;
									$Offer_detail=" Get".$offer_details['discount']." %  discount on  ".$offer_details['Loyalty_at_value'];
									
									$Validity = date('d-M-Y',strtotime($offer_details['From_date']))." To ".date('d-M-Y',strtotime($offer_details['Till_date']));
									
									$For_whom ="'".$Lp_tier_name."' Tier Members ";
								}
								if($For_whom=="'Bronze' Tier Members") 
								{
									
									$color="#ad8a56";
								}
								else if($For_whom=="'Silver' Tier Members")
								{
									$color="#d7d7d7";
									
								}
								else if($For_whom=="'Gold' Tier Members")
								{
									$color="#c9b037";
								}
							?>
								<div class="col-md-4">				
									<div class="box box-widget widget-user-2">
										<div class="widget-user-header" id="offerDiv" style="background: <?php echo $color;?> !important;">	
											<div class="card-header"><img src="<?php echo $Photograph; ?>" class="img-circle" width="150" height="152" style="margin-left: 49px;"/></div>
											<h4> <b> <?php echo $Offer_name1; ?></b> </h4>
											<h5 style="line-height: 1.5em; height: 2em;       
												overflow: hidden;"><?php echo $For_whom; ?></h5>	
											<h5 style="line-height: 1.5em; height: 2em;       
												overflow: hidden;"><?php echo $Offer_detail."'s ".$str1; ?></h5>
											<h5 style="line-height: 1.5em; height: 2em;       
												overflow: hidden;"><?php echo $Validity; ?></h5>	
											<?php if($Tier_details->Tier_name==$Lp_tier_name || $Tier_details->Tier_name=="ALL") { ?>
												 <span class="badge badge-pill badge-success">Applicable For You</span>
											<?php } else { ?> <br> <?php  } ?>
										</div> 
									</div>
								</div>
					<?php	}
							$i++;
						}
					}
					?> 
				</div>		
			</div>	
	
	<?php 
	/*	$Referral_Offers_flag=0;
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
									<h4 class="widget-user-username"><?php echo $Referral_Offers[0]['First_name'].' '.$Referral_Offers[0]['Last_name']; ?></h4>
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
		} */
	?>
		<div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Communication Offers</h3>                 
			</div>         		
				<div class="row">
				<?php 
				if($MerchantCommunication!=NULL)
				{
					foreach($MerchantCommunication as $comm_details) 
					{	?>
						<div class="col-md-4">
							<h5> <?php echo $comm_details['communication_plan']; ?>  </h5>
							<?php echo $comm_details['description'];  ?> 
						</div>
	<?php	        }
				}   ?>			
				</div>
		</div>
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
.img-circle{
	background-color: #fefdf8 !IMPORTANT;
}
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
  background: -webkit-linear-gradient(#ffa48f , #abbaca40); 
  <!--background: -webkit-linear-gradient(#A5DBEA , #A5DBEA ); -->
}
p>img{
	width: 300px;
    height: 200px;
    padding: 0px;
   /*  height: 248px;	
	margin-left: -21px; */ 
}
.badge badge-pill, .badge-success{
       background-color: #008000 !Important
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