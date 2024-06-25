<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Transfer History</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 	
</head>
<body>
<div id="application_theme" class="section pricing-section" style="min-height: 650px;" >
    <div class="container">
        <div class="section-header">          
                <p><a href="<?php echo base_url(); ?>index.php/Beneficiary/Load_beneficiary" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">Transfer History</p>
        </div>
        <div class="row pricing-tables">
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">

                <!-- 1st Card -->
                <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                <?php 
                    if($Beneficiary_Trans_points_history != "")
                    {
                               
                        foreach($Beneficiary_Trans_points_history as $Trans_RPT)
                        { 
                            $Topup_amount= $this->Beneficiary_model->get_received_points_beneficiary($Trans_RPT->Manual_billno,$Trans_RPT->From_Beneficiary_company_id,$Trans_RPT->To_Beneficiary_company_id);

                            // $Topup_amount=$Details->Topup_amount;
							?>
                            <div class="pricing-details">                        
                                <div class="row" >
                                    <div class="col-xs-12 text-center" style="width:100%" >
                                        <span id="Value_font"><?php echo date('Y-m-d',  strtotime($Trans_RPT->Trans_date)); ?></span>
                                    </div>
                                           
                                    <div class="col-md-12">
                                        <div class="row">
										
                                            
                                                <?php /* ?><span id="Medium_font">Sender</span><br />
                                                <span id="Value_font"><?php echo $Trans_RPT->From_Beneficiary_company_name; ?></span><br />
                                                <span id="Small_font">Identifier Id :</span>
                                                <span id="Value_font"><?php echo $Trans_RPT->Card_id; ?></span><br />
												 <span id="Small_font">Points :</span>
                                                <span id="Value_font"><?php echo $Trans_RPT->Transfer_points; ?></span> <?php */ ?>
												<?php /* ?>
												<div style="overflow-x:auto;" align="center">
													<table align="center">
														<tr>
															<td colspan="2" align="center"><strong id="Medium_font">Sender</strong></td>
															
															<td colspan="2" align="center"><strong id="Medium_font">Receiver</strong></td>
															
														</tr>
														<tr>
															<td colspan="2" align="left"><span id="Value_font"><?php echo $Trans_RPT->From_Beneficiary_company_name; ?></span></td>
															
															
															<td colspan="2" align="left"><span id="Value_font"><?php echo $Trans_RPT->To_Beneficiary_company_name; ?></span></td>

															
														</tr>										
												
														
														<tr>
															<td><strong id="Medium_font">Identifier</strong></td>
															<td> <span id="Value_font">:<?php echo $Trans_RPT->Card_id; ?></span></td>		
															
															<td><strong id="Medium_font">Identifier</strong></td>
															<td><span id="Value_font">:<?php echo $Trans_RPT->Card_id2; ?></span></td>

															
														</tr>												
														<tr>
															<td><strong id="Medium_font">Points</strong></td>
															<td><span id="Value_font">:<?php echo $Trans_RPT->Transfer_points; ?></span></td>	
															
															
															<td><strong id="Medium_font">Points</strong></td>
															<td><span id="Value_font">:<?php echo $Topup_amount; ?></span></td>
															
														</tr>										
													</table>
												</div> <?php */ ?>
												
												
												
												
												
												<table style="width:98%;margin-left: 2px;"  class="text-center">
													<thead>
													<tr>
														<th colspan="2" class="text-center"><strong id="Medium_font">Sender</strong></th>
														<th colspan="2" class="text-center"><strong id="Medium_font">Receiver</strong></th>
														
													</tr>
													<tr>
														<th colspan="2" class="text-center"><span id="Value_font"><?php echo $Trans_RPT->From_Beneficiary_company_name; ?></span></th>
														<th colspan="2" class="text-center"><span id="Value_font"><?php echo $Trans_RPT->To_Beneficiary_company_name; ?></span></th>														
													</tr>
													</thead>
													<tbody>
														<tr>
															<td><strong id="Medium_font">Identifier</strong></td>
															<td><span id="Value_font">:<?php echo $Trans_RPT->Card_id; ?></span></td>
															<td><strong id="Medium_font">Identifier</strong></td>
															<td><span id="Value_font">:<?php echo $Trans_RPT->Card_id2; ?></span></td>
														</tr>
														<tr>
															<td><strong id="Medium_font">Points</strong></td>
															<td><span id="Value_font">:<?php echo $Trans_RPT->Transfer_points; ?></span></td>
															<td><strong id="Medium_font">Points</strong></td>
															<td><span id="Value_font">:<?php echo $Topup_amount; ?></span></td>
														</tr>
													
													</tbody>
												</table>

												
                                            </div>
											
											
                                </div>
                                <hr style="width:98%;background:white;">
                                <br>
                            </div>
                            </div>
                           
                            
                <?php 
                        } 
                    }
                    else
                    { 
                ?>
                        <div class="pricing-details text-center">  
                            <div class="row" >
                                <div class="col-md-12 text-center">
                                    <strong id="Medium_font">No Records Found</strong><br />
                                </div>
                            </div>
                        </div>
                    <hr>
                <?php 
                
                    }
                ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
    <?php $this->load->view('front/header/footer');?> 

<script>
function cancel_order(Trans_id,Bill_no,Voucher_no,Item_name)
{	
// alert(Voucher_no);
	/* BootstrapDialog.confirm("Are you sure to cancel the Order  "+Item_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Shopping/Update_order_status/?serial_id='+Trans_id+'&Bill_no='+Bill_no+'&Voucher_no='+Voucher_no;
		if (result == true)
		{
			// show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		}
	}); */
	
	$.ajax(
    {
		type: "POST",
        data: { serial_id:Trans_id, Bill_no:Bill_no, Voucher_no:Voucher_no },
        url: "<?php echo base_url()?>index.php/Shopping/Update_order_status",
        success: function(data)
        {
			location.reload(true);
		}
	})
}
function return_order(Trans_id,Bill_no,Voucher_no,Item_name)
{	

	/* var url = '<?php echo base_url()?>index.php/Shopping/Update_order_status_return/?serial_id='+Trans_id+'&Bill_no='+Bill_no+'&Voucher_no='+Voucher_no;
	if (result == true)
	{
		// show_loader();
		window.location = url;
		return true;
	}
	else
	{
		return false;
	} */	
	$.ajax(
    {
		type: "POST",
        data: { serial_id:Trans_id, Bill_no:Bill_no, Voucher_no:Voucher_no },
        url: "<?php echo base_url()?>index.php/Shopping/Update_order_status_return",
        success: function(data)
        {
			location.reload(true);
		}
	})
}
</script>

<style>


table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  
}
th { 
  
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  
  text-align: left; 
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		
		font-weight: 600;
	}
	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		
	}
	
	
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
	
	
	
	#button{
		margin: 7%;
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
	
	
	
	#detail_purchase {
		line-height: 160%;
		width: 10%;
		margin-top: 10px;
	}
	
</style>