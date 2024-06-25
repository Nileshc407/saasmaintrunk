<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">STEP 2: Verify Enrollment Data</h6>
                    

						 <?php
						 $attributes = array('id' => 'formValidate');
                         echo form_open('Enrollement_data_transform/verify_data_file', $attributes);
						  
						  
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
                          <?php }

							if ($file_status == 3 && $UploadData == NULL) {
								echo '<div class="text-center"><font color="red">Enrollement not found between from date and till date!</font></div>';
							}
							?>
					
					
						<!--<div id="lp_info">	
						
						</div> -->	
						
                </div>
				<!-------------------- START - Upload_errors Data Table -------------------->	  
				<?php	
				// print_r($Upload_errors);
				if($Upload_errors != NULL) {
				?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            <font color="red">File Upload Errors </font>| <font color="green">Upload File: <?php echo $filename; ?> </font>
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>							
										<th>Serial No.</th>	
										<th>Error(s)</th>	
									</tr>
                                </thead>						
                                <tfoot>
									<tr>							
										<th>Serial No.</th>	
										<th>Error(s)</th>	
									</tr>
                                </tfoot>
                                <tbody>
                                      <?php
									  $i=1;
									  $todays=date("Y-m-d");
										foreach ($Upload_errors as $rower) {
											
											$Filename=$rower->File_name;
											$Companyid=$rower->Company_id;
										  ?>
											  <tr>

												  <td><?php echo $i; ?></td>
												  <td><?php echo "Row no.".$rower->Error_row_no." ".$rower->Error_in; ?></td>

											  </tr>
										  <?php
										  $i++;
										}
										?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>	  
					<?php if ($UploadData == NULL) { ?>				  
						<div class="form-buttons text-center">
							<button type="submit" name="Upload_files_errors" value="Upload_files_errors" id="Upload_files_errors" class="btn btn-primary">Send Errors</button>
						</div>				  
					<?php } ?>
				<?php } ?>                
                <!--------------------  END - Upload_errors Data Table  -------------------->
				
				<!-------------------- START - UploadData Data Table -------------------->	  
				<?php
				if ($UploadData != NULL) { ?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                           <font color="green">File Valid Data</font>
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
										<th>Enrollment Date</th>
										<th>First Name</th>
										<th>Last Name.</th>
										<th>Address</th>
										<th>Membership ID</th>	
										<th>Phone No.</th>						
										<th>User Email Id</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Enrollment Date</th>
										<th>First Name</th>
										<th>Last Name.</th>
										<th>Address</th>
										<th>Membership ID</th>	
										<th>Phone No.</th>						
										<th>User Email Id</th>
                                    </tr>
                                </tfoot>
                                <tbody>
									<?php
									$todays = date("Y-m-d");
									foreach($UploadData as $row) {
									?>
										<tr>
											<td><?php echo $row->Date; ?></td>
											<td><?php echo $row->First_Name; ?></td>
											<td><?php echo $row->Last_Name; ?></td>
											<td><?php echo $row->Address; ?></td>
											<td><?php echo $row->Membership_ID; ?></td>
											<td><?php echo $row->Phone_No; ?></td>
											<td><?php echo $row->User_Email_ID; ?></td>
										</tr>
									<?php
									}
									?>
                                </tbody>
                            </table>
                        </div>						
                    </div>
				</div>
				<div class="element-box">
					<div class="form-buttons text-center">
						<input type="hidden" name="file_status" value="<?php echo $file_status; ?>" />	
						<button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
				<?php } ?>                
                <!--------------------  END - UploadData Data Table  -------------------->
				<?php 
					echo form_close();  ?>
            </div>           
        </div>
    </div>	
</div>	
<?php $this->load->view('header/footer'); ?>
<script>
	$('#submit').blur(function ()
	{
		show_loader();
	})
 </script>
