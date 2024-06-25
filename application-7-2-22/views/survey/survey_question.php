<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php
				$attributes = array('id' => 'formValidate');
				echo form_open_multipart('Survey/surveyquestion',$attributes); 
			?>
				<div class="element-wrapper">
					<h6 class="element-header">SURVEY QUESTION MASTER
					</h6>
					
					<div class="element-box">
					<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
				<?php 	} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
				<?php 	} ?>
							<div class="row">
								<div class="col-sm-7">
								   <div class="form-group">
									<label for=""><span class="required_info">* </span>Select Survey</label>
									<select class="form-control" name="Survey_name" id="Surveyname12" data-error="Please select survey" onchange="find_survey_details(this.value);Show_remaing_question(this.value);" id="Survey_dtls" required="required">
										<option value="">Select Survey</option>
										<?php if($CompanySurveyDetails) {
										foreach($CompanySurveyDetails as $survey)
										{?>
											<option value="<?php echo $survey['Survey_id']; ?>"><?php echo $survey['Survey_name']; ?></option>
									<?php 
										}	} ?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group ">
									<label for=""><span class="required_info">* </span>Enter Question</label>
									<textarea class="form-control" rows="3" name="surveyquestion" id="surveyquestion" data-error="Please enter question" required="required"></textarea>	
									<div class="help-block form-text with-errors form-control-feedback"></div>
								 </div>
								 
								 <div class="form-group">
									<label for=""><span class="required_info">* </span>Type of Response</label>
									<select class="form-control" name="ResponseType" id="ResponseType" data-error="Please select type of response" onchange="Check_remain_balane(this.value);hideshow_multiselection(this.value);" required="required">
										<option value="">Type of Response</option>
										<option value="1">Multiple Choice</option>
										<option value="2">Text Based</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
								 </div>
								  
								 <div class="form-group"  id="MultipleChoiceSet" style="display:none" >
									<label for=""><span class="required_info">* </span>Select Multiple Choice Set</label>
									<select class="form-control" name="MultipleChoiceSet" id="MultipleChoice" onchange="Find_MultipleChoiceSet(this.value);" data-error="Please select multiple choice set" required="required">
										<option value="0">Multiple Choice Set</option>
										<?php foreach($MultipleChoiceSetDetails as $multipleSet) 
										{	?>
											<option value="<?php echo $multipleSet['Choice_id']?>"><?php echo $multipleSet['Name_of_option']?></option>
										<?php 	}
										?>							 
									</select>
									<div class="help-block form-text with-errors form-control-feedback" id="help-block3"></div>
								 </div>		
								 
								 <div class="form-group" id="multiselection" style="display:none">		
									<label for=""><span class="required_info">* </span> Multiple Selection</label>&nbsp;&nbsp;						
									<input type="radio" name="Multiple_selection" value="1" required="required">Yes		&nbsp;&nbsp;					
									<input type="radio" name="Multiple_selection" checked  value="0" required="required">No
									<div class="help-block form-text with-errors form-control-feedback"></div>
								 </div>								  
								</div>											
								<div class="col-sm-5">
									<div class="form-group">						
										<div id="RemaingQuestion">				
										</div>
									</div>						
									<div class="form-group" >						
										<div id="SetDetails">				
										</div>	
									</div>
								</div>
							</div>
						  <div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" id="Register">Submit</button>
							<button class="btn btn-primary" type="reset">Reset</button>
							<input type="hidden" name="Company_id" value="<?php echo $Company_id; ?>" class="form-control">
						  </div>
					</div>
				</div>
				<?php echo form_close(); ?>	
				<div id="survey_details">				
				</div>
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	if( $('#Remaing_MCQ_bal_flag').val() == 0 && $('#Remaing_TEXT_bal_flag').val() == 0)
	{
		document.getElementById("Surveyname12").value='';
		document.getElementById("surveyquestion").value='';
		document.getElementById("ResponseType").value='';
		$("#help-block2").html("Survey question balance is over");
		$("#ResponseType").addClass("form-control has-error");		
		return false;		
	}
	else
	{
		if( $('#Surveyname12').val() != "" && $('#surveyquestion').val() != ""&& $('#ResponseType').val() != "")
		{
			if($('#ResponseType').val()==2)
			{
				show_loader();			
			}		
			else
			{
				if($('#MultipleChoice').val()==0)
				{	
					$("#help-block3").html("Please select multiple choice set");
					$("#MultipleChoice").addClass("form-control has-error");						
					return false;
				}
				else
				{
					show_loader();
				}
			}
		}
		// else
		// {	
			// var Title = "Blank Field Validation";
			// var msg = "Please Enter All Required Field(s)";
			// runjs(Title,msg);					
			// return false;	
		// }
	}
});

function find_survey_details(SurveyID)
{
	var Company_id = '<?php echo $Company_id; ?>';	
	$.ajax({
		type: "POST",
		data: {SurveyID:SurveyID, Company_id:Company_id},	//get_survey_questions_details	
		url: "<?php echo base_url()?>index.php/Survey/get_survey_questions_details",
		success: function(data)
		{	
			$('#survey_details').html(data);
		}
	}); 
}

function Find_MultipleChoiceSet(choiceID)
{
	$.ajax({
		type: "POST",
		data: {choiceID:choiceID},
		
		url: "<?php echo base_url()?>index.php/Survey/get_multiple_choice_set",
		success: function(data)
		{	
			$('#SetDetails').html(data);
			$("#MultipleChoice").removeClass("has-error");
			$("#help-block3").html("");  
		}
	}); 
}

function Show_remaing_question(SurveyID)
{
	var Company_id = '<?php echo $Company_id; ?>';
	$.ajax({
		type: "POST",
		data: {SurveyID:SurveyID, Company_id:Company_id},	
		
		url: "<?php echo base_url()?>index.php/Survey/show_remaining_questions",
		success: function(data)
		{	
			$('#RemaingQuestion').html(data);
		}
	}); 
} 

 function Check_remain_balane(Response)
 {
	if(Response==1)
	{
		if($('#Remaing_MCQ_bal_flag').val() ==0 )
		{
			// document.getElementById("Surveyname12").value='';
			// document.getElementById("surveyquestion").value='';
			document.getElementById("ResponseType").value='';
			$("#help-block2").html("Multiple choice question balance is over");
			$("#ResponseType").addClass("form-control has-error");			
			return false;
		}
		else
		{
			$("#ResponseType").removeClass("has-error");
			$("#help-block2").html("");
		}
	}
	if(Response==2)
	{
		if($('#Remaing_TEXT_bal_flag').val() ==0 )
		{
			// document.getElementById("Surveyname12").value='';
			// document.getElementById("surveyquestion").value='';
			document.getElementById("ResponseType").value='';
			$("#help-block2").html("Text based question balance is over");
			$("#ResponseType").addClass("form-control has-error");	
			return false;
		} 
		else
		{
			$("#ResponseType").removeClass("has-error");
			$("#help-block2").html("");
		}
	}
	
	/* if($('#Total_remaing_bal_flag').val() ==0 )
	{
		var Title = "Data Validation";
		var msg = "All Questions Balance is Over";
		runjs(Title,msg);					
		return false;
	}
	if($('#Remaing_MCQ_bal_flag').val() ==0 )
	{
		var Title = "Data Validation";
		var msg = "Multiple Choice Question Balance is Over";
		runjs(Title,msg);					
		return false;
	}
	if($('#Remaing_TEXT_bal_flag').val() ==0 )
	{
		var Title = "Data Validation";
		var msg = "Text Based Question Balance is Over";
		runjs(Title,msg);					
		return false;
	} */
 }

$(function(){
	$('#ResponseType').on('change', function()
	{
		if($("#ResponseType").val()==1)
		{
			if($('#Remaing_MCQ_bal_flag').val() > 0 )
			{
				$("#MultipleChoiceSet").show();
				$("#MultipleChoice" ).attr("required","required");
				$("#ResponseType").removeClass("has-error");
				$("#help-block2").html("");
			}
			else
			{
				$("#MultipleChoiceSet").hide();
			}
		}
		else
		{
			$("#MultipleChoiceSet").hide();
		}
   });
});

function hideshow_multiselection(inputVal)
{
	// alert(inputVal);
	if(inputVal==1)
	{
		$("#multiselection").show();
	}
	else
	{
		$("#multiselection").hide();
	}
}	
</script>