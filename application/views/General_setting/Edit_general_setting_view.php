<?php $this->load->view('header/header');?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				FRONT END TEMPLATE SETTINGS
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
			<?php 	} 
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
			<?php 	} ?>
				
			<?php $attributes = array('id' => 'formValidate');
					echo form_open_multipart('General_setting',$attributes); 
					
					
						
					// echo"---Seller_id----".$Seller_id."----<br>";
						
					$Count_mobile_template = $this->General_setting_model->Company_template_count($Company_details->Company_id,$Seller_id);
					
					$General = $this->General_setting_model->get_type_name_by_id('frontend_settings','General', 'value',$Company_details->Company_id,$Seller_id);
					$General_info_data = json_decode($General, true);
					
					$Small_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Small_font', 'value',$Company_details->Company_id,$Seller_id);
					$Small_font_data = json_decode($Small_font, true);
					
					$Medium_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Medium_font', 'value',$Company_details->Company_id,$Seller_id);
					$Medium_font_data = json_decode($Medium_font, true);
					
					$Large_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Large_font', 'value',$Company_details->Company_id,$Seller_id);
					$Large_font_data = json_decode($Large_font, true);
					
					$Extra_large_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Extra_large_font', 'value',$Company_details->Company_id,$Seller_id);
					$Extra_large_font_data = json_decode($Extra_large_font, true);
					
					$Value_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Value_font', 'value',$Company_details->Company_id,$Seller_id);
					$Value_font_data = json_decode($Value_font, true);
					
					$Footer_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Footer_font', 'value',$Company_details->Company_id,$Seller_id);
					$Footer_font_data = json_decode($Footer_font, true);			
					
					$Button_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Button_font', 'value',$Company_details->Company_id,$Seller_id);
					$Button_font_data = json_decode($Button_font, true);
					
					$Placeholder_font = $this->General_setting_model->get_type_name_by_id('frontend_settings','Placeholder_font', 'value',$Company_details->Company_id,$Seller_id);
					$Placeholder_font_data = json_decode($Placeholder_font, true);
					
					$Menu_access = $this->General_setting_model->get_type_name_by_id('frontend_settings','Menu_access', 'value',$Company_details->Company_id,$Seller_id);					
					$Menu_access_data = json_decode($Menu_access, true);
				?>
					
					<div class="row">
						<div class="col-md-6">
							<fieldset class="form-group">
							<legend><span>General Configuration</span></legend>	
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Company Name </label>
									<select class="form-control" name="Company_id"  id="Company_id" required="required">

									 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
									</select>
								</div>
								<?php //var_dump($Sellers_details); ?>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Select Brand </label>
									<select class="form-control" name="Seller_id"  id="Seller_id" required="required">
										<?php foreach($Sellers_details as $seller) { 
											if($Seller_id==0){ ?>
												<option value="0" selected>All Brand</option>												
										<?php } else if($Seller_id==$seller->Enrollement_id){ ?>
												<option value="<?php echo $seller->Enrollement_id; ?>" selected><?php echo $seller->First_name.' '.$seller->Last_name; ?></option>
										<?php } else { ?>
												<option value="<?php echo $seller->Enrollement_id; ?>"><?php echo $seller->First_name.' '.$seller->Last_name; ?></option>
										<?php } ?>
											
									 <?php } ?>
									</select>
								</div>	
									
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Application Title</label>
									<input type="text" name="Application_title" id="Application_title" class="form-control" value="<?php if(!empty($General_info_data)){echo $General_info_data[0]['Application_title'];} else{echo $General_info_data[0]['Application_title'];}?>" placeholder="Application Title" required="required" data-error="Please enter application title"/>
									<div class="help-block form-text with-errors form-control-feedback" id="pname"></div>									
								</div>

								<div class="form-group">
									<label for="">Application Image</label>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="Application_image_flag" type="radio" id="Application_image_flag" onclick="return HideShowAppImage(1);"  value="yes" <?php if($General_info_data[0]['Application_image_flag'] =='yes' ){ echo 'checked';} ?> required="required">Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input class="form-check-input" name="Application_image_flag" id="Application_image_flag" type="radio" onclick="return HideShowAppImage(0)" value="no" <?php if($General_info_data[0]['Application_image_flag'] =='no' ){ echo 'checked';} ?> required="required">No</label>
									  </div> 
									</div>
								  </div>

								<?php if($General_info_data[0]['Application_image_flag'] =='yes' ) {  ?>
									<div class="form-group" id="App_iamge_div" >										
										<label for="exampleInputEmail1"><span class="required_info">* </span>Application Background Image</label>
										
										<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
										<input type="file" name="application" id="application" onchange="readImage(this,'#Theme_image');"  />
										</div>
							
										
										<br>
										<?php $Theme_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'application', 'value',$Company_details->Company_id,$Seller_id);
										// echo "-----Theme_image--if---".$Theme_image."---<br>";
										 if(!empty($Theme_image))
										{ ?>
											<img id="blah" src="<?php echo base_url(); ?><?php echo $Theme_image; ?>" id="Theme_image" class="img-responsive custom_img">
											
											<input type="hidden" name="Theme_image_hdn" id="Theme_image_hdn" value="<?php echo $Theme_image; ?>" >
										<?php
										} else {
										?>
										<img id="blah" src="<?php echo base_url(); ?>images/no_image.jpeg" id="Theme_image" class="img-responsive custom_img">
										<?php } ?>						
									</div>
									
									<div class="form-group" id="App_bg_color_div"style="display:none;">
										<label for="exampleInputEmail1">Theme Color </label><br>
										<input type="color" style="width:30%;height: 6%;" name="Theme_color" id="Theme_color"  value="<?php if(!empty($General_info_data)){echo $General_info_data[0]['Theme_color'];} else{echo '#41c5a2';}?>" required="required">				
									</div>

							<?php } else { ?>	
								<div class="form-group" id="App_iamge_div" style="display:none;">										
									<label for="exampleInputEmail1"><span class="required_info">* </span>Application Background Image</label>
									<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
									<input type="file" name="application" id="application" onchange="readImage(this,'#Theme_image');"  />
									</div>
									<br>
									<?php $Theme_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'application', 'value',$Company_details->Company_id,$Seller_id);
									// echo "-----Theme_image--else---".$Theme_image."---<br>";
									 if(!empty($Theme_image))
									{ ?>
										<img src="<?php echo base_url(); ?><?php echo $Theme_image; ?>" id="Theme_image" class="img-responsive custom_img">
										
										<input type="hidden" name="Theme_image_hdn" id="application" value="<?php echo $Theme_image; ?>" >
									<?php
									} else {
									?>
									<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="Theme_image" class="img-responsive custom_img">
									<?php } ?>						
								</div>
								
								<div class="form-group" id="App_bg_color_div" >
									<label for="exampleInputEmail1">Theme Color </label><br>
									<input type="color" name="Theme_color" id="Theme_color"  value="<?php if(!empty($General_info_data)){echo $General_info_data[0]['Theme_color'];} else{echo '#41c5a2';}?>" required="required">				
								</div>
								
							<?php }  ?>	
										
								<div class="form-group">
										
									<label for="exampleInputEmail1"><span class="required_info">* </span>Content Background Transparent</label><br>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="Header_transparent" type="radio" id="Header_transparent" onclick="return HideShow_Header_transparent(1)" value="yes" <?php if($General_info_data[0]['Header_transparent'] =='yes' ){ echo 'checked';} ?> required="required">Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input class="form-check-input" name="Header_transparent" id="Header_transparent" type="radio" onclick="return HideShow_Header_transparent(0)" value="no" <?php if($General_info_data[0]['Header_transparent'] =='no' ){ echo 'checked';} ?> required="required">No</label>
									  </div> 
									</div>										
								</div>

								<?php if($General_info_data[0]['Header_transparent'] =='no' ) {  ?>
									<div class="form-group" id="Header_Colour_div" >
										
										<label for="exampleInputEmail1"><span class="required_info">* </span>Colour</label><br>
										<input type="color" name="Header_color" id="Header_color"  value="<?php if(!empty($General_info_data)){ echo $General_info_data[0]['Header_color'];} else{echo '#ffffff';}?>">
									</div>	
									<div class="form-group" id="Header_Colour_opacity_div" style="display:none">
										<label for="exampleInputEmail1"><span class="required_info">* </span>opacity</label><br>
										<input type="text" class="form-control" name="Header_color_opacity" id="Header_color_opacity" placeholder="Transperency value" required="required" value="<?php if(!empty($General_info_data)){ echo $General_info_data[0]['Header_color_opacity'];} else{echo '0';}?>" data-error="Please enter transperency(blur) value">
									</div>
									<div class="help-block form-text with-errors form-control-feedback"></div>	
									
								<?php } else {  ?>
									<div class="form-group" id="Header_Colour_div" style="display:none">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Colour</label><br>
										<input type="color" name="Header_color" id="Header_color"  value="<?php if(!empty($General_info_data)){ echo $General_info_data[0]['Header_color'];} else{echo '#ffffff';}?>">
									</div>
									<div class="form-group" id="Header_Colour_opacity_div" >
										<label for="exampleInputEmail1"><span class="required_info">* </span>opacity</label><br>
										<input type="text" class="form-control" name="Header_color_opacity" id="Header_color_opacity" placeholder="Transperency value" required="required" value="<?php if(!empty($General_info_data)){ echo $General_info_data[0]['Header_color_opacity'];} else{echo '0';}?>" data-error="Please enter transperency(blur) value">
									</div>
									<div class="help-block form-text with-errors form-control-feedback"></div>	
								<?php }  ?>
								<div class="form-group" id="Show_States">
								
									<label for="exampleInputEmail1"><span class="required_info">* </span>Theme Icon Color</label><br>
									<div class="col-sm-8" style=" margin-top:7px;">
									 
									 <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="Theme_icon_color" type="radio" id="Theme_icon_color" value="black" <?php if($General_info_data[0]['Theme_icon_color'] =='black' ){ echo 'checked';} ?> required="required">Black</label>
									  </div>
									  
									  <div class="form-check" style="float:left; margin-left:5px;">
										<label class="form-check-label">
										<input class="form-check-input" name="Theme_icon_color" id="Theme_icon_color" type="radio" onclick="return HideShow_Header_transparent(0)" value="grey" <?php if($General_info_data[0]['Theme_icon_color'] =='green' ){ echo 'checked';} ?> required="required">Grey</label>
									  </div>

										<div class="form-check" style="float:left; margin-left:5px;">
										<label class="form-check-label">
										<input class="form-check-input" name="Theme_icon_color" id="Theme_icon_color" type="radio" onclick="return HideShow_Header_transparent(0)" value="white" <?php if($General_info_data[0]['Theme_icon_color'] =='white' ){ echo 'checked';} ?> required="required">White</label>
									  </div>									  
									</div>						
								</div>	
															
							</fieldset>
							<fieldset class="form-group">
							<legend><span>Button Font Configuration (add to Cart, Wishlist etc.)</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Font Colour</label>
									<input type="color" name="Button_font_color" id="Button_font_color"  value="<?php if(!empty($Button_font_data)){echo $Button_font_data[0]['Button_font_color'];} else{echo '#515f58';}?>" >
								</div>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Background Color  </label>
									<input type="color" name="Button_background_color" id="Button_background_color"  value="<?php if(!empty($Button_font_data)){echo $Button_font_data[0]['Button_background_color'];} else{echo '#515f58';}?>" >
								</div>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Border Color  </label>
									<input type="color" name="Button_border_color" id="Button_border_color"  value="<?php if(!empty($Button_font_data)){echo $Button_font_data[0]['Button_border_color'];} else{echo '#515f58';}?>" >
								</div>
								
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Button_font_family" id="Button_font_family">
								<option value="">Select Font Family</option>
									<?php 
										foreach($Fontfamily as $font) {
										if($Button_font_data[0]['Button_font_family'] == $font['Code_decode']) {
										?>
											<option value="<?php echo $Button_font_data[0]['Button_font_family']; ?>" selected><?php echo $Button_font_data[0]['Button_font_family']; ?></option>
										<?php 
										} else {
											?>
												<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Button_font_size" id="Button_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=16;
									for($i=1; $i<=$FontSize; $i++) {									
									$ipx=$i.'px';
									if(trim($Button_font_data[0]['Button_font_size']) == $ipx ) {
										?>
											<option value="<?php echo $Button_font_data[0]['Button_font_size']; ?>" selected><?php echo $Button_font_data[0]['Button_font_size']; ?></option>
										<?php 
										}
										else { ?>
											<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>		
							</fieldset>
							<fieldset class="form-group">
							<legend><span>Sub Heading Font Configuration (Membership Id, Item Name etc.)</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span> Font Colour </label>
									<input type="color" name="Medium_font_color" id="Medium_font_color"  value="<?php if(!empty($Medium_font_data)){echo $Medium_font_data[0]['Medium_font_color'];} else{echo '#515f58';}?>" >
								</div>
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Medium_font_family" id="Medium_font_family">
								<option value="">Select Font Family</option>
									<?php 
									foreach($Fontfamily as $font) {
										if($Medium_font_data[0]['Medium_font_family'] == $font['Code_decode']) {
										?>
											<option value="<?php echo $Medium_font_data[0]['Medium_font_family']; ?>" selected><?php echo $Medium_font_data[0]['Medium_font_family']; ?></option>
										<?php 
										} else {
											?>
												<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Medium_font_size" id="Medium_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=24;
									for($i=12; $i<=$FontSize; $i++) {
										
										$ipx=$i.'px';
										if(trim($Medium_font_data[0]['Medium_font_size']) == $ipx ) {
											?>
												<option value="<?php echo $Medium_font_data[0]['Medium_font_size']; ?>" selected><?php echo $Medium_font_data[0]['Medium_font_size']; ?></option>
											<?php 
											}
											else { ?>
												<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
												<?php
											}
										} ?>
									</select>
								</div>		
							
							</fieldset>
							
							<fieldset class="form-group">
							<legend><span>Heading Font Configuration ( Member name, Merchant name etc. )</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Font Colour </label>
									<input type="color" name="Large_font_color" id="Large_font_color"  value="<?php if(!empty($Large_font_data)){ echo $Large_font_data[0]['Large_font_color'];} else { echo '#515f58'; }?>" >
								</div>
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Large_font_family" id="Large_font_family">
								<option value="">Select Font Family</option>
									<?php 
									foreach($Fontfamily as $font) {
										if($Large_font_data[0]['Large_font_family'] == $font['Code_decode']) {
										?>
											<option value="<?php echo $Large_font_data[0]['Large_font_family']; ?>" selected><?php echo $Large_font_data[0]['Large_font_family']; ?></option>
										<?php 
										} else {
											?>
												<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Large_font_size" id="Large_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=30;
									for($i=18; $i<=$FontSize; $i++) {									
									$ipx=$i.'px';
									if(trim($Large_font_data[0]['Large_font_size']) == $ipx ) {
										?>
											<option value="<?php echo $Large_font_data[0]['Large_font_size']; ?>" selected><?php echo $Large_font_data[0]['Large_font_size']; ?></option>
										<?php 
										}
										else { ?>
											<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>		
							
							</fieldset>
						</div>
						<div class="col-md-6">
							<fieldset class="form-group">
							<legend><span>Title Font Configuration ( Profile, Dashboard etc. )</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Font Colour </label>
									<input type="color" name="Extra_large_font_color" id="Extra_large_font_color" value="<?php if(!empty($Extra_large_font_data)){echo $Extra_large_font_data[0]['Extra_large_font_color'];} else{echo '#515f58';}?>" >
								</div>
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Extra_large_font_family" id="Extra_large_font_family">
								<option value="">Select Font Family</option>
									<?php 
									foreach($Fontfamily as $font) {
										if($Extra_large_font_data[0]['Extra_large_font_family'] == $font['Code_decode']) {
										?>
											<option value="<?php echo $Extra_large_font_data[0]['Extra_large_font_family']; ?>" selected><?php echo $Extra_large_font_data[0]['Extra_large_font_family']; ?></option>
										<?php 
										} else {
											?>
												<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Extra_large_font_size" id="Extra_large_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=36;
									for($i=18; $i<=$FontSize; $i++) {									
									$ipx=$i.'px';
									if(trim($Extra_large_font_data[0]['Extra_large_font_size']) == $ipx ) {
										?>
											<option value="<?php echo $Extra_large_font_data[0]['Extra_large_font_size']; ?>" selected><?php echo $Extra_large_font_data[0]['Extra_large_font_size']; ?></option>
										<?php 
										}
										else { ?>
											<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>		
							
							</fieldset>
							
							<fieldset class="form-group">
							<legend><span>Value Font Configuration ( Email Id, Phone no etc.)</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Font Colour</label>
									<input type="color" name="Value_font_color" id="Value_font_color" value="<?php if(!empty($Value_font_data)){echo $Value_font_data[0]['Value_font_color'];} else{echo '#515f58';}?>"  >
								</div>
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Value_font_family" id="Value_font_family">
								<option value="">Select Font Family</option>
									<?php 
										foreach($Fontfamily as $font) {
											if($Value_font_data[0]['Value_font_family'] == $font['Code_decode']) {
											?>
												<option value="<?php echo $Value_font_data[0]['Value_font_family']; ?>" selected><?php echo $Value_font_data[0]['Value_font_family']; ?></option>
											<?php 
											} else {
												?>
													<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
												<?php
											}
										} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Value_font_size" id="Value_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=14;
									for($i=1; $i<=$FontSize; $i++) {									
									$ipx=$i.'px';
									if(trim($Value_font_data[0]['Value_font_size']) == $ipx ) {
										?>
											<option value="<?php echo $Value_font_data[0]['Value_font_size']; ?>" selected><?php echo $Value_font_data[0]['Value_font_size']; ?></option>
										<?php 
										}
										else { ?>
											<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>		
							</fieldset>
							
							<fieldset class="form-group" style="margin-bottom: 115px;">
							<legend><span>Label Font Configuration (First name, Last name etc. )</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Font Colour</label>
									<input type="color" name="Small_font_color" id="Small_font_color"  value="<?php if(!empty($Small_font_data)){echo $Small_font_data[0]['Small_font_color'];} else{echo '#515f58';}?>">
								</div>
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Small_font_family" id="Small_font_family">
								<option value="">Select Font Family</option>
								<?php 
									foreach($Fontfamily as $font) {
									if($Small_font_data[0]['Small_font_family'] == $font['Code_decode']) {
										?>
											<option value="<?php echo $Small_font_data[0]['Small_font_family']; ?>" selected><?php echo $Small_font_data[0]['Small_font_family']; ?></option>
										<?php 
										}
										else {
											?>
												<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Small_font_size" id="Small_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=14;
									for($i=1; $i<=$FontSize; $i++) { 
										
										$ipx=$i.'px';
										if(trim($Small_font_data[0]['Small_font_size']) == $ipx ) {
											?>
												<option value="<?php echo $Small_font_data[0]['Small_font_size']; ?>" selected><?php echo $Small_font_data[0]['Small_font_size']; ?></option>
											<?php 
											}
											else { ?>
												<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
												<?php
											}
										}
									?>
									</select>
								</div>
							</fieldset>
							
							<fieldset class="form-group">
							<legend><span>Footer Font Configuration ( Footer Home, Mystatement etc. )</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Background Color  </label>
									<input type="color" name="Footer_background_color" id="Footer_background_color"  value="<?php if(!empty($Footer_font_data)){echo $Footer_font_data[0]['Footer_background_color'];} else{echo '#515f58';}?>" >
								</div>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Font Colour </label>
									<input type="color" name="Footer_font_color" id="Footer_font_color"  value="<?php if(!empty($Footer_font_data)){echo $Footer_font_data[0]['Footer_font_color'];} else{echo '#515f58';}?>"  >
								</div>
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Footer_font_family" id="Footer_font_family">
								<option value="">Select Font Family</option>
									<?php 
										foreach($Fontfamily as $font) {
										if($Footer_font_data[0]['Footer_font_family'] == $font['Code_decode']) {
										?>
											<option value="<?php echo $Footer_font_data[0]['Footer_font_family']; ?>" selected><?php echo $Footer_font_data[0]['Footer_font_family']; ?></option>
										<?php 
										} else {
											?>
												<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Footer_font_size" id="Footer_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=16;
									for($i=1; $i<=$FontSize; $i++) {									
									$ipx=$i.'px';
									if(trim($Footer_font_data[0]['Footer_font_size']) == $ipx ) {
										?>
											<option value="<?php echo $Footer_font_data[0]['Footer_font_size']; ?>" selected><?php echo $Footer_font_data[0]['Footer_font_size']; ?></option>
										<?php 
										}
										else { ?>
											<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>		
							</fieldset>
							
							<fieldset class="form-group" style="margin-top: -1px;">
							<legend><span>Placeholder Font Configuration ( Enter first name,Enter last name etc. )</span></legend>
								<div class="form-group">
									<label for=""> <span class="required_info">* </span>Font Colour</label>
									<input type="color" name="Placeholder_font_color" id="Placeholder_font_color"  value="<?php if(!empty($Placeholder_font_data)){echo $Placeholder_font_data[0]['Placeholder_font_color'];} else {echo '#515f58';}?>">
								</div>
								
								<div class="form-group">
								<label for=""> Font Family </label>
								<select class="form-control " name="Placeholder_font_family" id="Placeholder_font_family">
								<option value="">Select Font Family</option>
									<?php 
										foreach($Fontfamily as $font) {
										if($Placeholder_font_data[0]['Placeholder_font_family'] == $font['Code_decode']) {
										?>
											<option value="<?php echo $Placeholder_font_data[0]['Placeholder_font_family']; ?>" selected><?php echo $Placeholder_font_data[0]['Placeholder_font_family']; ?></option>
										<?php 
										} else {
											?>
												<option value="<?php echo $font['Code_decode']; ?>"><?php echo $font['Code_decode']; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>	
								<div class="form-group">
								<label for=""> Font Size </label>
								<select class="form-control " name="Placeholder_font_size" id="Placeholder_font_size">
								<option value="">Select Font Size</option>
								<?php 
									$FontSize=11;
									for($i=1; $i<=$FontSize; $i++) {									
									$ipx=$i.'px';
									if(trim($Placeholder_font_data[0]['Placeholder_font_size']) == $ipx ) {
										?>
											<option value="<?php echo $Placeholder_font_data[0]['Placeholder_font_size']; ?>" selected><?php echo $Placeholder_font_data[0]['Placeholder_font_size']; ?></option>
										<?php 
										}
										else { ?>
											<option value="<?php echo $ipx; ?>"><?php echo $ipx; ?></option>
											<?php
										}
									} ?>
									</select>
								</div>		
							</fieldset>	
						</div>
					</div>
					<fieldset class="form-group">
					<legend><span>Home Page Icons Configuration</span></legend>
					<div class="row">
						<?php if($Company_details->Dashboard_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $dashboard_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'dashboard', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($dashboard_image))
							{ ?>
								<img src="<?php echo base_url(); ?><?php echo $dashboard_image; ?>" id="dashboard" class="card-img-top img-responsive custom_img">
								<input type="hidden" name="dashboard_image_hdn" id="dashboard_image_hdn" value="<?php echo $dashboard_image; ?>" >
							<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/dashboard.png" id="dashboard" class="card-img-top img-responsive custom_img">
							<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Dashboard</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Dashboard_flag"  id="Dashboard_flag"  value="1"  <?php if($Menu_access_data[0]['Dashboard_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Dashboard_flag" id="Dashboard_flag"  value="0"  <?php if($Menu_access_data[0]['Dashboard_flag']==0 ){echo "checked";} ?> >No
										
										<br>
										<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="dashboard" onchange="readImage(this,'#dashboard');" />
										</div>
									</p>
								 
								</div>
							  </div>
							</div>
						<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img class="card-img-top img-responsive custom_img" src="<?php echo base_url(); ?>images/icon/template_icon/dashboard.png" alt="Card image" >
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text" >Please contact administrative to enable dashboard module</p>
									</div>
								</div>
							  </div>
						<?php } ?>  
						<?php if($Company_details->Profile_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $profile_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'profile', 'value',$Company_details->Company_id,$Seller_id);
								if(!empty($profile_image))
								{ ?>
									<img src="<?php echo base_url(); ?><?php echo $profile_image; ?>" id="profile" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="profile_image_hdn" id="profile_image_hdn" value="<?php echo $profile_image; ?>" >
									
								<?php
								} else {
								?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/profile.png" id="profile" class="card-img-top img-responsive custom_img" >
							<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Profile</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Profile_flag"  id="Profile_flag"  value="1"  <?php if($Menu_access_data[0]['Profile_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Profile_flag" id="Profile_flag"  value="0"  <?php if($Menu_access_data[0]['Profile_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
											<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="profile" onchange="readImage(this,'#profile');" />
										</div>
									</p>
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/profile.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable profile module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
							
						<?php if($Company_details->Ecommerce_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $shopping_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'shopping', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($shopping_image))
							{ ?>
								<img src="<?php echo base_url(); ?><?php echo $shopping_image; ?>" id="shopping" class="card-img-top img-responsive custom_img">
								<input type="hidden" name="shopping_image_hdn" id="shopping_image_hdn" value="<?php echo $shopping_image; ?>" > 
								
							<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/shopping.png" id="shopping" class="card-img-top img-responsive custom_img" >
							<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Shopping</strong></label>
									<p class="card-text">
									<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Ecommerce_flag"  id="Ecommerce_flag"  value="1"  <?php if($Menu_access_data[0]['Ecommerce_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Ecommerce_flag" id="Ecommerce_flag"  value="0"  <?php if($Menu_access_data[0]['Ecommerce_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="shopping" onchange="readImage(this,'#shopping');"  />
										</div>
									</p>
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/shopping.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable e-ccommerce module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
					</div>
					<div class="row">
						<?php if($Company_details->Redeem_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							  <?php $redeem_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'redeem', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($redeem_image))
							{ ?>
								<img src="<?php echo base_url(); ?><?php echo $redeem_image; ?>" id="redeem"  class="card-img-top img-responsive custom_img" >
								<input type="hidden" name="redeem_image_hdn" id="redeem_image_hdn" value="<?php echo $redeem_image; ?>" >
							<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/redeem.png" id="redeem"  class="card-img-top img-responsive custom_img" >
							<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Redeem</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Redeem_flag"  id="Redeem_flag"  value="1"  <?php if($Menu_access_data[0]['Redeem_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Redeem_flag" id="Redeem_flag"  value="0"  <?php if($Menu_access_data[0]['Redeem_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="redeem" onchange="readImage(this,'#redeem');"  />
										</div>
									</p>
								</div>
							  </div>
							</div>
						<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/redeem.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable redemption module</p>
									</div>
								</div>
							  </div>
						<?php } ?>  
						<?php if($Company_details->Offer_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $offers_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'offers', 'value',$Company_details->Company_id,$Seller_id);
								if(!empty($offers_image))
								{ ?>
									<img src="<?php echo base_url(); ?><?php echo $offers_image; ?>" id="offers" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="offers_image_hdn" id="offers_image_hdn" value="<?php echo $offers_image; ?>" >
								<?php
								} else {
								?>
									<img src="<?php echo base_url(); ?>images/icon/template_icon/offers.png" id="offers" class="card-img-top img-responsive custom_img" >
								<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Offers</strong></label>
									<p class="card-text">
									<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Offer_flag"  id="Offer_flag"  value="1"  <?php if($Menu_access_data[0]['Offer_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Offer_flag" id="Offer_flag"  value="0"  <?php if($Menu_access_data[0]['Offer_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="offers" onchange="readImage(this,'#offers');"  />
										</div>
									</p>
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/offers.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable offer module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
							
						<?php if($Company_details->Transfer_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $points_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'transfer_points', 'value',$Company_details->Company_id,$Seller_id);
								if(!empty($points_image))
								{ ?>
									<img src="<?php echo base_url(); ?><?php echo $points_image; ?>" id="points" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="points_image_hdn" id="points_image_hdn" value="<?php echo $points_image; ?>" >
								<?php
								} else {
								?>
									<img src="<?php echo base_url(); ?>images/icon/template_icon/points.png" id="points" class="card-img-top img-responsive custom_img" >
								<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Transfer Points</strong></label>
									<p class="card-text">
									<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Transfer_flag"  id="Transfer_flag"  value="1"  <?php if($Menu_access_data[0]['Transfer_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Transfer_flag" id="Transfer_flag"  value="0"  <?php if($Menu_access_data[0]['Transfer_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
											<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="transfer_points" onchange="readImage(this,'#points');"  />
										</div>
									</p>
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img  src="<?php echo base_url(); ?>images/icon/template_icon/points.png"  alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable transfer module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
					</div>
					<div class="row">
						<?php if($Company_details->Transfer_accross_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							  <?php $transfer_across_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'transfer_across', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($transfer_across_image))
							{ ?>
								<img src="<?php echo base_url(); ?><?php echo $transfer_across_image; ?>" id="transfer_across" class="card-img-top img-responsive custom_img" >
								<input type="hidden" name="transfer_across_image_hdn" id="transfer_across_image_hdn" value="<?php echo $transfer_across_image; ?>" >
							<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/across.png" id="transfer_across" class="card-img-top img-responsive custom_img" >
							<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Transfer Across</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Transfer_accross_flag"  id="Transfer_accross_flag"  value="1"  <?php if($Menu_access_data[0]['Transfer_accross_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Transfer_accross_flag" id="Transfer_accross_flag"  value="0"  <?php if($Menu_access_data[0]['Transfer_accross_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
											<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="transfer_across" onchange="readImage(this,'#transfer_across');"  />
										</div>
									</p>
								 
								</div>
							  </div>
							</div>
						<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/across.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable transfer accross module</p>
									</div>
								</div>
							  </div>
						<?php } ?> 

						<?php if($Company_details->Add_membership_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $Add_membership_flag = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Add_membership', 'value',$Company_details->Company_id,$Seller_id);
								if(!empty($Add_membership_flag))
								{ ?>
									<img src="<?php echo base_url(); ?><?php echo $Add_membership_flag; ?>" id="membership" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="membership_image_hdn" id="membership_image_hdn" value="<?php echo $Add_membership_flag; ?>" >
								<?php
								} else {
								?>
									<img src="<?php echo base_url(); ?>images/icon/template_icon/membership.png" id="membership" class="card-img-top img-responsive custom_img" >
								<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Add Membership</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Add_membership_flag"  id="Add_membership_flag"  value="1"  <?php if($Menu_access_data[0]['Add_membership_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Add_membership_flag" id="Add_membership_flag"  value="0"  <?php if($Menu_access_data[0]['Add_membership_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
											<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file"  multiple="" name="membership" onchange="readImage(this,'#membership');"  />
										</div>
									</p>
								 
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/user.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable membership module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
		
						<?php if($Company_details->Survey_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $survey_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'survey', 'value',$Company_details->Company_id,$Seller_id);
								if(!empty($survey_image))
								{ ?>
									<img src="<?php echo base_url(); ?><?php echo $survey_image; ?>" id="survey" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="survey_image_hdn" id="survey_image_hdn" value="<?php echo $survey_image; ?>" >
								<?php
								} else {
								?>
									<img src="<?php echo base_url(); ?>images/icon/template_icon/survey.png" id="survey" class="card-img-top img-responsive custom_img" >
								<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Survey</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Survey_flag"  id="Survey_flag"  value="1"  <?php if($Menu_access_data[0]['Survey_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Survey_flag" id="Survey_flag"  value="0"  <?php if($Menu_access_data[0]['Survey_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
											<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file" name="survey" onchange="readImage(this,'#survey');"  />
										</div>
									</p>
								 
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img  src="<?php echo base_url(); ?>images/icon/template_icon/survey.png"  alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable survey module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
					</div>
					<div class="row">
						<?php if($Company_details->Notification_flag==1) { ?>
						<div class="col-sm-4">
						   <div class="card" style="width:400px">
							  <?php $notification_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'notification', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($notification_image))
							{ ?>
								<img src="<?php echo base_url(); ?><?php echo $notification_image; ?>" id="notification"  class="card-img-top img-responsive custom_img">
								<input type="hidden" name="notification_image_hdn" id="notification_image_hdn" value="<?php echo $notification_image; ?>" >
							<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/notification.png" id="notification"  class="card-img-top img-responsive custom_img" >
							<?php } ?>

							<div class="card-body">
								
								<label class="card-title"><strong>Notification</strong></label>
								<p class="card-text">
								<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
								<input type="radio" name="Notification_flag"  id="Notification_flag"  value="1"  <?php if($Menu_access_data[0]['Notification_flag']==1){echo "checked";} ?>  >Yes
								<input type="radio" name="Notification_flag" id="Notification_flag"  value="0"  <?php if($Menu_access_data[0]['Notification_flag']==0 ){echo "checked";} ?> >No
								<br>
								<div class="upload-btn-wrapper">
									<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
									<input type="file" name="notification" onchange="readImage(this,'#notification');"  />
								</div>
								
								</p>
							</div>
						  </div>
						</div>
						<?php } else { ?>
						<div class="col-sm-4">
							<div class="card" style="width:400px">
								<img src="<?php echo base_url(); ?>images/icon/template_icon/notification.png" alt="Card image" class="card-img-top img-responsive custom_img">
								<div class="card-body alert-warning" style="max-width:50%;">
								  <p class="card-text">Please contact administrative to enable notification module</p>
								</div>
							</div>
						  </div>
					<?php } ?>
						  
					<?php if($Company_details->Call_center_flag==1) { ?>
						<div class="col-sm-4">
						   <div class="card" style="width:400px">
						  <?php $call_center_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'call_center', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($call_center_image))
							{ ?>
								<img src="<?php echo base_url(); ?><?php echo $call_center_image; ?>" id="call_center" class="card-img-top img-responsive custom_img" >
								<input type="hidden" name="call_center_image_hdn" id="call_center_image_hdn" value="<?php echo $call_center_image; ?>" >
							<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/call_center.png" id="call_center" class="card-img-top img-responsive custom_img" >
							<?php } ?>

							<div class="card-body">
								<label class="card-title"><strong>Call Center</strong></label>
								<p class="card-text">
								<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
								<input type="radio" name="Call_center_flag"  id="Call_center_flag"  value="1"  <?php if($Menu_access_data[0]['Call_center_flag']==1){echo "checked";} ?>  >Yes
								<input type="radio" name="Call_center_flag" id="Call_center_flag"  value="0"  <?php if($Menu_access_data[0]['Call_center_flag']==0 ){echo "checked";} ?> >No
								<br>
								<div class="upload-btn-wrapper">
									<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
									<input type="file"  name="call_center" onchange="readImage(this,'#call_center');"  />
								</div>
								</p>
							</div>
						  </div>
						</div>
						<?php } else { ?>
						<div class="col-sm-4">
							<div class="card" style="width:400px">
								<img src="<?php echo base_url(); ?>images/icon/template_icon/call_center.png" alt="Card image" class="card-img-top img-responsive custom_img">
								<div class="card-body alert-warning" style="max-width:50%;">
								  <p class="card-text">Please contact administrative to enable call center module</p>
								</div>
							</div>
						</div>
					<?php } ?>
							
					<?php if($Company_details->My_statement_flag==1) { ?>
						<div class="col-sm-4">
						   <div class="card" style="width:400px">
						  <?php $statement_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'statement', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($statement_image))
							{ 	?>
									<img src="<?php echo base_url(); ?><?php echo $statement_image; ?>" id="statement" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="statement_image_hdn" id="statement_image_hdn" value="<?php echo $statement_image; ?>" >
								<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/statement.png" id="statement" class="card-img-top img-responsive custom_img" >
							<?php } ?>

							<div class="card-body">
								<label class="card-title"><strong>Statement</strong></label>
								<p class="card-text">
									<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
									<input type="radio" name="My_statement_flag"  id="My_statement_flag"  value="1"  <?php if($Menu_access_data[0]['My_statement_flag']==1){echo "checked";} ?>  >Yes
									<input type="radio" name="My_statement_flag" id="My_statement_flag"  value="0"  <?php if($Menu_access_data[0]['My_statement_flag']==0 ){echo "checked";} ?> >No
									<br>
									<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
										<input type="file"  multiple="" name="statement" onchange="readImage(this,'#statement');"  />
									</div>
								</p>
							</div>
						  </div>
						</div>
						<?php } else { ?>
						<div class="col-sm-4">

							<div class="card" style="width:400px">
								<img  src="<?php echo base_url(); ?>images/icon/template_icon/statement.png"  alt="Card image" class="card-img-top img-responsive custom_img">
								<div class="card-body alert-warning" style="max-width:50%;">
								  <p class="card-text">Please contact administrative to enable report module</p>
								</div>
							</div>
						  </div>
					<?php } ?>
					</div>
						
					<div class="row">
						<?php if($Company_details->Contact_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							   <?php $contact_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'contact', 'value',$Company_details->Company_id,$Seller_id);
							if(!empty($contact_image))
							{ ?>
								<img src="<?php echo base_url(); ?><?php echo $contact_image; ?>" id="contact" class="card-img-top img-responsive custom_img" >
								<input type="hidden" name="contact_image_hdn" id="contact_image_hdn" value="<?php echo $contact_image; ?>" >
							<?php
							} else {
							?>
								<img src="<?php echo base_url(); ?>images/icon/template_icon/contact.png" id="contact" class="card-img-top img-responsive custom_img" >
							<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Contact Us</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Contact_flag"  id="Contact_flag"  value="1"  <?php if($Menu_access_data[0]['Contact_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Contact_flag" id="Contact_flag"  value="0"  <?php if($Menu_access_data[0]['Contact_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
											<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file"  multiple="" name="contact" onchange="readImage(this,'#contact');"  />
										</div>
									</p>
								 
								</div>
							  </div>
							</div>
						<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img class="card-img-top img-responsive custom_img" src="<?php echo base_url(); ?>images/icon/template_icon/contact.png" alt="Card image" >
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable contact us module</p>
									</div>
								</div>
							  </div>
						<?php } ?>  
	
						<?php if($Company_details->Buy_miles_flag==1) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							  <?php $Buy_miles_flag = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Buy_miles', 'value',$Company_details->Company_id,$Seller_id);
								if(!empty($Buy_miles_flag))
								{ ?>
									<img src="<?php echo base_url(); ?><?php echo $Buy_miles_flag; ?>" id="Buy_miles_image" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="Buy_miles_image_hdn" id="Buy_miles_image_hdn" value="<?php echo $Buy_miles_flag; ?>" >
								<?php
								} else {
								?>
									<img src="<?php echo base_url(); ?>images/icon/template_icon/buywithjoy.png" id="Buy_miles_image" class="card-img-top img-responsive custom_img" >
								<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Buy Miles</strong></label>
									<p class="card-text">
									<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Buy_miles_flag"  id="Buy_miles_flag"  value="1"  <?php if($Menu_access_data[0]['Buy_miles_flag']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Buy_miles_flag" id="Buy_miles_flag"  value="0"  <?php if($Menu_access_data[0]['Buy_miles_flag']==0 ){echo "checked";} ?> >No
										<br>
										<div class="upload-btn-wrapper">
											<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
											<input type="file"  multiple="" name="Buy_miles_image" onchange="readImage(this,'#Buy_miles_image');"  />
										</div>
									</p>
								 
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">

								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/buywithjoy.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body alert-warning" style="max-width:50%;">
									  <p class="card-text">Please contact administrative to enable buy miles module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
						
						<?php if($Company_details->Promo_code_applicable==1 || $Company_details->Auction_bidding_applicable==1 ) { ?>
							<div class="col-sm-4">
							   <div class="card" style="width:400px">
							  <?php $games_image = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'games', 'value',$Company_details->Company_id,$Seller_id);
								if(!empty($games_image))
								{ ?>
									<img src="<?php echo base_url(); ?><?php echo $games_image; ?>" id="games" class="card-img-top img-responsive custom_img" >
									<input type="hidden" name="games_image_hdn" id="games_image_hdn" value="<?php echo $games_image; ?>" >
								<?php
								} else {
								?>
									<img src="<?php echo base_url(); ?>images/icon/template_icon/games.png" id="games" class="card-img-top img-responsive custom_img" >
								<?php } ?>

								<div class="card-body">
									<label class="card-title"><strong>Games</strong></label><br>
									<div>
									<label class="card-title"><strong>Promo Code</strong></label>
									<p class="card-text">
									<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable</label>
									<input type="radio" name="Promo_code_applicable"  id="Promo_code_applicable"  value="1"  <?php if($Menu_access_data[0]['Promo_code_applicable']==1){echo "checked";} ?>>Yes
									<input type="radio" name="Promo_code_applicable" id="Promo_code_applicable"  value="0"  <?php if($Menu_access_data[0]['Promo_code_applicable']==0 ){echo "checked";} ?> >No &nbsp;
									</p>
									</div>
									<?php if($Company_details->Auction_bidding_applicable==1 ) { ?>
									
									<div>
									<label class="card-title"><strong>Auction Bid</strong></label>
									<p class="card-text">
										<label for="exampleInputEmail1"><span class="required_info">* </span>Applicable </label>
										<input type="radio" name="Auction_bidding_applicable"  id="Auction_bidding_applicable"  value="1"  <?php if($Menu_access_data[0]['Auction_bidding_applicable']==1){echo "checked";} ?>  >Yes
										<input type="radio" name="Auction_bidding_applicable" id="Auction_bidding_applicable"  value="0" <?php if($Menu_access_data[0]['Auction_bidding_applicable']==0 ){echo "checked";} ?> >No
									</p>
									</div>
									<?php } ?>
									<p class="card-text">
									<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
										<input type="file" name="games" onchange="readImage(this,'#games');"  />
									</div>
									</p>
								</div>
							  </div>
							</div>
							<?php } else { ?>
							<div class="col-sm-4">
								<div class="card" style="width:400px">
									<img src="<?php echo base_url(); ?>images/icon/template_icon/games.png" alt="Card image" class="card-img-top img-responsive custom_img">
									<div class="card-body">
									  <p class="card-text" style="max-width:50%;">Please contact administrative to enable promo code and auction module</p>
									</div>
								</div>
							  </div>
						<?php } ?>
					</div>
					</fieldset>
					<div class="form-buttons-w" align="center">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
						<input type="hidden" name="Count_mobile_template" value="<?php echo $Count_mobile_template;?>">
						<input type="hidden" name="username" value="<?php echo $username; ?>">
						<input type="hidden" name="compID" value="<?php echo $Company_id; ?>">
						<input type="hidden" name="Seller_id" value="<?php echo $Seller_id; ?>">
					</div>
					<?php echo form_close(); ?>
					
					<?php if($Template_details) { ?>
						<!--------------Table------------->	 
						<div class="element-wrapper">											
							<div class="element-box">
							  <h6 class="form-header">
							   Enrollments
							  </h6>                  
							  <div class="table-responsive">
								<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
									<thead>
										<tr>
											<th>Action</th>
											<th>Brand Name</th>
											
											
										</tr>
									</thead>						
									<tfoot>
										<tr>
											<th>Action</th>
											<th>Brand Name</th>
											
											
										</tr>
									</tfoot>
									<tbody>
											<?php foreach($Template_details as $templet) {
												
												// echo"---First_name----".$templet['First_name']."-----Last_name----".$templet['Last_name']."---<br>";
												if($templet['First_name'] =="" || $templet['Last_name'] ==""){
													
													$name=" All Brand Template";
													
												} else {
													
													
													$name=$templet['First_name'].' '.$templet['Last_name'];
												}
												// echo"---Seller_id----".$templet['Seller_id']."----<br>";		
												?>											
												<tr>
													<td class="row-actions">
														<a href="<?php echo base_url()?>index.php/General_setting/edit_general_setting/?Seller_id=<?php echo $templet['Seller_id']; ?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
														
													</td>
													<td><?php echo $name; ?></td>
													
													
												</tr>
											<?php } ?>
									</tbody>
								</table>
							  </div>
							</div>
						</div>
						<?php } ?>
						<!--------------Table--------------->
					
					
				</div>
			</div>			
		  </div>
		</div>
	</div>
</div>
<!-- msg popup modal -->
<div class="modal fade" id="msg_myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					Application Information
				</h5>
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			</div>
			<div class="modal-body">
				<div  id="modal_msg"></div>
			</div>
			<div class="modal-footer">
			<button class="btn btn-secondary" data-dismiss="modal" type="button"> Ok</button>
		  </div>
		</div>
    </div>
</div>	
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	var Application_image_flag = $("input[name=Application_image_flag]:checked").val();
	var Header_transparent = $("input[name=Header_transparent]:checked").val();
	// var Offer_flag = $("input[name=Offer_flag]:checked").val();
	// var Offer_flag = $('#Offer_flag').val();
	var application = $('#application').val();
	var Header_color_opacity = $('#Header_color_opacity').val();
	//var Product_brand_id = $('#Product_brand_id').val();
	// alert(Application_image_flag);		
	// alert(Header_transparent);		
	// alert(application);		
	if(Application_image_flag=='yes')
	{
		var Theme_image_hdn = $('#Theme_image_hdn').val();
		if(Theme_image_hdn == "")
		{
			if(application== "")
			{
				var msg = 'Please select application background image';
				$("#modal_msg").text(msg);
				$('#msg_myModal').modal('toggle');
			}
		}
	}
	else
	{
		show_loader();
		return true;
	}
	if(Header_transparent=='yes')
	{
		if(Header_color_opacity== "")
		{
			var msg = 'Please enter header transparent opacity';
			$("#modal_msg").text(msg);
			$('#msg_myModal').modal('toggle');
		}
	}
	else
	{
		show_loader();
		return true;
	}
	// return false;
});
function HideShowAppImage(InputVal)
{
	if(InputVal ==1)
	{
		document.getElementById('App_iamge_div').style.display="";
		document.getElementById('App_bg_color_div').style.display="none";
	}
	else
	{
		document.getElementById('App_iamge_div').style.display="none";
		document.getElementById('App_bg_color_div').style.display="";
	}	
}
 
function HideShow_Header_transparent(InputVal)
{
	if(InputVal ==1)
	{
		
		document.getElementById('Header_Colour_div').style.display="none";
		document.getElementById('Header_Colour_opacity_div').style.display="";
	}
	else
	{
		document.getElementById('Header_Colour_div').style.display="";
		document.getElementById('Header_Colour_opacity_div').style.display="none";
	}	
}
/************** image upload **************/
function readImage(input,div_id) 
{
	if (input.files && input.files[0]) 
	{
		var reader = new FileReader();

		reader.onload = function (e) {
			$(div_id)
				.attr('src', e.target.result);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>
<style>
.custom_img{
	width:120px;
	height:100px;
	background: gray;
}
</style>