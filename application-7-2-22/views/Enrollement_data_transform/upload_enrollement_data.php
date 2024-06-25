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
	window.location.href = '<?php echo base_url(); ?>index.php/Enrollement_data_transform/verify_data_file';
}
</script>
