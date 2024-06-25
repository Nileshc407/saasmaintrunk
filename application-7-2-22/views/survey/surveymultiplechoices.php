<?php $this->load->view('header/header'); 
?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				DEFINE SURVEY MULTIPLE CHOICE STRUCTURE
			  </h6>
				<div class="element-box">
				<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_box" style="display:none;"></div>
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code'); ?>
						</div>
				<?php 		
					} 
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} 
					
				$attributes = array('id' => 'formValidate');
				// echo form_open_multipart('Survey/survey_multiple_choices');
				echo form_open_multipart('Survey/survey_multiple_choices',$attributes); ?>
				<div class="col-sm-8">
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Name Of Multiple Choice Set</label>
						<input class="form-control" type="text" name="multiple_choice_name" id="multiple_choice_name" placeholder="Enter name of multiple choice set" data-error="Please enter name of multiple choice set" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div> 
					
					  <div class="form-group"> 
						<label for=""><span class="required_info">* </span> Enter Number of Options</label>
						<input class="form-control" type="text" name="no_of_options" id="no_of_options" placeholder="Enter number of options" data-error="Please enter number of options" onchange="createMany(this.value);"  class="form-control" placeholder="Number of Options " onkeyup="this.value=this.value.replace(/\D/g,'')" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
					  </div>
				</div>
				<?php
				if($Company_details->Survey_analysis== '1') 
				{
					$column="col-sm-3";	
				}
				else
				{
					$column="col-sm-3";	
				} ?>
				<div class="col-sm-12">						
					<fieldset class="form-group">
						<legend><span>Options Description</span></legend>						
						<div class="row">
							<div class="<?php echo $column; ?>">
								<div class="form-group" id="optionName">
								</div>				
							</div>
							<?php
								if($Company_details->Survey_analysis== '1') { ?>
							<div class="<?php echo $column; ?>">
								<div class="form-group" id="optionName_NPS">
									
								</div>					
							</div>
							<?php } ?>
							<div class="<?php echo $column; ?>">
								<div class="form-group" id="option_images">
								</div>					
							</div>
							<div class="<?php echo $column; ?>">
								<div class="form-group" id="file_images">				
								</div>					
							</div>
						</div>
					</fieldset>
				</div>
			
				<div class="form-buttons-w">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				</div>
				<?php echo form_close(); ?>	
			  </div>
			</div>
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
								<th>Name Of Multiple Choice Structure</th>
								<th>Number Of Options</th>
							</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Name Of Multiple Choice Structure</th>
								<th>Number Of Options</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results != NULL)
						{
							foreach($results as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Survey/edit_multiple_choice/?Choice_id=<?php echo $row->Choice_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Choice_id;?>','<?php echo $row->Name_of_option; ?>','','Survey/delete_multi_choice/?choiceId');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
								</td>
								<td><?php echo $row->Name_of_option;?></td>
								<td><?php echo $row->Number_of_option;?></td>
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
<?php $this->load->view('header/footer'); ?>

<script>
function createMany(nums)
{
	var str = "";
	for(i=1;i<=nums;i++)
	{
		str += "<label for=\"\"><span class=\"required_info\">*</span> Option Value </label><input type='text' class=\"form-control\" id='option_value_"+i+"' name='option_value[]' placeholder=\"Enter option value\" data-error=\"Please enter option value\" required=\"required\"> <br/> <div class=\"help-block form-text with-errors form-control-feedback\"></div>";
	}
	
	document.getElementById("optionName").innerHTML = str;
	
	var option_img = "";
	var file_img = "";
	for(i=1;i<=nums;i++)
	{
		option_img += "<label for=\"\"><span class=\"required_info\">*</span>Option Image</label><br/><div class='upload-btn-wrapper'><button class='file-btn'><i class='fa fa-cloud-upload'></i></button><input type='file' name='file_"+i+"' id='file' class=\"form-control\" onchange=\"readImage(this,'#file_"+i+"');\" /></div><br/>";	
		
		file_img += "<img type='file' name='file_"+i+"' src='<?php echo base_url(); ?>images/no_image.jpeg' id='file_"+i+"' style='width: 40%;padding: 10px;'><br>";
	}	
	document.getElementById("option_images").innerHTML = option_img;
	document.getElementById("file_images").innerHTML = file_img;
	
	var Surveyanalysis ='<?php echo $Company_details->Survey_analysis; ?>';
	if( Surveyanalysis == '1' )
	{
		var nps_str = "";	
		for(i=1;i<=nums;i++)
		{
		 	nps_str += "<label for=\"\"><span class=\"required_info\">*</span> NPS Type </label><select class=\"form-control\" id='nps_value_"+i+"' name='nps_value[]' data-error=\"Please select nps type\" required=\"required\"> <br/> <option value=\"\"> Select nps type</option> <?php foreach($Survey_nps_type as $nps) { ?> <option value=\"<?php echo $nps['NPS_type_id']; ?>\"> <?php echo $nps['NPS_type_name']; ?> </option> <?php } ?> </select> <br/> <div class=\"help-block form-text with-errors form-control-feedback\"></div>";				
		}	
		document.getElementById("optionName_NPS").innerHTML = nps_str;
	}
}

$('#multiple_choice_name').blur(function()
{
	if( $("#multiple_choice_name").val() != "")
	{
		var choice_name = $("#multiple_choice_name").val();
		var Company_id ='<?php echo $Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {choice_name: choice_name, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Survey/check_mul_choice_structure",
			success: function(data)
			{
				// alert(data.length);
				if(data.length == 13)
				{							
					$("#multiple_choice_name").val("");
					$("#multiple_choice_name").addClass("form-control has-error");
					$("#help-block1").html("Already exist");
				}
				else
				{
					$("#multiple_choice_name").removeClass("has-error");
					$("#help-block1").html("");
				}	
			}
		});
	}
	else
	{
		$("#multiple_choice_name").val("");
		$("#help-block1").html("Please enter name of multiple choice set");
	} 
}); 

$("#Register").click(function ()  
{
	var zorunluAlan = ["input[name='option_value[]']"];
	for (i = 0; i < zorunluAlan.length; i++) 
	{
		if ($(zorunluAlan[i]).val().trim().length == 0) 
		{
			var msg = 'All option values are required';
			$('#alert_box').show();			
			$("#alert_box").html(msg);
			jQuery("#alert_box").attr("tabindex",-1).focus();
			setTimeout(function(){ $('#alert_box').hide(); }, 4000);			
			return false;
		}
		
	}
	var Surveyanalysis ='<?php echo $Company_details->Survey_analysis; ?>';
	if( Surveyanalysis == '1' )
	{				
		var zorunluAlan1 = ["input[name='nps_value[]']"];
		for (j = 0; j < zorunluAlan1.length; j++) 
		{
			if ($(zorunluAlan1[j]).val().trim().length == 0) 
			{
				var msg = 'All NPS option values are required';
				$('#alert_box').show();			
				$("#alert_box").html(msg);
				jQuery("#alert_box").attr("tabindex",-1).focus();
				setTimeout(function(){ $('#alert_box').hide(); }, 4000);			
				return false;
			}
		}				
	}
});
function readImage(input,div_id) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$(div_id)
				.attr('src', e.target.result)
				.height(100);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>
