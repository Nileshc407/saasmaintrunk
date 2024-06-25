<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   Reconciliation Data Mapping
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
					echo form_open('Reconsolation_data/insert_data_map',$attributes); ?>
					
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
						<label for=""> <span class="required_info">* </span>Publisher Name </label>
						<select class="form-control " name="Column_Seller_id" id="Column_Seller_id" required="required" data-error="Please select publisher name">
						<option value="">Select publisher name</option>							
							<?php foreach($Pubblisher as $publisher) {?>
								<option value="<?php echo $publisher['Register_beneficiary_id']; ?>"><?php echo $publisher['Beneficiary_company_name']; ?></option>
							<?php } ?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Number of Header Rows</label>								
						<input class="form-control" name="Column_header_rows"  id="Column_header_rows"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"  placeholder="Enter number of header rows" required="required" data-error="Please enter number of header rows">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					   <div class="form-group">
						<label for=""> <span class="required_info">* </span>Date</label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);" name="Column_Date" id="Column_Date" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter column no. of date " required="required" data-error="Please enter column number of date">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Publisher Identifier Id</label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);" name="Column_Customer" id="Column_Customer" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter column no. of joy coind identifier id" required="required" data-error="Please enter column number of joy coins identifier id">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Bill No. </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Bill_no"  id="Column_Bill_no"  type="text"  placeholder="Enter column no. of bill no." required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of bill no.">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Purchased Miles </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Amount"  id="Column_Amount"  type="text"  placeholder="Enter column no. of purchased miles" onkeyup="this.value=this.value.replace(/\D/g,'')" required="required" data-error="Please enter column number of purchased miles">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Status</label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);" name="Column_Status" id="Column_Status" type="text"  placeholder="Enter column no. of status" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of status">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Remarks</label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_remarks" id="Column_remarks" type="text" placeholder="Enter column no. of remarks etc" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of remarks">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Date Format</label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_date_format" id="Column_date_format" type="text" placeholder="Enter date gormat" required="required" data-error="Please enter date format">
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
function checkVAL(v1,ID,spanID)
{
	var leng=Val_array.length;
	if(leng==0)
	{
		Val_array.push(v1);
	}
	for(var i=0;i<leng;i++)
	{
		if(Val_array[i]==v1)
		{
			//alert("already exist");
			document.getElementById(ID).style.borderColor ="#A94442";
			document.getElementById(ID).value="";
			document.getElementById(ID).placeholder="Duplicate values";		
			//has_error(".has-feedback-"+spanID,"#"+spanID,".help-block-"+spanID,"Duplicate values");
		}
		else
		{
			//alert(v1);
			//has_success(".has-feedback-"+spanID,"#"+spanID,".help-block-"+spanID,'');			
			Val_array.push(v1);
			document.getElementById(ID).style.borderColor ="";
		}
	}
}
function delete_data_mapping(Map_id,Merchant)
{	
	var url = '<?php echo base_url()?>index.php/Reconsolation_data/delete_data_mapping?Map_id='+Map_id;
	BootstrapDialog.confirm("Are you sure to delete data map for merchant '"+Merchant+"' ?", function(result) 
	{
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
$('#Register').click(function()
{
	if( $('#Column_header_rows').val() != "" &&  $('#Column_date_format').val() != "" &&  $('#Column_Date').val() != "" &&  $('#Column_Customer').val() != "" &&  $('#Column_Bill_no').val() != "" && $('#Column_Amount').val() != "" && $('#Column_Status').val() != "" && $('#Column_Seller_id').val() != "" && $('#Column_remarks').val() != "" )
	{		
		show_loader();
	}
});
</script>