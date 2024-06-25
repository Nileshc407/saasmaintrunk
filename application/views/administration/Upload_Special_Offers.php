<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   Upload Special Offer Images
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
				echo form_open_multipart('Administration/Upload_Special_Offers',$attributes); ?>	
				<div class="row">
		  <div class="col-sm-6">
				  <div class="form-group">
					<label for="">Company Name</label>
					<select class="form-control" name="Company_id"  required="required">
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option> 
					</select>
				  </div>  
				  
				  
				<div class="panel-heading">
							<label for="">Upload Images of Special Offers<br><font color="RED" align="center" size="0.8em"><i>* Preferred Image size should be 340 ( horizontal) X 170 ( Vertical) Pixels. Also the file size should be less than 200KB<br>* Note: If the above resolution is not complied the  images will not look as desired</i></font></label>
						</div>
					
						<div class="panel-body">
						
							<div class="row">
							
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-left"><strong>Offer Image-1</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image1" class="img-responsive" style="width: 40%;">									
										<div class="caption">
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file1" id="file1" onchange="readImage(this,'#no_image1');" style="width: 100%;" data-error="Please select merchandise item image-1" />
													<div class="help-block form-text with-errors form-control-feedback"></div>
												</div>
												
											</div>
										</div>
										<!--Sequence No.<input type='number' value="1" name='SequenceNo1'  id='SequenceNo1' onchange="check_sequence(id,this.value);" required>
										<div class="help-block form-text with-errors form-control-feedback" id="ErrorSequenceNo1" style="display:none;">Already exist</div>-->
									</div>
								</div>
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-left"><strong>Offer Image-2</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image2" class="img-responsive" style="width: 40%;">
										
										<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file2"  id="file2" onchange="readImage(this,'#no_image2');" style="width: 100%;" data-error="Please select merchandise item image-2" />
													<div class="help-block form-text with-errors form-control-feedback"></div>
												</div>
											</div>
											<!--Sequence No.<input type='number' value="2" name='SequenceNo2' id='SequenceNo2'  onchange="check_sequence(id,this.value);"  required>
											<div class="help-block form-text with-errors form-control-feedback" id="ErrorSequenceNo2" style="display:none;">Already exist</div>-->
									</div>
								</div>
								
							
								
							</div>
							
						</div>
						
					

					</div>
				  
				    <div class="col-sm-6">
					
					<div class="form-group">
					<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
					<select class="form-control" name="seller_id" ID="seller_id" data-error="Please Select Business/Merchant Name"    required="required">
						<option value="">Select Business/Merchant</option>
						<?php
								/* if($Logged_user_id == 2 || $Super_seller == 1)
								{
									echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
								} */
								
								foreach($Seller_array as $seller_val)
								{
									echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
								}
							?> 
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
				  </div>  
				  
							
					
					
						
						<div class="panel-body">
						<div class="panel-heading">
							<label for="">&nbsp;  <br><font color="RED" align="center" size="0.8em"><i>&nbsp; </i></font>&nbsp;  <br>&nbsp; <br>&nbsp;</label>
						</div>
							<div class="row">
							
								
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-left"><strong>Offer Image-3</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image3" class="img-responsive" style="width: 40%;">
										
										<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file3" onchange="readImage(this,'#no_image3');" style="width: 100%;" />
												</div>
											</div>
											<!--Sequence No.<input type='number' name='SequenceNo3'id='SequenceNo3'  value="3"  onchange="check_sequence(id,this.value);"  required>
											<div class="help-block form-text with-errors form-control-feedback" id="ErrorSequenceNo3" style="display:none;">Already exist</div>-->
									</div>
								</div>
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-left"><strong>Offer Image-4</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image4" class="img-responsive" style="width: 40%;">
										
										<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file4" onchange="readImage(this,'#no_image4');" style="width: 100%;" />
												</div>
											</div>
											<!--Sequence No.<input type='number' name='SequenceNo4' id='SequenceNo4' value="4"  onchange="check_sequence(id,this.value);"  required>
											<div class="help-block form-text with-errors form-control-feedback" id="ErrorSequenceNo4" style="display:none;">Already exist</div>-->
									</div>
								</div>
								
							</div>
								
								
								
								
							</div>
						</div>	
				
					<div class="row">
							
								<div class="table-responsive" id='Uploaded_images'></div>
						
					</div>
					
				</div>	
					
					
				  
				  
				  <div class="form-buttons-w"  align="center">
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>


	<!--------------Table------------->
	  
		
		
		
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Special Offer Images
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Action</th>
							<th>Business/Merchant Name</th>
							
						</tr>
						
					</thead>						
					 
					<tbody>
				<?php
						$todays = date("Y-m-d");
						
						if($results2 != NULL)
						{
							foreach($results2 as $row)
							{
									
							?>
						<tr>
									<td>
										<a href="<?php echo base_url()?>index.php/Administration/Edit_special_offer_images/?Brand_id=<?php echo $row->Brand_id;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										
										<a href="javascript:void(0);" class="danger"  onclick="delete_me('<?php echo $row->Brand_id;?>','All Special offer images for selected Business/Merchant','','Administration/delete_special_offer_images/?Brand_id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
											<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									
									<td><?php echo $row->First_name." ".$row->Last_name;?></td>
									
									
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
	</div> 
	<!--------------Table--------------->
	
	
</div>			
<?php $this->load->view('header/footer'); ?>

      
<script>	
var seq_arr = new Array('1','2','3','4');
// alert(seq_arr);
function readImage(input,div_id) 
	{
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$(div_id)
					.attr('src', e.target.result)
					.height(100);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}
	function check_sequence(id,valS)
	{
		// alert(seq_arr);
		// alert(valS);
		
		if(seq_arr.includes(valS) == true)
		{
			$('#Error'+id).show();
			// var prev_val = $('#'+id).val();
			$('#'+id).val('0');
			 seq_arr = new Array($('#SequenceNo1').val(),$('#SequenceNo2').val(),$('#SequenceNo3').val(),$('#SequenceNo4').val());
			 // alert(seq_arr);
		}
		else
		{
			$('#Error'+id).hide();
			 $('#'+id).val(valS);
			 seq_arr = new Array($('#SequenceNo1').val(),$('#SequenceNo2').val(),$('#SequenceNo3').val(),$('#SequenceNo4').val());
			 // alert(seq_arr);
			// alert('Not exist');
		}
		
		// seq_arr = new Array();
		// alert(seq_arr);
		// $('#'+id).val(valS);
		// alert(id);
		// alert(valS);
	}
	
/* $('#seller_id').change(function()
	{
		var Brand_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		
		$.ajax({
			type:"POST",
			data:{Brand_id:Brand_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Administration/Get_brands_special_images_sequence/',
			success:function(opData2){
				// alert(opData2.Image_sequence);
				$('#Uploaded_images').html(opData2.Image_sequence);
				
			}
		});
		
				
			
	});	 */
</script>
