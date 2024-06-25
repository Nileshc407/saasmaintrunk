<?php $this->load->view('header/header'); 

$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag'];
?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   LOYALTY RULE
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
				echo form_open('Administration/loyalty_rule',$attributes); ?>	
				<div class="row">
		  <div class="col-sm-6">
				  <div class="form-group">
					<label for="">Company Name</label>
					<select class="form-control" name="Company_id"  required="required">
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option> 
					</select>
				  </div>  
				  
				  <div class="form-group">
					<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
					<select class="form-control" name="seller_id" ID="seller_id" data-error="Please Select Business/Merchant Name"  required="required">
						<option value="">Select Business/Merchant</option>
						<?php
								if($Logged_user_id == 2 || $Super_seller == 1)
								{
									echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
								}
								
								foreach($Seller_array as $seller_val)
								{
									echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
								}
							?> 
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
				  </div>  
				  
				 <div class="form-group">
					<label for=""><span class="required_info" style="color:red;">* </span>Loyalty Program Name</label>
					<!---onkeypress="return isAlphanumeric(event)"---->
					<input class="form-control" placeholder="Enter Loyalty Program Name" type="text" name="LPName" id="LPName" required="required"   onblur="lp_name_validation(this.value,loyalty_rule_setup.value);"  data-error="Please Enter Loyalty Program Name" >
					
					<div class="help-block form-text with-errors form-control-feedback" id="LPName2" ></div>
				  </div>
				  
				  <div class="form-group">
						<label for="">
							<span class="required_info" style="color:red;">*</span> Valid From <span class="required_info" style="color:red;font-size:10px;">(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="start_date" id="datepicker1" class="single-daterange form-control" placeholder="Rule Start Date" required />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="">
							<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" style="color:red;">(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="end_date" id="datepicker2" class="single-daterange form-control" placeholder="Rule End Date" required />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
				 
				 
					<div class="form-group">
						<label for=""> <span class="required_info" style="color:red;">*</span> Select Tier</label> 
						<select class="form-control" name="member_tier_id"  id="member_tier_id" required >
							<option value="0">All Tiers</option>						
							<?php										
							foreach($Tier_list as $Tier)
							{
								echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
							}
							?>
						</select>						
					</div>
					</div>
				    <div class="col-sm-6">
				 <div class="form-group">
					<label for=""><span class="required_info">* </span>Loyalty Rule Setup</label>
					<div class="col-sm-8" >
					  <div class="form-check" >
						<label class="form-check-label">
						<input class="form-check-input" name="loyalty_rule_setup" type="radio" value="PA" required checked>On 'Purchase' Amount</label>
					  </div>
					  <div class="form-check" >
						<label class="form-check-label">
						<input class="form-check-input" name="loyalty_rule_setup" type="radio" value="BA" required>On 'Balance To Pay'</label>
					  </div>
					</div>
				  </div>
					<div class="form-group">
					  <label for=""><span class="required_info" style="color:red;">* </span>Member Gain <?php echo $Company_details->Currency_name; ?> </label>
					  <div class="col-sm-12" >
					  <div class="form-check" >
						<label class="form-check-label">
						<input class="form-check-input" name="customer_gain" id="inlineRadio3" type="radio" value="1" onclick="hide_gained_points(this.value)" required="required" checked>Based On Every Transaction</label>
					  </div>
					  
					  <div class="form-check" >
						<label class="form-check-label">
						<input class="form-check-input" name="customer_gain" id="inlineRadio3" data-toggle="modal" data-target="#myModal1" type="radio"  value="2" onclick="hide_gained_points(this.value)"  required="required">Based On Value of Transaction</label>
					  </div> 
						
						<div class="help-block form-text with-errors form-control-feedback"></div>
							
						<div class="form-group"  id="has-feedback5">
						<span id="if_every_transaction" style="display:none;">
						<label for=""> <span class="required_info">* </span>Gain <?php echo $Company_details->Currency_name; ?> <span class="required_info">(Please Enter Percentage(%) between 1 to 100)</span></label>
						<input class="form-control" type="text" name="gained_points" id="gained_points" onblur="checkVal(this.value,this.id);"   class="form-control" placeholder="Enter Gain <?php echo $Company_details->Currency_name; ?> (In Percentage)"  required="required" data-error="Please Enter Gain <?php echo $Company_details->Currency_name; ?> (In Percentage)"  onkeyup="this.value=this.value.replace(/\D/g,'')" >
							<div class="help-block form-text with-errors form-control-feedback"  id="Gain" ></div>
						</span>
				  </div>
					</div>
					</div>
					<!-- Modal -->
								<div id="myModal1" class="modal fade" role="dialog">
								  <div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
									<div align="right"><button type="button" class="close"  data-dismiss="modal"><span aria-hidden="true"> &times;</span></button>
									</div>
									  <div class="element-wrapper" style="margin-left: 1em;">
										
										<h6 class="element-header">  
									   Member Gain <?php echo $Company_details->Currency_name; ?> Based On Value of Transaction 
									  </h6>
									  <span class="required_info">(Please Enter Percentage(%) between 1 to 100)</span>
									 
									  
									  <div class="modal-body">
									
											<div class="table-responsive">
											<table  id="options-table" class="table table-bordered table-hover">
												<thead>
												<tr>
													<th class="text-center">On Purchase Above</th>
													<th class="text-center">Gain <?php echo $Company_details->Currency_name; ?> (in Percentage)</th>
													<th class="text-center">
														<button type="button" id="addrows" class="btn btn-info" >Add Rule</button>
													</th>
												</tr>
												<tr id="Row_1"><td><input type="text" name="Purchase_value[]"  onblur="CheckDuplicateVals(this.value,this.id);" value="0" id="Purchase_1"  onkeyup="this.value=this.value.replace(/\D/g,'')"  class="form-control" /></td>
												<td><input type="text"  onblur="checkVal(this.value,this.id);" onkeypress="return isNumberKey(event)"  class="form-control"  value="" name="Issue_points[]" id="Points_1"  onkeyup="this.value=this.value.replace(/\D/g,'')" /></td>
												<td>
												
												<a class="danger" id="Rmv_1" href="javascript:RemoveRow('1');"  title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
												</td></tr>
												</thead>
											</table>
											</div>
									  </div>
										<div class="form-group has-feedback" id="has-feedback4">
											<div class="help-block" id="help-block4"></div>
										</div>
										<div class="form-group has-feedback" id="Duplicateentry">
										</div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
									  </div>
									</div>
									</div>
								  </div>
								</div>
					<div class="form-group">
						  <label for=""><span class="required_info" style="color:red;">* </span>Loyalty Rule For</label>
							<div class="col-sm-8" >
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Rule_for" type="radio" id="r1" value="1" checked>Menu Group</label>
							  </div>
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Rule_for" type="radio" id="r2" value="2">Segment
								</label>
							  </div> 
								
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Rule_for" type="radio" id="r3" value="3">None (Normal Rule)
								</label>
							  </div> 
								
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Rule_for" type="radio" id="r4" value="4">Transaction Channel
								</label>
							  </div> 
								
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Rule_for" type="radio" id="r5" value="5">Payment Type
								</label>
							  </div> 
								
							</div>
						  
						</div>
						
						<div class="form-group"  id="Category" >
								<label for=""><span class="required_info" >* </span>Select Menu Group</label>
								<div class="col-sm-12" >
								<select class="form-control select2" multiple="true" name="Category_id[]" id="Category_id"  data-error="Please Select Menu Group" >
								 <option value="" selected > Select Business/Merchant First </option>
								</select>
							</div> 
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div> 

						
						<div  class="form-group" id="Channel" style="display:none;">
									<label for=""><span class="required_info">* </span> Select Transaction Channel </label>
									<select class="form-control" name="Trans_Channel" id="Trans_Channel"   >
										<option value="0">All</option>
										<option value="2" >POS</option>
										<option value="12">Online</option>
										<option value="29">3rd Party Online order</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>	
						
						<div  class="form-group" id="Payment" style="display:none;">
									<label for=""><span class="required_info">* </span> Select Payment Type </label>
									<select class="form-control" name="Payment_Type_id" id="Payment_Type_id"   >
							<?php										
							foreach($get_payement_type as $rec)
							{
								echo '<option value="'.$rec->Payment_type_id.'">'.$rec->Payment_type.'</option>';
							}
							?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>	
						
						
						<div  class="form-group" id="Segment" style="display:none;">
									<label for=""><span class="required_info">* </span> Select Segment </label>
									<select class="form-control" name="Segment_id" id="Segment_id"   onchange="Show_criteria(this.value);"   data-error="Please Select Segment"  >
										<option value="">Select Segment First</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>	
						
						<div class="form-group" id="Segment_Criteria" style="display:none;">
									<label for="">&nbsp;Segment Criteria</label>
									<textarea class="form-control" rows="3" name="S_Criteria" id="S_Criteria" readonly>
									</textarea>
						</div>
					
					
						
					</div>
					
				</div>	
					
					
				  
				  <?php if($_SESSION['Privileges_Add_flag']==1){ ?>
				  <div class="form-buttons-w"  align="center">
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  <?php } ?>
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>


	<!--------------Table------------->
	<?php if($_SESSION['Privileges_View_flag']==1){ ?>
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Loyalty Rules
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Action</th>
							<th>Business/Merchant Name</th>
							<th>Loyalty Program Name</th>
							<!--<th class="text-center">Flat File Yes/No</th>-->							
							<th>Menu Group Name</th>						
							<th>Validity</th>
							<!--<th>Tier Name</th>-->
							<!--
							<th colspan="2" >Validity Of Transaction</th>
							<th>Loyalty @ Transaction</th>
							<th colspan="2">Loyalty @ Value</th>-->
						</tr>
						<!--
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							
							<td>From Date</td>
							<td>Till Date</td>
							<td> % <?php echo $Company_details->Currency_name; ?>  Gained</td>
							<td>Value</td>
							<td> % <?php echo $Company_details->Currency_name; ?>  Gained</td>
							
						</tr>-->
					</thead>						
					
					<tbody>
				<?php
						$todays = date("Y-m-d");
						
						if($results2 != NULL)
						{
							foreach($results2 as $row)
							{
									if( ($todays >= $row->From_date) && ($todays <= $row->Till_date) )
									{
										$class = 'style="color:#00b300;"';
									}
									else
									{
										$class = "";
									}
							?>
						<tr>
									<td class="row-actions">
									<?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
										<a href="<?php echo base_url()?>index.php/Administration/edit_loyalty_rule/?LWabckoy10calNtyJiSd=<?php echo App_string_encrypt($row->Loyalty_id);?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>
										<a href="javascript:void(0);" class="danger"  onclick="delete_me('<?php echo $row->Loyalty_id;?>','<?php echo $row->Loyalty_name;?>','','Administration/delete_loyalty_rule/?Loyalty_id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
											<i class="os-icon os-icon-ui-15"></i>
										</a>
										<?php } ?>
									</td>
									
									<td class="text-center"><?php echo $row->First_name." ".$row->Last_name;?></td>
									
									<td><?php echo $row->Loyalty_name;?></td>
									<?php /* 
									<td class="text-center"><?php if($row->Flat_file_flag==1){ echo "Yes"; } else { echo "No"; }?></td>  */ ?>
									
									<td class="text-center"><?php if($row->Merchandize_category_name !="") { echo $row->Merchandize_category_name; } else { echo "-"; }?></td>
									<?php 
										
										$ci_object = &get_instance();
										$ci_object->load->model('administration/Administration_model');
										
										$Segment_name = $ci_object->Administration_model->Get_Segment_Name($row->Segment_id,$Company_id);
										
										if($Segment_name!=NULL)
										{
											$Segmentname=$Segment_name->Segment_name;		
										} 
									?>
									<!--
									<td class="text-center"><?php if($Segment_name !="") { echo $Segmentname; } else { echo "-"; } ?></td>-->
									<td <?php echo $class; ?>><?php echo  $row->From_date." <b>To</b> ".$row->Till_date; ?> </td>
									<!--
									<td class="text-center"><?php if($row->Tier_id !="") { echo $row->Tier_name; } else { echo "All Tier"; } ?></td>-->
									
									
									<!--
									<td><?php echo  $row->From_date; ?> </td>
									<td><?php echo $row->Till_date; ?> </td>
										
									<td><?php echo $row->Loyalty_at_transaction;?></td>
									<td><?php echo $row->Loyalty_at_value;?></td>
									<td><?php echo $row->discount;?></td>
										-->
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
	<?php } ?>
	<!--------------Table--------------->
	
</div>			
<?php $this->load->view('header/footer'); ?>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/redmond/jquery-ui.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.js"></script>-->

<script>
$('#Register').click(function()
{
	//alert();
	if( $('#seller_id').val() != "" && $('#LPName').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" && $("input[name=customer_gain]:checked").val() > 0)
	{
		var radioVAL = $("input[name=customer_gain]:checked").val();
		var Rule_for = $("input[name=Rule_for]:checked").val();
		
		/* alert("radioVAL "+radioVAL);
		alert("Rule_for "+Rule_for); */
		if(Rule_for==1)
		{
			if( $('#Category_id').val() == "")
			{
				return false;
			}
		}
		
		if(Rule_for==2)
		{
			if( $('#Segment_id').val() == "")
			{
				return false;
			}
		}
		
		if(radioVAL == 1)
		{
			
				show_loader();
			
		}
		else if(radioVAL == 2)
		{
			if($('#Purchase_1').val() > 0)
			{
				show_loader();
			}
			else
			{
				var Title = "In-valid Data Validation";
				var msg='Please enter purchase amount and points in percentage!.';
				runjs(Title,msg);
				return false;
			}
		}
	}
});
</script>
<script type="text/javascript">

	function lp_name_validation(lpname,rule_type)
	{
		// var rule_type = $("input[name=loyalty_rule_setup]:checked").val();

		// var Lp_Name = rule_type+"-"+lpname;
	
		var Company_id = '<?php echo $Company_id; ?>';
		
		 // if( lpname == "" )
		// {
			// $("#LPName").val("");
			// has_error(".has-feedback","#glyphicon","#help-block6","Please Enter Valid Loyalty Program Name..!!");
		// }
		// else if(rule_type == "PA" || rule_type == "BA")
		// {
		$.ajax({
				type:"POST",
				data:{lpname:lpname, Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Administration/loyalty_program_name_validation",
				success : function(data)
				{ 
					// alert(data);
					if(data == 0)
					{
						$("#LPName").val("");
						//has_error(".has-feedback","#glyphicon","#help-block6","Already Exist");
						$("#LPName2").html("Already exist");
						$("#LPName").addClass("form-control has-error");
					}
					else
					{
						$("#LPName2").html("");
						$("#LPName").removeClass("has-error");
					}
					
				}
			});
		// }
		// else
		// {
			// $("#LPName").val("");
			// has_error(".has-feedback","#glyphicon","#help-block6","Please Select Any One Loyalty Rule Setup..!!");
		// }
		
		
	}
	
/******calender *********/
/* $(function() 
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
		
}); */

/******calender *********/
$("#datepicker1").datepicker({
  minDate: 0,
  yearRange: "-80:+2",
  changeMonth: true,
  changeYear: true,
  onSelect: function(date) {
    $("#datepicker1").datepicker('option', 'minDate', date);
  }
});
$("#datepicker2").datepicker({
	
	 minDate: 0,
  yearRange: "-80:+2",
  changeMonth: true,
  changeYear: true,
	onSelect: function(date) {
    $("#datepicker2").datepicker('option', 'minDate', date);
	}
	
});
/******calender *********/

	$('#seller_id').change(function()
	{
		var seller_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/POS_CatalogueC/get_seller_menu_groups',
			success:function(opData2){
				$('#Category_id').html(opData2);
				$('#select_menu_group_id').attr('disabled', true);
			}
		});
	});
/******calender *********/
hide_gained_points(1);
function hide_gained_points(input_val)
{
	if(input_val == 2)
	{
		$("#if_every_transaction").hide();
		$("#gained_points").removeAttr("required");	
	}
	else
	{
		$("#if_every_transaction").show();
		$("#gained_points").attr("required","required");
	}
}



function checkVal(percent_val,field_id)
{
	if(percent_val > 100)
	{
		$("#"+field_id).val("");
		
		if(field_id == "gained_points")
		{
			// has_error("#has-feedback5","#glyphicon5","#help-block5","Enter between 1 to 100 percentage(%).");
			$("#Gain").html("Please Enter Percentage(%) between 1 to 100");
			$("#gained_points").addClass("form-control has-error");
		}
		else
		{
			// has_error("#has-feedback4","#glyphicon4","#help-block4","Enter between 1 to 100 percentage(%).");
		}
	}
	else 
	{
		if(percent_val == 0)
		{
			$("#"+field_id).val("");
			
			if(field_id == "gained_points")
			{
				// has_error("#has-feedback5","#glyphicon5","#help-block5","Enter between 1 to 100 percentage(%).");
				$("#Gain").html("Please Enter Percentage(%) between 1 to 100");
				$("#gained_points").addClass("form-control has-error");
			}
			else
			{
				// has_error("#has-feedback4","#glyphicon4","#help-block4","Enter between 1 to 100 percentage(%).");
				$("#Gain").html("Please Enter Percentage(%) between 1 to 100");
			}
		}
	}
	
	if(field_id == "gained_points")
	{
		if(percent_val != 0 && percent_val <= 100)
		{
			$("#gained_points").removeClass("has-error");
			$("#Gain").html("");
		}
	}
	
	/*else
	{
		if(field_id == "gained_points")
		{
			has_success("#has-feedback5","#glyphicon5","#help-block5","");
		}
		else
		{
			
			has_success("#has-feedback4","#glyphicon4","#help-block4","");
		}
		
	}*/
}
	var allVals = new Array();
	function CheckDuplicateVals(percent_val,field_id)
	{
		
		if($.inArray(percent_val, allVals) == '-1')
		{
			allVals.push(percent_val);
		}
		else
		{
			// has_error("#has-feedback4","#glyphicon4","#help-block4","Do not enter Duplicate entry");
			$("#Duplicateentry").html("Do not enter Duplicate entry");
			
			$("#"+field_id).val("");
		}
			
	}
	//onkeyup="this.value=this.value.replace(/\D/g,'')"
/******** add row ********/ 
jQuery(function(){
    var counter = 2;
    jQuery('#addrows').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<tr id="Row_'+counter+'"><td><input  class="form-control"  type="text" name="Purchase_value[]"  onblur="CheckDuplicateVals(this.value,this.id);"      onkeypress="return isNumberKey(event)" value="0"    id="Purchase_' +
            counter + '"/></td><td><input type="text"  onblur="checkVal(this.value,this.id);"  onkeypress="return isNumberKey(event)" value="" name="Issue_points[]"  class="form-control"    id="Points_' +
            counter + '"/></td><td><a id="Rmv_' +
            counter + '" href="javascript:RemoveRow('+counter+');"><i class="os-icon os-icon-ui-15"></i></a></td></tr>');
        jQuery('#options-table').append(newRow);
    });
});

function RemoveRow(rowID)
{
	jQuery('#Row_'+rowID).remove();
}	

function RemoveAllRows()
{
	$("#options-table").find("tr:gt(0)").remove();

}


function delete_loyalty_rule(Loyalty_id,Loyalty_name)
{	
			var url = '<?php echo base_url()?>index.php/Administration/delete_loyalty_rule/?Loyalty_id='+Loyalty_id;
			window.location = url;
			return true;
			
/* 	BootstrapDialog.confirm("Are you sure to Delete the Loyalty Rule "+Loyalty_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_loyalty_rule/?Loyalty_id='+Loyalty_id;
		alert(url);
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
	}); */
}
/*****************Show Hide*****************/
	$('#r1').click(function()
	{
		 $("#Category").show();	
		//document.getElementById("Category").style.display="";
		$("#Category_id").attr("required","required");
		$("#Channel").hide();
		$("#Payment").hide();
		$("#Segment").hide();
		$("#Segment_Criteria").hide();
		$("#Segment_id").removeAttr("required");
		
		/*$.ajax({
			type:"POST",
			data:{Company_id:'<?php echo $Company_id; ?>'},
			url: "<?php echo base_url(); ?>index.php/Administration/Get_Merchandize_category",
			success: function(data)
			{ 
				$("#Category_id").html(data.Category_data);	
			}				
		});*/
		
	});		
	$('#r2').click(function()
	{
		$("#Category").hide();
		$("#Segment_Criteria").hide();
		$("#Category_id").removeAttr("required"); 	 
		$("#Segment").show();
		$("#Segment_id").attr("required","required");
		$("#Channel").hide();
		$("#Payment").hide();
		$.ajax({
			type:"POST",
			data:{Company_id:'<?php echo $Company_id; ?>'},
			url: "<?php echo base_url(); ?>index.php/Administration/Get_Segment",
			success: function(data)
			{ 
				$("#Segment_id").html(data.Segment_data);	
			}				
		});
	});		
	$('#r3').click(function()
	{
		$("#Category").hide();
		$("#Segment_Criteria").hide();
		// $("#Category_id").removeAttr("required");
		$("#Segment").hide();
		$("#Channel").hide();
		$("#Payment").hide();
		// $("#Segment_id").removeAttr("required");
	});
	
	$('#r4').click(function()
	{
		$("#Category").hide();
		$("#Segment_Criteria").hide();
		// $("#Category_id").removeAttr("required");
		$("#Segment").hide();
		$("#Channel").show();
		$("#Payment").hide();
		// $("#Segment_id").removeAttr("required");
	});
	
	$('#r5').click(function()
	{
		$("#Category").hide();
		$("#Segment_Criteria").hide();
		// $("#Category_id").removeAttr("required");
		$("#Segment").hide();
		$("#Channel").hide();
		$("#Payment").show();
		// $("#Segment_id").removeAttr("required");
	});
	
	function Show_criteria(Segment_id)
	{
		if(Segment_id !=0)
		{
			$.ajax({
				type: "POST",
				data: {Segment_id: Segment_id,Company_id:'<?php echo $Company_id; ?>'},
				url: "<?php echo base_url()?>index.php/Administration/Get_Segment_Criteria",
				success: function(data)
				{ 
					$("#Segment_Criteria").show();
					$("#S_Criteria").html(data.Criteria_data);			
				}
			});
		}
		else
		{
			$("#Segment_Criteria").hide();
		}
	}
/**************Show Hide**********************/
</script>
