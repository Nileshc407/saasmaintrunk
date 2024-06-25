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
						
						foreach($Offer_details as $offer)
						{
							$communication_id = $offer->id;
							$communication_plan = $offer->communication_plan;
							$communication_seller_id = $offer->seller_id;
							$Hobbie_id = $offer->Hobbie_id;
							$Link_to_lbs = $offer->Link_to_lbs;
							$communication_description = $offer->description;
							$From_date = date("m/d/Y",strtotime($offer->From_date));
							$Till_date = date("m/d/Y",strtotime($offer->Till_date));
						}
						
						
						?>
						
						
						
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('Administration/update_communication',$attributes); ?>	
				
				<div class="row">
			<div class="col-sm-8">
				 <div class="form-group">
							<label for=""><span class="required_info">*</span> Company Name</label>
								<select class="form-control" name="companyId" id="companyId" required >
									<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
								</select>									
						</div>						
						<div class="form-group">
							<label for=""><span class="required_info">*</span> Merchant Name</label>
								<select class="form-control" name="sellerId" id="sellerId" required>
								<?php
								if($Logged_user_id > 2 || $Super_seller == 1)
								{
									echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';								
								}
								foreach($company_sellers as $sellers)
								{
									if($communication_seller_id == $sellers->Enrollement_id)
									{
									?>
										<option selected value="<?php echo $sellers->Enrollement_id; ?>"><?php echo $sellers->First_name." ".$sellers->Last_name; ?></option>
									<?php
									}
									/*else
									{
										?>
										<option value="<?php echo $sellers->Enrollement_id; ?>"><?php echo $sellers->First_name." ".$sellers->Last_name; ?></option>
										<?php
									}*/
								}
								?>
								</select>
						</div>
						
						<div class="form-group">
							<div class="form-check" >
								<label class="form-check-label">
									<input type="radio" class="form-check-input" checked  name="r1" id="r1" value="1" >Create New SMS
								</label>
							</div> 
							
							<div class="form-check" >
								<label class="form-check-label">						
									<input type="radio" class="form-check-input" disabled  name="r1" id="r2" value="2" >Send Existing SMS
								</label>
							</div> 
							
							<div class="form-check" >
								<label class="form-check-label">
									<input type="radio" class="form-check-input" disabled name="r1" id="r3" value="3" >Send Multiple SMS 
								</label>
							</div> 
							
						</div>
						
						<div class="form-group">
							<legend><span>Create New SMS</span></legend>
							
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Sender Name</label>
									<span class="required_info"> (6 characters only & Space not allowed)</span>
									<input type="text" name="offer" id="offer_name" value="<?php echo $communication_plan; ?>"  class="form-control" placeholder="Enter Sender Name" maxlength="6"  onkeyup="this.value=this.value.replace(/[0-9\.]+/g, '')"  onkeypress="this.value=this.value.replace(/ /g, '')"  data-error="Please Enter Sender Name" />
									<div class="help-block form-text with-errors form-control-feedback" id="offer_name2" ></div>									
								</div>
								
							<div class="form-group">
								<label for="">SMS Related to</label>
								<select class="form-control"  name="Offer_related_to" id="Offer_related_to">
									<option value="">Select Hobbies/Interest</option>
								<?php
								
									foreach($Hobbies_list as $hob)
									{
										if($Hobbie_id == $hob->Id)
										{
											echo "<option selected value=".$hob->Id.">".$hob->Hobbies."</option>";
										}
										else
										{
											echo "<option value=".$hob->Id.">".$hob->Hobbies."</option>";
										}
									}
								?>		
									
									
								</select>								
							</div>
					
								<div class="form-group">
									<label for="">
										<span class="required_info">*</span> Valid From <span class="required_info">(* click inside textbox)</span>
									</label>
									<div class="input-group">
										<input type="text" name="start_date" id="datepicker1" class="form-control" placeholder="Communication Start Date"  value="<?php echo $From_date; ?>" />			
										<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
									</div>
								</div>
								
								<div class="form-group">
									<label for="">
										<span class="required_info">*</span> Valid Till <span class="required_info">(* click inside textbox)</span>
									</label>
									<div class="input-group">
										<input type="text" name="end_date" id="datepicker2" class="form-control" placeholder="Communication End Date"  value="<?php echo $Till_date; ?>" />			
										<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group">								
									<label for="">
										Link to LBS </label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<label class="form-check-label">
											<input type="radio" class="form-check-input"  name="Link_to_lbs" id="Link_to_lbs" value="1" <?php if($Link_to_lbs==1){echo "checked";} ?> >Yes								
										</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<label class="form-check-label">										
											<input type="radio" class="form-check-input"  name="Link_to_lbs" id="Link_to_lbs"  value="0" <?php if($Link_to_lbs==0){echo "checked";} ?> >No									
										</label>
											
								</div>
								
								<div class="form-group">
									<label for=""><span class="required_info">*</span> SMS Contents</label>
									<textarea class="form-control" rows="4" name="offerdetails" id="offerdetails1" style="visibility:visible" value="" onkeypress="sms_count(this.value);"><?php echo $communication_description; ?></textarea>
									<p><span id="remaining" class="required_info">160 characters</span>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="messages" class="required_info">1 message(s)</span></p>
								</div>
							
						</div>
						
						
						<!-- Modal -->
					
						
						<input type="hidden" name="communication_id" value="<?php echo $communication_id; ?>" >
						<input type="hidden" name="Comm_type" value="1" >
						<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Update</button>										
					
						<input type="hidden" name="Company_id" value="<?php echo $Company_details->Company_id; ?>"/>
					
					
			</div>	
			<!--		
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
				  -->
				  
				  
				  
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
var sms_cont = document.getElementById("offerdetails1").value;
sms_count(sms_cont);
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
			var Title1 = "Application Information";
			var msg1 = 'Please Select Atleast One Option';
			runjs(Title1,msg1);
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
					var Title2 = "Application Information";
					var msg2 = 'Please Select Atleast One Option from Send Communication To';
					runjs(Title2,msg2);
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
				var Title3 = "Application Information";
				var msg3 = 'Please Select Atleast One Option from Send Communication To';
				runjs(Title3,msg3);
				return false;
			}
		}
	}
});

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
		var url = '<?php echo base_url()?>index.php/Administration/delete_communication_offer/?id='+offer_id+'&seller_id='+seller_id+'&url=2';
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
