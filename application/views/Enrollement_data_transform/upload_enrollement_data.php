<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">STEP 1: UPLOAD ENROLLEMENT DATA FILE</h6>
                    <div class="element-box">
					
					
						<?php
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
						<?php } ?>
						  
						  
						  
					 <?php
                          $attributes = array('class' => 'dropzone dz-clickable','id' => 'formValidate');
                          echo form_open_multipart('Enrollement_data_transform/upload_data', $attributes);
                        ?>						 
						
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
												if($FinSub_seller_Enrollement_id==$seller_val->Enrollement_id)//Fianance login
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
						<select class="form-control " name="outlet_id"   id="Column_outlet_id" required="required" >
						<option value="0">Select Merchant First</option>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
                                           						
                        
							<div class="dz-message">
								<div>
									<h4>Drop files here or click to upload.<br /><br /></h4>
								</div>
							</div>						                                         
						<br> 
						<input type="hidden" id="seller" name="seller" value="<?php echo $enroll; ?>"/>
						<?php echo form_close(); ?>						
                    </div>		
					
					
                </div>
            </div>
            <div class="col-sm-5">
				<div class="col-md-12">
					<div class="element-wrapper">
						<h6 class="element-header"><span class="required_info">* NOTES</span></h6>
						<div class="element-box">	
							<div class="profile-tile">											
								<div class="profile-tile-meta">
									<ul>
										
										<li>
											<span class="required_info">*maximum upload file size 1 MB</span>
										</li>										
										<li>
											<span class="required_info"><br>Please check the blank cell before uploading excel file</span>	
										</li>
									</ul>								  
								</div>								
							</div>			
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>	
</div>		
<?php $this->load->view('header/footer'); ?>
<script>

/* CallOwnUrl function defined in dropzone.js */

function CallOwnUrl(){
	// console.log('CallOwnUrl');
	// alert();
	window.location.href = '<?php echo base_url(); ?>index.php/Enrollement_data_transform/verify_data_file';
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
				/* if(Sub_seller_Enrollement_id > 0)
				{
					
					$("#Column_outlet_id option[value != '"+enroll+"']").remove();
					// $('#Column_outlet_id').append(new Option('amit', 'amit')); 
					// $('#Column_outlet_id').val(10);
				} */
				
				
				// $('#Column_outlet_id').html('<option value="0" >All Outletssss</option>');
			}
		});
			
	});
</script>
<style>
	.dropzone{
		border: none !IMPORTANT;
		border-radius: none !IMPORTANT;
	}
	.dz-message{
		border: 2px dashed #047bf8;
		border-radius: 6px;
	}
</style>