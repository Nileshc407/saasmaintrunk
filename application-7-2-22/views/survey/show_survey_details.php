	
	
	<?php 
	// var_dump($Show_survey);
	?>
<div class="modal-content">	
	<div class="modal-body">
	<?php			
	if($Show_survey)
	{ ?>
		<table  class="table table-bordered table-hover"  id="detail_myModal">
			<thead>
				<h4 class="modal-title" style="background-color:#dd4b39;color:#fff;text-align:center">Survey Details</h4>
				<tr>
					<th>Question</th>
					
					
				</tr>					  
			</thead>
			<tbody>
			<?php	
			
				$todays = date("Y-m-d");			
				foreach($Show_survey as $survey)
				{	
					
					?>				
						<tr>						
							<td><?php echo $survey['Question']; 
								echo"<br>";
								if($survey['Response_type']==1)
								{ 
									$ci_object = &get_instance();
									$ci_object->load->model('Survey_model');
									
									$choice_values = $ci_object->Survey_model->get_MCQ_choice_values($survey['Choice_id']);
									foreach($choice_values as $ch_val)
									{
										?>
											<div class="form-check" >
											<label class="form-check-label">
												<input type="radio"  class="form-check-input"  name="<?php echo $ch_val['Value_id']; ?>"  value="<?php echo $ch_val['Value_id'] ?>"   id="<?php echo $ch_val['Value_id'] ?>" ><?php echo $ch_val['Option_values']; ?>
												
											</label>
											</div>											
									<?php 
									}
								}
								else
								{ ?>
									<input type="text" class="form-control" style="width:20%" name="text_based"> 
								  <?php
								}
								?>			
							
							</td>
							</tr>			
					<?php					
				}
			}
			else
			{
				echo '<h4 class="modal-title" style="background-color:#dd4b39;color:#fff;text-align:center">Please Set Survey Questions</h4>';
			}
			?>
			</tbody>
		</table>

		
	
	</div>
	
	<div class="modal-footer">
		<button type="button" id="close_modal3" class="btn btn-primary">Close</button>
	</div>				
</div>
<script>
$(document).ready(function() 
{	
	$("#close_modal3").click(function(e)
	{
		$('#Survey_model').hide();
		$("#Survey_model").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>


	
			