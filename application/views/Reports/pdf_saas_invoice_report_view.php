<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php //echo $Company_name;?></h1>
		<h2 style="text-align:center">
			<?php  echo 'Saas Invoice Report'; 	?>
		</h2>
	
	</div>                 
  <div class="table-responsive">
	<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		<thead>

		<?php
							$ReportType = $_REQUEST["ReportType"];	
								if($ReportType==0)//Details
								{
							?>
							<tr>
							<th>Payment Date</th>
							<th>Company</th>
							<th>Currency</th>
							<th>License Type</th>
							<th>Period</th>
							<th>Invoice No.</th>
							<th>Total Invoice Amount</th>
							<th>Paid Amount</th>
							<th>Payment Status</th>
							<th>Payment Reference ID</th>
							</tr>
								<?php }else{ ?>
								<tr>
									<th>Company</th>
									<th>Currency</th>
									<th>License Type</th>
									<th>Total Invoice</th>
									<th>Total CGST</th>
									<th>Total SGST</th>
									<th>Total IGST</th>
									<th>Total Invoice Amount</th>
									<th>Total Paid Amount</th>
									<th>Payment Status</th>
								</tr>
								<?php } ?>

		</thead>
		<tbody>
				<?php
						$todays = date("Y-m-d");
						$start_date = date('Y-m-d',strtotime($_REQUEST["start_date"]));
						$end_date = date('Y-m-d',strtotime($_REQUEST["end_date"]));
						$Country = $_REQUEST["Country"];
						$PaymentStatus = $_REQUEST["PaymentStatus"];
						
						$Saas_Company_id = $_REQUEST["Saas_Company_id"];
						$LicenseType = $_REQUEST["LicenseType"];
						  
						if($Trans_Records != NULL)
						{
							// if($seller_id=='0'){$Brand_name='All';}
							foreach($Trans_Records as $row)
							{
								if($row->License_type==121)//Basic
								{
									$row->License_type='Basic';
								}
								if($row->License_type==253)//Standard
								{
									$row->License_type='Standard';
								}
								
								if($row->License_type==120)//Enhance
								{
									$row->License_type='Enhance';
								}
								
								if($row->Currency=='India'){$row->Currency='INR';}else{$row->Currency='USD';}
								
								if($row->Email_sent==1){$row->Email_sent='Yes';}else{$row->Email_sent='No';}
								if($row->Payment_Reference_Id==''){$row->Payment_Reference_Id='-';}
								if($row->Period=='30'){$row->Period='Monthly';}
								if($row->Period=='90'){$row->Period='Quaterly';}
								if($row->Period=='180'){$row->Period='Bi-Anually';}
								if($row->Period=='365'){$row->Period='Anually';}
								
								// $Company_details = $this->Igain_model->get_company_details($row->Company_name);
								// $row->Company_name=$Company_details->Company_name;
								if($ReportType==0)//Details
								{
									echo "<tr>";
									echo "<td>".$row->Bill_date."</td>";
									echo "<td>".$row->Company_name."</td>";
									echo "<td>".$row->Currency."</td>";
									echo "<td>".$row->License_type."</td>";
									echo "<td>".$row->Period."</td>";
									echo "<td>".$row->Bill_no."</td>";
									echo "<td>".$row->Total_invoice_amount."</td>";
									echo "<td>".$row->Paid_Amount."</td>";
									if($row->Payment_status==NULL){echo '<td>Not Initiated</td>';}else{echo '<td>'.$row->Payment_status."</td>";}
									echo "<td>".$row->Payment_Reference_Id."</td>";
									// echo "<td>".$Email_sent."</td>";
									// echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>".$row->Company_name."</td>";
									echo "<td>".$row->Currency."</td>";
									echo "<td>".$row->License_type."</td>";
									echo "<td>".$row->Total_invoice."</td>";
									echo "<td>".$row->Total_CGST."</td>";
									echo "<td>".$row->Total_SGST."</td>";
									echo "<td>".$row->Total_IGST."</td>";
									echo "<td>".$row->TotalInvoiceAmount."</td>";
									echo "<td>".$row->TotalPaidAmount."</td>";
									if($row->Payment_status==NULL){echo '<td>Not Initiated</td>';}else{echo '<td>'.$row->Payment_status."</td>";}
									// echo "<td>".$Email_sent."</td>";
									echo "</tr>";
								}
									
							}
						}
						?>
						
		</tbody>
	</table>
	
  </div>
</div>
