<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   SEND SURVEY
			  </h6>
			  <div class="element-box">
			
					<!-----------------------------------Flash Messege-------------------------------->

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
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('Survey/surveysend',$attributes); ?>	
				<div class="row">
		  <div class="col-sm-8">
				  <div class="form-group">
					<label for="">Company Name</label>
					<select class="form-control" name="companyId"  id="companyId" required="required">
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option> 
					</select>
				  </div>  
				  
					<div class="form-group">
							<label for=""><span class="required_info">*</span> Survey Name</label>
								<select class="form-control" name="sellerId" id="Survey_id"  required>
								<option value="">Select Survey</option>
								<?php
								foreach($CompanySurveyDetails as $survey_name)
								{
								?>
									<option value="<?php echo $survey_name['Survey_id']; ?>"><?php echo $survey_name['Survey_name']; ?></option>
								<?php
								}
								?>
								</select>
						</div>
						
						
							
								<div class="form-group">								
									<legend><span>Send Survey To:</span></legend>
										<div class="form-check" >
											<label class="form-check-label">
												<input type="radio" class="form-check-input comm_type"  name="r2" id="r21" value="1">Single Member
											</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<label>
												<input type="radio" class="form-check-input comm_type"  name="r2" id="r22" value="2">All Members
											</label>
										</div>
										<div class="form-check" >
											<label class="form-check-label">
												<input type="radio" class="form-check-input comm_type"  name="r2" id="r23" value="3">Key Members
											</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<label class="form-check-label">
												<input type="radio" class="form-check-input comm_type"  name="r2" id="r24" value="4">Worry Members
											</label>
										</div>
									<div class="help-block form-text with-errors form-control-feedback" id="comm_type" ></div>
								</div>							
							
						
						
							<div class="form-group" id="send_to_single">								
									<legend><span>Single Member:</span></legend>
									
										<div class="form-group">
											<label for=""><span class="required_info">*</span> Enter Member Name</label>
											<input type="text" name="mailtoone" id="mailtoone" class="form-control" placeholder="Start typing Member Name" autocomplete="off"/>
										</div>
										
										<div class="form-group">
											<label for="">Phone Number</label>
											<input type="text" name="mailtoone_phnno" id="mailtoone_phnno" class="form-control" readonly/>
										</div>
										
										<div class="form-group">
											<label for="">Membership ID</label>
											<input type="text" name="mailtoone_memberid" id="mailtoone_memberid" class="form-control" readonly/>
										</div>
										
										<div class="form-group">
											<input type="hidden" name="Enrollment_id" id="EnrollmentId" value=""/>
										</div>
									
							</div>
						
						<div class="form-group" id="send_to_all">								
									<legend><span>Send to All Members:</span></legend>
							
								<div class="form-group">								
									<select class="form-control" name="mailtoall">
										<option value="0">All Members</option>
									</select>								
								</div>							
						
						</div>
						
						<div class="form-group" id="send_to_key">								
									<legend><span>Send to Key Members:</span></legend>
							</label>
							
								<div class="form-group">								
									<select class="form-control" name="mailtokey" id="mailtokey">
										<option value="">Purchase more than</option>
										<option value="1">2 times in last 3 months</option>
										<option value="2">3 times in last 3 months</option>
										<option value="3">5 times in last 3 months</option>
									</select>								
								</div>
							
						</div>
						
						
							<div class="form-group" id="send_to_worry">								
									<legend><span>Send to Worry Members:</span></legend>
							
								<div class="form-group">								
									<select class="form-control" name="mailtoworry" id="mailtoworry">
										<option value="">No Purchase in</option>
										<option value="1">last 1 month</option>
										<option value="2">last 2 months</option>
										<option value="3">last 3 months</option>
									</select>							
								</div>
							
							</div>
						
						<div class="panel panel-default" id="key_worry_customers">
							<div class="panel-heading"><label for="" id="key_wory_heading">Key / Worry Members</label></div>
							
								<div class="form-group">								
									<select multiple class="form-control" name="key_worry_cust[]" id="KeyWorryCust">
										<option value="">Key / Worry Members</option>
									</select>								
								</div>
							
						</div>	
						<div class="form-buttons-w"  align="center">
					<button class="btn btn-primary" name="submit"  value="Send" id="Send"  type="submit">Send</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				</div>	
					
					
				  
				  
				  
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>

<div id="Survey_model" class="modal fade" role="dialog" style="overflow-y:auto;">
		<div class="modal-dialog" style="width: 90%;margin-top:18%;" id="Survey_details">

		</div>
	</div>
	<!-- Modal -->
	
	<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			 Survey Details
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Survey Name</th>
							<th>Survey Type</th>
							<th>Survey Send</th>
							<th>Survey Details</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				if($CompanySurveyDetails != NULL)
				{
					foreach($CompanySurveyDetails as $row)
					{
						// Feedback Survey  Service Related Survey Product Survey
						
						if($row['Survey_type']==1)
						{$Survey_type='Feedback Survey';}
						else if($row['Survey_type']==1){ $Survey_type='Service Related Survey';}
						else{$Survey_type='Product Survey';}
						
					?>
					<tr>							
							<td><?php echo $row['Survey_name']; ?></td>
							<td><?php echo $Survey_type; ?></td>
							<td>		
							<?php if($row['Send_flag'] == 1 ) {								
						?>
						<span class="btn btn-success btn-sm" >Sent</span>
						<?php } else { ?> 
						<span class="btn btn-danger btn-sm" >Not Send</span>
							<?php }
							?>
							</td>
							<td><div class="sparkbar" data-color="#00a65a" data-height="20">
								<a href="javascript:void(0);" onclick="Survey_details('<?php echo $row['Survey_id'];?>','<?php echo $row['Company_id']; ?>');">Click for Details
								</a>
							</div></td>
							
						</tr>
						
					<?php
					}
				}
				?>		
					</tbody>
				</table>
			  </div>
			</div>
		</div>
	</div> 
	<!--------------Table--------------->
	
</div>			
<?php $this->load->view('header/footer'); ?>

<script type="text/javascript">

$('#Send').click(function()
{	
	if( $('#companyId').val() != "" && $('#Survey_id').val() != "" )
	{
		if( $('input[name=r2]').is(":checked") == true )
				{
					var r2Value = $('input[name=r2]:checked').val();
					if( r2Value == 1 )
					{
						if( $('#mailtoone').val() != "" )
						{
							show_loader();
						}
					}
					if( r2Value == 2 )
					{
						show_loader();
					}
					if( r2Value == 3 )
					{
						if( $('#mailtokey').val() != "" )
						{
							if( $('#KeyWorryCust').val() != null )
							{
								show_loader();
							}
						}
					}
					if( r2Value == 4 )
					{
						if( $('#mailtoworry').val() != "" )
						{
							if( $('#KeyWorryCust').val() != null )
							{
								show_loader();
							}
						}
					}
				}
				else 
				{
					
					var msg1 = 'Please Select Atleast One Option';
					document.getElementById("comm_type").innerHTML=msg1;
					return false;
				}
				
		
		if(r1Value == 3)
		{
			if( $('input[name=r2]').is(":checked") == true )
			{
				var r2Value = $('input[name=r2]:checked').val();			
				if( r2Value == 1 )
				{
					if( $('#mailtoone').val() != "" )
					{
						show_loader();
					}
				}
				if( r2Value == 2 )
				{
					show_loader();
				}
				if( r2Value == 3 )
				{
					if( $('#mailtokey').val() != "" )
					{
						if( $('#KeyWorryCust').val() != null )
						{
							show_loader();
						}
					}
				}
				if( r2Value == 4 )
				{
					if( $('#mailtoworry').val() != "" )
					{
						if( $('#KeyWorryCust').val() != null )
						{
							show_loader();
						}
					}
				}
			}
			else 
				{
					
					var msg1 = 'Please Select Atleast One Option';
					document.getElementById("comm_type").innerHTML=msg1;
					return false;
				}
			
		}
	}
	
});

$(".comm_type").click(function() {

	
	document.getElementById("comm_type").innerHTML='';
		
})

$('#Survey_id').change(function()
{
	var Surveyid = $("#Survey_id").val();
		// alert(Surveyid);
		var Company_id = '<?php echo $Company_id; ?>';
		if( $("#Surveyid").val() == "")
		{
			$("#Surveyid").val("");		
			
		}
		else
		{
			$.ajax({
				type: "POST",
				data: {Surveyid: Surveyid, Company_id: Company_id},
				dataType: "json",
				url: "<?php echo base_url()?>index.php/Survey/check_survey_question",
				success: function(json)
				{
					if( (json == "" || json == 0) )
					{						
						var Title = "Application Information";
						var msg = 'Enable to send this survey to Customer';
						runjs(Title,msg);
						$("#Survey_id").val("");
					}
				}
			});
		}
});

/******************************Show Hide*********************************/
	$('#r21').click(function()
	{
		$( "#send_to_single" ).show();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();	
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone" ).attr("required","required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
	});
	
	$('#r22').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).show();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
	});
	
	$('#r23').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).show();
		$( "#send_to_worry" ).hide();
		$( "#mailtokey" ).attr("required","required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$( "#key_worry_customers" ).show();
		$("#KeyWorryCust").attr("required","required");
		$('#key_wory_heading').html("Key Members");
	});
	
	$('#r24').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).show();
		$( "#mailtoworry" ).attr("required","required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#key_worry_customers" ).show();
		$("#KeyWorryCust").attr("required","required");
		$('#key_wory_heading').html("Worry Members");
	});
/******************************Show Hide*********************************/


$(document).ready(function() 
{	
	$( "#send_to_single" ).hide();
	$( "#send_to_all" ).hide();
	$( "#send_to_key" ).hide();
	$( "#send_to_worry" ).hide();
	$( "#key_worry_customers" ).hide();
	$("#mailtoone_phnno").val("");
	$("#mailtoone_memberid").val("");
	
	
	
	/*********************************Autocomplete***************************************/
		$("#mailtoone").autocomplete({
			source: "<?php echo base_url()?>index.php/Survey/autocomplete_customer_names" // path to the get_birds method
		});
	/*********************************Autocomplete***************************************/
	
	$('#mailtoone').blur(function()
	{
		var Cust_name = $("#mailtoone").val();
		var Company_id = '<?php echo $Company_id; ?>';
		if( $("#mailtoone").val() == "")
		{
			$("#mailtoone_phnno").val("");				
			$("#mailtoone_memberid").val("");				
			$("#EnrollmentId").val("");
		}
		else
		{
			$.ajax({
				type: "POST",
				data: {Cust_name: Cust_name, Company_id: Company_id},
				dataType: "json",
				url: "<?php echo base_url()?>index.php/Survey/get_phnno_memberid",
				success: function(json)
				{
					if( (json == "" || json == null) )
					{
						$("#mailtoone").val("");
						$("#mailtoone_phnno").val("");				
						$("#mailtoone_memberid").val("");				
						$("#EnrollmentId").val("");	
					}
					else
					{
						$("#mailtoone_phnno").val(json[0].Phone_no);				
						$("#mailtoone_memberid").val(json[0].Card_id);				
						$("#EnrollmentId").val(json[0].Enrollement_id);				
					}
				}
			});
		}
	});
	
	$('#mailtokey').change(function()
	{
		var mailtokey = $("#mailtokey").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var r2Value = $('input[name=r2]:checked').val();
		$.ajax({
			type:"POST",
			data:{Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey},
			url: "<?php echo base_url()?>index.php/Survey/get_key_worry_customers",
			success: function(data)
			{
				$('#KeyWorryCust').html(data.get_key_worry_customers);
				$('#key_wory_heading').html("Key Members");
			}				
		});
	});
	
	$('#mailtoworry').change(function()
	{
		var mailtokey = $("#mailtoworry").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var r2Value = $('input[name=r2]:checked').val();
		$.ajax({
			type:"POST",
			data:{Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey},
			url: "<?php echo base_url()?>index.php/Survey/get_key_worry_customers",
			success: function(data)
			{
				$('#KeyWorryCust').html(data.get_key_worry_customers);
				$('#key_wory_heading').html("Worry Members");
			}				
		});
	});
	
});
</script>
<script>
function Survey_details(SurveyID,Company_id)
{	
	// alert('SurveyID '+SurveyID);
	// alert('Company_id '+Company_id);
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
</script>
