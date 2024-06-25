<?php 
if($Surveysummary)
{ ?>
	<h6 class="form-header">Survey Summary Details</h6>
	<div style="text-align:center"><b>Total Survey Responder: <?php echo $Surveyresponder; ?> </b></div>
	<div class="table-responsive">
		<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
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
					<tr>
						<td>
							<?php echo"<b>".$question_count.") ".$survey['Question']." ";?>
						</td>
					<?php
						$get_choice_id = $ci_object->Survey_model->get_choice_id($survey['Survey_id'],$survey['Question_id'],$survey['Company_id']);
						if($get_choice_id->Choice_id > 0)
						{
							$total_response_count = $ci_object->Survey_model->count_response_id($get_choice_id->Choice_id,$survey['Question_id']);
							$multiple_choice_values=$ci_object->Survey_model->get_MCQ_All_choice_values($get_choice_id->Choice_id);
							if($multiple_choice_values !="" )
							{
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
						}
						else
						{
							echo "<td>Please see Individual Responses Detail below</td>";
						}				
					?>
					</tr>
			<?php 
				   $question_count++;
				}
			?>					
			</tbody>
		</table>
		<a href="<?php echo base_url()?>index.php/Survey/export_survey_analysis_summary_report/?Survey_id=<?php  echo $Survey_id; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=1">
		<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>	
		</a>
		
		<a href="<?php echo base_url()?>index.php/Survey/export_survey_analysis_summary_report/?Survey_id=<?php  echo $Survey_id; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=2">
		<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
		</a>
	</div>
</div>
<?php 
}else{?>
<div class="alert alert-danger" role="alert">
<h6 align="center">No Records Found</h6>
</div>
<?php } ?>		