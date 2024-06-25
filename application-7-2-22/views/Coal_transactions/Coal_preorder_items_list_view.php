<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">PREORDER ITEM LIST</h6>
                    <div class="element-box">
                        <?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>                       
						
						<!-------------------- START - Data Table -------------------->	
						<?php 
						if($Preorder_items_not_done != NULL) {
                        ?>
						<h5 class="form-header">                            
							Preorder Item list
                        </h5>                
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
										<th>Item</th>
                                        <th>Member name</th>
                                        <th>Quantity</th>
                                        <th>Trans. type</th>
                                        <th>Sub Total</th>
                                        <th>Sales Tax</th>
                                        <th>Grand Total</th>
                                        <th>Order Date-Time</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Item</th>
                                        <th>Member name</th>
                                        <th>Quantity</th>
                                        <th>Trans. type</th>
                                        <th>Sub Total</th>
                                        <th>Sales Tax</th>
                                        <th>Grand Total</th>
                                        <th>Order Date-Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
									<?php 
										$Todays_date=date("Y-m-d");
										foreach ($Preorder_items_not_done as $item) {
											
											$Trans_type="Redemption";
											$Symbol="Points";
											
											$Sub_Total=($item["Total_Price_Points"]*$item["QTY"]);
											$Sales_tax='-';
											$Sales_tax2=0;
											$Grand_total=round($Sub_Total);
											if($item["Trans_type"]==2)
											{
												$Trans_type="Purchase";
												$Symbol=$Symbol_currency;
												
												$Sub_Total=($item["Total_Price_Points"]*$item["QTY"]);
												$Sales_tax=round(($Sub_Total*$Merchant_sales_tax)/100,2);
												$Sales_tax2=round(($Sub_Total*$Merchant_sales_tax)/100,2);
												$Sales_tax=$Sales_tax.' <span class="required_info" style="font-size: 8px;">'.$Symbol_currency.'</span>';
												$Grand_total=round(($Sub_Total+$Sales_tax),2);
											}
											$Signal="green";
											//echo '<br>if('.$Current_time.' > '.$item["Order_time"].' || '.$Todays_date.'>'.$item["Order_date"].')';
											if($Current_time > $item["Order_time"] || $Todays_date>$item["Order_date"])
											
											{
												$Signal="red";												
											}											
											$Full_name=$item["First_name"]." ".$item["Last_name"];
										?>
                                        <tr>
                                            <td><a>
													<img src="<?php echo $item["Thumbnail_image1"]; ?>"  style="width:50px;height:50px;" >
												</a>
												<br>
												<a><?php echo $item["Merchandize_item_name"]; ?></a>
											</td>
												
                                            <td><?php echo $Full_name." (".$item["Card_id"]." )"; ?> </td>
                                            <td><?php echo $item["QTY"]; ?> </td>
                                            <td><?php echo $Trans_type; ?> </td>
                                            <td><?php echo $Sub_Total." "; ?><span class="required_info" style="font-size: 8px;"><?php echo $Symbol;?></span></td>
                                            <td><?php echo $Sales_tax." "; ?><span class="required_info" style="font-size: 8px;"></span> </td>
                                            <td>
												<?php echo $Grand_total." "; ?><span class="required_info" style="font-size: 8px;"><?php echo $Symbol;?></span>
											</td>
											<td style="color:<?php echo $Signal;?>;">
														<?php echo $item["Order_date"]; ?>
														<?php echo $item["Order_time"]; ?>
											</td>
											<td width="15%">
													<div class="form-group">
													
													<select class="form-control" name="status" id="status_<?php echo $item["Id"]; ?>" >
													<option value="2">Complete</option>
														<option value="1">Not taken</option>
														
														<option value="3">Cancel</option>
														
													</select>							
												</div>
											</td>
											<td>
													<div class="col-md-8 text-left" >
														<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary" onclick="javascript:submit_preorder(<?php echo $item["Id"]; ?>,'<?php echo $item["Card_id"]; ?>',<?php echo $item["QTY"]; ?>,<?php echo $item["Trans_type"]; ?>,<?php echo $Sub_Total; ?>,<?php echo $item["Cust_enroll_id"]; ?>,'<?php echo $item["Company_merchandize_item_code"]; ?>',<?php echo $item["Partner_id"]; ?>,'<?php echo $Full_name; ?>','<?php echo $item["Merchandize_item_name"]; ?>','<?php echo $Symbol_currency; ?>','<?php echo $item["Cust_seller_balance"]; ?>','<?php echo $item["Cust_prepayment_balance"]; ?>',<?php echo $Sales_tax2; ?>,<?php echo $Grand_total; ?>);">Submit</button>
													</div>
													</td>
                                        </tr>
								<?php } ?>
                                </tbody>
                            </table>
                        </div>    
													
						<?php 
						} else {
							?>
								<div class="text-center">
									<span class="required_info" style="font-size: 18px;">Sorry, No preorder found..!!</span>
								</div>
						<?php }
                        ?>
						
                    </div>
					
					
					<div class="element-box">
                                              
						
						<!-------------------- START - Data Table -------------------->	
						<?php 
						if($Preorder_items_done != NULL) {
                        ?>
						<h5 class="form-header">                            
							Preorder Done Transactions
                        </h5>                
                        <div class="table-responsive">
                            <table id="dataTable2" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
										<th>Trans Date</th>
										<th>Item</th>
                                        <th>Member name</th>
                                        <th>Quantity</th>
                                        <th>Trans. type</th>
                                        <th>Sub Total</th>
                                        <th>Sales Tax</th>
                                        <th>Grand Total</th>
                                        <th>Order Date-Time</th>
                                        <th>Status</th>
                                      

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
										<th>Trans Date</th>
                                        <th>Item</th>
                                        <th>Member name</th>
                                        <th>Quantity</th>
                                        <th>Trans. type</th>
                                        <th>Sub Total</th>
                                        <th>Sales Tax</th>
                                        <th>Grand Total</th>
                                        <th>Order Date-Time</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </tfoot>
                                <tbody>
									<?php 
										$Todays_date=date("Y-m-d");
										foreach ($Preorder_items_done as $item) {
											
											$Trans_type="Redemption";
											$Symbol="Points";
											$Sub_Total=($item["Total_Price_Points"]*$item["QTY"]);
											$Sales_tax="-";
											$Grand_total=round($Sub_Total);
											if($item["Trans_type"]==2)
											{
												$Trans_type="Purchase";
												$Symbol=$Symbol_currency;
												
												$Sub_Total=($item["Total_Price_Points"]*$item["QTY"]);
												$Sales_tax=round(($Sub_Total*$Merchant_sales_tax)/100,2);
												$Sales_tax=$Sales_tax.' <span class="required_info" style="font-size: 8px;">'.$Symbol_currency.'</span>';
												$Grand_total=round(($Sub_Total+$Sales_tax),2);
											}
											
											$Status=$item["Status"];
											if($Status==1)
											{
												$Status="Not taken";
											}
											elseif($Status==2)
											{
												$Status="Complete";
											}
											else
											{
												$Status="Cancel";
											}
											
											$Full_name=$item["First_name"]." ".$item["Last_name"];
										?>
                                        <tr>
											<td><?php echo $item["Update_date"]; ?></td>
                                            <td><a>
													<img src="<?php echo $item["Thumbnail_image1"]; ?>"  style="width:50px;height:50px;" >
												</a>
												<br>
												<a><?php echo $item["Merchandize_item_name"]; ?></a>
											</td>
												
                                           
                                            <td><?php echo $Full_name." (".$item["Card_id"]." )"; ?> </td>
                                            <td><?php echo $item["QTY"]; ?> </td>
                                            <td><?php echo $Trans_type; ?> </td>
                                            <td><?php echo $Sub_Total." "; ?><span class="required_info" style="font-size: 8px;"><?php echo $Symbol;?></span></td>
                                            <td><?php echo $Sales_tax." "; ?><span class="required_info" style="font-size: 8px;"></span> </td>
                                            <td>
												<?php echo $Grand_total." "; ?><span class="required_info" style="font-size: 8px;"><?php echo $Symbol;?></span>
											</td>
											<td style="color:<?php echo $Signal;?>;">
														<?php echo $item["Order_date"]; ?>
														<?php echo $item["Order_time"]; ?>
											</td>
											<td><?php echo $Status; ?></td>
											
                                        </tr>
								<?php } ?>
                                </tbody>
                            </table>
                        </div>    
													
						<?php 
						} else {
							?>
								<div class="text-center">
									<span class="required_info" style="font-size: 18px;">Sorry, No preorder done yet..!!</span>
								</div>
						<?php }
                        ?>
						
                    </div>
                </div>
                <!--------------------  END - Data Table  -------------------->


            </div>
        </div>
    </div>	
</div>
<?php $this->load->view('header/footer'); ?>
<style>	


    /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        height: 500px;
        overflow-y: auto;
    }
</style>
<script>


$(document).ready(function() {
    $('#dataTable2').DataTable();
} );

setTimeout(function(){
   window.location.reload(1);
}, 60000);



function submit_preorder(Preorder_id,Card_id,QTY,Trans_type,Total_Price_Points,Customer_enroll_id,Company_merchandize_item_code,Partner_id,Full_name,Merchandize_item_name,Symbol,Cust_seller_balance,Cust_prepayment_balance,Sales_tax,Grand_total )
{
	var status=$('#status_'+Preorder_id).val();
	
	/*
	alert("Preorder_id "+Preorder_id);
	alert("Card_id "+Card_id);
	alert("QTY "+QTY);
	alert("Trans_type "+Trans_type);
	alert("Total_Price_Points "+Total_Price_Points);
	alert("Customer_enroll_id "+Customer_enroll_id);
	alert("Company_merchandize_item_code "+Company_merchandize_item_code);
	alert("Merchandize_item_name "+Merchandize_item_name);
	alert("Partner_id "+Partner_id);
	alert("status "+status);
	alert("Full_name "+Full_name);
	alert("Symbol "+Symbol);
	alert("Cust_seller_balance "+Cust_seller_balance);
	alert("Cust_prepayment_balance "+Cust_prepayment_balance);
	*/
	
	if(status == 2)
	{
		if((Cust_seller_balance >=  Grand_total && Trans_type == 10) || (Cust_prepayment_balance >=  Grand_total  && Trans_type == 2))
		{
			show_loader();
			var url = '<?php echo base_url()?>index.php/Coal_Transactionc/Fulfill_preorder/?Preorder_id='+Preorder_id+'&Card_id='+Card_id+'&QTY='+QTY+'&Trans_type='+Trans_type+'&Total_Price_Points='+Total_Price_Points+'&status='+status+'&Customer_enroll_id='+Customer_enroll_id+'&Company_merchandize_item_code='+Company_merchandize_item_code+'&Partner_id='+Partner_id+'&Full_name='+Full_name+'&Merchandize_item_name='+Merchandize_item_name+'&Symbol='+Symbol+'&Sales_tax='+Sales_tax+'&Grand_total='+Grand_total;	
			window.location = url;
		}
		else
		{
			if(Trans_type == 2)//Purchase
			{
				var Title = "Data Validation";
				var msg = 'Insufficient Prepayment Balance !!!<br>You have Currently '+Cust_prepayment_balance+' '+Symbol+' Prepayment Balance  for this merchant outlet.';
				runjs(Title,msg);
			}
			else //Redeem
			{
				var Title = "Data Validation";
				var msg = 'Insufficient Loyalty Balance !!!<br>You have Currently '+Cust_seller_balance+' '+Symbol+' Loyalty Balance for this merchant outlet.';
				runjs(Title,msg);
			}
		}
	
	}
	else
	{
		show_loader();
		var url = '<?php echo base_url()?>index.php/Coal_Transactionc/Fulfill_preorder/?Preorder_id='+Preorder_id+'&Card_id='+Card_id+'&QTY='+QTY+'&Trans_type='+Trans_type+'&Total_Price_Points='+Total_Price_Points+'&status='+status+'&Customer_enroll_id='+Customer_enroll_id+'&Company_merchandize_item_code='+Company_merchandize_item_code+'&Partner_id='+Partner_id+'&Full_name='+Full_name+'&Merchandize_item_name='+Merchandize_item_name+'&Symbol='+Symbol+'&Sales_tax='+Sales_tax+'&Grand_total='+Grand_total;	
		window.location = url;
	}
	
}

 
</script>

