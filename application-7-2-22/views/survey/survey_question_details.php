<?php 
if($Survey_array)
{	?>
	<div class="element-wrapper">											
		<div class="element-box">
				<h6 class="form-header">Survey Details</h6>
				<div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
						<tr>
							<th>Survey Name</th>
							<th>Survey Type</th>
							<th>Question</th>
							<th>Response Type</th>
							<th>Option Name</th>

						</tr>						
						</thead>
						<tfoot>
						<tr>
							<th>Survey Name</th>
							<th>Survey Type</th>
							<th>Question</th>
							<th>Response Type</th>
							<th>Option Name</th>

						</tr>						
						</tfoot>
						
						<tbody>
						<?php
						$ci_object = &get_instance();
						$ci_object->load->model('Survey_model');
						// var_dump($Survey_array);
						
							
							foreach($Survey_array as $survey)
							{
								if($survey['Survey_type']==1)
								{  $Survey_type='Feedback Survey';}
								else if($survey['Survey_type']==2)
								{  $Survey_type='Service Related Survey';}
								else
								{  $Survey_type='Product Survey';}
								
								if($survey['Response_type']==1)
								{ $Response_type='Multiple Choice';	}
								else
								{ $Response_type='Text Based';}
								
								if($survey['Choice_id'] !=0 )
								{								
									$multiple_choice_name = $ci_object->Survey_model->get_multiple_choice_name($survey['Company_id'],$survey['Choice_id']);
									$Name_of_option1=$multiple_choice_name->Name_of_option;
									/* if($Name_of_option=="")
									{	
										$Name_of_option1='-';
									}
									else
									{
										$Name_of_option1=$Name_of_option;
									} */
								}
								else
								{
									$Name_of_option1='-';
								}
							?>
								<tr>
									<td><?php echo $survey['Survey_name']; ?></td>
									<td><?php echo $Survey_type; ?></td>
									<td><?php echo $survey['Question']; ?></td>
									<td><?php echo $Response_type; ?></td>
									<td><?php echo $Name_of_option1; ?></td>
					
								</tr>
							<?php
							}
						
						?>						
						</tbody> 
					</table>
				</div>
			</div>
		</div>
<?php 	
}	?>		