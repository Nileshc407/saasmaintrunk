<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><img src="<?php echo base_url().''.$Company_details->Company_logo; ?>"></h1>		
		
		
		
	</div>
		
	
	
	<TABLE style="font-weight:normal;text-align:left; width:100%;"> 
			<TR>				
				<TD>Date: <?php echo date("Y-m-d"); ?></TD> 
			</TR>
			<TR> 
				<TD>Invoice No:<?php echo $billing_bill_no; ?></TD> 
			</TR> 
			<TR> 
				<TD>Merchant ID: M-<?php echo $seller_id; ?></TD>
			</TR>
		<TR> 
			<TH  BGCOLOR="#D9EDF7"><?php echo $Company_details->Company_name; ?>,<br>
					<?php echo $Company_details->Company_address; ?>,<br>
					<?php echo $Company_City_name; ?>,
					<?php echo $Company_State_name; ?>,							
					<?php echo $Company_Country_name; ?>,<br>
					<?php echo $Company_details->Company_primary_email_id; ?>,<br>
					<?php echo $Company_details->Company_primary_phone_no; ?>,<br>
					<?php echo $Company_details->Website; ?>,<br>
					<?php echo $Company_details->Company_reg_no; ?>
			</TH>
			<TH  BGCOLOR="#D9EDF7"  >BILL TO,<br>
				<?php echo $Seller_name; ?>,<br>
				<?php echo $Current_address; ?>,<br>
				<?php echo $City_name; ?>,
				<?php echo $State_name; ?>,
				<?php echo $Country_name; ?>-
				<?php echo $Zipcode; ?>,<br>
				<?php echo $User_email_id; ?>,<br>
				<?php echo $Phone_no; ?>.
			</TH> 
				
		</TR> 
			
		
			
			
	</TABLE> 
	
	<?php 
	
	/* <TR> 
				
					<TD>Date</TD>
					<TD><?php echo date("Y-m-d"); ?></TD> 
			</TR>
			<TR> 
				<TD>Invoice No.</TD> 
				<TD><?php echo $billing_bill_no; ?></TD> 
			</TR> 
			<TR> 
				<TD>Merchant ID</TD>
				<TD>M-<?php echo $seller_id; ?></TD>
			</TR>  */
	?>
	
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;width:100%;" >
		
			<thead>
			
					<tr style="background-color: #D9EDF7;">
						<th>Sr. No.</th>
						<th>Description</th>
						<th>No. of Joy Coins Issued </th>
						<th>Rate (AED)</th>	
						<th>Amount (AED)</th>
					</tr>
			</thead>
			
			<tbody>
					
					<tr style="background-color: #D9EDF7;">
						<th>1.</th>
						<th>Total number of records processed successfully* are <?php echo $Total_row; ?>.</th>
						<th><?php echo $total_coins_issued; ?></th>
						<th><?php echo $Seller_Billingratio; ?></th>
						<th><?php 
							$sub_total=($total_coins_issued*$Seller_Billingratio);
						echo $sub_total;
						?></th>	
						
					</tr>
					<tr style="background-color: #D9EDF7;" >
						<th colspan="3"></th>
						<th>Sub-Total</th>
						<th><?php echo $sub_total; ?></th>
					</tr>
					<tr style="background-color: #D9EDF7;" >
						<th colspan="3"></th>
						<th>TAX</th>
						<th><?php echo $Merchant_sales_tax; ?></th>
					</tr>
					<tr style="background-color: #D9EDF7;" >
						<th colspan="3"></th>
						<th>Grand Total</th>
						<?php
												
							$tax_amout= ($sub_total*$Merchant_sales_tax)/100; 							
							$total_grand_amt= $sub_total+$tax_amout;							
						?>
						<th><?php echo $total_grand_amt; ?></th>
					</tr>					
								
			</tbody> 
		</table> 
		
	
	<div style="width:100%">
		<h6 style="text-align:center">*Note: Please see attached Annexure for details of Successful records processed</h6>
		<h6 style="text-align:center">If you have any questions about this invoice , please contact</h6>
		<h6 style="text-align:center"><?php echo $Company_primary_contact_person; ?>,<?php echo $Company_contactus_email_id; ?>,<?php echo $Company_primary_phone_no; ?></h6>
		<h5 style="text-align:center;font-weight:bold">Thank You for your Business</h5>
	</div>
	
</div>