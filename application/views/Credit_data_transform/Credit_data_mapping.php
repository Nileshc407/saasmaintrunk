<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   CREDIT TRANSACTION DATA MAPPING
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
					echo form_open('Credit_data_transform/insert_data_map',$attributes); ?>
					
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

						 <option value="<?php echo $Company_id; ?>"><?php echo $Company_name; ?></option>
						</select>
						</div>		  		
									  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Merchant Name (Business/Merchant)</label>
						<select class="form-control " name="Column_Seller_id"  id="Column_Seller_id" required="required" data-error="Please select merchant name">
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
					</div>
					<div class="col-sm-12 col-md-6">
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Membership ID </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Membership_ID" id="Column_Membership_ID" type="text" placeholder="Enter Column No. Membership ID" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of membership id">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
						
					<div class="form-group">
						<label for=""> <span class="required_info">* </span>Bill No. </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Bill_no"  id="Column_Bill_no"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. Bill No" required="required" data-error="Please enter column number of bill number">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Credit Points </label>								
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Credit_Points"  id="Column_Credit_Points"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"   placeholder="Enter Column No. of Credit Points" required="required" data-error="Please enter column number of Credit Points">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					 <div class="form-group">
						<label for=""> <span class="required_info">* </span>Remarks </label>
						<input class="form-control" onchange="checkVAL(this.value,this.id);"  name="Column_Remarks" id="Column_Remarks" type="text" placeholder="Enter Column No. of Remarks" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter column number of Remarks">
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
										<th class="text-center">Outlet Name</th>
										<th class="text-center">No. of Header Rows</th>
										<th class="text-center">Column of Membership ID</th>
										<th class="text-center">Column of Bill No.</th>
										<th class="text-center">Column of Credit Points</th>
										<th class="text-center">Column of Remarks</th>
										<th class="text-center">Column of Date</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Outlet Name</th>
										<th class="text-center">No. of Header Rows</th>
										<th class="text-center">Column of Membership ID</th>
										<th class="text-center">Column of Bill No.</th>
										<th class="text-center">Column of Credit Points</th>
										<th class="text-center">Column of Remarks</th>
										<th class="text-center">Column of Date</th>
											
									</tr>
								</tfoot>		

								<tbody>
								<?php
									// var_dump($results);
									if($results != NULL)
									{
										foreach($results as $row)
										{
											$Map_id = App_string_encrypt($row->Map_id);
											$Map_id = str_replace('+', 'X', $Map_id);
											$_SESSION[$Map_id]=$row->Map_id;
										?>
											<tr>
												<td class="row-actions">
													<a href="<?php echo base_url()?>index.php/Credit_data_transform/edit_data_map/?Map_id=<?php echo $Map_id;?>" title="Edit">
														<i class="os-icon os-icon-ui-49"></i>
													</a>
							
													<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $Map_id;?>','<?php echo $row->First_name." ".$row->Last_name;?>','Credit Transaction data mapping','Credit_data_transform/delete_data_mapping?Map_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
														<i class="os-icon os-icon-ui-15"></i>
													</a>
												</td>
												<td><?php echo $row->First_name." ".$row->Last_name; ?></td>
												<td><?php echo $row->Column_header_rows; ?></td>
												<td><?php echo $row->Column_Membership_ID; ?></td>
												<td><?php echo $row->Column_Bill_no; ?></td>
												<td><?php echo $row->Column_Amount; ?></td>
												<td><?php echo $row->Column_remarks; ?></td>
												<td><?php echo $row->Column_Date; ?></td>
												
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
	if( $('#Column_header_rows').val() != "" &&  $('#Column_Remarks').val() != "" &&  $('#Column_Credit_Points').val() != "" &&  $('#Column_Bill_no').val() != "" &&  $('#Column_Membership_ID').val() != "" &&  $('#Column_Date').val() != ""  &&  $('#Column_outlet_id').val() != "" )
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