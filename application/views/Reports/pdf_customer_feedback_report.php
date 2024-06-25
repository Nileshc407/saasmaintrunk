<?php if($Trans_Records != NULL) { ?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Members Feedback Report </h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($start_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
				<tr>
				
					<th>Member Name</th>
					<th>Membership ID</th>
					
					<th>Phone No</th>
					<th>Email</th>
					<th>Feedback Type</th>
					<th>Feedback Comment</th>
					<th>Date</th>	
	
				</tr>
				
			
			</thead>	
			<tbody>
				<?php

				if(count($Trans_Records) > 0)
						{
							//print_r($Trans_Records[0]);die;
							
							//$From_date=$_REQUEST["start_date"];
							//echo '<table  class="table table-bordered table-hover">';
							$lv_Enrollement_id=0;
							
							foreach($Trans_Records as $row)
							{
								$Member_name=$row->Member_name;
								$Card_id=$row->Membership_id;
								$Enrollement_id=$row->Enrollment_id;
								
							
									echo "<tr>";
									echo "<td>".$Member_name."</td>";
									
									echo "<td>".$Card_id."</td>";
									echo "<td>".$row->Phone_no."</td>";
									echo "<td>".$row->User_email_id."</td>";
									echo "<td>".$row->Feedback_type."</td>";
									echo "<td>".$row->Feedback_comment."</td>";
									echo "<td>".date("Y-m-d",strtotime($row->Comment_date))."</td>";
									
									echo "</tr>";
								
							}
						}				
				
		
				?>		
			</tbody> 
		</table>
	</div>
</div>
<?php } ?>