<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">STEP 2: Select Checkbox and Process the data</h6>
                    <div class="element-box">
						 <?php
						 $attributes = array('id' => 'formValidate');
                         echo form_open('Reconsolation_data/Reconsolation_verify_data_file', $attributes);
						  
						  
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
							<?php }	?>
							<?php if($Upload_errors != NULL) { ?>
							
									<h5 class="form-header"> <font color="red">File Upload Errors</font> | <font color="green">File Name:<?php echo $filename; ?></font></h5>                  
										<div class="table-responsive">
											<table id="dataTable2" class="table table-striped table-lightfont">
												<thead>
													<tr>
														<th>Trans Date</th>
														<th>Error</th>
														<th>Identifier</th>
														<th>Bill No.</th>
														<th>Purchase <?php echo $publisher_Currency; ?></th>
														<th>Status</th>
														<th>Remarks</th>
																	
													</tr>									
												</thead>
												<tfoot>
														<th>Trans Date</th>
														<th>Error</th>
														<th>Identifier</th>
														<th>Bill No.</th>
														<th>Purchase <?php echo $publisher_Currency; ?></th>
														<th>Status</th>
														<th>Remarks</th>
												</tfoot>
												<tbody>
													<?php
														$todays=date("Y-m-d");
														foreach($Upload_errors as $rower)
														{					
															if($rower->Transaction_amount > 0)
															{
																$Transaction_amount=$rower->Transaction_amount;
															} else{
																$Transaction_amount="";
															}
															if($rower->Status==44){
																$Status='Pending';
															} else if($rower->Status==45){
																$Status='Approved';
															} else if($rower->Status==46){
																$Status='Cancelled';
															} else {
																$Status='-';
															} 
															// echo "----Status----".$rower->Status."--<br>";

															if($rower->Transaction_date=='0000-00-00 00:00:00'){

																$Transaction_date="";
																
															}else{								

																$Transaction_date= date('Y-m-d',strtotime($rower->Transaction_date));
															}
											
														?>
															<tr>									
																<td><?php echo $rower->Error_transaction_date; ?></td>
																<td><?php echo "Row no.".$rower->Error_row_no." ".$rower->Error_in; ?></td>
																<td><?php echo $rower->Card_id; ?></td>
																<td><?php echo $rower->Bill_no; ?></td>
																<td><?php echo $Transaction_amount; ?></td>
																<td><?php echo $Status; ?></td>
																<td><?php echo $rower->Remarks; ?></td>
															</tr>
														<?php
													}									
													?>							
												</tbody> 
											</table>
										</div>
							
							<?php }	?>				
							
					</div>
						
                </div>
				
				
				<?php
				if ($UploadData != NULL) {  
				?>
				
				<div class="element-wrapper">                
					<div class="element-box">
						<h5 class="form-header"><font color="green">File Valid Data</font><font color="green" size='1em'>&nbsp;&nbsp;(Valid Purchase <?php echo $publisher_Currency; ?> File Data)</font></h5>                  
						<div class="table-responsive">
							<table id="dataTable2" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th>#</th>
										<th>Trans Date</th>
										<th>Identifier</th>
										<th>Bill No.</th>
										<th>Purchase <?php echo $publisher_Currency; ?></th>
										<th>Status</th>
										<th>Remarks</th>
													
									</tr>									
								</thead>
								<tfoot>
										<th>#</th>
										<th>Trans Date</th>
										<th>Identifier</th>
										<th>Bill No.</th>
										<th>Purchase <?php echo $publisher_Currency; ?></th>
										<th>Status</th>
										<th>Remarks</th>
								</tfoot>
								<tbody>
									<?php
										$todays=date("Y-m-d");
										foreach($UploadData as $row)
										{					
											if($row->Status==44){
											$Status='Pending';
											} else if($row->Status==45){
												$Status='Approved';
											} else if($row->Status==46){
												$Status='Cancelled';
											} else {
												$Status='-';
											}
							
										?>
											<?php if($row->Status==45) { ?>
												<tr style="color:green"> 

													<td><input type="Checkbox" class="checkbox1 user-success" name="upload_id[]" value="<?php echo $row->upload_id.'_'.$row->Pos_Customerno.'_'.$row->Pos_Billno.'_'.$row->Pos_Billamt.'_'.$row->Remarks.'_'.$row->Status; ?>"></td>
													<td><?php echo $row->Pos_Transdate; ?></td>
													<td><?php echo $row->Pos_Customerno; ?></td>
													<td><?php echo $row->Pos_Billno; ?></td>
													<td><?php echo $row->Pos_Billamt; ?></td>
													<td><?php echo $Status; ?></td>                                        
													<td><?php echo $row->Remarks; ?></td>
													
												</tr>
												<?php } else { ?>

													<tr style="color:red"> 

													<td><input type="Checkbox" class="checkbox1 user-success" name="upload_id[]" value="<?php echo $row->upload_id.'_'.$row->Pos_Customerno.'_'.$row->Pos_Billno.'_'.$row->Pos_Billamt.'_'.$row->Remarks.'_'.$row->Status; ?>"></td>
													<td><?php echo $row->Pos_Transdate; ?></td>
													<td><?php echo $row->Pos_Customerno; ?></td>
													<td><?php echo $row->Pos_Billno; ?></td>
													<td><?php echo $row->Pos_Billamt; ?></td>
													<td><?php echo $Status; ?></td>
													<td><?php echo $row->Remarks; ?></td>
													
												</tr>

												<?php } ?>
										<?php
									}									
									?>							
								</tbody> 
							</table>
						</div>
					</div>
				</div>				
				<?php } ?>
				
				
				<?php if($UploadData != NULL) { ?>
					<div class="form-buttons text-center">
						<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Submit</button>
						<div class="help-block form-text with-errors form-control-feedback" id="SubmitBTN"></div>
					</div>
				<?php } if($UploadData == NULL) { ?>
					<div class="form-buttons text-center">
						<button type="submit" name="Recolation_files_errors" value="Register" id="Recolation_files_errors" class="btn btn-primary">Send Errors</button>
					</div>
				<?php }
				?>
				
				
				<?php 
						echo form_close();						
						?>
				
            </div>
			
			
           
        </div>
    </div>	
</div>	

	
<?php $this->load->view('header/footer'); ?>
<script>


$("#Recolation_files_errors").click(function() 
{
	show_loader();
});

$("#Register").click(function() 
{
	var count_checked = $("[name='upload_id[]']:checked").length; // count the checked rows
	if(count_checked == 0) 
	{
		
		/* var Title = "Application Information";
		var msg = 'Please select atleast one checkbox for Process Reconcilation';
		runjs(Title,msg); */
		
		$('#SubmitBTN').html('Please select atleast one checkbox for Process Reconcilation');
		return false;
	} 
	else{
		
		show_loader();
	}
	
});


</script>
