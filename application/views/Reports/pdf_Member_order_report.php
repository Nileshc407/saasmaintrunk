<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">
			<?php if($report_type==1){ echo 'Member Points Detail Report'; }
							else{echo 'Member Points Summary Report'; }
					?>
		</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($start_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>                 
  <div class="table-responsive">
	<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		<thead>

			<?php if($report_type==1){ //Details?>
			<tr>
			<!--	<th>Sequence No</th>-->
				<th>Date</th>
				<th>POS Bill No</th>

				<th>Membership ID</th>
				<th>Member Name</th>
				<th>Channel</th>
				<th>Outlet</th>
				
				<th>Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
			
				<th>Discount Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>Earned <?php echo $Company_details->Currency_name; ?></th> 
				<th>Earned Amt</th>
				<th>Redeem <?php echo $Company_details->Currency_name; ?></th>
				<th>Redeem Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<!--<th>Mpesa TransId</th>
				<th>Mpesa Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
				<!--<th>COD Amount <?php echo '('.$Symbol_of_currency.')';?></th>-->
				
				


			</tr>
			<?php }
			if($report_type==2){ //summary?>
			<tr>

			
				<th>Membership ID</th>
				<th>Member Name</th>
				<th>Outlet Visits</th>
				<th>Online Purchased</th>
				<th>Online Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>POS Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>Discount Amt <?php echo '('.$Symbol_of_currency.')';?></th> 
				<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>Total Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<th>Earned <?php echo $Company_details->Currency_name; ?></th>
				<th>Earned Amt</th>
				<th>Redeem <?php echo $Company_details->Currency_name; ?></th> 
				<th>Redeem Amt <?php echo '('.$Symbol_of_currency.')';?></th>
				<!--<th>Mpesa TransId</th>
				<th>Mpesa Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
				<!--<th>COD Amount <?php echo '('.$Symbol_of_currency.')';?></th>-->
				
				<th>Current Points</th>

			</tr>
			<?php } ?>
		</thead>
		<tbody>
	<?php
	$ci_object = &get_instance(); 

	if(count($Trans_Records) > 0)
	{
		//print_r($Trans_Records[0]);die;
		
		//$From_date=$_REQUEST["start_date"];
		//echo '<table  class="table table-bordered table-hover">';
		$lv_Enrollement_id=0;
		
		foreach($Trans_Records as $row)
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
				
			if($row->Channel == 12)
			{
				$TransType = "Online";
			}
			
			if($row->Channel == 2)
			{
				$TransType = "POS";
			}

			if($row->Channel == 29)
			{
				$Channel_name = $ci_object->Report_model->Get_beneficiary_company($row->Channel_id);
				$TransType = $Channel_name->Beneficiary_company_name;
			}
			if($report_type==1)//Details
			{
				
				echo "<tr>";
			//	echo "<td>".$row->Sequence_no."</td>";
				echo "<td>".$row->Date."</td>";
				echo "<td>".$row->POS_bill_no."</td>";
				
				//echo "<td>".$row->Pos_billno."</td>";
				
				echo "<td>".$Card_id."</td>";
				echo "<td>".$Member_name."</td>"; 
				echo "<td>".$TransType."</td>";
				echo "<td>".$row->Outlet."</td>";
		
				echo "<td>".number_format(round($row->Bill_amt),2)."</td>";
			
				echo "<td>".number_format(round($row->Discount_amt),2)."</td>";
				echo "<td>".number_format(round($row->Voucher_amt),2)."</td>";
				echo "<td>".number_format(round($row->Paid_amt),2)."</td>";
				echo "<td>".round($row->Earned_pts)."</td>";
				echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
				echo "<td>".round($row->Redeemed_pts)."</td>";
				echo "<td>".number_format(round($row->Redeemed_amt),2)."</td>";
			
			//	echo "<td>".number_format(round($row->Total_mpesa_amount),2)."</td>";
				//echo "<td>".number_format(round($row->Total_cash_amount),2)."</td>";
				
				
				//echo "<td style='color:$color;'>".$VoucherStatus."</td>";

				echo "</tr>";
			}
			else
			{ 
				echo "<tr>";
				echo "<td>".$Card_id."</td>";
				echo "<td>".$Member_name."</td>"; 
				echo "<td>".$row->Outlet_visits."</td>"; 
				echo "<td>".$row->Online_purchased."</td>"; 
				echo "<td>".number_format(round($row->Online_Bill_amt),2)."</td>";
				echo "<td>".number_format(round($row->POS_Bill_amt),2)."</td>";
				echo "<td>".number_format(round($row->Bill_amt),2)."</td>";
				
				echo "<td>".number_format(round($row->Discount_amt),2)."</td>";
				echo "<td>".number_format(round($row->Voucher_amt),2)."</td>";
				echo "<td>".number_format(round($row->Paid_amt),2)."</td>";
				echo "<td>".round($row->Earned_pts)."</td>";
				echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
				
				echo "<td>".round($row->Redeemed_pts)."</td>";
				echo "<td>".number_format(round($row->Redeemed_amt),2)."</td>";
				//echo "<td>".$row->Mpesa_TransID."</td>";
			//	echo "<td>".number_format(round($row->Total_mpesa_amount),2)."</td>";
				//echo "<td>".number_format(round($row->Total_cash_amount),2)."</td>";
				
				echo "<td>".round($row->Current_points)."</td>";
				//echo "<td style='color:$color;'>".$VoucherStatus."</td>";

				echo "</tr>";
			}
			$lv_Enrollement_id=$Enrollement_id;
		}
	}
	?>
		</tbody>
	</table>
	
  </div>
</div>
