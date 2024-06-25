<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   Edit Reconciliation Data Mapping
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
					echo form_open('Reconsolation_data/update_data_map',$attributes); ?>
					
				<div class="row">
					<div class="col-md-12">					
						<h6 class="form-group"> <span class="required_info">* Enter Column Numbers (Indexing start from 0, means column 1 is 0, 2 is 1 and  so on..)<br>* Please do not enter duplicate Column no.</span></h6>
					</div>
				</div>
						
				<div class="row">
					<div class="col-sm-12 col-md-6">
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Company Name </label>
						<select class="form-control " name="Column_Company_id"  required="required" disabled>
						 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>
					  </div>		  		
									  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Publisher Name </label>
						<select class="form-control " name="Column_Seller_id" id="Column_Seller_id" required="required" data-error="Please select publisher name" disabled>
							<?php foreach($Pubblisher as $publisher) {?>
								<option value="<?php echo $publisher['Register_beneficiary_id']; ?>" <?php if($Records->Column_Seller_id==$publisher['Register_beneficiary_id']){echo "selected";}?> ><?php echo $publisher['Beneficiary_company_name']; ?></option>
							<?php } ?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group"> 
						<label for=""> <span class="required_info">* </span>Number of Header Rows</label>								
						<input class="form-control" name="Column_header_rows" id="Column_header_rows" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter number of header rows" required="required" data-error="Please enter number of header rows" value="<?php echo $Records->Column_header_rows;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					   <div class="form-group">
						<label for=""> <span class="required_info">* </span>Date</label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);" onfocus="removeVal(this.value,this.id);" name="Column_Date" id="Column_Date" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter column no. of date " required="required" data-error="Please enter column number of date" value="<?php echo $Records->Column_Date;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Publisher Identifier Id</label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);" onfocus="removeVal(this.value,this.id);" name="Column_Customer" id="Column_Customer" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter column no. of joy coind identifier id" required="required" data-error="Please enter column number of joy coins identifier id" value="<?php echo $Records->Column_Customer;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					</div> 
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Bill No. </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  onfocus="removeVal(this.value,this.id);" name="Column_Bill_no"  id="Column_Bill_no"  type="text"  placeholder="Enter column no. of bill no." required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of bill no." value="<?php echo $Records->Column_Bill_no;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Purchased Miles </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  onfocus="removeVal(this.value,this.id);" name="Column_Amount"  id="Column_Amount"  type="text"  placeholder="Enter column no. of purchased miles" onkeyup="this.value=this.value.replace(/\D/g,'')" required="required" data-error="Please enter column number of purchased miles" value="<?php echo $Records->Column_Amount;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Status</label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);" onfocus="removeVal(this.value,this.id);" name="Column_Status" id="Column_Status" type="text"  placeholder="Enter column no. of status" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of status" value="<?php echo $Records->Column_Status;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Remarks</label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);" onfocus="removeVal(this.value,this.id);" name="Column_remarks" id="Column_remarks" type="text" placeholder="Enter column no. of remarks etc" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of remarks" value="<?php echo $Records->Column_remarks;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Date Format</label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  onfocus="removeVal(this.value,this.id);" name="Column_date_format" id="Column_date_format" type="text" placeholder="Enter date gormat" required="required" data-error="Please enter date format" value="<?php echo $Records->Column_date_format;?>">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						<span class="required_info">Supported Date Formats ((d-m-Y &nbsp; dd-mm-YY &nbsp; m/d/Y &nbsp; mm/dd/YY  &nbsp; dd/mm/yyyy )) &nbsp;)</span>
						<br>
						<span class="required_info">Note: ("d-m-Y"  &  "dd-mm-YY" formats are Same Use  "d-m-Y" ) AND (  "m/d/Y"  &  "mm/dd/YY"  formats are Same Use  "m/d/Y")</span>
					  
					</div>
				</div>				
				<div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register" >Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
					<input type="hidden"   name="Map_id"  value="<?php echo $Records->Map_id;?>"/>
					<input type="hidden" name="Data_map_for" value="3">		
				</div>				  
				<?php echo form_close(); ?>
			</div>
			</div>
				<!-------------------- START - Data Table -------------------->
				<div class="element-wrapper">                
					<div class="element-box">
					  <h5 class="form-header">
					  Reconciliation Data Map Details
					  </h5>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Pubblisher Name</th>
									<th>No. of Header Rows</th>
									<th>Column of Date Format</th>
									<th>Column of Date</th>
									<th>Column of Identifier ID</th>
									<th>Column of Bill no.</th>
									<th>Column of Purchase Miles</th>
									<th>Column of Status</th>
									<th>Column of Remarks</th>
									
								</tr>
							</thead>	
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Pubblisher Name</th>
									<th>No. of Header Rows</th>
									<th>Column of Date Format</th>
									<th>Column of Date</th>
									<th>Column of Identifier ID</th>
									<th>Column of Bill no.</th>
									<th>Column of Purchase Miles</th>
									<th>Column of Status</th>
									<th>Column of Remarks</th>
										
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
												<a href="<?php echo base_url()?>index.php/Reconsolation_data/edit_data_map/?Map_id=<?php echo $row->Map_id;?>" title="Edit">
												<i class="os-icon os-icon-ui-49"></i>
												</a>
						 
												<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Map_id;?>','<?php echo $row->Beneficiary_company_name;?>','Reconciliation data mapping','Reconsolation_data/delete_data_mapping?Map_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
												<i class="os-icon os-icon-ui-15"></i>
												</a>
											</td>
											<td><?php echo $row->Beneficiary_company_name; ?></td>
											<td><?php echo $row->Column_header_rows; ?></td>
											<td><?php echo $row->Column_date_format; ?></td>
											<td><?php echo $row->Column_Date; ?></td>
											<td><?php echo $row->Column_Customer; ?></td>
											<td><?php echo $row->Column_Bill_no; ?></td>
											<td><?php echo $row->Column_Amount; ?></td>
											<td><?php echo $row->Column_Status; ?></td>
											<td><?php echo $row->Column_remarks; ?></td>
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
var Val_array = new Array();
document.onload = setArray();

function setArray() {       
	
	Val_array.push(document.querySelector('#Column_Customer').value);
	Val_array.push(document.querySelector('#Column_Bill_no').value);
	Val_array.push(document.querySelector('#Column_Amount').value);
	Val_array.push(document.querySelector('#Column_Status').value);
	Val_array.push(document.querySelector('#Column_remarks').value);
	Val_array.push(document.querySelector('#Column_date_format').value);
	Val_array.push(document.querySelector('#Column_Date').value);
	
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
$('#Register').click(function()
{
	if( $('#Column_header_rows').val() != "" &&  $('#Column_date_format').val() != "" &&  $('#Column_Date').val() != "" &&  $('#Column_Customer').val() != "" &&  $('#Column_Bill_no').val() != "" && $('#Column_Amount').val() != "" && $('#Column_Status').val() != "" && $('#Column_Seller_id').val() != "" && $('#Column_remarks').val() != "" )
	{		
		show_loader();
	}
});
</script>