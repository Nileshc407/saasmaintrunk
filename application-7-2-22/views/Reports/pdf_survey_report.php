<?php 
if($Survey_analysis_rpt != NULL) 
{

$ci_object = &get_instance();
$ci_object->load->model('Survey_model');
$ci_object->load->model('Igain_model');
foreach($Survey_analysis_rpt as $survey)
{
	$Survey_name=$survey['Survey_name'];
	
	$Survey_name = $ci_object->Survey_model->get_survey_details($survey['Survey_id'],$survey['Company_id']);
	$Survey_name=$Survey_name->Survey_name;
}
error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Survey Analysis Report</h2>
		<h4 style="text-align:center">Survey Name: <?php echo $Survey_name;?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Report Date : <?php echo $Report_date; ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">		
			<thead>
				<tr style="background-color: #D9EDF7;">
					<th>Member Name</th>
					<th>Membership ID</th>
					<?php					
					$question_count=1;
					foreach($Survey_analysis_rpt as $survey)
					{ 
						$Survey_id=$survey['Survey_id'];
						$get_question = $ci_object->Survey_model->get_question($survey['Question_id']);
						?>					
						<th><?php echo $question_count.'.    '.$get_question->Question; ?></th>
						<?php 
						$question_count++;
					}
					?>
				</tr>						
			</thead>
					<tbody>
					
					<?php	
						foreach($Survey_enroll_rpt as $survey)
						{
								echo"<tr>";
								$Enrollment_details=$ci_object->Igain_model->get_enrollment_details($survey['Enrollment_id']);
									
								echo"<td>".$Enrollment_details->First_name.' '.$Enrollment_details->Last_name."</td>";
								echo"<td>".$Enrollment_details->Card_id."</td>";
								
								
								$responce_question_id=$ci_object->Survey_model->responce_question_id($survey['Survey_id'],$survey['Enrollment_id']);
								foreach($responce_question_id as $questionid)
								{
									$result_responce_12=$ci_object->Survey_model->get_response($survey['Survey_id'],$survey['Enrollment_id'],$questionid['Question_id']);
									foreach($result_responce_12 as $response)
									{
										if($response['Response2']!=0)
										{
											$choice_values=$ci_object->Survey_model->get_MCQ_choice($response['Response2']);
											foreach($choice_values as $ch_val)
											{
												echo"<td>".$ch_val['Option_values']."</td>";
											}
											
										}
										else
										{
											 echo"<td>".$response['Response1']."</td>";
										}
									}
								}
							echo"<tr>";
						}	
				
					?>
				
					</tbody>
			
		
			
			
		
		</table>
	</div>
</div>
<?php }
// die;
 ?>