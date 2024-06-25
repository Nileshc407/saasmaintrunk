<!DOCTYPE html>
<html lang="en">
  <head>
 <title>My Statement</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?> 
</head>
<body> 
	<form  name="Search_statement" method="POST" action="<?php echo base_url()?>index.php/Cust_home/Search_statement" enctype="multipart/form-data">   
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
        <div class="container">
            <div class="section-header">          
                <p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font" style="margin-left: -3%;">My Statement</p>
            </div>
            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<div class="pricing-details">
						
						<address style="margin-left:-15px; margin-bottom:2px;"> 
							<a href="<?php echo base_url(); ?>index.php/Cust_home/Load_mystatement_APP"><span id="button5" onclick="Page_refresh();"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/refresh.png" style="width: 20px"></span></a>						
						   <input type="text" name="Search_key" placeholder="Search" id="Search_mail" class="txt" autocomplete="off">
						   <a href="#">
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png" id="search" onclick="form_submit();">
						   </a>
						</address> 
						
						<?php
						if($Trans_details!=Null)
						{
							foreach($Trans_details as $Trans)
							{
								$Merchant_name= $Trans->Seller_name;
								$Bill_no= $Trans->Bill_no;
								$Purchase_amount= $Trans->Purchase_amount;
								$Loyalty_pts= $Trans->Loyalty_pts;
								$Redeem_points= $Trans->Redeem_points;
								$Bonus_points= $Trans->Topup_amount;
								$Transfer_points= $Trans->Transfer_points;
								$Expired_points= $Trans->Expired_points;
								$Quantity= $Trans->Quantity;
								
								if($Merchant_name=="")
								{
									$Merchant_name='-';
								}
								if($Bill_no=="" || $Bill_no=="0")
								{
									$Bill_no='-';
								}
								if($Purchase_amount=="0")
								{
									$Purchase_amount='-';
								}
								if($Loyalty_pts=="0")
								{
									$Loyalty_pts='-';
								}
								if($Redeem_points=="0")
								{
									$Redeem_points='-';
								}
								if($Bonus_points=="0")
								{
									$Bonus_points='-';
								}
								if($Trans->Trans_type_id=="10")
								{
									$Redeem_points=($Redeem_points*$Quantity);
								}		
							?>		
							<div class="row" >
								<div class="col-md-12">
									<a href="<?php echo base_url();?>index.php/Cust_home/mystatement_details?Bill_no=<?php echo $Trans->Bill_no;?>&Seller_id=<?php echo $Trans->Seller; ?>&Trans_id=<?php echo $Trans->Trans_id; ?>&Company_id=<?php echo $Company_id;?>">
								
										<div class="row " id="Flydubai" >
											<div class="col-xs-8 text-left" id="detail">
												<strong id="Large_font"><?php echo $Trans->Trans_type; ?></strong><br/>					
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right" >
												
										<?php 
												if($Loyalty_pts+$Bonus_points !=0 && $Trans->Trans_type_id!=24)
												{ ?>
													<span id="Medium_font"><?php echo $Company_Details->Currency_name; ?> Earned : </span> <span id="Value_font"><strong> <?php echo ($Loyalty_pts+$Bonus_points); ?>  </strong></span><br>
										<?php	} 
												if($Trans->Trans_type_id ==25)
												{
												?> <!--
													<span id="Medium_font">For : </span> <span id="Value_font"><strong> <?php //echo $Trans->To_Beneficiary_cust_name.' ('.$Trans->To_Beneficiary_company_name.')'; ?> </strong></span><br> -->
													
													<span id="Medium_font">Buy <?php echo $Trans->To_currency; ?> : </span> <span id="Value_font"><strong> <?php echo $Purchase_amount; ?> </strong></span><br>
										<?php   }
												if($Trans->Trans_type_id ==24)
												{ ?> <!--
													<span id="Medium_font">From : </span> <span id="Value_font"><strong> <?php //echo $Trans->From_Beneficiary_cust_name.' ('.$Trans->From_Beneficiary_company_name.')'; ?> </strong></span><br>
													
													<span id="Medium_font">To : </span> <span id="Value_font"><strong> <?php //echo $Trans->To_Beneficiary_cust_name.' ('.$Trans->To_Beneficiary_company_name.')'; ?> </strong></span><br> -->
												
													<span id="Medium_font">Transferred : </span> <span id="Value_font"><strong> <?php echo $Trans->Transfer_points.' '.$Trans->form_currency; ?> </strong></span><br>
													
													<span id="Medium_font">Received : </span> <span id="Value_font"><strong> <?php echo $Trans->Topup_amount.' '.$Trans->To_currency; ?> </strong></span><br>
										<?php	}
												if($Redeem_points+$Transfer_points !=0 && $Trans->Trans_type_id!=24)
												{
												?>
													<span id="Medium_font"><?php echo $Company_Details->Currency_name; ?> Redeemed : </span> <span id="Value_font"><strong> <?php echo ($Redeem_points+$Transfer_points); ?> </strong></span><br>
										<?php   }  	
												if($Expired_points!=0)
												{
												?>
													<span id="Medium_font"><?php echo $Company_Details->Currency_name; ?> Expired : </span> <span id="Value_font"><strong> <?php echo $Expired_points; ?> </strong></span><br>
										<?php	} ?> 
												<span id="Small_font"><strong><?php echo date('d-M-Y', strtotime($Trans->Trans_date)); ?></strong></span>	
											</div>	 
										</div>
									</a>		
								</div>
							</div><hr>
										
					<?php   }
						}
						else
						{ ?>
							<div class="row ">
								<div class="col-xs-12 " style="width: 100%;">	
								<br/>
									<span id="Medium_font" class="uppercase">No Record Found.</span>
								</div>
							</div>
			<?php		}	?>															
									
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
	</form>
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
	 <script src="<?php echo base_url();?>assets/js/wow.js"></script>    
<?php $this->load->view('front/header/footer'); ?> 
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
		padding: 12px 12px 0 12px;
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
	#prodname{
		color: #7d7c7c;
		font-size:13px;
	}
	#img{
		float: right;
		width: 10%;
		margin: -18px -15px auto;
	}
	#detail {
		line-height: 160%;
		width: 90%;
		margin-top: 10px;
		padding-left: 5%;
	}
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

	document.Search_statement.submit();
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
function receipt_details(Bill_no,Seller_id,Trans_id,Transaction_type)//Amit 16-11-2017
{	
	//alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id+"--Transaction_type--"+Transaction_type);
	//var Transaction_type = 3;
        
	var Company_id='<?php echo $Company_id;?>';
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no,Seller_id:Seller_id,Trans_id:Trans_id,Transaction_type:Transaction_type,Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Cust_home/Cc_transaction_receipt",
		success: function(data)
		{
			// $("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			// $('#receipt_myModal').show();
			// $("#receipt_myModal").addClass( "in" );	
			// $( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
</script>