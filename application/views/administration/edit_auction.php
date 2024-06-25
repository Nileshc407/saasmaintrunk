<?php $this->load->view('header/header'); 
$_SESSION["Edit_Auction_id"]=$results->Auction_id; ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   EDIT AUCTION
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
				echo form_open_multipart('Administration/update_auction',$attributes); ?>	
				<div class="row">
					<div class="col-sm-6">
				  
						<div class="form-group">
							<label for=""><span class="required_info">*</span> Auction Name</label>
							<input type="text" name="auction_name" id="auction_name" class="form-control" onkeypress="return isAlphanumeric(event)" placeholder="Enter Auction Name" required="required"  data-error="Please Enter Auction Name"  value="<?php echo $results->Auction_name; ?>" />
							
							<div class="help-block form-text with-errors form-control-feedback" id="auction_name2" ></div>
						</div>
						
						<div class="form-group">
							<label for=""><span class="required_info">*</span> Auction Prize</label>
							<input type="text" name="prize" id="prize" class="form-control" placeholder="Enter Auction Prize" required="required"  data-error="Please Enter Auction Prize"  value="<?php echo $results->Prize; ?>" />
							<div class="help-block form-text with-errors form-control-feedback"  ></div>
						</div>
						
						<div class="form-group">
							<label for=""><span class="required_info">*</span> Minimum <?php echo $Company_details->Currency_name; ?> To Bid</label>
							<input type="text" name="minpointstobid" id="minpointstobid" value="<?php echo $results->Min_bid_value; ?>"  class="form-control" placeholder="Enter Minimum <?php echo $Company_details->Currency_name; ?> To Bid" required="required"   data-error="Please Enter Minimum <?php echo $Company_details->Currency_name; ?> To Bid"  onkeyup="this.value=this.value.replace(/\D/g,'')" />
							
							<div class="help-block form-text with-errors form-control-feedback"  ></div>
						</div>
						
						<div class="form-group">
							<label for=""><span class="required_info">*</span> Minimum Increment</label>
							<input type="text" name="minincrement" id="minincrement" value="<?php echo $results->Min_increment; ?>"  class="form-control" placeholder="Enter Minimum Increment" required="required"  onkeyup="this.value=this.value.replace(/\D/g,'')"   data-error="Please Enter Minimum Increment" />
							<div class="help-block form-text with-errors form-control-feedback"  ></div>
						</div>
						
						<div class="form-group">
							<label for="">Prize Description</label>
							<textarea class="form-control" rows="3" name="description" placeholder="Prize Description"><?php echo $results->Prize_description; ?></textarea>
						</div>
						<div class="form-group">
								<label for="">Prize Image <span class="required_info">( You can upload upto maximum 500kb)</span> </label>
								<br>
								<div class="upload-btn-wrapper">
								<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
								<input type="file" name="file" id="file" onchange="readURL(this);"/>
								</div>
								
								<img id="blah" src="<?php echo base_url().$results->Prize_image; ?>" class="img-responsive left-block"  width="25%" />
								<!--
								<br><br>
								<div class="thumbnail" id="profile_pic" >
								<img src="<?php echo base_url().$results->Prize_image; ?>" id="image1" class="img-responsive" width="25%">
								</div>-->
						</div>
					</div>
					
					<div class="col-sm-6">
						  <div class="form-group">
							<label for="">
								<span class="required_info" style="color:red;">*</span> Valid From <span class="required_info" style="color:red;">(click inside textbox)</span>
							</label>
							<div class="input-group">
								<input type="text" name="startDate" id="datepicker1" value="<?php echo date("m/d/Y", strtotime($results->From_date)); ?>"  class="single-daterange form-control"required="required" />			
								<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
							</div>
						</div>
						
						<div class="form-group">
							<label for="">
								<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" style="color:red;">(click inside textbox)</span>
							</label>
							<div class="input-group">
								<input type="text" name="endDate" id="datepicker2" class="single-daterange form-control"  required="required"  value="<?php echo date("m/d/Y", strtotime($results->To_date)); ?>" />			
								<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
							</div>
						</div>
						<div class="form-group">
							<label for=""><span class="required_info">*</span>Reminder Trigger Notification Days After Validity Starts</label>
							<input type="text" name="Trigger_notification_start_days" id="Trigger_notification_start_days" class="form-control" placeholder="Enter Trigger Notification Days After Validity Starts"  required="required"  onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="check_validity(this.value,'Start_days');"  data-error="Please Enter Trigger Notification Days After Validity Starts"  value="<?php echo $results->Trigger_notification_start_days; ?>" />
							<div class="help-block form-text with-errors form-control-feedback"  ></div>
						</div>
							
						<div class="form-group">
							<label for=""><span class="required_info">*</span>Reminder Trigger Notification Days After Validity Ends</label>
							<input type="text" name="Trigger_notification_end_days" id="Trigger_notification_end_days" class="form-control" placeholder="Enter Trigger Notification Days After Validity Ends"  required="required"  onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="check_validity(this.value,'End_days');"  data-error="Please Enter Trigger Notification Days After Validity Ends" value="<?php echo $results->Trigger_notification_end_days; ?>"  />
							<div class="help-block form-text with-errors form-control-feedback"  ></div>
						</div>
						
						
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Auction Close Time</label>
						<div class="row">
							<div class="col-md-6 text-center" style="margin: 10px auto;">
								<label for="exampleInputEmail1">Hour</label>
								<select class="form-control" name="THH" id="THH" required >
									<option value="">HH</option>
									<?php
									$End_time = explode(":", $results->End_time);
									for($i=0;$i<=23;$i++)
									{
									?>
										<option value="<?php echo $i; ?>" <?php if($End_time[0] == $i){echo "selected='selected'";} ?> ><?php echo $i; ?></option>';
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-md-6 text-center" style="margin: 10px auto;">
								<label for="">Minutes</label>
								<select class="form-control" name="TMM" id="TMM" required >
									<option value="">MM</option>
									<?php
									for($i=0;$i<=59;$i++)
									{
									?>
										<option value="<?php echo $i; ?>" <?php if($End_time[1] == $i){echo "selected='selected'";} ?> ><?php echo $i; ?></option>';
									<?php
									}
									?>
								</select>
							</div>
						</div>
					</div>
					
						
							
						
						
						
						
					
					</div>
					
				</div>	
					
					
				  
				  
				  <div class="form-buttons-w"  align="center">
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
					<input type="hidden" name="Auction_image" value="<?php echo $results->Prize_image; ?>" />
					
				  </div>
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>


	<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			  Auction
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Auction name</th>
							<th class="text-center">Prize</th>
							<th class="text-center">Min bid value</th>
							<th class="text-center">Min Increment</th>
							<th class="text-center">Auction Start Date</th>
							<th class="text-center">Auction End Date</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				$todays = date("Y-m-d");
				if($results2 != NULL)
				{
					foreach($results2 as $row)
					{
						if( ($todays >= $row->From_date) && ($todays <= $row->To_date) )
						{
							$class = 'style="color:#00b300;"';
						}
						else
						{
							$class = "";
						}
						$Encrypt_Auction_id = App_string_encrypt($row->Auction_id);
						$Encrypt_Auction_id = str_replace('+', 'X', $Encrypt_Auction_id);
						$_SESSION[$Encrypt_Auction_id]=$row->Auction_id;
					?>
						<tr>
							<td class="row-actions">
								<a href="<?php echo base_url()?>index.php/Administration/edit_auction/?ktvxuctjiqonicd=<?php echo $Encrypt_Auction_id;?>" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
								<?php  if($_SESSION['Edit_Privileges_Delete_flag']==1){ ?>
								<?php /* <?php echo base_url()?>index.php/Administration/delete_auction/?Auction_id=<?php echo $row->Auction_id;?>*/ ?>
								<a href="javascript:void(0);" class="danger"  onclick="delete_me('<?php echo $row->Auction_id;?>','<?php echo $row->Auction_name; ?>','','Administration/delete_auction/?Auction_id');"  title="Delete"  data-target="#deleteModal" data-toggle="modal" >
									<i class="os-icon os-icon-ui-15"></i>
								</a>	
								<?php } ?>								
							</td>
							<td class="text-center"><?php echo $row->Auction_name; ?></td>
							<td class="text-center"><?php echo $row->Prize; ?></td>
							<td class="text-center"><?php echo $row->Min_bid_value; ?></td>
							<td class="text-center"><?php echo $row->Min_increment; ?></td>
							<td <?php echo $class; ?>><?php echo date('Y-m-d',strtotime($row->From_date)); ?></td>
							<td <?php echo $class; ?>><?php echo date('Y-m-d',strtotime($row->To_date)); ?></td>
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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/redmond/jquery-ui.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">
$('#Register').click(function()
{
	var Trigger_notification_start_days=$('#Trigger_notification_start_days').val();
	var Trigger_notification_end_days=$('#Trigger_notification_end_days').val();
	check_validity(Trigger_notification_start_days);
	check_validity(Trigger_notification_end_days);
	if( $('#datepicker').val() != "" && $('#datepicker2').val() != "" && $('#THH').val() != "" && $('#TMM').val() != "" && $('#auction_name').val() != "" && $('#prize').val() != "" && $('#minpointstobid').val() != "" && $('#minincrement').val() != "" && $('#auction_image').val() != "" && Trigger_notification_start_days != ""  && Trigger_notification_end_days != "" )
	{
		show_loader();
	}
});

function check_validity(days,fordays)
{
	var From_date=$('#datepicker').val();
	var Till_date=$('#datepicker2').val();
	// alert('days '+days);
	 From_date = new Date(From_date);
	 Till_date = new Date(Till_date);
	var timeDiff = Till_date.getTime() - From_date.getTime();
	var DaysDiff = timeDiff / (1000 * 3600 * 24);
	
	// alert('From_date '+From_date);
	// alert('Till_date '+Till_date);
	// alert('DaysDiff '+DaysDiff);
	if(days > DaysDiff)
	{
		if(fordays=='Start_days')
		{
			$('#Trigger_notification_start_days').val('');
		}
		if(fordays=='End_days')
		{
			$('#Trigger_notification_end_days').val('');
		}
		
		var Title = "Application Information";
		var msg = 'Please Enter Days less than Auction Validity Days('+DaysDiff+')';
		runjs(Title,msg);
		return false;
	}
}

/* $(function() 
{
	$( "#datepicker" ).datepicker({
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
 */
 
 $("#datepicker1").datepicker({
  minDate: 0,
  onSelect: function(date) {
    $("#datepicker2").datepicker('option', 'minDate', date);
  }
});
$("#datepicker2").datepicker({});

$('#auction_name').blur(function()
{	
	var Company_id = '<?php echo $Company_id; ?>';
	var Auction_name = $('#auction_name').val();
	
	if( $("#auction_name").val() == "" )
	{
		// has_error(".has-feedback","#glyphicon",".help-block","Please Enter Valid Auction Name..!!");
		$("#auction_name2").html("Please Enter Valid Auction Name");
	}
	else
	{
		$.ajax({
			type: "POST",
			data: {Auction_name: Auction_name, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Administration/check_auction_name",
			success: function(data)
			{
				if(data == 0)
				{
					$("#auction_name").val("");
					$("#auction_name2").html("Already exist");
						$("#auction_name").addClass("form-control has-error");
					//has_error(".has-feedback","#glyphicon",".help-block","Auction Name not Available..!!");
				}
				else
				{
					// has_success(".has-feedback","#glyphicon",".help-block",data);
					$("#auction_name2").html("");
					$("#auction_name").removeClass("has-error");
				}
			}
		});
	}
});

function delete_auction(Auction_id,Auction_name)
{	
	BootstrapDialog.confirm("Are you sure to Delete the Auction "+Auction_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_auction/?Auction_id='+Auction_id;
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
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
function readImage(input,div_id) 
{
	document.getElementById('profile_pic').style.display="";
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
