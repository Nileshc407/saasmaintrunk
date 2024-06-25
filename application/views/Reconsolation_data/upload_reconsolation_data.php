<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">STEP 1: UPLOAD RECONCILIATION DATA FILE</h6>
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
                          echo form_open_multipart('Reconsolation_data/Reconsolation_upload_data', $attributes);
                        ?>
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span>Select Publisher</label>
                            <select class="form-control" name="publisher" id="publisher" data-error="Select Publisher" required="required">
							<?php foreach($Pubblisher as $publisher) {?>
									
									<option value="<?php echo $publisher['Register_beneficiary_id']; ?>"><?php echo $publisher['Beneficiary_company_name']; ?></option>

							<?php }?>
							</select>
                            <div class="help-block form-text with-errors form-control-feedback" id="publisherID"></div>
                        </div>						
                        
							<div class="dz-message">
								<div>
									<h4>Drop files here or click to upload.<br /><br /></h4>
								</div>
							</div>						                                         
						<br>                        
                    </div>
					<?php /* ?>
					<div class="element-box">
						<div class="form-buttons text-center">                            
							<button class="btn btn-primary" type="submit"> Submit</button>
						</div>
					</div>
					<?php */ ?>
					
					<?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-sm-5">
				<div class="col-md-12" id="GiftCardUserInfo">
					<div class="element-wrapper">
						<h6 class="element-header"><span class="required_info">* NOTES</span></h6>
						<div class="element-box">	
							<div class="profile-tile">											
								<div class="profile-tile-meta">
									<ul>
										<li>
											<span class="required_info">*select merchant and then upload flat file</span>
										</li>
										<li>
											<span class="required_info">*maximum upload file size 1 MB</span>
										</li>												
										<li>
											<span class="required_info"><br>*Supported Date Formats (&nbsp; mm/dd/yy, &nbsp; mm/dd/yyyy,  &nbsp;yyyy-mm-dd, &nbsp; dd-mm-yyyy,&nbsp;dd-mmm-yyyy &nbsp;)</span>
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
	
	if($('#publisher').val() !="" || $('#publisher').val() !=0)
	{
		$("#publisherID").html("");
		$("#publisher").removeClass("has-error");
		window.location.href = '<?php echo base_url(); ?>index.php/Reconsolation_data/Reconsolation_verify_data_file';
		
	}else{
		
		$("#publisherID").html("Please Select Merchant and then select file");
		$("#publisher").addClass("form-control has-error");
	}
	
}
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