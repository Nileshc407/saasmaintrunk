<?php if($Total_Trans_Records != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Orders Report - <?php if($report_type == 1) { echo " Details"; } else { echo " Summary";} ?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($start_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
				<?php if($report_type==1){ //Details?>
				<tr>
					<th>Membership ID</th>
					<th>Member Name</th>
					<th>Outlet Name</th>
					<th>Order Date</th>
					<th>POS Bill No</th>
					
					<th>Trans Type</th>
					<th>Menu Name</th>
					<th>Category</th>
					<th>Qty</th>
					<!--<th>Condiments</th>-->
					<th>Purchase Amount <?php echo '('.$Symbol_of_currency.')'; ?></th>
					<th>Order Type</th>
					<th>Order Status</th>
	
				</tr>
				<?php } else { //Summary?>
				<tr>
					<th>Membership ID</th>
					<th>Member Name</th>
					<th>Outlet Name</th>
					
					<th>Order Date</th>
					<th>Online Order No</th>
					<th>POS Bill No</th>
					<th>Trans Type</th>
					<th>Total Purchase Amount <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Total Delivery Cost <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Total Gained <?php echo $Company_details->Currency_name; ?></th>
					<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
					<th>Total Redeemed Amount <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Voucher No.</th>
					<th>Voucher Amount <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>M-pesa Trans ID</th>
					<th>M-pesa Trans Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Total Cash Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Total Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Order Type</th>
					<th>Order Status</th>

				</tr>
				<?php } ?>
			</thead>	
			<tbody>
				<?php
				$ci_object = &get_instance(); 
				foreach($Total_Trans_Records as $row)
				{
					$Member_name=$row->Member_name;
					$Card_id=$row->Membership_ID;
					$Enrollement_id=$row->Enrollement_id;
					
					/*if($lv_Enrollement_id!=$Enrollement_id)
					{
						echo "<tr class='success'><td colspan='13'>".$Full_name." (".$Card_id.")</td></tr>";
					}*/
					
					$color="green";
					$VoucherStatus = "-";	

						if($row->Order_status == 18)
						{
							$VoucherStatus = "Ordered";
						}
						if($row->Order_status == 19)
						{
							$VoucherStatus = "Shipped";
						}
						if($row->Order_status == 20)
						{
							// $VoucherStatus = "Delivered";
							if($row->Order_type == 28)
							{
								$VoucherStatus = "Collected";
							}
							else if($row->Order_type == 29)
							{
								$VoucherStatus = "Delivered";
							}
							else
							{
								$VoucherStatus = " ";
							}
						}
						if($row->Order_status == 21)
						{
							$VoucherStatus = "Cancel";
							$color="red";
						}
						
					if($row->Trans_type == 12)
					{
						$TransType = "Online";
					}
					
					if($row->Trans_type == 2)
					{
						$TransType = "POS";
					}
					if($row->Trans_type == 29)
					{
						$Channel_name = $ci_object->Report_model->Get_beneficiary_company($row->Channel_id);
						$TransType = $Channel_name->Beneficiary_company_name;
					}
					if($row->Quantity == 0)
					{
						$row->Quantity = "-";
						$row->Menu_name = "-";
					}
					
					if($row->Order_type == 28)
						{
							$row->Order_type = "Pick Up";
						}
						elseif($row->Order_type == 29)
						{
							$row->Order_type = "Home Delivery";
						}
						else
						{
							$row->Order_type = "In-Store";
						}
					
					if($report_type==1)//Details
					{

						echo "<tr>";
						echo "<td>".$Card_id."</td>";
						echo "<td>".$Member_name."</td>"; 
						echo "<td>".$row->Outlet."</td>";

						echo "<td>".$row->Order_date."</td>";
						// echo "<td>".$row->Order_no."</td>";
						echo "<td>".$row->Pos_billno."</td>";
						
						echo "<td>".$TransType."</td>";

						//echo "<td>".$row->Outlet."</td>";
						echo "<td>".$row->Menu_name."</td>";
						echo "<td>".$row->Category."</td>";
						echo "<td>".$row->Quantity."</td>";
						//echo "<td>".$condiments."</td>";
						echo "<td>".number_format(round($row->Purchase_amount),2)."</td>";
						echo "<td>".$row->Order_type."</td>";
						echo "<td style='color:$color;'>".$VoucherStatus."</td>";
						
						echo "</tr>";
					}
					else
					{
						echo "<tr>";
						echo "<td>".$Card_id."</td>";
						echo "<td>".$Member_name."</td>";
						echo "<td>".$row->Outlet."</td>";
						echo "<td>".$row->Order_date."</td>";
						echo "<td>".$row->Order_no."</td>";
						echo "<td>".$row->Pos_billno."</td>";
						echo "<td>".$TransType."</td>";
						
						echo "<td>".number_format(round($row->Total_purchase_amount),2)."</td>";
						echo "<td>".number_format(round($row->Total_Delivery_cost),2)."</td>";
						echo "<td>".round($row->Total_gained_pts)."</td>";
						echo "<td>".round($row->Redeemed_points)."</td>";
									
					echo "<td>".number_format(round($row->Total_redeem_amount),2)."</td>";
						echo "<td>".$row->Voucher_no."</td>";
						echo "<td>".$row->Voucher_amount."</td>";
						echo "<td>".$row->Mpesa_TransID."</td>";
						echo "<td>".number_format(round($row->Total_mpesa_amount),2)."</td>";
						echo "<td>".number_format(round($row->Total_cash_amount),2)."</td>";
						echo "<td>".number_format(round($row->Total_paid_amount),2)."</td>";

						echo "<td>".$row->Order_type."</td>";
						echo "<td style='color:$color;'>".$VoucherStatus."</td>";

						echo "</tr>";
					}
					$lv_Enrollement_id=$Enrollement_id;
				
				}
		
				?>		
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>