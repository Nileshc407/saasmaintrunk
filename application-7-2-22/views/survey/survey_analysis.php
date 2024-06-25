<?php $this->load->view('header/header'); ?>
<div class="content-i" style="min-height: 600px;">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Survey/surveystructure',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">SURVEY ANALYSIS REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-8">
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Select Survey</label>
								<select class="form-control" name="Survey_name" id="Surveyname12" data-error="Please select survey" onchange="find_survey_details(this.value);find_survey_summary(this.value);" required="required">
								<option value="">Select survey</option>
								<?php 
								if($SurveyAnalysisDetails) 
								{
									foreach($SurveyAnalysisDetails as $survey)
									{ ?>
										<option value="<?php echo $survey['Survey_id']; ?>"><?php echo $survey['Survey_name']; ?></option>									
							<?php   }
								} 
								?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							</div>
						</div>
					  <br/><br/>
					  <div id="Survey_model" class="modal fade" role="dialog" style="overflow-y:auto;">
						<div class="modal-dialog" style="width: 90%;" id="Survey_details">
						</div>
					  </div>
					  <div id="survey_analysis">				
					  </div>	
					  <div id="survey_details">				
					  </div>
					</div>
				</div>
				<?php echo form_close(); ?>	
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>
function Survey_question_analysis(SurveyID,Company_id,Enrollement_id)
{	
	$.ajax({
		type: "POST",
		data: {SurveyID:SurveyID, Company_id:Company_id,Enrollement_id:Enrollement_id},
		url: "<?php echo base_url()?>index.php/Survey/fetch_survey_customer_analysis",
		success: function(data)
		{
			$("#Survey_details").html(data.SurveyDetailHtml);	
			$('#Survey_model').show();
			$("#Survey_model").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}

function find_survey_details(SurveyID)
{
	var Company_id = '<?php echo $Company_id; ?>';	
	$.ajax({
		type: "POST",
		data: {SurveyID:SurveyID, Company_id:Company_id},	
		url: "<?php echo base_url()?>index.php/Survey/get_survey_analysis_details",
		success: function(data)
		{	
			$('#survey_details').html(data);
		}
	});
}
function find_survey_summary(SurveyID)
{
	var Company_id = '<?php echo $Company_id; ?>';	
	$.ajax({
		type: "POST",
		data: {SurveyID:SurveyID, Company_id:Company_id},	
		url: "<?php echo base_url()?>index.php/Survey/get_survey_summary_details",
		success: function(data)
		{	
			$('#survey_analysis').html(data);
		}
	}); 
}

$('#submit').click(function()
{
	if( $('#Surveyname12').val() != "" )
	{
		show_loader();
	}
});
</script>