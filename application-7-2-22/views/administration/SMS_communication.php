<?php $this->load->view('header/header'); ?>

<script src="<?php echo base_url()?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<script>	
	function fileBrowserCallBack(field_name, url, type, win)
	{
		$('.mce-window').css("z-index","0");
		$('.modal').css("z-index","9999999");
		$('#ImageModal').show();
		$("#ImageModal").addClass( "in" );	
		$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );		
	}
	
	$(document).ready(function (e)
	{		
		$("#uploadForm").on('submit',(function(e) 
		{
			e.preventDefault();
                        var mce = window.top.tinyMCE.activeEditor;
			$.ajax(
			{
				url: "<?php echo base_url()?>index.php/Administration/upload_offer_images", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					if(data.message == '1')
					{
						$('.mce-window').css("z-index","65536");
						$('#ImageModal').hide();
						$("#ImageModal").removeClass( "in" );
						$('.modal-backdrop').remove();
						
                                                mce.windowManager.close();
                                                var Content_to_insert = "<img src='"+data.image_name+"' />";
                                                tinyMCE.activeEditor.execCommand("mceInsertContent", true, Content_to_insert);
					}
					else
					{
						return false;
					}
				}
			});
		}));
	});
	
	tinymce.init(
	{
		selector: "textarea#offerdetails1",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		// toolbar1: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | print preview media code | forecolor backcolor emoticons",	//link image |
		toolbar1: " print preview media",	//link image |
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				
				$('#Offer_description').html(htmlContent);
				$('input[name=offerdetails]').val(htmlContent);
				var count_contents=$("#offerdetails1").val().length;
				
				var text = $(htmlContent).text();
				// alert("text "+text);
				// alert("count_contents "+text.length);
				var chars=text.length;
				 sms_count(chars);
			});
			
			
		}
	});
	
	tinymce.init(
	{
		selector: "textarea#offerdetails",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "preview",	
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				  
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				$('input[name=offerdetails1]').val(htmlContent);
				
			});
		}
	});	
			function sms_count(chars)
			{
				//alert(chars.length);
				var remaining = document.getElementById('remaining');
				// var chars = document.getElementById("offerdetails1").length;
				chars = chars.length+1;
				var messages = Math.ceil(chars/160);
				remaining =  messages * 160 - (chars % (messages * 160) || messages * 160) ;
				document.getElementById('remaining').innerHTML = remaining + ' characters';
				document.getElementById('messages').innerHTML = messages + ' message(s)';
			}
			function sms_count2(chars)
			{
				
				var messages = Math.ceil(chars/160);
			
				document.getElementById('messages2').innerHTML = messages + ' message(s)';
			}
			
				
</script>


<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   SMS Communication
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
					
					
							<?php
							if($Available_sms <= 10)
							{
								?>
								
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
								  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
								  <span aria-hidden="true"> &times;</span></button>
									<p>Your SMS Balance is below 10, Please increase your SMS Balance !!!</p>	
								</div>
							<?php
							}
							if($Available_sms == 0)
							{
								?>
								
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
								  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
								  <span aria-hidden="true"> &times;</span></button>
									<p>Your SMS Balance is exhausted, Please increase your SMS Balance !!!</p>	
								</div>
							<?php
							
							}
							?>
						
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('Administration/SMS_communication',$attributes); ?>	
				
				<div class="row">
			<div class="col-sm-6">
				 <div class="form-group">
							<label for=""><span class="required_info">*</span> Company Name</label>
								<select class="form-control" name="companyId" id="companyId" required >
									<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
								</select>									
						</div>						
						<div class="form-group">
							<label for=""><span class="required_info">*</span> Merchant Name</label>
								<select class="form-control" name="sellerId" id="sellerId" required>
								<option value="">Select Merchant</option>
								<?php
								if($Logged_user_id > 2 || $Super_seller == 1)
								{
									echo '<option value="0">All Merchant</option>';
									echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';								
								}
								foreach($company_sellers as $sellers)
								{
								?>
									<option value="<?php echo $sellers->Enrollement_id; ?>"><?php echo $sellers->First_name." ".$sellers->Last_name; ?></option>
								<?php
								}
								?>
								</select>
						</div>
						
						<div class="form-group">
							<div class="form-check" >
								<label class="form-check-label">
									<input type="radio" class="form-check-input comm_type"  name="r1" id="r1" value="1" >Create New SMS
								</label>
							</div> 
							
							<div class="form-check" >
								<label class="form-check-label">						
									<input type="radio" class="form-check-input comm_type"  name="r1" id="r2" value="2" >Send Existing SMS
								</label>
							</div> 
							
							<div class="form-check" >
								<label class="form-check-label">
									<input type="radio" class="form-check-input comm_type"  name="r1" id="r3" value="3" >Send Multiple SMS 
								</label>
							</div> 
							 <div class="help-block form-text with-errors form-control-feedback" id="comm_type" ></div>
						</div>
						
						<div class="form-group" id="create_new_offer">
							<legend><span>Create New SMS</span></legend>
							
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Sender Name</label>
									<span class="required_info"> (6 characters only & Space not allowed)</span>
									<input type="text" name="offer" id="offer_name" class="form-control" placeholder="Enter Sender Name" maxlength="6"  onkeyup="this.value=this.value.replace(/[0-9\.]+/g, '')"  onkeypress="this.value=this.value.replace(/ /g, '')"  data-error="Please Enter Sender Name" />
									<div class="help-block form-text with-errors form-control-feedback" id="offer_name2" ></div>									
								</div>
								
							<div class="form-group">
								<label for="">SMS Related to</label>
								<select class="form-control"  name="Offer_related_to" id="Offer_related_to">
									<option value="">Select Hobbies/Interest</option>
								<?php
								
									foreach($Hobbies_list as $hob)
									{
										echo "<option value=".$hob->Id.">".$hob->Hobbies."</option>";
									}
								?>	
									
									
								</select>								
							</div>
					
								<div class="form-group">
									<label for="">
										<span class="required_info">*</span> Valid From <span class="required_info">(* click inside textbox)</span>
									</label>
									<div class="input-group">
										<input type="text" name="start_date" id="datepicker1" class="form-control" placeholder="Communication Start Date" />			
										<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
									</div>
								</div>
								
								<div class="form-group">
									<label for="">
										<span class="required_info">*</span> Valid Till <span class="required_info">(* click inside textbox)</span>
									</label>
									<div class="input-group">
										<input type="text" name="end_date" id="datepicker2" class="form-control" placeholder="Communication End Date" />			
										<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group">								
									<label for="">
										Link to LBS </label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<label class="form-check-label">
											<input type="radio" class="form-check-input"  name="Link_to_lbs" id="Link_to_lbs" value="1">Yes								
										</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<label class="form-check-label">										
											<input type="radio" class="form-check-input"  name="Link_to_lbs" id="Link_to_lbs" checked value="0">No									
										</label>
											
								</div>
								
								<div class="form-group">
									<label for=""><span class="required_info">*</span> SMS Contents</label>
									<textarea class="form-control" rows="4" name="offerdetails" id="offerdetails1" style="visibility:visible" value="" onkeypress="sms_count(this.value);"></textarea>
									<p><span id="remaining" class="required_info">160 characters</span>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="messages" class="required_info">1 message(s)</span></p>
								</div>
							
						</div>
						
						<div class="panel panel-default" id="send_exist_offer">
							<legend><span>Send Existing Communication</span></legend>
							
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Select Active Communication</label>
									<select class="form-control" name="activeoffer" id="activeoffer">
										<option value="">Select Merchant First</option>
									</select>								
								</div>
								
								<div class="form-group">
									<label for=""><span class="required_info">*</span> SMS Contents</label>
									<textarea class="form-control" rows="4" name="offerdetails1" id="offerdetails" placeholder="Select Offer First" readonly></textarea>
									<p>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="messages2" class="required_info">1 message(s)</span></p>
								</div>
							
							
							
						</div>
						
						<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
							<div class="modal-dialog" style="width: 90%;">

							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title text-center">Communication</h4>
									</div>
									<div class="modal-body">
										<div class="table-responsive" id="show_multiple_offer"></div>
									</div>
									<div class="modal-footer">
										<button type="button" id="close_modal" class="btn btn-primary">Save Applied Rule(s)</button>
										<button type="button" id="close_modal12" class="btn btn-primary">Close</button>
									</div>
								</div>

							</div>
						</div>
					
						<div class="panel panel-default" id="send_communication_to">
							
							<legend><span>Send Communication To</span></legend>
							<div class="panel-body">
								<div class="form-group">								
									<div class="col-xs-12">
										<div class="radio">
											<label>
												<input type="radio" name="r2" id="r21" value="1">Single Member
											
											</label>
										</div>
										<div class="radio">
											<label>
												
												<input type="radio" name="r2" id="r22" value="2">All Members
											</label>
										</div>
										
										<div class="radio">
											<label>
												<input type="radio" name="r2" id="r23" value="3">Key Members
											
											</label>
										</div>
										<div class="radio">
											<label>
											
												<input type="radio" name="r2" id="r24" value="4">Worry Members
											</label>
										</div>
										
										<div class="radio">
											<label>
												<input type="radio" name="r2" id="r25" value="5">Tier Based Members
											</label>
										</div>
										<div class="radio" id="hobbie" style="display:none;">
											<label>
												<input type="radio" name="r2" id="r26" value="6">Hobbies/Intrested Members
											</label>
										</div>
										
										<div class="radio">
											<label>
												<input type="radio" name="r2" id="r27" value="7">Segment Based Members
											</label>
										</div>
									</div>
								</div>							
							</div>
						</div>
						
						<div class="panel panel-default" id="send_to_single">
							<legend><span>Single Member</span></legend>
							<div class="panel-body">
								<div class="form-group has-feedback" id="block1" >
								<label for=""><span class="required_info">*</span> Membership ID</label>
								<input type="text" id="mailtoone_memberid" name="mailtoone_memberid" class="form-control"  placeholder="Enter Membership ID" value=""  data-error="Please Enter Membership ID" />								
										
								<div class="help-block form-text with-errors form-control-feedback" id="member_id" ></div>			
								</div>
							</div>
						
						
								<div class="panel panel-default" id="Member_details" >
								 <legend><span>Member Details</span></legend>
									<div class="panel-body">
										<div class="form-group">
											<label for="">Member Name</label>
											<input type="text" name="mailtoone" id="mailtoone" class="form-control" readonly />	
										</div>
										
										<div class="form-group">
											<label for="">Member Email ID</label>
											<input type="text" id="member_email" class="form-control" readonly />	
										</div>
										
										<div class="form-group">
											<label for="">Member Phone No.</label>
											<input type="text" name="mailtoone_phnno" id="mailtoone_phnno" class="form-control"  readonly />	
										</div>
										
										<div class="form-group">
											<input type="hidden" name="Enrollment_id" id="MemberEnrollmentId" value=""/>
										</div>
									</div>
								</div>
								
						<!--
							<div class="panel-body">
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Enter Member Name</label>
									<input type="text" name="mailtoone" id="mailtoone" class="form-control" placeholder="Start typing Customer Name" autocomplete="off"/>
								</div>
								
								<div class="form-group">
									<label for="">Phone Number</label>
									<input type="text" name="mailtoone_phnno" id="mailtoone_phnno" class="form-control" readonly/>
								</div>
								
								<div class="form-group">
									<label for="">Membership ID</label>
									<input type="text" name="mailtoone_memberid" id="mailtoone_memberid" class="form-control" readonly/>
								</div>
								
								
							</div>
							-->
						</div>
						
						<div class="panel panel-default" id="send_to_all">
							<legend><span>Send to All Members</span></legend>
							<div class="panel-body">
								<div class="form-group">								
									<select class="form-control" name="mailtoall">
										<option value="0">All Members</option>
									</select>								
								</div>							
							</div>
						</div>
						
						<div class="panel panel-default" id="send_to_key">
							<legend><span>Send to Key Members</span></legend>
							<div class="panel-body">
								<div class="form-group">								
									<select class="form-control" name="mailtokey" id="mailtokey">
										<option value="">Purchase more than</option>
										<option value="1">2 times in last 3 months</option>
										<option value="2">3 times in last 3 months</option>
										<option value="3">5 times in last 3 months</option>
									</select>								
								</div>
							</div>
						</div>
						
						<div class="panel panel-default" id="send_to_worry">
							<legend><span>Send to Worry Members</span></legend>
							<div class="panel-body">
								<div class="form-group">								
									<select class="form-control" name="mailtoworry" id="mailtoworry">
										<option value="">No Purchase in</option>
										<option value="1">last 1 month</option>
										<option value="2">last 2 months</option>
										<option value="3">last 3 months</option>
									</select>							
								</div>
							</div>
						</div>
						
						<div class="panel panel-default" id="key_worry_customers">
							<div class="panel-heading"><label for="" id="key_wory_heading">Key / Worry Members</label></div>
							<div class="panel-body">
								<div class="form-group">								
									<select multiple class="form-control" name="key_worry_cust[]" id="KeyWorryCust">
										<option value="">Key / Worry Members</option>
									</select>								
								</div>
							</div>
						</div>
							<div class="panel panel-default" id="Segment_block" style="display:none;">
							<legend><span>Select Segment</span></legend>
							<div class="panel-body">
								<div class="form-group">								
									<select class="form-control" name="Segment_code" id="Segment_code">
										<option value="">Select Segment</option>

										<?php										
										foreach($Segments_list as $Segments)
										{
											echo '<option value="'.$Segments->Segment_code.'">'.$Segments->Segment_name.'</option>';
										}
										?>
									</select>								
								</div>							
							</div>
						</div>
						<div class="panel panel-default" id="send_to_tier">
							<legend><span>Select Tier</span></legend>
							<div class="panel-body">
								<div class="form-group">								
									<select class="form-control" name="mailtotier" id="mailtotier">
										<option value="">Select Tier</option>

										<?php										
										foreach($Tier_list as $Tier)
										{
											echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
										}
										?>
									</select>								
								</div>							
							</div>
						</div>
						
						<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Submit</button>								
														
						<button type="submit" name="submit" value="Send" id="Send" class="btn btn-primary">Send</button>								
						<button type="reset" class="btn btn-primary">Reset</button>
						
						<input type="hidden" name="Company_id" value="<?php echo $Company_id; ?>"/>
					
			</div>	
					
			<div class="col-sm-6">
						<div class="panel panel-info">
							<div class="panel-heading text-center">SMS Preview</div>
							
							<div class="panel-body">
								
								<div class="table-responsive">
									<table class="table">
									
										<tr>
											<td style="border: medium none;">
												<img class="fix" src="<?php echo base_url()?>images/comm.jpg" width="100%" border="0" alt="" />
											</td>
										</tr>
										
										
										<tr>
											<td style="border: medium none;color: #153643; font-family: Tahoma;font-size: 12px; line-height: 22px;" id="Offer_description"></td>
										</tr>
									
									</table>
								</div>
							</div>						
						</div>						
					</div>			
				  
				  
				  
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>

<div id="Survey_model" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 90%;margin-top:18%;" id="Survey_details">

		</div>
	</div>
	<!-- Modal -->
	
	<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			 SMS Communication
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							
							<th>Action</th>
							<th>Merchant Name</th>
							<th>Communication Name</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>SMS Contents</th>
							<th>Status</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				$todays = date("Y-m-d");
				
				if($results != NULL)
				{
					foreach($results as $row)
					{
						if( ($todays >= $row->From_date) && ($todays <= $row->Till_date) )
						{
							$class = 'style="color:#00b300;"';
						}
						else
						{
							$class = "";
						}
						
						$offer_description = substr($row->description, 0, 255);
					?>
						<tr>
							
							<td   class="row-actions">
								<a href="<?php echo base_url()?>index.php/Administration/edit_communication_offer/?id=<?php echo $row->id;?>&seller_id=<?php echo $row->seller_id;?>&SMS" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
								<a href="javascript:void(0);"  class="danger" onclick="delete_me('<?php echo $row->id;?>','<?php echo $row->communication_plan;?>','','Administration/delete_communication_offer/?path=Administration/SMS_communication&id');" title="Delete" data-target="#deleteModal" data-toggle="modal" >
									<i class="os-icon os-icon-ui-15"></i>
								</a> 
																
							</td>
							<td class="text-center"><?php echo $row->First_name." ".$row->Last_name; ?></td>
							<td><?php echo $row->communication_plan; ?></td>
							<td <?php echo $class; ?>><?php echo $row->From_date; ?></td>
							<td <?php echo $class; ?>><?php echo $row->Till_date; ?></td>
							<td><?php echo $offer_description; ?></td>
							<td class="text-center">
								<a href="<?php echo base_url()?>index.php/Administration/communication_acivate_deactivate/?id=<?php echo $row->id;?>&seller_id=<?php echo $row->seller_id;?>&activate=<?php echo $row->activate;?>&SMS" title="Active/Inactive">
									<?php if($row->activate == "yes"){ ?>
										<span class="btn btn-success btn-sm" >Active</span>
									<?php } else { ?>
										<span class="btn btn-danger btn-sm" >Inactive</span>
									<?php } ?>
								</a>								
							</td>
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


<!-- Modal -->
<div id="ImageModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 40%;">

	<!-- Modal content-->
		<div class="modal-content">
			<form id="uploadForm" name='upload' action="" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title text-center">Upload Image</h4>
				</div>
				<div class="modal-body">
					<div class="panel panel-default">				
						<div class="panel-body" id="Upload_offer_image">
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Select Image to Upload</label>
								<input type="file" name="file" />								
							</div>
							
							<span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="Upload" class="btn btn-primary">Upload</button>
					<button type="button" id="close_modal4" class="btn btn-primary">Close</button>
				</div>
			</form>
		</div>

	</div>
</div>
<!-- Modal -->

<script>
$('#offerdetails1').keyup(function()
{
	var htmlContent=$('#offerdetails1').val();
	
	$('#Offer_description').html(htmlContent);
})
$('#Register').click(function()
{
          
	if( ($('input[name=r1]:checked').val() == 1) )
		{
			//var htmlContent = tinyMCE.activeEditor.getContent();

			var htmlContent = tinyMCE.get('offerdetails1').getContent();
			var ContentLength = htmlContent.length;
			
			if( $('#offer_name').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "")
			{
				if(ContentLength == 0)
				{
					var Title1 = "Application Information";
					var msg1 = 'Please Enter Offer Details!.';
					runjs(Title1,msg1);
					return false;
				}
				else
				{
					show_loader();
				
					return true;
				}
				
			}
			
		}
		else if( ($('input[name=r1]').is(":checked") == false) )
		{
			var msg1 = 'Please Select Atleast One Option';
			document.getElementById("comm_type").innerHTML=msg1;
			return false;
		}
});

$('#Send').click(function()
{
	if( $('#companyId').val() != "" && $('#sellerId').val() != "" )
	{
		var r1Value = $('input[name=r1]:checked').val();
		if(r1Value == 2)
		{
			if( $('#activeoffer').val() != "" )
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

/******************************Show Hide*********************************/
	$('#r1').click(function()
	{
		$( "#create_new_offer" ).show();
		$( "#send_exist_offer" ).hide();
		$( "#send_communication_to" ).hide();
		$( "#Send" ).hide();
		$( "#Register" ).show();
		$( "#key_worry_customers" ).hide();
		$("#offer_name").attr("required","required");
		
		$("#datepicker1").attr("required","required");
		$("#datepicker2").attr("required","required");
		//$("#offerdetails1").attr("required","required");
		$("#activeoffer").removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$("#mailtoone").removeAttr("required");
		$( "#send_to_tier" ).hide();
		// $("#r1").attr("required","required");
		// $("#r2").removeAttr("required");
		// $("#r3").removeAttr("required");
		$( "#send_to_single" ).hide();
		// $( "#multiple_social" ).hide();
				$("#Segment_block").hide();
	});

	$('#r2').click(function()
	{
		$( "#send_exist_offer" ).show();
		$( "#send_communication_to" ).show();
		$( "#Send" ).show();
		$( "#create_new_offer" ).hide();
		$( "#Register" ).hide();
		$( "#key_worry_customers" ).hide();
		$("#offer_name").removeAttr("required");
		
		$("#datepicker1").removeAttr("required");
		$("#datepicker2").removeAttr("required");
		$("#offerdetails1").removeAttr("required");
		$("#activeoffer").attr("required","required");
		$( "#send_to_tier" ).hide();
		// $("#r1").removeAttr("required");
		// $("#r2").removeAttr("required");
		// $("#r3").attr("required","required");
		// $("#r21").attr("required","required");
		$("#KeyWorryCust").removeAttr("required");
		// $( "#multiple_social" ).hide();
				$("#Segment_block").hide();
	});
	
	$('#r3').click(function()
	{
		$( "#send_exist_offer" ).hide();
		$( "#send_communication_to" ).show();
		$( "#Send" ).show();
		$( "#create_new_offer" ).hide();
		$( "#Register" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#hobbie" ).hide();
		$("#offer_name").removeAttr("required");
		
		$("#datepicker1").removeAttr("required");
		$("#datepicker2").removeAttr("required");
		$("#offerdetails1").removeAttr("required");
		$("#activeoffer").removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		// $( "#multiple_social" ).show();
		// $("#r1").attr("required","required");
		// $("#r2").removeAttr("required");
		// $("#r3").removeAttr("required");
		// $("#r21").attr("required","required");
		$( "#send_to_tier" ).hide();
				$("#Segment_block").hide();
		var Seller_id = $("#sellerId").val();
		if(Seller_id == "")
		{
			var Title = "Application Information";
			var msg = 'Please Select Merchant First';
			runjs(Title,msg);
		}
		else
		{
			$.ajax({
				type: "POST",
				data: {Seller_id: Seller_id,Comm_type:1},
				url: "<?php echo base_url()?>index.php/Administration/show_multiple_offers",
				success: function(data)
				{
					$("#show_multiple_offer").html(data.multipleOfferHtml);	
					$('#myModal1').show();
					$("#myModal1").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
				}
			});
		}
	});

	$('#r21').click(function()
	{
		$( "#send_to_single" ).show();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();	
		$( "#key_worry_customers" ).hide();
		
		$( "#mailtoone_memberid" ).attr("required","required");
		$( "#mailtoone" ).attr("required","required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r22').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).show();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r23').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).show();
		$( "#send_to_worry" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).attr("required","required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$( "#key_worry_customers" ).show();
		$("#KeyWorryCust").attr("required","required");
		$('#key_wory_heading').html("Key Members");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r24').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).show();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtoworry" ).attr("required","required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#key_worry_customers" ).show();
		$("#KeyWorryCust").attr("required","required");
		$('#key_wory_heading').html("Worry Members");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r25').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$("#Segment_code").removeAttr("required");
		$( "#send_to_tier" ).show();
		$("#mailtotier").attr("required","required");
				$("#Segment_block").hide();
	});
	
	$('#r26').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
		$("#Segment_block").hide();
	});
	
	$('#r27').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$("#send_to_tier").hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").attr("required","required");
		$("#Segment_block").show();
	});
	
/******************************Show Hide*********************************/


$(document).ready(function() 
{	
	$( "#create_new_offer" ).hide();
	$( "#send_exist_offer" ).hide();
	$( "#send_communication_to" ).hide();
	$( "#send_to_single" ).hide();
	$( "#send_to_all" ).hide();
	$( "#send_to_key" ).hide();
	$( "#send_to_worry" ).hide();
	$( "#send_to_tier" ).hide();
	$( "#key_worry_customers" ).hide();
	$( "#Send" ).hide();
	$("#mailtoone_phnno").val("");
	$("#mailtoone_memberid").val("");
	
	$( "#close_modal" ).click(function(e)
	{
		 var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });

		if(val == "")
		{
			var Title = "Application Information";
			var msg = 'Please Select at least one Communication Offer';
			runjs(Title,msg);
			return false;
		}
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal12" ).click(function(e)
	{
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal3" ).click(function(e)
	{
		$('#ImageModal').hide();
		$("#ImageModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal4" ).click(function(e)
	{
		$('.mce-window').css("z-index","65536");
                $('#ImageModal').hide();
                $("#ImageModal").removeClass( "in" );
                $('.modal-backdrop').remove();
	});
	
	$('#offer_name').blur(function()
	{
		
		var Sender_length=$("#offer_name").val().length;
		
		if( $("#sellerId").val() != "")
		{
			if($("#offer_name").val() == "")
			{
				$("#offer_name").val("");
				$("#offer_name2").html("Please Enter Sender Name");
			}
			else if(Sender_length!=6)
			{
				$("#offer_name").val("");
				$("#offer_name2").html("Please Enter Sender Name only 6 characters");
			}
			else
			{
				
				
				var communication_plan = $("#offer_name").val();
				var Seller_id = $("#sellerId").val();
				$.ajax({
					type: "POST",
					data: {communication_plan: communication_plan, Seller_id: Seller_id},
					url: "<?php echo base_url()?>index.php/Administration/check_communication_offer",
					success: function(data)
					{
						
						if(data == 0)
						{
							$("#offer_name").val("");
							$("#offer_name2").html("Already Exist");
						}
						else
						{
							$("#offer_name2").html("");
						}
						
					}
				});
			}
		}
		else
		{
			$("#offer_name").val("");
			$("#offer_name2").html("Please Select Merchant First!!");
		}
	});
	
	$('#sellerId').change(function()
	{
		var sellerID = $("#sellerId").val();
		$.ajax({
			type:"POST",
			data:{Seller_id:sellerID,Comm_type:1, Company_id:'<?php echo $Company_id; ?>'},
			url: "<?php echo base_url()?>index.php/Administration/get_communication_offers",
			success: function(data)
			{
				$('#activeoffer').html(data);
			}				
		});
	});
	
	$('#activeoffer').change(function()
	{
		var offerid = $("#activeoffer").val();
		$.ajax({
			type:"POST",
			data:{offerid:offerid},
			dataType: "json",
			url: "<?php echo base_url()?>index.php/Administration/get_offer_details",
			success: function(json)
			{
				// $('#offerdetails').val(data);
				$('#offerdetails').html(json['offer_description']);
				$('#Offer_description').html(json['offer_description']);
				tinyMCE.get('offerdetails').setContent(json['offer_description']);
				tinymce.activeEditor.getBody().setAttribute('contenteditable', false);
				
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				$('input[name=offerdetails]').val(htmlContent);
				var count_contents=$("#offerdetails1").val().length;
				
				var text = $(htmlContent).text();
				// alert("text "+text);
				// alert("count_contents "+text.length);
				var chars=text.length;
				//alert(chars);
				 sms_count2(chars);
		
				if((json['offer_hobbie_id']) > 0)
				{
					$("#hobbie").show();
				}
				else
				{
					$("#hobbie").hide();
				}
			}				
		});
	});
	
	/*********************************Autocomplete***************************************/
		$("#mailtoone").autocomplete({
			source: "<?php echo base_url()?>index.php/Administration/autocomplete_customer_names" // path to the get_birds method
		});
	/*********************************Autocomplete***************************************/
	/*
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
				url: "<?php echo base_url()?>index.php/Administration/get_phnno_memberid",
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
	});*/
	
	$('#mailtokey').change(function()
	{
		var mailtokey = $("#mailtokey").val();
		var Seller_id = $("#sellerId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var r2Value = $('input[name=r2]:checked').val();
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id, Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey},
			url: "<?php echo base_url()?>index.php/Administration/get_key_worry_customers",
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
		var Seller_id = $("#sellerId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var r2Value = $('input[name=r2]:checked').val();
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id, Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey},
			url: "<?php echo base_url()?>index.php/Administration/get_key_worry_customers",
			success: function(data)
			{
				$('#KeyWorryCust').html(data.get_key_worry_customers);
				$('#key_wory_heading').html("Worry Members");
			}				
		});
	});
	
});


$('#mailtoone_memberid').blur(function()
	{
		if( $("#mailtoone_memberid").val() == "" || $("#mailtoone_memberid").val() == 0 )
		{
			$('#mailtoone_memberid').val('');
			// has_error(".has-feedback","#glyphicon1",".help-block1","Please Enter Membership Card ID..!!");
			//has_error("#block1","#glyphicon1","#Membership_help","Please Enter Membership Card ID..!!");
			
			$("#member_id").html("Please Enter Membership Card ID");
			$("#mailtoone").val("");
			$("#member_email").val("");
			$("#mailtoone_phnno").val("");
			$("#MemberEnrollmentId").val("");
		}
		else
		{
			var cardId = $("#mailtoone_memberid").val();
			var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				  type: "POST",
				  data: {cardid: cardId, Company_id: Company_id},
				  dataType: "json",
				  url: "<?php echo base_url()?>index.php/Transactionc/validate_card_id",
				  success: function(json)
				  {
						if(json['Card_id'] == 0)
						{
							$('#mailtoone_memberid').val('');
							// has_error(".has-feedback","#glyphicon1",".help-block1","Invalid Membership Card ID!");	
							//has_error("#block1","#glyphicon1","#Membership_help","Invalid Membership Card ID..!!");
							$("#member_id").html("Invalid Membership Card ID");
							$("#mailtoone").val("");
							$("#member_email").val("");
							$("#mailtoone_phnno").val("");
							$("#MemberEnrollmentId").val("");
						}
						else
						{
							// has_success(".has-feedback","#glyphicon1",".help-block1",data);	
							//has_success("#block1","#glyphicon1","#Membership_help"," ");
							$("#member_id").html("");
							var Member_name = json['First_name']+" "+json['Last_name'];
							var Member_email = json['User_email_id'];
							var Member_phn = json['Phone_no'];
							var Member_Enrollement_id = json['Enrollement_id'];
							
							$("#mailtoone").val(Member_name);
							$("#member_email").val(Member_email);
							$("#mailtoone_phnno").val(Member_phn);
							$("#MemberEnrollmentId").val(Member_Enrollement_id);
						}
				  }
			});
		}
	});	
	
/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
});
/******calender *********/


function delete_communication_offer(offer_id,seller_id,offerName)
{	
	BootstrapDialog.confirm("Are you sure to Delete the Offer - '"+offerName+"' ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_communication_offer/?path=2&id='+offer_id+'/?path=2&seller_id='+seller_id;
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

</script>
