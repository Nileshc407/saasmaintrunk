<div class="modal-content" style="margin-top:250px;">	
	<div class="modal-body">
	<?php
		// var_dump($Show_customer_analysis);
		if($Show_customer_analysis)
		{ ?> 
		<table class="table table-bordered table-hover" id="detail_myModal">
			<thead>
				<h4 class="modal-title" style="background-color:#dd4b39;color:#fff;text-align:center">Customer Survey Response Details</h4>
				<tr>
					<th>Question</th>
				</tr>					  
			</thead>
			<tbody>
			<?php	
				$todays = date("Y-m-d");			
				foreach($Show_customer_analysis as $survey)
				{					
			?>	
					<tr>						
						<td>
					<?php 
							$ci_object = &get_instance();
							$ci_object->load->model('Survey_model');
							$get_question = $ci_object->Survey_model->get_question($survey['Question_id']);
							// echo $survey['Question_id']; 
							echo $get_question->Question;
							// echo $survey['Question_id']; 
							echo"<br>";
							  // echo"Response1------".$survey['Response1']."----<br>";
							if($survey['Response1'] =="")
							{ 
								if($survey['Choice_id'] != "")
								{
									$choice_values = $ci_object->Survey_model->get_MCQ_choice($survey['Response2']);
									if($choice_values != "")
									{
										foreach($choice_values as $ch_val)
										{
											$All_choice_values = $ci_object->Survey_model->get_MCQ_All_choice_values($ch_val['Choice_id']);
											foreach($All_choice_values as $ch_values)
											{
												echo'<br>';
												if($survey['Response2']== $ch_values['Value_id'] )
												{ ?>
													<label class="radio-inline">
													<input type="radio" checked disabled name="<?php echo $ch_values['Value_id']; ?>" id="<?php echo $ch_values['Value_id']; ?>"  value="<?php echo $ch_values['Value_id'] ?>" ><?php echo $ch_values['Option_values']; ?>
													</label>
										<?php	}
												else
												{ ?>												
													<label class="radio-inline">
													<input type="radio"  readonly name="<?php echo $ch_values['Value_id']; ?>"  value="<?php echo $ch_values['Value_id'] ?>" ><?php echo $ch_values['Option_values']; ?>
													</label> <?php
												}
											}											
										}
									
									}
								}
							}
							else
							{ ?>
								<textarea class="form-control" rows="2" name="text_based">  <?php echo $survey['Response1'] ?> </textarea>
							<?php 
							}
							?>				
						</label>
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