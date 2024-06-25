<?php $this->load->view('header/header');
$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag']; ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   TRANSACTION DATA MAPPING
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
				
				<?php $attributes = array('id' => 'formValidate');
					echo form_open('Data_transform/insert_data_map',$attributes); ?>
					
					<div class="row">
						<div class="col-md-12">					
							<h6 class="form-group"> <span class="required_info">* Enter Column Numbers (Indexing start from 0, means column 1 is 0, 2 is 1 and  so on..)<br>* Please do not enter duplicate Column no.</span></h6>
						</div>
					</div>
						
				<div class="row">
					<div class="col-sm-12 col-md-6">
							  		
									  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Merchant Name  (Business/Merchant)</label>
						<select class="form-control " name="Column_Seller_id" id="Column_Seller_id" required="required" data-error="Please select merchant name">
						<option value="">Select Merchant</option>							
									<?php
									foreach($All_brands as $seller_val)
									{
										if($Super_seller==0)
										{
											if($Sub_seller_Enrollement_id > 0)//Outlet login
											{
												if($Sub_seller_Enrollement_id==$seller_val->Enrollement_id)
												{
													echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
												}
											}
											else //Business/Merchant login
											{
												if($enroll==$seller_val->Enrollement_id)
												{
													echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
												}
											}
											
										}
										else //Super Seller login
										{
											echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
										}
									}
								?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  
					  	<div class="form-group">
						<label for=""> <span class="required_info">* </span>Outlet Name</label>
						<select class="form-control " name="Column_outlet_id[]" multiple  id="Column_outlet_id" required="required" >
						<option value="0">Select Merchant First</option>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Number of Header Rows </label>								
						<input class="form-control" name="Column_header_rows"  id="Column_header_rows"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Number of Header Rows" required="required" data-error="Please enter number of header rows">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>

						<div class="form-group">
							<legend><span>Billwise (Required)</span></legend>	
					
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Membership ID </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Customer" id="Column_Customer" type="text" placeholder="Enter Column No. Membership ID" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of membership id">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						
					  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Bill No. </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Bill_no"  id="Column_Bill_no"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Bill No" required="required" data-error="Please enter column number of bill number">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<legend><span>Itemwise (Optional)</span></legend>	
					
						</div>
						<div class="form-group">
						<label for=""> Item Code </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Item_Code"  id="Column_Item_Code"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Item Code"  data-error="Please enter column number of item code">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> Remarks </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_remarks"  id="Column_remarks"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Remarks"  data-error="Please enter column number of remarks">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
					</div>
					<div class="col-sm-12 col-md-6">
					<!--
						<div class="form-group">
						<label for=""> Payment Type </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Payment_type"  id="Column_Payment_type"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Payment Type"  data-error="Please enter column number of payment type">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>-->
						
						<div class="form-group" >
						<br><br><br><br><br><br><br><br><br>
						</div>
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Date Format </label>	
						<!--<input class="form-control" name="Column_date_format" id="Column_date_format"  type="text"  placeholder="Enter Date Format" required="required" data-error="Please enter date format"  onkeyup="this.value=this.value.replace(/\d/g,'')"  >-->
						<select class="form-control " name="Column_date_format"   id="Column_date_format" required="required" >
						<option value="">Select Date Format</option>
						<option value="d-m-Y">d-m-Y</option>
						<option value="dd-mm-YY">dd-mm-YY</option>
						<option value="m/d/Y">m/d/Y</option>
						<option value="mm/dd/YY">mm/dd/YY</option>
						<option value="mm/dd/yyyy">mm/dd/yyyy</option>
						<option value="dd/mm/yyyy">dd/mm/yyyy</option>
						<option value="mm-dd-yyyy">mm-dd-yyyy</option>
						<option value="dd-mm-yyyy">dd-mm-yyyy</option>
						
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
						
						</div>
						
						
						
						<br><br>
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Date </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Date" id="Column_Date" type="text" placeholder="Enter Column No. Date" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of date">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Amount </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Amount"  id="Column_Amount"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Amount" required="required" data-error="Please enter column number of amount">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<br><br>
						<div class="form-group">
						
						<label for=""> Quantity </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Quantity"  id="Column_Quantity"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Quantity"  data-error="Please enter column number of quantity">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						
						<!--
						<div class="form-group">
						<label for="">Status </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Status"  id="Column_Status"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Status"  data-error="Please enter column number of status">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>-->
						
						
						
						
						
					</div>
				</div>
				<?php if($_SESSION['Privileges_Add_flag']==1){ ?>
				 <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register" >Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  <?php } ?>
				<?php echo form_close(); ?>
				
				</div>
			</div>
<!-------------------- START - Data Table -------------------->
	           <?php if($_SESSION['Privileges_View_flag']==1){ ?>
				<div class="element-wrapper">                
						<div class="element-box">
						  <h5 class="form-header">
						   Data Mapping Details
						  </h5>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Outlet Name</th>
										<th class="text-center">No. of Header Rows</th>
										<th class="text-center">Column of Date Format</th>
										<th class="text-center">Column of Date</th>
										<th class="text-center">Column of Membership ID</th>
										<th class="text-center">Column of Bill no.</th>
										<th class="text-center">Column of Amount</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Outlet Name</th>
										<th class="text-center">No. of Header Rows</th>
										<th class="text-center">Column of Date Format</th>
										<th class="text-center">Column of Date</th>
										<th class="text-center">Column of Membership ID</th>
										<th class="text-center">Column of Bill no.</th>
										<th class="text-center">Column of Amount</th>
											
									</tr>
								</tfoot>		

								<tbody>
								<?php
									if($results != NULL)
									{
										foreach($results as $row)
										{
											$Map_id = App_string_encrypt($row->Map_id);
											$Map_id = str_replace('+', 'X', $Map_id);
											$_SESSION[$Map_id]=$row->Map_id;
										?>
											<tr>
												<td class="row-actions"><?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
													<a href="<?php echo base_url()?>index.php/Data_transform/edit_data_map/?Map_id=<?php echo $Map_id;?>" title="Edit">
														<i class="os-icon os-icon-ui-49"></i>
													</a>
													<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>
													<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $Map_id;?>','<?php echo $row->First_name." ".$row->Last_name;?>','transaction data mapping','Data_transform/delete_data_mapping?Map_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
														<i class="os-icon os-icon-ui-15"></i>
													</a><?php } ?>
												</td>
												<td class="text-center"><?php echo $row->First_name." ".$row->Last_name; ?></td>
												<td><?php echo $row->Column_header_rows; ?></td>
												<td><?php echo $row->Column_date_format; ?></td>
												<td><?php echo $row->Column_Date; ?></td>
												<td><?php echo $row->Column_Customer; ?></td>
												<td><?php echo $row->Column_Bill_no; ?></td>
												<td><?php echo $row->Column_Amount; ?></td>
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
		<?php } ?>
<!--------------------  END - Data Table  -------------------->
				
			 
		  </div>
		</div>
	</div>
</div>			

<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	
	
	if( $('#Column_header_rows').val() != "" &&  $('#Column_date_format').val() != "" &&  $('#Column_Date').val() != "" &&  $('#Column_Customer').val() != "" &&  $('#Column_Bill_no').val() != "" && $('#Column_Amount').val() != "" && $('#Column_Seller_id').val() != ""  )
	{
		show_loader();
	}
});

var Val_array = new Array();
function checkVAL(v1,ID)
{
	
	var leng=Val_array.length;
	if(leng==0)
	{
		Val_array.push(v1);
	}
	for(var i=0;i<leng;i++)
	{
		//alert(v1);
		//alert(Val_array[i]);
		if(Val_array[i]==v1)
		{
			document.getElementById(ID).style.borderColor ="#A94442";
			document.getElementById(ID).value="";
			document.getElementById(ID).placeholder="Duplicate values";
		}
		else
		{
			Val_array.push(v1);
			document.getElementById(ID).style.borderColor ="";
		}
	}
}

	$('#Column_Seller_id').change(function()
	{
		var seller_id = $("#Column_Seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var enroll = '<?php echo $enroll; ?>';
		var Sub_seller_Enrollement_id = '<?php echo $Sub_seller_Enrollement_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_outlet_by_subadmin',
			success:function(opData4){
				$('#Column_outlet_id').html(opData4);
				if(Sub_seller_Enrollement_id > 0)
				{
					
					$("#Column_outlet_id option[value != '"+enroll+"']").remove();
					// $('#Column_outlet_id').append(new Option('amit', 'amit')); 
					// $('#Column_outlet_id').val(10);
				}
				
				
				// $('#Column_outlet_id').html('<option value="0" >All Outletssss</option>');
			}
		});
			
	});
</script>