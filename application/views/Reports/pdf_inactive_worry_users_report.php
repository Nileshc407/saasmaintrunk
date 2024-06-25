<?php if($worry_customers != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h4 style="text-align:center">Inactive Users ( Who have not done any transaction since last 1 month )</h4>
		<h4 style="text-align:center">Report Date : <?php echo $Report_date; ?></h4>
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
						<thead>
						<tr style="background-color: #D9EDF7;">
							
							<th class="text-center">User Name</th>
							<th class="text-center">User Type</th>
							<th class="text-center">Membership ID</th>
							<th class="text-center">City</th>
							<th class="text-center">Phone No.</th>
							<th class="text-center">Total <?php echo $Company_details->Currency_name; ?></th>
							<th class="text-center">Total Redeem <?php echo $Company_details->Currency_name; ?></th>
							<th class="text-center">Total Bonus <?php echo $Company_details->Currency_name; ?></th>
							<th class="text-center">Last Visit Date</th>
							
						</tr>
						
						</thead>
						
						<tbody>
						<?php							
							if($worry_customers != NULL)
							{
								$Worry_Customer_name = $worry_customers['Worry_Customer_name'];
								$Customer_last_visit = $worry_customers['Customer_last_visit'];
								$Card_id = $worry_customers['Card_id'];
								$User_id = $worry_customers['User_id'];
								$City = $worry_customers['City'];
								$Phone_no = $worry_customers['Phone_no'];
								$Current_balance = $worry_customers['Current_balance'];
								$Total_reddems = $worry_customers['Total_reddems'];
								$Total_topup_amt = $worry_customers['Total_topup_amt'];								
								$count_worry=count($Worry_Customer_name);
								
								for($i=0;$i<$count_worry;$i++)
								{
									if($Worry_Customer_name[$i] != NULL)
									{ 
										if($User_id[$i]==1)
										{	$User_id1='Member';	}
										else {$User_id1='-'; }
										if($Card_id[$i]!=0)
										{	$Card_id1=$Card_id[$i];	}
										else {$Card_id1='-'; }
										if($City[$i]!="")
										{	$City1=$City[$i];	}
										else {$City1='-'; }
										if($Phone_no[$i]!="")
										{	$Phone_no1=$Phone_no[$i];	}
										else {$Phone_no1='-'; }
										if($Current_balance[$i]!=0)
										{$Current_balance1=$Current_balance[$i];	}
										else {$Current_balance1='-'; }
										if($Total_reddems[$i]!=0)
										{$Total_reddems1=$Total_reddems[$i];	}
										else {$Total_reddems1='-'; }
										if($Total_topup_amt[$i]!=0)
										{$Total_topup_amt1=$Total_topup_amt[$i];	}
										else {$Total_topup_amt1='-';}
										
										echo '<tr>';
										echo '<td class="text-center">'.$Worry_Customer_name[$i].'</td>';
										echo '<td >'.$User_id1.'</td>';
										echo '<td >'.$Card_id[$i].'</td>';
										echo '<td >'.$City1.'</td>';
										echo '<td >'.$Phone_no1.'</td>';
										echo '<td>'.$Current_balance1.'</td>';
										echo '<td >'.$Total_reddems1.'</td>';
										echo '<td >'.$Total_topup_amt1.'</td>';
										echo '<td>'.date("d M Y",strtotime($Customer_last_visit[$i])).'</td>';
										echo '</tr>';
									}
								}
							}
						
						?>
						<tr>

							<td colspan="9" ><?php //echo $pagination; ?></td>
						</tr>
						
						</tbody> 

					</table> 

		</table>
	</div>
</div>
<?php } ?>
