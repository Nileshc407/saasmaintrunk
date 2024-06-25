<?php 
if($Surveysummary != NULL) 
{
 
$ci_object = &get_instance();
$ci_object->load->model('Survey_model');
$ci_object->load->model('Igain_model');
foreach($Surveysummary as $survey)
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
		<h2 style="text-align:center">Survey Summary Analysis Report</h2>
		<h4 style="text-align:center">Survey Name: <?php echo $Survey_name;?></h4>
		<h4 style="text-align:center">No of Responder: <?php echo $Surveyresponder;?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Report Date : <?php echo $Report_date; ?></h5>
		</div>
	
	<div>
		<table class="table table-bordered table-hover" border="1">
						<thead>
						<tr>
							<!--<th class="text-center">Action</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Survey Name</th>-->
						</tr>						
						</thead>						
						<tbody>
						<?php
							$ci_object = &get_instance();
							$ci_object->load->model('Survey_model');	
							$question_count=1;
							foreach($Surveysummary as $survey)
							{
								$Survey_id=$survey['Survey_id'];
								$Company_id=$survey['Company_id'];
						?>

									<tr style="background-color: #D9EDF7;">
									<td>
										<?php echo"<b>".$question_count.") ".$survey['Question']." ";?>
									</td>
									<?php
									$get_choice_id = $ci_object->Survey_model->get_choice_id($survey['Survey_id'],$survey['Question_id'],$survey['Company_id']);
									if($get_choice_id->Choice_id > 0)
									{
										$total_response_count = $ci_object->Survey_model->count_response_id($get_choice_id->Choice_id,$survey['Question_id']);
										$multiple_choice_values=$ci_object->Survey_model->get_MCQ_All_choice_values($get_choice_id->Choice_id);
										foreach($multiple_choice_values as $mulVal)
										{
											$count_option_values1 = $ci_object->Survey_model->count_response2($survey['Question_id'],$mulVal['Value_id']);
											$count_option_values = ($count_option_values1 / $total_response_count);
											$count_option_values = round($count_option_values,4) * 100;
											echo "<td>".$mulVal['Option_values'];
											if($count_option_values > 0)
											{
												echo "<font color='GREEN' size='0.3px'> ( ".$count_option_values." % )</font>";
											}
											else
											{
												echo "<br><font color='GREEN' size='0.3px'> ( 0 % )</font>";
											}
										}
									}
									else
									{
										echo "<td>Please see Individual Response</td>";
										
									}				
									?>
								</tr>
									
									
							<?php 
							$question_count++;
							}
						
						?>
													
						</tbody> 

					</table>
	</div>
</div>
<?php }
// die;
 ?>