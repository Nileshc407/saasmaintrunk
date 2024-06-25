<?php if($Trans_Records != NULL) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Item Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("d M Y",strtotime($start_date))." To Date: ".date("d M Y",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
							<th>MembershipID</th>
							<th>Member Name</th>
							<th>Phone</th>
							<th>Item</th>
							<th>Times Purchased</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Menu Group</th>
							<th>Times Purchased</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if($Trans_Records != NULL)
						{
							
							$ci_object = &get_instance(); 
							$lv_MembershipID='0';
							$lv_category_id='0';
							foreach($Trans_Records as $row)
							{
								$MembershipID=$row->MembershipID;
								$Merchandize_category_id=$row->Merchandize_category_id;
								// $Times_purchased = array();
								foreach($Trans_Records2 as $row2)
								{
									$MembershipID2=$row2->MembershipID;
									$Merchandize_category_id2=$row2->Merchandize_category_id;
									
									if($MembershipID == $MembershipID2 && $Merchandize_category_id2 == $Merchandize_category_id)
									{  //die;
										$Times_purchased=$row2->Cat_Times_purchased;
										$Cat_value=$row2->Cat_value;
									}
									else
									{
										continue;
									}
									
								} 
									echo "<tr>";
									echo "<td>".$row->MembershipID."</td>";
									echo "<td>".$row->Member_name."</td>";
									echo "<td>".$row->Phone_no."</td>";
									echo "<td>".$row->Merchandize_item_name."</td>";
									echo "<td>".$row->Times_purchased."</td>";
									// echo "<td>".number_format(round($row->Item_value),2)."</td>";
									echo "<td>".$row->Item_value."</td>";
									echo "<td>".$row->Menu_group."</td>";
									echo "<td>".$Times_purchased."</td>";
									echo "<td>".number_format(round($Cat_value),2)."</td>";
									
									
									echo "</tr>";
									
									$lv_MembershipID=$MembershipID;
									$lv_category_id=$Merchandize_category_id;
								
							}
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>