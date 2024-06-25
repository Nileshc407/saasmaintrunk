<?php
if($RemaingQuestionArray)
{ 
	$ci_object = &get_instance();
	$ci_object->load->model('Survey_model');	
	foreach($RemaingQuestionArray as $remainQues)
	{
		$Survey_id=$remainQues['Survey_id'];
		$Company_id=$remainQues['Company_id'];
		$No_of_questions=$remainQues['No_of_questions'];
		$No_of_multiple_choice=$remainQues['No_of_multiple_choice'];
		$No_of_text_based=$remainQues['No_of_text_based'];
	}	
	$MCQ_balance = $ci_object->Survey_model->count_MCQ_QUESTION_details($Survey_id,$Company_id);
	// var_dump($MCQ_balance);
	$TEXT_balance = $ci_object->Survey_model->count_TEXT_QUESTION_details($Survey_id,$Company_id);
	$Remaing_MCQ_balance=$No_of_multiple_choice-$MCQ_balance;
	$Remaing_TEXT_balance=$No_of_text_based-$TEXT_balance;		
	$Total_remaing_balance=$No_of_questions-($MCQ_balance+$TEXT_balance);
	
	if($Remaing_MCQ_balance =="" || $Remaing_MCQ_balance == 0 || $Remaing_MCQ_balance < 0)
	{
		$Remaing_MCQ_balance=0;
		$Remaing_MCQ_bal_flag=0;
	}
	else
	{
		$Remaing_MCQ_balance=$Remaing_MCQ_balance;
		$Remaing_MCQ_bal_flag=1;
	}
	if($Remaing_TEXT_balance =="" || $Remaing_TEXT_balance == 0 || $Remaing_TEXT_balance < 0)
	{
		$Remaing_TEXT_balance=0;
		$Remaing_TEXT_bal_flag=0;
	}
	else
	{
		$Remaing_TEXT_balance=$Remaing_TEXT_balance;
		$Remaing_TEXT_bal_flag=1;
		
	}
	if($Total_remaing_balance =="" || $Total_remaing_balance == 0 || $Total_remaing_balance < 0)
	{
		$Total_remaing_balance=0;
		$Total_remaing_bal_flag=0;
	}
	else
	{
		$Total_remaing_balance=$Total_remaing_balance;
		$Total_remaing_bal_flag=1;
	}		
?>
	<label for="questionBalance"><span class="required_info" >Question Balance</span></label>
	<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th class="text-center">#</th>
		<th class="text-center">Total</th>
		<th class="text-center">Balance</th>							
	</tr>
	</thead>							
	<tbody>
		<tr>
			<td class="text-center">Total Questions	</td>
			<td class="text-center"><?php echo $No_of_questions; ?></td>
			<td class="text-center"><?php echo $Total_remaing_balance; ?>
				<input type="hidden" name="Total_remaing_bal_flag" id="Total_remaing_bal_flag" value="<?php echo $Total_remaing_balance; ?>" />
			</td>
		</tr>
		<tr>
			<td class="text-center">Multiple choice Questions</td>
			<td class="text-center"><?php echo $No_of_multiple_choice; ?></td>
			<td class="text-center"><?php echo $Remaing_MCQ_balance; ?>
				<input type="hidden" name="Remaing_MCQ_bal_flag" id="Remaing_MCQ_bal_flag" value="<?php echo $Remaing_MCQ_balance; ?>" />
			</td>
		</tr>
		<tr>
			<td class="text-center">Text Based Questions</td>
			<td class="text-center"><?php echo $No_of_text_based; ?></td>
			<td class="text-center"><?php echo $Remaing_TEXT_balance; ?>
			<input type="hidden" name="Remaing_TEXT_bal_flag" id="Remaing_TEXT_bal_flag" value="<?php echo $Remaing_TEXT_balance; ?>" />
			</td>
		</tr>										
	</tbody> 
	</table>
	<?php if($Total_remaing_balance >0 || $Total_remaing_balance >0 || $Total_remaing_balance >0) { ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  Survey Questionnaire Incomplete.! Please Add Remaining Questions
	</div>
	<?php } else { ?>
	<div class="alert alert-info alert-dismissible fade show" role="alert">
	  Survey Questionnaire completed.! 
	</div>
	<?php }  ?>
<?php 
}
?>