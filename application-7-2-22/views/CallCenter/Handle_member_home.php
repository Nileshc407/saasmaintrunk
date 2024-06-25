<?php $this->load->view('header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('CallCenter_model');
$ci_object->load->model('Igain_model'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				MEMBER PROFILE -<?php echo $results->First_name.' '.$results->Last_name." (".$results->Card_id.")";?>
			  </h6>
			  	  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						 <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			<?php 		
					} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} ?>
			<?php 	$attributes = array('id' => 'formValidate');
					echo form_open_multipart('Call_center/edit_handle_member_home_update',$attributes); ?>
							<div class="os-tabs-w" style="width:100%;">
						<div class="os-tabs-controls os-tabs-complex">
						  <ul class="nav nav-tabs">
							<li class="nav-item" style="width:25%;">
							  <a aria-expanded="false" class="nav-link active"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_home"><span class="tab-label">Profile</span></a>
							</li>
							<li class="nav-item"  style="width:30%;">
							  <a aria-expanded="false" class="nav-link"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_transaction"><span class="tab-label">Transaction Details</span></a>
							</li>
							<li class="nav-item"  style="width:24%;">
							  <a aria-expanded="false" class="nav-link" href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_query_record"><span class="tab-label">Query Records</span></a>
							</li>
							<li class="nav-item"  >
							  <a aria-expanded="true" class="nav-link"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_log_query"><span class="tab-label">Log Query</span></a>
							</li>
						   
						  </ul>
						</div>
					</div>
			  <div class="element-box">
			  
					<div class="row">
			
								<div class="col-md-6">
									<div class="form-group">
										<label for="">First Name</label>
										<input type="text" name="firstName" id="firstName" value="<?php echo $results->First_name; ?>" class="form-control" placeholder="First Name" required />
									</div>

									<div class="form-group">
										<label for="">Middle Name</label>
										<input type="text" name="middleName" value="<?php echo $results->Middle_name; ?>" class="form-control" placeholder="Middle Name"/>
									</div>

									<div class="form-group">
										<label for="">Last Name</label>
										<input type="text" name="lastName" id="lastName" value="<?php echo $results->Last_name; ?>" class="form-control" placeholder="Last Name" required />
									</div>

									<div class="form-group">
										<label for="">Current Address</label>
										<textarea class="form-control" rows="4" id="currentAddress" name="currentAddress" ><?php echo App_string_decrypt($results->Current_address); ?></textarea>
									</div>

									<div class="form-group" >
										<label for="">Country</label>
										<select class="form-control" name="country" id="country_id" required onchange="Get_states(this.value);">
											<option value="<?php echo $results->Country; ?>" ><?php echo $results->country_name; ?></option>
										</select>
									</div>

									<div class="form-group" id="Show_States">
										<label for="">State</label>
										<select class="form-control" name="state" id="state" onchange="Get_cities(this.value);">
										<?php
											foreach($States_array as $rec)
											{?>
												<option value="<?php echo $rec->id;?>" <?php if($results->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
										<?php }
										?>
										</select>
									</div>

									<div class="form-group" id="Show_Cities">
										<label for="">City</label>
											<select class="form-control" name="city" id="city" >

											<?php
												foreach($City_array as $rec)
												{?>
													<option value="<?php echo $rec->id;?>" <?php if($results->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
												<?php }
											?>
										</select>
									</div>

									<div class="form-group">
										<label for="">District</label>
										<input type="text" name="district" id="district" value="<?php echo $results->District; ?>" class="form-control" placeholder="Enter District" />
									</div>

									<div class="form-group">
										<label for="">Zip/Postal Code/P.O Box</label>
										<input type="text" name="zip"  id="zip" value="<?php echo $results->Zipcode; ?>" class="form-control" placeholder="Enter Zip/Postal Code/P.O Box" />
									</div>

									<div class="form-group">
										<label for="">Total No. Of <?php if($Company_details->Coalition==1) { echo "Coalition"; } ?> <?php echo $Company_details->Currency_name; ?> </label>
										<input type="text" name="Current_balance" readonly value="<?php echo $results->Current_balance; ?>" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Membership ID</label>
										<input type="text" readonly name="membership_id" value="<?php echo $results->Card_id; ?>" class="form-control" placeholder="Enter Membership ID" />
									</div>
									<div class="form-group">
										<label for="">Date of Birth</label>
										<input type="text" name="dob"  id="datepicker" value="<?php echo date('m/d/Y',strtotime($results->Date_of_birth)); ?>" class="single-daterange form-control" placeholder="Enter Date of Birth"/>
									</div>
									<div class="form-group">
										<label for="">Anniversary Date</label>
										<input type="text" name="Wedding_annversary_date"  id="datepicker1" value="<?php echo $results->Wedding_annversary_date; ?>" class="form-control" placeholder="Enter Date of Birth"/>
									</div>
									<div class="form-group">
										<label for="">Sex(Male/Female)</label>
										<select class="form-control" name="sex">
											<option value="">Select Sex</option>
											<option value="Male" <?php if($results->Sex == "Male"){echo "selected";} ?>>Male</option>
											<option value="Female" <?php if($results->Sex == "Female"){echo "selected";} ?>>Female</option>
										</select>
									</div>
									<div class="form-group">
										<label for="">Profession</label>
										<input type="text" name="qualifi" value="<?php echo $results->Qualification; ?>" class="form-control" placeholder="Enter Profession"/>
									</div>
									<div class="form-group has-feedback">
										<label for="">Phone No.</label>
										<input type="text" name="phno" id="phno" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo App_string_decrypt($results->Phone_no); ?>" class="form-control" placeholder="Enter Phone No" required readonly/>
										<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>
										<div class="help-block" id="help-block"></div>
									</div>
									<div class="form-group has-feedback email_feedback">
										<label for="">User Email Address</label>
										<input type="email" name="userEmailId" id="userEmailId" value="<?php echo App_string_decrypt($results->User_email_id); ?>" class="form-control" placeholder="User Email address" required readonly/>

										<span class="glyphicon" id="glyphicon1" aria-hidden="true"></span>
										<div class="help-block" id="help-block1"></div>
									</div>
									<div class="form-group">
										<span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
											<label for="">Photograph</label><br>
										<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
										<input type="file" name="file" id="file" onchange="readURL(this);"/>
										</div>
										
										
										<?php if($results->Photograph == ""){ ?>
											<img id="blah" src="#" class="img-responsive left-block" style="display:none" />
										<?php } else { ?>
										
											<img id="blah" src="<?php echo base_url().$results->Photograph; ?>" class="img-responsive left-block" width="25%" />
										<?php } ?>
										
									</div>
									<div class="form-group">
										<label for="">Current Tier </label>
										<select class="form-control" name="member_tier_id"  id="member_tier_id"    onchange="get_baranches(this.value);">
											<?php
											
												foreach($Tier_list as $Tier)
												{
													
													if($results->Tier_id == $Tier->Tier_id)
													{
														echo '<option selected value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
													}
													/* else if($Super_seller == 1)
													{
														echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
													} */
												}
											?>
										</select>
									</div>

									<div class="form-group" id="Select_hobies">
										<label for="">Hobbies/Interest<span class="required_info"> ( Press 'CTRL' to select multiple options ) </span></label>
										<select multiple class="form-control select2"  name="hobbies[]">
										<option value="">Select Hobbies/Interest</option>
											<?php
												foreach($Hobbies_list as $hob)
												{
													if (in_array($hob->Id, $member_hobbies))
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
								</div>
					</div>
					<div class="form-buttons-w"  align="center">
					<input type="hidden" name="Enrollment_image" value="<?php echo $results->Photograph; ?>" class="form-control" />
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Update</button>
				 </div>
				</div>
			</div>
			
		  </div>
		</div>
		
		<?php
			$Current_balance=$results->Current_balance;
			$Blocked_points=$results->Blocked_points;
			$Debit_points=$results->Debit_points;

			$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);

			if($Current_point_balance<0)
			{
				$Current_point_balance=0;
			}
			else
			{
				$Current_point_balance=$Current_point_balance;
			}

			$total_gain_points=$total_gain_points->Total_gained_points;

			if($total_gain_points!='')
			{
				$TotalGainPoints=$total_gain_points;
			}
			else
			{
				$TotalGainPoints="0";
			}

			$Total_Transfer_points=$Total_transfer->Total_Transfer_points;

			if($Total_Transfer_points!='')
			{
				$Total_Transfer_points=$Total_transfer->Total_Transfer_points;
			}
			else
			{
				$Total_Transfer_points="0";
			}
			?>
<div class="element-wrapper">
  <div class="element-box">
<div class="table-responsive">
      <!--------------------
      START - Basic Table
      -------------------->
      <table class="table table-striped table-bordered">
      <thead>
          <tr>
            <th  colspan="2"></th>
            
            <th class="text-center" colspan="2">
              <u>Received Points</u>
            </th>
            <th class="text-center"  colspan="2">
             <u> Used Points</u>
            </th>
           
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              Available <?php if($Company_details->Coalition==1) { echo "Coalition"; } ?> <?php echo $Company_details->Currency_name; ?> Balance
            </td>
            <td>
             <?php echo $Current_point_balance; ?>
            </td>
            <td class="text-right">
              Issued <?php echo $Company_details->Currency_name; ?> 
            </td>
            <td class="text-right">
             <?php echo $TotalGainPoints; ?>
            </td>
            <td class="text-right">
             Redeemed <?php echo $Company_details->Currency_name; ?>
            </td>
            <td class="text-right">
             <?php echo $results->Total_reddems; ?>
            </td>
          </tr>
          <tr>
            <td>
             Total Purchase Amount
            </td>
            <td>
              <?php echo $Currency_Symbol.' '.number_format($results->total_purchase,2); ?>
            </td>
            <td class="text-right">
              Bonus <?php echo $Company_details->Currency_name; ?> 
            </td>
            <td class="text-right">
              <?php echo $results->Total_topup_amt; ?>
            </td>
            <td class="text-right">
              Transferred <?php echo $Company_details->Currency_name; ?> 
            </td>
			<td class="text-right">
             <?php echo $Total_Transfer_points;?>
            </td>
          </tr>
          <tr>
            <td>
             Total Received <?php if($Company_details->Coalition==1) { echo "Coalition"; } ?> <?php echo $Company_details->Currency_name; ?>
            </td>
            <td>
              <?php echo $results->Total_topup_amt+$TotalGainPoints; ?>
            </td>
            <td></td>
            <td></td>
            <td class="text-right">
              Blocked <?php echo $Company_details->Currency_name; ?> 
            </td>
            <td class="text-right">
              <?php echo round($results->Blocked_points);?>
            </td>
           
          </tr>
          <tr>
            <td>
              Total Used <?php if($Company_details->Coalition==1) { echo "Coalition"; } ?> <?php echo $Company_details->Currency_name; ?>
            </td>
            <td>
              <?php echo round($results->Total_reddems+$Total_Transfer_points+$results->Blocked_points+$results->Debit_points); ?>
            </td>
            <td> </td>
            <td> </td>
            <td class="text-right">
             Debited <?php echo $Company_details->Currency_name; ?> 
            </td>
            <td class="text-right">
             <?php echo $results->Debit_points; ?>
            </td>
          </tr>
        
        </tbody>
      </table>
      <!--------------------
      END - Basic Table
      -------------------->
    </div>
    </div>
    </div>
</div>
	
</div>			
<?php echo form_close(); ?>
<?php $this->load->view('header/footer'); ?>

<script>
$(document).ready(function()
{
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
});
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
function Get_states(Country_id)
{
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url()?>index.php/Company/Get_states",
		success: function(data)
		{
			$("#Show_States").html(data.States_data);

		}
	});
}
function Get_cities(State_id)
{
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo base_url()?>index.php/Company/Get_cities",
		success: function(data)
		{
			$("#Show_Cities").html(data.City_data);

		}
	});
}
$('#Register').click(function()
{
	show_loader();
});

function Gained_Points_Detail()
{
	var enrollId='<?php echo $results->Enrollement_id ?>';
	var comp_id='<?php echo $results->Company_id ?>';
	$.ajax({
		type: "POST",
		data: {enrollId: enrollId, comp_id:comp_id},
		url: "<?php echo base_url()?>index.php/Call_center/merchant_gained_loyalty_points",
		success: function(data)
		{
			$("#show_merchant_gainpoints_details").html(data.transactionDetailHtml);
			$('#detail_myModal').show();
			$("#detail_myModal").addClass( "in" );
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
$("#close_modal").click(function(e)
	{
		 $('#detail_myModal').hide();
		$("#detail_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
</script>
