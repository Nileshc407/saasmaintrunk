<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php
				$attributes = array('id' => 'formValidate');
				echo form_open_multipart('Survey/surveystructure',$attributes); 
			?>
				<div class="element-wrapper">
					<h6 class="element-header">SURVEY STRUCTURE MASTER
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
								<div class="col-sm-6">		
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Name Of Survey</label>
									<input type="text" class="form-control" name="survey_name" id="survey_name" data-error="Please enter name of survey" placeholder="Enter name of survey" required="required">
									<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
								  </div> 
								  
								   <div class="form-group">
									<label for=""><span class="required_info">* </span>Type Of Survey</label>
									<select class="form-control" name="Type_of_survey" id="Type_of_survey" data-error="Please select survey type" required="required">
										<option value="">Select Type</option>
										<option value="1">Feedback Survey</option>
										<option value="2">Service Related Survey</option>
										<option value="3">Product Survey</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span> Enter number of Questions</label>
									<input type="text" class="form-control" name="no_of_questions" id="no_of_questions" data-error="Please enter number of questions" placeholder="Enter number of questions" onkeyup="this.value=this.value.replace(/\D/g,'')" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span> Number Of Multiple Choice Questions</label>
									<input type="text" class="form-control" name="multiple_choice" id="multiple_choice" data-error="Please enter number of multiple choice questions" placeholder="Enter number of multiple choice questions" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="javascript:cal_text_no(this.value)" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								 
								 <div class="form-group ">
									<label for=""><span class="required_info">* </span> Number Of Text Based Questions</label>
									<input type="text" name="text_based" id="text_based" class="form-control" placeholder="Number of text based questions" readonly="readonly" onkeyup="this.value=this.value.replace(/\D/g,'')" required="required" />
									
								 </div>									  
								</div>											
								<div class="col-sm-6">
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>Valid From <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="Valid_from" id="datepicker1" data-error="Please select from date"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>Valid Till <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="End Date" type="text"  name="Valid_till" id="datepicker2" data-error="Please select till date"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
									<div class="form-group ">
										<label for="" ><span class="required_info">Reminder Notification Days:</span></label>
									</div>
								 
								 
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Reminder Notification Days After Validity Starts</label>
									<input type="text" class="form-control" name="remind_after_validity" id="remind_after_validity" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter reminder notification days after validity starts" data-error="Please enter reminder notification days after validity starts" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Reminder Notification Days Before Validity Ends</label>
									<input type="text" class="form-control" name="remind_before_validity" id="remind_before_validity" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter reminder notification days before validity ends" data-error="Please enter reminder notification days before validity ends" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								 <div class="form-group">
									<label for="">Survey Reward?</label>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="r2" id="r2" type="radio" onchange="show_survey(this.value)" value="1" required="required">Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input class="form-check-input" name="r2" id="r1" type="radio" value="0" onchange="show_survey(this.value)" required="required" checked>No</label>
									  </div> 
									 
									</div>
								  </div>
								  <div class="form-group" id="Survey_Reward" style="display:none">
									<label for=""><span class="required_info">* </span>Survey Reward Points</label>
									<input type="text" name="Survey_Reward_Points" id="Survey_Reward_Points" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter reward points">
									<div class="help-block form-text with-errors form-control-feedback" id="help-block4"></div>
								 </div>
								
								<div class="form-group">		
									<label for=""><span class="required_info">* </span>Enable Survey Template </label>
									<br>
									<input type="radio" name="Survey_template" id="STemplate" onchange="JavaScript:show_template(this.value);" value="1" required="required"> Preview Template 1	
									<!--<input type="radio" name="Survey_template" id="STemplate" onchange="JavaScript:show_template(this.value);" value="1" required> Preview Template 1						
									<input type="radio" name="Survey_template" id="STemplate" onchange="JavaScript:show_template(this.value);" value="2" required>Preview Template 2 -->
									<input type="radio" name="Survey_template" id="STemplate" onchange="JavaScript:show_template(this.value);" value="3" required="required">Preview Template 2
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								
								</div>
							</div>
						  <div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" id="Register">Submit</button>
							<button class="btn btn-primary" type="reset">Reset</button>
							<input type="hidden" name="Company_id" value="<?php echo $Company_id; ?>"  class="form-control"  />
						  </div>
					</div>
				</div>
				<?php echo form_close(); ?>	
				<!--------------Table------------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					   Multiple Choice Structure Details
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Survey Name</th>
									<th>Survey Type</th>
									<th>Number of Questions</th>
									<th>Multiple Choice Questions</th>
									<th>Text Based Questions</th>
									<th>From Date</th>
									<th>To Date</th>
									<th>Survey Details</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Survey Name</th>
									<th>Survey Type</th>
									<th>Number of Questions</th>
									<th>Multiple Choice Questions</th>
									<th>Text Based Questions</th>
									<th>From Date</th>
									<th>To Date</th>
									<th>Survey Details</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
						$mv_date=date("Y-m-d");
							if($Survey_structure != NULL)
							{
								foreach($Survey_structure as $row)
								{
									if($row->Survey_type==1)
									{
										$Survey_type='Feedback Survey';
									}
									else if($row->Survey_type==2)
									{
										$Survey_type='Service Related Survey';
									}
									else
									{
										$Survey_type='Product Survey';
									}
							?>
								<tr>
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/Survey/editsurveystructure/?Survey_id=<?php echo $row->Survey_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
						
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Survey_id;?>','<?php echo $row->Survey_name; ?>','','Survey/delete_survey_structure/?Survey_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
									</td>
									<td><?php echo $row->Survey_name;?></td>
									<td><?php echo $Survey_type;?></td>
									<td><?php echo $row->No_of_questions;?></td>
									<td><?php echo $row->No_of_multiple_choice;?></td>
									<td><?php echo $row->No_of_text_based;?></td><?php                      
									if(($mv_date >= $row->Start_date) && ($mv_date <= $row->End_date))
									{ ?>
										<td style="color:green"><?php echo date('Y-M-d',strtotime($row->Start_date)); ?></td>
										<td style="color:green"><?php echo date('Y-M-d',strtotime($row->End_date)); ?></td>
									<?php 
									}
									else
									{
									?>
										<td><?php echo $row->Start_date; ?></td>
										<td><?php echo $row->End_date; ?></td>
									<?php 
									}
									?>
									<td>
										<div class="sparkbar" data-color="#00a65a" data-height="20">
											<a href="javascript:void(0);" onclick="Survey_details('<?php echo $row->Survey_id;?>','<?php echo $row->Company_id; ?>');">
												Click for Details
											</a>
										</div>
									</td>									
								</tr>
					<?php 		}
							}	?>
							</tbody>
						</table>
					  </div>
					</div>
				</div>
				<!--------------Table--------------->
			</div>
		</div>	
	</div>
</div>
<!--Survey details Modal-->
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" id="Survey_model" class="modal fade bd-example-modal-sm show" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" style="overflow-y:auto;">
	<div class="modal-dialog" style="width: 90%;" id="Survey_details" role="document">
	</div>
</div>
<!--Survey details Modal-->
<?php $this->load->view('header/footer'); ?>
<script>
function Survey_details(SurveyID,Company_id)
{	
	$.ajax({
		type: "POST",
		data: {SurveyID:SurveyID, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Survey/fetch_survey_details",
		success: function(data)
		{
			$("#Survey_details").html(data.SurveyDetailHtml);	
			$('#Survey_model').show();
			$("#Survey_model").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
function show_template(tempid)
{	
	if(tempid==1)
	{
		var url1='<?php echo base_url()?>index.php/Survey/fetch_survey_template1';
	}
	else if(tempid==2)
	{
		var url1='<?php echo base_url()?>index.php/Survey/fetch_survey_template2';
	}
	else if(tempid==3)
	{
		// alert(tempid);
		var url1='<?php echo base_url()?>index.php/Survey/fetch_survey_template3';
	}
	
	$.ajax({
	type: "POST",
	data: {tempid:tempid},		
	url:url1,		
	success: function(data)
	{ 		
		window.open(url1, '_blank','width=600, height=600');
	}
	});		
}
$('#Register').click(function()
{
	/*if(document.getElementById('r2').checked== false || document.getElementById('r1').checked== false )
	{
		$("#help-block2").html("Please check survey reward or not");
		$("#r2").addClass("form-control has-error");
		return false; 
	} */
	
	if(document.getElementById('r2').checked)
	{
		var rate_value = document.getElementById('Survey_Reward_Points').value;
		if(rate_value =="")
		{
			$("#Survey_Reward_Points").attr("required","required");
			$("#help-block4").html("Please enter survey reward");
			$("#Survey_Reward_Points").addClass("form-control has-error");
			return false;
		}	
	}
	
	if( $('#survey_name').val() != "" && $('#Type_of_survey').val() != "" && $('#no_of_questions').val() != "" && $('#multiple_choice').val() != ""&& $('#text_based').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" && $('#remind_after_validity').val() != "" && $('#remind_before_validity').val() != "" && $('input[name="Survey_template"]:checked').length > 0 )
	{
		show_loader();
	}	
});

$('#Survey_Reward_Points').blur(function()
{
	if( $("#Survey_Reward_Points").val() != "")
	{
		$("#Survey_Reward_Points").removeClass("has-error");
		$("#help-block4").html("");
	}
	else
	{
		$("#help-block4").html("Please enter survey reward");
		$("#Survey_Reward_Points").addClass("form-control has-error");
	} 
});

$('#survey_name').blur(function()
{
	if( $("#survey_name").val() != "")
	{
		var survey_name = $("#survey_name").val();
		var Company_id ='<?php echo $Company_details->Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {survey_name: survey_name, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Survey/check_survey_structure",
			success: function(data)
			{ 
				if(data.length == 13)
				{							
					$("#survey_name").val("");
					$("#help-block1").html("Already exist");
					$("#survey_name").addClass("form-control has-error");
				}
				else
				{
					$("#survey_name").removeClass("has-error");
					$("#help-block1").html("");
				}
			}
		});
	}
	else
	{
		$("#survey_name").val("");
		$("#help-block1").html("Please enter survey name");
		$("#survey_name").addClass("form-control has-error");
	} 
});

	
function delete_survey_structure(Survey_id,Survey_name,companyID)
{	
	BootstrapDialog.confirm("Are you sure to Delete the  "+Survey_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Survey/delete_survey_structure/?Survey_id='+Survey_id+'&companyID='+companyID;
		if (result == true)
		{
			show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		} 
	});
} 

function cal_text_no(number)
{
	// alert(number);
	if(number == "")
	{
		document.getElementById("multiple_choice").focus();
		var Title = "Blank Field Validation";
		var msg = "Please Enter Number Of Multiple Choice Questions!";
		runjs(Title,msg);					
		return false;
	}
	else
	{
		var no_of_questions = parseInt(document.getElementById('no_of_questions').value);
		var multiple_choice = parseInt(document.getElementById('multiple_choice').value);
		var text_based = document.getElementById('text_based');
		var Title = "Blank Field Validation";
		if(multiple_choice > no_of_questions)
		{
			// alert(number);
			document.getElementById('multiple_choice').value= "";
			text_based.value="";
			var msg = "Number of Questions is Greater Than Multiple Choice Question...Please Enter Proper Data !";
			runjs(Title,msg);
			return false;
		}					
		if(multiple_choice != "" && no_of_questions != "")
		{
			text_based.value=Math.round(no_of_questions - multiple_choice);
		}
		else
		{
			if(number == 0)
			{
				text_based.value=Math.round(no_of_questions + multiple_choice);
			}
			else
			{
				text_based.value="";
			}
		}
	}
}			
/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
		
});
/******calender *********/

 function show_survey(ValRD)		
{
	if(ValRD==1)
	{
		$("#Survey_Reward").show(); 		
	}
	else
	{
		$("#Survey_Reward").hide();
	}
} 
</script>
