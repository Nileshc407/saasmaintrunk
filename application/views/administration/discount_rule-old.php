<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   Discount RULE
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
				echo form_open('Administration/Discount_rule_master',$attributes); ?>	
				<div class="row">
		  <div class="col-sm-6">
				  <div class="form-group">
					<label for="">Company Name</label>
					<select class="form-control" name="Company_id"  required="required">
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option> 
					</select>
				  </div>  
				  
				  
				  
				 <div class="form-group">
					<label for=""><span class="required_info" style="color:red;">* </span>Discount Rule Code</label>
					
					<input class="form-control" placeholder="Enter Discount Rule Code" type="text" name="Discount_code" id="Discount_code" required="required"  onkeypress="return isAlphanumeric(event)"  data-error="Please Enter Discount Rule Code" >
					<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
				  </div>
				  
				 
				  
				  <div class="form-group">
						<label for="">
							<span class="required_info" style="color:red;">*</span> Valid From <span class="required_info" style="color:red;font-size:10px;">(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="Valid_from" id="datepicker1" class="single-daterange form-control" placeholder="Rule Start Date" required />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					
					
				 
				 
					<div class="form-group">
						<label for=""> <span class="required_info" style="color:red;">*</span> Select Tier</label> 
						<select class="form-control" name="Tier_id"  id="Tier_id" required >
							<option value="0">All Tiers</option>						
							<?php										
							foreach($Tier_list as $Tier)
							{
								echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
							}
							?>
						</select>						
					</div>
					<div class="form-group">
							  <label for=""><span class="required_info" style="color:red;">* </span>Discount Rule Set </label>
							  <div class="col-sm-12" >
							
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_rule_set" id="inlineRadio3" type="radio"   value="1"  required="required" checked onclick="hide_gained_points(this.value)"  >Percentage</label>
							  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_rule_set"  id="inlineRadio3"  type="radio"  value="2"  required="required"   onclick="hide_gained_points(this.value)"  >Value</label>
							  </div> 
								
								<div class="help-block form-text with-errors form-control-feedback"></div>
									
								<div class="form-group"  id="has-feedback5">
									<span>
										<label for=""> <span class="required_info">* </span><span class="required_info" id="discount_rule_set">(Please Enter Percentage(%) between 1 to 100)</span></label>
										<input class="form-control" type="text" name="Discount_Percentage_Value" id="Discount_Percentage_Value" onblur="checkVal(this.value,this.id);"   class="form-control" placeholder="Enter Percentage(%) between 1 to 100)"  required="required"   onkeypress="return isNumberKey2(event)"  >
								
									<div class="help-block form-text with-errors form-control-feedback"  id="Gain" ></div>
									</span>
								</div>
							</div>
					</div>
					
								
						<div class="form-group">
						
							<label for=""> Set Max Limit For Discount</label>
							<div class="col-sm-12" >	
								<input class="form-control" type="text" name="max_discount" id="max_discount"   class="form-control" maxlength="8" placeholder="Maximum Limit Value"  data-error="Enter Maximum Limit For Discount"  onkeypress="return isNumberKey2(event)"  >
						
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
						</div>
					
					</div>
				  
				    <div class="col-sm-6">
					
						 <div class="form-group">
							<label for=""><span class="required_info">* </span>Outlet Name</label>
							<select class="form-control select2" multiple="true" name="Seller_id[]" ID="Seller_id" data-error="Please Select Outlet Name"    required="required">
								
								<?php
										if($Logged_user_id > 2 || $Super_seller == 1)
										{
											echo '<option value="0">All Outlet</option>';
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
								<label for=""><span class="required_info" style="color:red;">* </span>Discount Rule Name</label>
								
								<input class="form-control" placeholder="Enter Discount Rule Name" type="text" name="Discount_rule_name" id="Discount_rule_name" required="required"  data-error="Please Enter Discount Rule Name" >
								
								<div class="help-block form-text with-errors form-control-feedback" id="LPName2" ></div>
							</div>
						  
					<div class="form-group">
						<label for="">
							<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" style="color:red;">(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="Valid_till" id="datepicker2" class="single-daterange form-control" placeholder="Rule End Date" required />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					
					<div class="form-group">
							<label for=""><span class="required_info">* </span>Issue  Discount as  an eVoucher </label>
							<div class="col-sm-8" >
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_voucher_applicable" type="radio"   value="1"  >Yes</label>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_voucher_applicable" type="radio"  value="0" checked>No</label>
							  </div> 
							  
							</div>
					</div>
					<br>	  
					<div class="form-group"> 
						<label for=""><span class="required_info">* </span>Discount Rule Applicable For</label>	
						
						 <div class="row">
							
							<div class="col-sm-4" >
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_rule_for" type="radio"  id="Bill_level"  value="1"  checked onclick="Toggle_discount(this.value);">Overall Bill Level</label>
							  </div>
							</div> 
							<div class="col-sm-4" >	
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_rule_for" id="Category_level" type="radio"  value="2" onclick="Toggle_discount(this.value);" >Category Level</label>
							  </div> 
							 </div> 
							<div class="col-sm-4" >	 
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_rule_for" type="radio"  id="Item_level" value="3" onclick="Toggle_discount(this.value);">Item Level</label>
							  </div> 
							  
							</div>
							
							<div class="col-sm-4" >
								<div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_rule_for" type="radio"    id="r4" value="4" onclick="Toggle_discount(this.value);">Transaction Channel
								</label>
							  </div> 
							</div> 
							
							<div class="col-sm-4" >
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" name="Discount_rule_for" type="radio"    id="r5" value="5" onclick="Toggle_discount(this.value);">Payment Type
								</label>
							  </div> 
							</div> 
							  
						  </div>
						  </div>
				 
							
							<div class="form-group"  id="Bill_block" >
								<div class="col-sm-12" >
								<select class="form-control"  name="Operator" id="Operator" data-error="Please Select Operator"  required="required" >
									<option value="">Select Operator</option>
									<option value=">">></option>
									<option value=">=">>=</option>
									<option value="<"><</option>
									<option value="<="><=</option>
									<option value="=">=</option>
									<option value="!=">!=</option>
								 
								</select>
							</div> 
							<div class="help-block form-text with-errors form-control-feedback"></div>
							</div> 
							
							<div  class="form-group" id="Channel" style="display:none;">
									<label for=""><span class="required_info">* </span> Select Transaction Channel </label>
									<select class="form-control" name="Trans_Channel" id="Trans_Channel"   >
										<option value="0">All</option>
										<option value="2">POS</option>
										<option value="12">Online</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>	
							
							<div  class="form-group" id="Payment" style="display:none;">
										<label for=""><span class="required_info">* </span> Select Payment Type </label>
										<select class="form-control" name="Payment_Type_id" id="Payment_Type_id" >
										<option value="0">All</option>
								<?php										
								foreach($get_payement_type as $rec)
								{
									echo '<option value="'.$rec->Payment_type_id.'">'.$rec->Payment_type.'</option>';
								}
								?>
										</select>
										<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>	
						
					
					<div class="form-group" id="Bill_block2" >
						
						<label for=""> <span class="required_info">* </span>Criteria Value</label>
						<div class="col-sm-12" >	
							<input class="form-control" type="text" name="Criteria_value" id="Criteria_value"   class="form-control" placeholder="Enter Criteria Value"  required="required" data-error="Enter Criteria Value"  onkeypress="return isNumberKey2(event)"  >
					
							<div class="help-block form-text with-errors form-control-feedback" id="crit_error"></div>
						</div>
					</div>
					
					
					
						
						<div class="form-group"  id="Category" style="display:none;">
								<label for=""><span class="required_info" >* </span>Select Category</label>
								<div class="col-sm-12" >
								<select class="form-control" name="Category_id" id="Category_id"  data-error="Please Select Category" >
								<option value="">Select Category</option>
								  <?php
								foreach($Merchandize_Category_Records as $Merchandize_Category) 
								{
									if(!$Merchandize_Category->Parent_category_id) 
									{
										$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
										
										echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
									
										foreach($childs as $row) {
											echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
										}
									}							
								}
							?>	
								</select>
							</div> 
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div> 

					
						
						<div class="form-group"  id="Item_Category" style="display:none;">
								<label for=""><span class="required_info" >* </span>Select Category</label>
								<div class="col-sm-12" >
								<select class="form-control" name="Item_Category_id" id="Item_Category_id"  data-error="Please Select Category"  onchange="Get_items(this.value);" >
								<option value="">Select Category</option>
								  <?php
								foreach($Merchandize_Category_Records as $Merchandize_Category) 
								{
									if(!$Merchandize_Category->Parent_category_id) 
									{
										$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
										
										echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
									
										foreach($childs as $row) {
											echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
										}
									}							
								}
							?>	
								</select>
							</div> 
							<div class="help-block form-text with-errors form-control-feedback"></div>
							<div style="color:red;" id="help-block22"></div>
						</div> 

				
						
					</div>
					
					<div class="col-md-12"  id="selected_items"  style="display:none;">
								<div class="panel panel-default">
											<div class="panel-heading">
												<legend><span>Linked Items for Discount</span></legend>
											</div>
									<div class="panel-body">
										<div class="col-md-12"  id="Linked_items" >
										
									
										</div>
									</div>
								</div>
					</div>
				</div>	
				 <input type="hidden" id="linked_itemcode" name="linked_itemcode" value="">
				  <input type="hidden" id="linked_Discount_percentage_or_value" name="linked_Discount_percentage_or_value" value="">	
				  <input type="hidden" id="linked_Category_id" name="linked_Category_id" value="">	
					
				  
				  
				  <div class="form-buttons-w"  align="center">
					<button class="btn btn-primary" name="submit" id="Register"  type="submit" >Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
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
			   Discount Rules
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Action</th>
							<th>Discount Rule Code</th>
							<th>Discount Rule Name</th>
							<th>Outlet Name</th>
							<th>Discount Rule Applicable For</th>						
							<th>Validity</th>
							
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
						$todays = date("Y-m-d");
						
						if($results2 != NULL)
						{
							foreach($results2 as $row)
							{
								$Seller_details = $this->Igain_model->get_seller_details($row->Seller_id);
								foreach($Seller_details as $seller_val)
								{
									$Outlet_name=$seller_val->First_name." ".$seller_val->Last_name;
								}
									if( ($todays >= $row->Valid_from) && ($todays <= $row->Valid_till) )
									{
										$class = 'style="color:#00b300;"';
									}
									else
									{
										$class = "";
									}
									if($row->Discount_rule_for==1)
									{
										$Discount_rule_for='Overall Bill Level';
									}
									if($row->Discount_rule_for==2)
									{
										$Discount_rule_for='Category Level';
									}
									if($row->Discount_rule_for==3)
									{
										$Discount_rule_for='Item Level';
									}
									if($row->Discount_rule_for==4)
									{
										$Discount_rule_for='Channel Level';
									}
									if($row->Discount_rule_for==5)
									{
										$Discount_rule_for='Payment Type Level';
									}
							?>
						<tr>
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/Administration/edit_new_discount_rule/?Discount_id=<?php echo $row->Discount_id;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										
										<a href="javascript:void(0);" class="danger"  onclick="delete_me('<?php echo $row->Discount_id;?>','<?php echo $row->Discount_rule_name;?>','','Administration/delete_new_discount_rule/?Discount_id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
											<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									
									<td><?php echo $row->Discount_code;?></td>
									<td><?php echo $row->Discount_rule_name;?></td>
									<td><?php echo $Outlet_name;?></td>
									<td><?php echo $Discount_rule_for;?></td>
									
								
									<td <?php echo $class; ?>><?php echo  $row->Valid_from." <b>To</b> ".$row->Valid_till; ?> </td>
									
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


	<div id="myModal1" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" >
		<div class="modal-dialog modal-lg" style="margin-top:14%;width:60%;">
			<div class="modal-content">
			 <!-- <div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			  </div>-->
			  <div class="modal-body">
				<div  id="Show_items"></div>
			  </div>
			 
			</div>
		</div>
    </div>		
<?php $this->load->view('header/footer'); ?>


<script type="text/javascript">

// $('#Register').click(function()
var temp =1;

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

function hide_gained_points(input_val)
{
	$("#Gain").html("");
	$("#Discount_Percentage_Value").val("");
	if(input_val == 2)//value
	{
		$("#discount_rule_set").html('(Please Enter Value > 0)');
		$("#Discount_Percentage_Value").attr("placeholder", "Enter Value > 0");
		
	}
	else
	{
		$("#discount_rule_set").html('(Please Enter Percentage(%) between 1 to 100)');
		$("#Discount_Percentage_Value").attr("placeholder", "Enter Percentage(%) between 1 to 100");
		
	}
}



function checkVal(percent_val,field_id)
{
	var Discount_rule_set = $("input[name=Discount_rule_set]:checked").val();
	if(Discount_rule_set==1)//Percentage
	{
		if(percent_val > 100)
		{
			$("#"+field_id).val("");
			
			if(field_id == "Discount_Percentage_Value")
			{
				$("#Gain").html("Please Enter Percentage(%) between 1 to 100");
				$("#Discount_Percentage_Value").addClass("form-control has-error");
			}
			
		}
		else 
		{
			if(percent_val == 0)
			{
				$("#"+field_id).val("");
				
				if(field_id == "Discount_Percentage_Value")
				{
					$("#Gain").html("Please Enter Percentage(%) between 1 to 100");
					$("#Discount_Percentage_Value").addClass("form-control has-error");
				}
				else
				{
					$("#Gain").html("Please Enter Percentage(%) between 1 to 100");
				}
			}
		}
		
		if(field_id == "Discount_Percentage_Value")
		{
			if(percent_val != 0 && percent_val <= 100)
			{
				$("#Discount_Percentage_Value").removeClass("has-error");
				$("#Gain").html("");
			}
		}
	}
	else
	{
			if(percent_val == 0)
			{
				$("#"+field_id).val("");
				
				if(field_id == "Discount_Percentage_Value")
				{
					$("#Gain").html("Enter Value > 0");
					$("#Discount_Percentage_Value").addClass("form-control has-error");
				}
				
			}
			else
			{
				$("#Gain").html("");
				$("#Discount_Percentage_Value").removeClass("has-error");
				
			}
	}

}

$('#Criteria_value').blur(function()
{
	var Criteria_value = $('#Criteria_value').val();
	if(Criteria_value == 0)
	{
		$('#Criteria_value').val('');
		$("#crit_error").html("Enter Value > 0");
		$("#Criteria_value").addClass("form-control has-error");
	}
	else
	{
		$("#crit_error").html("");
		$("#Criteria_value").removeClass("has-error");
		
	}
});

/*****************Show Hide*****************/
	function Toggle_discount(val)
	{
		if(val==1)//Bill
		{
			$("#Bill_block").show();
			$("#Bill_block2").show();
			$("#Criteria_value").attr("required","required");
			$("#Operator").attr("required","required");
			
			$("#Category").hide();
			$("#Category_id").removeAttr("required"); 	
			
			$("#Channel").hide();
			$("#Trans_Channel").removeAttr("required"); 
			
			$("#Payment").hide();
			$("#Payment_Type_id").removeAttr("required"); 
			
			$("#selected_items").hide();
			
			$("#Item_Category").hide();
			$("#Item_Category_id").removeAttr("required"); 	
		}
		else if(val==2)//Category
		{
			$("#Category").show();
			$("#Category_id").attr("required","required");
			
			$("#Bill_block").hide();
			$("#Bill_block2").hide();
			$("#Criteria_value").removeAttr("required"); 	
			$("#Operator").removeAttr("required"); 	
			
			$("#Channel").hide();
			$("#Trans_Channel").removeAttr("required"); 
			
			$("#Payment").hide();
			$("#Payment_Type_id").removeAttr("required"); 
			
			$("#selected_items").hide();
			
			$("#Item_Category").hide();
			$("#Item_Category_id").removeAttr("required"); 	
		}
		else if(val==3)//Item level
		{
			$("#Item_Category").show();
			$("#Item_Category_id").attr("required","required");
			
			$("#Channel").hide();
			$("#Trans_Channel").removeAttr("required"); 
			
			$("#Payment").hide();
			$("#Payment_Type_id").removeAttr("required"); 
			
			$("#Category").hide();
			$("#Category_id").removeAttr("required"); 	
			
			$("#Bill_block").hide();
			$("#Bill_block2").hide();
			$("#Criteria_value").removeAttr("required"); 	
			$("#Operator").removeAttr("required"); 	
		}
		else if(val==4)//channel
		{
			$("#Channel").show();
			$("#Trans_Channel").attr("required","required");
			
			$("#Payment").hide();
			$("#Payment_Type_id").removeAttr("required"); 
			
			$("#Category").hide();
			$("#Category_id").removeAttr("required"); 
			$("#Bill_block").hide();
			$("#Bill_block2").hide();
			$("#Criteria_value").removeAttr("required"); 	
			$("#Operator").removeAttr("required"); 	
			
			$("#selected_items").hide();
			
			$("#Item_Category").hide();
			$("#Item_Category_id").removeAttr("required"); 	
		}
		else if(val==5)//payment type
		{
			$("#Payment").show();
			$("#Payment_Type_id").attr("required","required");
			
			$("#Channel").hide();
			$("#Trans_Channel").removeAttr("required"); 
			
			$("#Category").hide();
			$("#Category_id").removeAttr("required"); 
			$("#Bill_block").hide();
			$("#Bill_block2").hide();
			$("#Criteria_value").removeAttr("required"); 	
			$("#Operator").removeAttr("required"); 	
			
			$("#selected_items").hide();
			
			$("#Item_Category").hide();
			$("#Item_Category_id").removeAttr("required"); 	
		}
		
		
	}	
	
	function Get_items(Item)
	{
		 var Discount_Percentage_Value = $("#Discount_Percentage_Value").val();
		 var Discount_code = $("#Discount_code").val();
		/*if(Discount_Percentage_Value=='' || Discount_Percentage_Value==0)
		{
			alert();
		} */
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Item:Item, Company_id:Company_id, Discount_code:Discount_code},
			url: "<?php echo base_url()?>index.php/Administration/Get_items_for_discount",
			success: function(data)
			{
				
				 $("#Show_items").html(data.Items_by_category);	
				
					$('.qty').val(Discount_Percentage_Value);
					$('#myModal1').show();
					$("#myModal1").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
			}				
		});
	}

	$('#Discount_code').blur(function()
		{
			//alert();
			if( $("#Discount_code").val()  == "" )
			{
				$("#Discount_code").val("");					
				$("#help-block1").html("Please enter Item code");
				$("#Discount_code").addClass("form-control has-error");
			}
			else
			{
				var Discount_code = $("#Discount_code").val();
				var Company_id = '<?php echo $Company_id; ?>';
				//alert(Branch_code);
				$.ajax({
					  type: "POST",
					  data: {Discount_code: Discount_code, Company_id: Company_id},
					  url: "<?php echo base_url()?>index.php/Administration/Check_Discount_code",
					  success: function(data)
					  {
						  //alert(data.length);
							if(data == 0)
							{
								$("#Discount_code").val("");					
								$("#help-block1").html("Already exist");
								$("#Discount_code").addClass("form-control has-error");
							}
							else
							{
								$("#Discount_code").removeClass("has-error");
								$("#help-block1").html("");
							}
						
							
					  }
				});
			}
		});
function isNumberKey2(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode

  if (charCode != 46 && charCode > 31
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}
/**************Show Hide**********************/
</script>
