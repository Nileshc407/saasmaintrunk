<?php $this->load->view('header/header'); ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   ENROLLMENT DATA MAPPING
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
					echo form_open('Enrollement_data_transform/insert_data_map',$attributes); ?>
					
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
										if($Super_seller==0)
										{
											if($enroll==$seller_val->Enrollement_id)
											{
												echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
											}
										}
										else
										{
											echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
										}
									}
								?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Number of Header Rows </label>								
						<input class="form-control" name="Column_header_rows"  id="Column_header_rows"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Number of Header Rows" required="required" data-error="Please enter number of header rows">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					   <div class="form-group">
						<label for=""> <span class="required_info">* </span>First Name </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_First_Name"  id="Column_First_Name"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. First Name" required="required" data-error="Please enter column number of first name">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Last Name </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Last_Name"  id="Column_Last_Name"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Last Name" required="required" data-error="Please enter column number of last name">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Address </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Address"  id="Column_Address"  type="text"  placeholder="Enter Column No. Address" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of address">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Phone No </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Phone_No"  id="Column_Phone_No"  type="text"  placeholder="Enter Column No. Phone Number" onkeyup="this.value=this.value.replace(/\D/g,'')" required="required" data-error="Please enter column number of phone number">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>User Email ID </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_User_Email_ID"  id="Column_User_Email_ID"  type="text"  placeholder="Enter Column No. Email ID" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of email">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Membership ID </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Membership_ID" id="Column_Membership_ID" type="text" placeholder="Enter Column No. Membership ID" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of membership id">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Date </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Date" id="Column_Date" type="text" placeholder="Enter Column No. Date" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of date">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					  
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
										<th class="text-center">Column of Date</th>
										<th class="text-center">Column of First Name</th>
										<th class="text-center">Column of Last Name</th>
										<th class="text-center">Column of Address</th>
										<th class="text-center">Column of Phone No</th>
										<th class="text-center">Column of User Email ID</th>
										<th class="text-center">Column of Membership ID</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Merchant Name</th>
										<th class="text-center">No. of Header Rows</th>
										<th class="text-center">Column of Date</th>
										<th class="text-center">Column of First Name</th>
										<th class="text-center">Column of Last Name</th>
										<th class="text-center">Column of Address</th>
										<th class="text-center">Column of Phone No</th>
										<th class="text-center">Column of User Email ID</th>
										<th class="text-center">Column of Membership ID</th>
											
									</tr>
								</tfoot>		

								<tbody>
								<?php
									// var_dump($results);
									if($results != NULL)
									{
										foreach($results as $row)
										{
										?>
											<tr>
												<td class="row-actions">
													<a href="<?php echo base_url()?>index.php/Enrollement_data_transform/edit_data_map/?Map_id=<?php echo $row->Map_id;?>" title="Edit">
														<i class="os-icon os-icon-ui-49"></i>
													</a>
							
													<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Map_id;?>','<?php echo $row->First_name." ".$row->Last_name;?>','enrollment data mapping','Enrollement_data_transform/delete_data_mapping?Map_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
														<i class="os-icon os-icon-ui-15"></i>
													</a>
												</td>
												<td><?php echo $row->First_name." ".$row->Last_name; ?></td>
												<td><?php echo $row->Column_header_rows; ?></td>
												<td><?php echo $row->Column_Date; ?></td>
												<td><?php echo $row->Column_First_Name; ?></td>
												<td><?php echo $row->Column_Last_Name; ?></td>
												<td><?php echo $row->Column_Address; ?></td>
												<td><?php echo $row->Column_Phone_No; ?></td>
												<td><?php echo $row->Column_User_Email_ID; ?></td>
												<td><?php echo $row->Column_Membership_ID; ?></td>
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
	
	if( $('#Column_header_rows').val() != "" &&  $('#Column_First_Name').val() != "" &&  $('#Column_Phone_No').val() != "" &&  $('#Column_User_Email_ID').val() != "" &&  $('#Column_Membership_ID').val() != "" &&  $('#Column_Date').val() != "" )
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
</script>