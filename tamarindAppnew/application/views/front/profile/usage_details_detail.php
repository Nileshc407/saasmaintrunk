<!DOCTYPE html>
<html lang="en">
<head>
<title>Usage Details</title>	
<?php $this->load->view('front/header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?>   
</head>
<body>  
    <div id="application_theme" class="section pricing-section" style="min-height: 500px;">
		<div class="container">
			<div class="section-header">
				<p><a href="<?php echo base_url();?>index.php/Cust_home/Usage_details" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Usage Details</p>
			</div>
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
				
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">

						<div class="pricing-details">
						<?php 
							$Merchant_name= $Trans_details->Seller_name;
							$Bill_no= $Trans_details->Bill_no;
							$Purchase_amount= $Trans_details->Purchase_amount;
							$Loyalty_pts= $Trans_details->Loyalty_pts;
							$Redeem_points= $Trans_details->Redeem_points;
							$Bonus_points= $Trans_details->Topup_amount;
							$Trans_type=$Trans_details->Trans_type;
							$Transfer_points= $Trans_details->Transfer_points;
							$Quantity= $Trans_details->Quantity;
							$Expired_points= $Trans_details->Expired_points;
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
							if($Trans_details->Trans_type=="10")
							{
								$Redeem_points=($Redeem_points*$Quantity);
							}
							if($Trans_details->Voucher_status==30 )
							{	
								$Voucher_status='Issued';
							}
							elseif($Trans_details->Voucher_status==31 )
							{
								$Voucher_status='Used';
							}
							elseif($Trans_details->Voucher_status==18 )
							{
								$Voucher_status='Ordered';
							}
							elseif($Trans_details->Voucher_status==19 )
							{
								$Voucher_status='Shipped';
							}
							elseif($Trans_details->Voucher_status==20 )
							{
								$Voucher_status='Delivered';
							}
							elseif($Trans_details->Voucher_status==21 )
							{	
								$Voucher_status='Cancel';
							}
							elseif($Trans_details->Voucher_status==22 )
							{
								$Voucher_status='Return Initiated';
							}
							elseif($Trans_details->Voucher_status==23 )
							{
								$Voucher_status='Returned';
							}
							elseif($Trans_details->Voucher_status==44)
							{
								$Voucher_status='Pending';
							}
							elseif($Trans_details->Voucher_status==45)
							{
								$Voucher_status='Approved';
							}
							elseif($Trans_details->Voucher_status==46)
							{
								$Voucher_status='Declined';
							}
							else
							{
								$Voucher_status='Expired';
							}

							if($Trans_details->Item_size==0) 
							{ 
								$Item_size=0; 
							} 
							elseif($Trans_details->Item_size==1) 
							{
								$Item_size="Small";
							} 
							elseif($Trans_details->Item_size==2) 
							{ 
								$Item_size="Medium"; 
							}
							elseif($Trans_details->Item_size==3) 
							{ 
								$Item_size="large"; 
							} 
							elseif($Trans_details->Item_size==4) 
							{ 
								$Item_size="Extra large"; 
							}	
							
						?>		
							<div class="row" >
								<div class="col-md-12">
									<div class="col-xs-8 text-left" id="detail">
									<div class="table-responsive">
									<table  class="table  table-hover">
									<thead>
									<?php if($Trans_details->Bill_no==0 && $Trans_details->Manual_billno==0)
										{ ?>
									<tr> 
										<td> <span id="Value_font"><strong><?php echo date('d-M-y', strtotime($Trans_details->Trans_date)); ?></strong></span></td>
										<td colspan="2"><strong id="Medium_font"><?php echo $Trans_details->TransType; ?></strong></td>	
									</tr>
								<?php 	}
										else
										{ ?>
									<tr colspan="3"> 
										<td > <span id="Value_font"><strong><?php echo date('d-M-y', strtotime($Trans_details->Trans_date)); ?></strong> </span></td>
										<td><strong id="Medium_font"> <?php echo $Trans_details->TransType; ?> </strong></td>
										<td><span id="Small_font"> Bill No. </span>
										<span id="Value_font"><strong><?php if($Trans_details->Bill_no!=0){ echo $Trans_details->Bill_no; } else { echo $Trans_details->Manual_billno; } ?></strong></span></td>
									</tr>
								<?php 	}
										if($Trans_type==8 || $Trans_type==21 || $Trans_type==24) 
										{ 
										 $Enrollement_id2 = $ci_object->Igain_model->get_enrollment_details($Trans_details->Enrollement_id2);
								?>										
									<tr>
										<td><span id="Small_font">Transferred To - </span></td>
										<td colspan="2"><span id="Value_font"><strong>  <?php echo $Enrollement_id2->First_name.' '.$Enrollement_id2->Last_name.' ('.$Trans_details->Card_id2.')'; ?>  </strong></span><br></td>
									</tr>
								<?php 	} 
										if($Trans_type==10 || $Trans_type==12 || $Trans_type==17 || $Trans_type==18 || $Trans_type==22) 
										{ ?>
									<tr>
											<td colspan="3"><span id="Value_font"><?php echo $Trans_details->Item_name; ?></span><?php if($Item_size!='0') { ?>
											 (<span id="Value_font"> <?php echo $Item_size;?></span>)<?php }?>, <span id="Small_font"> Qty :</span> <span id="Value_font"> <?php echo $Trans_details->Quantity; ?></span></td>
									</tr>
								<?php	} 
										if($Trans_type==2 || $Trans_type==12 || $Trans_type==4) 
										{ ?>
									<tr>		
											<td><span id="Small_font">Purchase Amount </span></td>
											<td colspan="2"><span id="Value_font"><strong>  <?php echo $Currency_Symbol.' '.$Trans_details->Purchase_amount; ?>  </strong></span><br></td>
									</tr>
								<?php	}
										if($Trans_type==25) 
										{ ?>
									<tr>		
											<td><span id="Small_font">For </span></td>
											<td colspan="2"><span id="Value_font"><strong>  <?php echo $Trans_details->To_Beneficiary_cust_name.' ('.$Trans_details->To_Beneficiary_company_name.')'; ?>  </strong></span><br></td>
									</tr>	
									<tr>		
											<td><span id="Small_font">Buy <?php echo $Trans_details->To_currency; ?> </span></td>
											<td colspan="2"><span id="Value_font"><strong>  <?php echo$Trans_details->Purchase_amount; ?>  </strong></span><br></td>
									</tr>
								<?php	}
										if($Trans_type==12) 
										{ 
											if($Trans_details->Shipping_cost!=0)
											{
												$Shipping_cost=$Trans_details->Shipping_cost; 
											}
											
										?>
									<tr>		
											<td><span id="Small_font">Delivery Cost </span></td>
											<td colspan="2"><span id="Value_font"><strong>  <?php echo $Currency_Symbol.' '.number_format($Shipping_cost,2); ?>  </strong></span><br></td>
									</tr>
								<?php	}
										if($Loyalty_pts+$Bonus_points !=0)
										{ ?>
										<tr>
											<td><span id="Small_font"><?php echo $Company_Details->Currency_name; ?> Received </span> </td>
											<td colspan="2"> <span id="Value_font"> <strong> <?php echo ($Loyalty_pts+$Bonus_points); ?>  </strong></span><br></td>
										</tr>
								<?php	} 
										if($Expired_points!=0)
										{ ?>
										<tr>
											<td><span id="Small_font"><?php echo $Company_Details->Currency_name; ?> Expired </span> </td>
											<td colspan="2"> <span id="Value_font"><strong> <?php echo $Expired_points; ?>  </strong></span><br></td>
										</tr>
								<?php	} 
										if($Redeem_points+$Transfer_points !=0)
										{
										?>
										<tr>
											<td><span id="Small_font"><?php echo $Company_Details->Currency_name; ?> Used  </span> </td>
											<td colspan="2"><span id="Value_font"><strong>  <?php echo ($Redeem_points+$Transfer_points); ?> </strong></span><br></td>
								<?php 	}
										if($Trans_type==10) 
										{ 
											if($Trans_details->Shipping_points!=0)
											{
										?>
										<tr>		
											<td><span id="Small_font">Delivery <?php echo $Company_Details->Currency_name; ?></span></td>
											<td colspan="2"><span id="Value_font"><strong> <?php echo $Trans_details->Shipping_points; ?>  </strong></span><br></td>
										</tr>		
										
									<?php	}
										}
										if($Trans_type==12)
										{
											$Shipping_cost=$Trans_details->Shipping_cost;
											$Purchase_amount=$Trans_details->Purchase_amount; 
											$Total_Purchase=$Shipping_cost+$Purchase_amount; 
										?>
										<tr>
											<td><span id="Small_font">Total Purchase </span> </td>
											<td colspan="2"><span id="Value_font"><strong>  <?php echo $Currency_Symbol.' '.number_format($Total_Purchase,2); ?> </strong></span><br></td>
								<?php 	} 	
										if($Trans_type==10)
										{
											$Shipping_points=$Trans_details->Shipping_points;
											$Total_points_use=$Redeem_points+$Shipping_points;
										?>
										<tr>
											<td><span id="Small_font">Total <?php echo $Company_Details->Currency_name; ?> Used </span> </td>
											<td colspan="2"><span id="Value_font"><strong>  <?php echo $Total_points_use; ?> </strong></span><br></td>
								<?php 	}
										if($Trans_type==10 || $Trans_type==12 || $Trans_type==17 || $Trans_type==18 || $Trans_type==22)
										{ ?>
										<tr>
											<td><span id="Small_font">Voucher No. </span> </td>
											<td colspan="2"><span id="Value_font"><strong>   
											<?php echo $Trans_details->Voucher_no; ?> </strong></span><br></td>
								<?php 	}	
										if($Trans_type==10 || $Trans_type==12 || $Trans_type==17 || $Trans_type==18 || $Trans_type==22)
										{ ?>
										<tr>
											<td><span id="Small_font">Voucher Status </span> </td>
											<td colspan="2"><span id="Value_font"><strong>   
											<?php echo $Voucher_status; ?> </strong></span><br></td>
								<?php 	}	
										if($Trans_type==25)
										{ ?>
										<tr>
											<td><span id="Small_font">Status</span> </td>
											<td colspan="2"><span id="Value_font"><strong>   
											<?php echo $Voucher_status; ?> </strong></span><br></td>
								<?php 	} 
										/* if($Trans_details->Seller_name!='')
										{
										?>
										<tr>
											<td><span id="Small_font">Done By </span> </td>
											<td colspan="2"><span id="Value_font"><strong>   
											<?php echo $Trans_details->Seller_name; ?> </strong></span><br></td>
										</tr>
								<?php	} */ ?>
										<tr>
											<td><span id="Small_font">Remarks </span> </td>
											<td colspan="2"><span id="Value_font"><strong>   
											<?php echo $Trans_details->Remarks; ?> </strong></span><br></td>
										</tr>
										<tr>
									</thead>
									</table>
									</div>	
									</div>	
								</div>
							</div><hr>					
					</div>		
					<!-- End -->
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
	
<?php $this->load->view('front/header/footer'); ?> 
<style>
.table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #eceeef;
}
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
	
	
	#detail
	{
		margin-left: 2%;
	}
</style>