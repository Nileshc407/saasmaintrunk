<?php $this->load->view('header/header'); ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   EDIT TRANSACTION DATA MAPPING
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
					echo form_open('Data_transform/update_data_map',$attributes); ?>
					
					<div class="row">
						<div class="col-md-12">					
							<h6 class="form-group"> <span class="required_info">* Enter Column Numbers (Indexing start from 0, means column 1 is 0, 2 is 1 and  so on..)<br>* Please do not enter duplicate Column no.</span></h6>
						</div>
					</div>
						
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Company Name </label>
						<select class="form-control " name="Column_Company_id"  required="required">

						 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>
						</div>		  		
									  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Merchant Name </label>
						<select class="form-control " name="Column_Seller_id" id="Column_Seller_id" required="required" data-error="Please select merchant name">
						<option value="">Select Merchant</option>							
								<?php
									foreach($Seller_array as $seller_val)
									{
								?>
									<option value="<?php echo $seller_val->Enrollement_id;?>" <?php if($Records->Column_Seller_id==$seller_val->Enrollement_id){echo "selected";}?>><?php echo $seller_val->First_name." ".$seller_val->Last_name;?></option>
								<?php }
								?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Number of Header Rows </label>								
						<input class="form-control" name="Column_header_rows"  id="Column_header_rows"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Number of Header Rows" required="required" data-error="Please enter number of header rows" value="<?php echo $Records->Column_header_rows;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>

						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Membership ID </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Customer" id="Column_Customer" type="text" placeholder="Enter Column No. Membership ID" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of membership id" value="<?php echo $Records->Column_Customer;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Date </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Date" id="Column_Date" type="text" placeholder="Enter Column No. Date" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of date" value="<?php echo $Records->Column_Date;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Bill No. </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Bill_no"  id="Column_Bill_no"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Bill No" required="required" data-error="Please enter column number of bill number" value="<?php echo $Records->Column_Bill_no;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Amount </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Amount"  id="Column_Amount"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Amount" required="required" data-error="Please enter column number of amount" value="<?php echo $Records->Column_Amount;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
					</div>
					<div class="col-sm-12 col-md-6">
					
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Payment Type </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Payment_type"  id="Column_Payment_type"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Payment Type" required="required" data-error="Please enter column number of payment type" value="<?php echo $Records->Column_Payment_type;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Quantity </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Quantity"  id="Column_Quantity"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Quantity" required="required" data-error="Please enter column number of quantity" value="<?php echo $Records->Column_Quantity;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Item Code </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Item_Code"  id="Column_Item_Code"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Item Code" required="required" data-error="Please enter column number of item code" value="<?php echo $Records->Column_Item_Code;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Status </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Status"  id="Column_Status"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Status" required="required" data-error="Please enter column number of status" value="<?php echo $Records->Column_Status;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Remarks </label>	
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_remarks"  id="Column_remarks"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Remarks" required="required" data-error="Please enter column number of remarks"  value="<?php echo $Records->Column_remarks;?>" onfocus="removeVal(this.value,this.id);">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Date Format </label>	
						<input class="form-control" name="Column_date_format" id="Column_date_format"  type="text"  placeholder="Enter Date Format" required="required" data-error="Please enter date format" value="<?php echo $Records->Column_date_format;?>" onkeyup="this.value=this.value.replace(/\d/g,'')" >
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">					
					<h6 class="form-group"> 
						<span class="required_info">Note: Supported Date Formats ((d-m-Y &nbsp; dd-mm-YY &nbsp; m/d/Y &nbsp; mm/dd/YY &nbsp; dd/mm/yyyy ) &nbsp;)</span>
						<br>
						<span class="required_info"> ("d-m-Y"  &  "dd-mm-YY" formats are Same Use  "d-m-Y" ) AND (  "m/d/Y"  &  "mm/dd/YY"  formats are Same Use  "m/d/Y")</span>
						</div>
						<input type="hidden"   name="Map_id"  value="<?php echo $Records->Map_id;?>"/>
						<input type="hidden" name="Data_map_for" value="2">	
					</h6>
					</div>
				</div>
				 <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register" >Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>
				
				</div>
			</div>
<!-------------------- START - Data Table -------------------->
	           
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
										<th class="text-center">Merchant Name</th>
										<th class="text-center">No. of Header Rows</th>
										<th class="text-center">Column of Date Format</th>
										<th class="text-center">Column of Date</th>
										<th class="text-center">Column of Membership ID</th>
										<th class="text-center">Column of Bill no.</th>
										<th class="text-center">Column of Amount</th>
										<th class="text-center">Column of Payment type</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Merchant Name</th>
										<th class="text-center">No. of Header Rows</th>
										<th class="text-center">Column of Date Format</th>
										<th class="text-center">Column of Date</th>
										<th class="text-center">Column of Membership ID</th>
										<th class="text-center">Column of Bill no.</th>
										<th class="text-center">Column of Amount</th>
										<th class="text-center">Column of Payment type</th>
											
									</tr>
								</tfoot>		

								<tbody>
								<?php
									if($results != NULL)
									{
										foreach($results as $row)
										{
										?>
											<tr>
												<td class="row-actions">
													<a href="<?php echo base_url()?>index.php/Data_transform/edit_data_map/?Map_id=<?php echo $row->Map_id;?>" title="Edit">
														<i class="os-icon os-icon-ui-49"></i>
													</a>
													
													<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Map_id;?>','<?php echo $row->First_name." ".$row->Last_name;?>','transaction data mapping','Data_transform/delete_data_mapping?Map_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
														<i class="os-icon os-icon-ui-15"></i>
													</a>
												</td>
												<td class="text-center"><?php echo $row->First_name." ".$row->Last_name; ?></td>
												<td><?php echo $row->Column_header_rows; ?></td>
												<td><?php echo $row->Column_date_format; ?></td>
												<td><?php echo $row->Column_Date; ?></td>
												<td><?php echo $row->Column_Customer; ?></td>
												<td><?php echo $row->Column_Bill_no; ?></td>
												<td><?php echo $row->Column_Amount; ?></td>
												<td><?php echo $row->Column_Payment_type; ?></td>
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
		
<!--------------------  END - Data Table  -------------------->
				
			 
		  </div>
		</div>
	</div>
</div>			

<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	
	
	if( $('#Column_header_rows').val() != "" &&  $('#Column_date_format').val() != "" &&  $('#Column_Date').val() != "" &&  $('#Column_Customer').val() != "" &&  $('#Column_Bill_no').val() != "" && $('#Column_Amount').val() != "" && $('#Column_Payment_type').val() != "" && $('#Column_Seller_id').val() != "" && $('#Column_remarks').val() != "" )
	{
		show_loader();
	}
});

var Val_array = new Array();
document.onload = setArray();

function setArray() {
	
	Val_array.push(document.querySelector('#Column_Date').value);
	Val_array.push(document.querySelector('#Column_Customer').value);
	Val_array.push(document.querySelector('#Column_Bill_no').value);
	Val_array.push(document.querySelector('#Column_Amount').value);
	Val_array.push(document.querySelector('#Column_Payment_type').value);
	Val_array.push(document.querySelector('#Column_Quantity').value);
	Val_array.push(document.querySelector('#Column_Item_Code').value);
	Val_array.push(document.querySelector('#Column_Status').value);
	Val_array.push(document.querySelector('#Column_remarks').value);
	
	//alert(Val_array);
}

function removeVal(v2,ElementId){
	
	let pos = Val_array.indexOf(v2);
	if(pos > 0){
		Val_array.splice(pos,1);
	}
	//alert(Val_array);
}

function checkVAL(v1,ID)
{
	var leng=Val_array.length;
	if(leng==0)
	{
		Val_array.push(v1);
	}
	for(var i=0;i<leng;i++)
	{
		//alert(Val_array[i]);
		if(Val_array[i]==v1)
		{
			document.getElementById(ID).style.borderColor ="#A94442";
			document.getElementById(ID).value="";
			document.getElementById(ID).placeholder="Duplicate values";
			break;
		}
		else
		{
			let pos = Val_array.indexOf(v1);
			if(pos < 1){
		//alert(Val_array);
				Val_array.push(v1);
				document.getElementById(ID).style.borderColor ="";
			}
		}
	}
}
</script>