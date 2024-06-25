<?php $this->load->view('header/header');
$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag'];
 ?>
<script src="<?php echo base_url()?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   Reference Email Template Master
			  </h6>
			  <div class="element-box">
			
					<!-----------------------------------Flash Messege-------------------------------->

					<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code'); ?>
							</div>
					<?php 	} ?>
					<?php
						if(@$this->session->flashdata('communication_error_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('communication_error_code'); ?>
							</div>
					<?php 	} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
					<?php 	} ?>
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Email_templateC/Reference_email_templates',$attributes); ?>	
				<div class="row">
				<div class="col-sm-6">					
									
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Template Type</label>
							<select class="form-control" name="Template_type_id" id="Template_type_id" required>
							<option value="">Select Template Type</option>
							<?php									
								foreach($Template_type as $Template_type)
								{
									?>
										<option value="<?php echo $Template_type['Template_type_id']; ?>"><?php echo $Template_type['Template_type_name']; ?></option>
									<?php
								}
								?>
							</select>
					</div>
						<div class="form-group">
								<label for=""><span class="required_info">*</span> Template Name</label>
								<input type="text" name="Email_template_name" id="Email_template_name" class="form-control" placeholder="Enter Template Name"/>									
							</div>				
					
									
					<div>							
												
							 <div class="form-group">
									<label><span class="required_info">* </span> Description</label>
									<textarea class="form-control" rows="3" name="Template_description"  id="Template_description" data-error="Please enter Description" required="required" placeholder="Enter Description"></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>	
												
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Subject</label>
								<input type="text" name="Email_subject" id="Email_subject" class="form-control" placeholder="Enter Subject" onkeyup='$("#subject").html(this.value);'/>									
							</div>	
														
							
							<div class="form-group">
								<label for="">Select Variable for Subject</label>
								<select class="form-control" name="SVariable" id="SVariable" onchange="insert_SVariable(this.value);$('#subject').html(Email_subject.value);">
								<option value="">Select Variable</option>
								<?php									
								foreach($Template_variables as $variables)
								{
									?>
										<option value="<?php echo $variables['Code_decode']; ?>"><?php echo $variables['Code_decode']; ?></option>
									<?php
								}
								?>
								</select>									
							</div>	
							
							<legend><span>Header Settings</span></legend>
							
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Header Tag Line</label>
								<input type="text" name="Email_header" id="Email_header" class="form-control" placeholder="Enter Header Tag Line"  onkeyup='$("#header2").html(this.value);'/>									
							</div>
						
						<div class="form-group" id="333">
						<label for="">Header Image </label>
						
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="HeaderImage_flg" class="form-check-input"   id="12" value="1" onclick="javascript:$('#headerblock').show();" checked>Yes	
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="HeaderImage_flg"  class="form-check-input"  id="13"   value="0"  onclick="javascript:$('#headerblock').hide();$('#blah3').hide();">No		
							</label>
							
						
					</div>								
							<div class="form-group" id="headerblock">								
								<label for=""> Upload Header Image <span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span> </label>	
								<div class="upload-btn-wrapper">
								<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
								<input type="file" name="Email_header_image" id="Email_header_image" onchange="readURL(this);"/>
								</div>								
								<img id="blah" src="#" class="img-responsive left-block" style="display:none" width="20%"/>		
							</div>
							
							<div class="form-group" id="multiple_social">
						<label for="">Set Header Background Color</label>
						<BR>
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Header_background_color" onclick="javascript:$('#header').css('background-color', $(this).val());"  value="#f9ee95" class="radio-btn" id="RadioGroup3_015" checked >
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #f9ee95;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Header_background_color" onclick="javascript:$('#header').css('background-color', $(this).val());"  value="#dadada" class="radio-btn" id="RadioGroup3_014">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #dadada;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Header_background_color" onclick="javascript:$('#header').css('background-color', $(this).val());" value="#bdc9d6" class="radio-btn" id="RadioGroup3_013">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #bdc9d6;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Header_background_color" onclick="javascript:$('#header').css('background-color', $(this).val());"  value="#67beca" class="radio-btn" id="RadioGroup3_012">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #67beca;"></div>
								
							</label>
							
							<label class="radio-group-2" style="margin-left:25px;font-size: 11px;margin-bottom: 0;padding-top: 0;"><br>
								<b>More Colors :</b>
								<input style="width: 25% !important;" onchange="get_color_pallete3();" id="pallete3"  class="color txtbox-3" value="">
								<input type="hidden" name="Header_background_colorpallet" id="Header_background_colorpallet" value="" />
								<font color="red" size="0.3px"><i>*click on box</i></font>
							</label>
							
					</div>	
							<legend><span>Body Settings</span></legend>
							<div class="form-group">
								<label for="">Body Structure</label>
								<select class="form-control" name="Body_structure" id="Body_structure" >
								<option value='0'>Select Body Content Width</option>
								<option value='40%'>40 %</option>
								<option value='60%'>60 %</option>
								<option value='80%'>80 %</option>
								<option value='100%'>100 %</option>
								</select>									
							</div>							
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Body Content</label>
								<textarea cols="80" class="form-control" id="Email_body1" name="Email_body" rows="10" ></textarea>
							</div>
							<div class="form-group">
								<label for="">Select Variable for Body</label>
								<select class="form-control" name="BVariable" id="BVariable" onchange="insert_BVariable(this.value)">
								<option value="">Select Variable</option>
								<?php									
								foreach($Template_variables as $variables)
								{
									?>
										<option value="<?php echo $variables['Code_decode']; ?>"><?php echo $variables['Code_decode']; ?></option>
									<?php
								}
								?>
								</select>									
							</div>	
							<div class="form-group" id="33e3">
							<label for="">Body Background Image </label>
						
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="bodyimg_flg" class="form-check-input"   id="121" value="1" onclick="javascript:$('#bodyblock').show();$('#BackgroundColor').hide();">Yes	
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="bodyimg_flg"  class="form-check-input"  id="131"  checked value="0"  onclick="javascript:$('#bodyblock').hide(); $('#BackgroundColor').show(); $('#bg-body').css('background', 'none');">No		
							</label>
							
						
							</div>	
							<div class="form-group"  style="display:none;" id="bodyblock">								
								<label for=""> Upload Body Background Image <span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span> </label>	
								<div class="upload-btn-wrapper">
								<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
								<input type="file" name="Body_image" id="Body_image" onchange="readURL2(this);"/>
								</div>								
								<img id="blah2" src="#" class="img-responsive left-block" style="display:none" width="20%"/>		
							</div>
							
							<div class="form-group" id="BackgroundColor">
						<label for="">Set Body Background Color</label>
						<BR>
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_background_color" onclick="javascript:$('#bg-body').css('background-color', $(this).val());$('#bg-body3').css('background-color', 'white');"     value="#f9ee95" class="radio-btn" id="RadioGroup3_0" checked >
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #f9ee95;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_background_color" onclick="javascript:$('#bg-body').css('background-color', $(this).val());$('#bg-body3').css('background-color', 'white');"     value="#dadada" class="radio-btn" id="RadioGroup3_0">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #dadada;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_background_color" onclick="javascript:$('#bg-body').css('background-color', $(this).val());$('#bg-body3').css('background-color', 'white');"    value="#bdc9d6" class="radio-btn" id="RadioGroup3_0">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #bdc9d6;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_background_color" onclick="javascript:$('#bg-body').css('background-color', $(this).val());$('#bg-body3').css('background-color', 'white');"     value="#F2F2F2" class="radio-btn" id="RadioGroup3_0">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #F2F2F2;"></div>
								
							</label>
							
							<label class="radio-group-2" style="margin-left:25px;font-size: 11px;margin-bottom: 0;padding-top: 0;"><br>
					<b>More Colors :</b>
					<input style="width: 25% !important;" onchange="get_color_pallete2();" id="pallete2"  class="color txtbox-3" value="">
					<input type="hidden" name="Email_background_colorpallet" id="Email_background_colorpallet" value="" />
					<font color="red" size="0.3px"><i>*click on box</i></font>
				</label>
							
							
							
						
					</div>		


						<div class="form-group" id="BackgroundColor">
						<label for="">Set Body Contents Background Color</label>
						<BR>
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_Contents_background_color" onclick="javascript:$('#Offer_description').css('background-color', $(this).val());"     value="#f9ee95" class="radio-btn" id="RadioGroup3_0" checked >
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #f9ee95;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_Contents_background_color" onclick="javascript:$('#Offer_description').css('background-color', $(this).val());"     value="#dadada" class="radio-btn" id="RadioGroup3_0">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #dadada;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_Contents_background_color" onclick="javascript:$('#Offer_description').css('background-color', $(this).val());"    value="#bdc9d6" class="radio-btn" id="RadioGroup3_0">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #bdc9d6;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_Contents_background_color" onclick="javascript:$('#Offer_description').css('background-color', $(this).val());"     value="#F2F2F2" class="radio-btn" id="RadioGroup3_0">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #F2F2F2;"></div>
								
							</label>
							
							<label class="radio-group-2" style="margin-left:25px;font-size: 11px;margin-bottom: 0;padding-top: 0;"><br>
					<b>More Colors :</b>
					<input style="width: 25% !important;" onchange="get_color_pallete6();" id="pallete6"  class="color txtbox-3" value="">
					<input type="hidden" name="Email_background_colorpallet6" id="Email_background_colorpallet6" value="" />
					<font color="red" size="0.3px"><i>*click on box</i></font>
				</label>
							
							
							
						
					</div>		

					<div class="form-group" id="multiple_social">
						<label for="">Set Body Text Color</label>
						<BR>
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_font_color" value="#000203" class="radio-btn" id="Email_font_color1" checked  onclick="javascript:$('#Offer_description').css('color', $(this).val());">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #000203;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_font_color" onclick="javascript:$('#Offer_description').css('color', $(this).val());" value="#353535" class="radio-btn" id="Email_font_color2">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #353535;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_font_color"  onclick="javascript:$('#Offer_description').css('color', $(this).val());"value="#6e6e6e" class="radio-btn" id="Email_font_color3">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #6e6e6e;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Email_font_color"  onclick="javascript:$('#Offer_description').css('color', $(this).val());"  value="#9f9f9e" class="radio-btn" id="Email_font_color4">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #9f9f9e;"></div>
								
							</label>
							
							
							<label class="radio-group-2" style="margin-left:25px;font-size: 11px;margin-bottom: 0;padding-top: 0;"><br>
					<b>More Colors :</b>
					<input style="width: 25% !important;" onchange="get_color_pallete1();" id="pallete1"  class="color txtbox-3" value="">
					<input type="hidden" name="Email_font_colorPallet" id="Email_font_pallet" value="" />
					<font color="red" size="0.3px"><i>*click on box</i></font>
				</label>
							
							
							
						
					</div>			
								
							
						
							
							
					
							
							
							
						<div class="form-group">
								<label for="">Set Body Text size</label>
								<select class="form-control" name="Email_font_size" id="Email_font_size"  onchange="javascript:$('#Offer_description').css('font-size', $(this).val());">
								<option value="">Select Font Size</option>
								<?php
									for($i=11;$i<=30;$i++)
									{
										echo '<option value="'.$i.'px">'.$i.'px</option>';
									}
								?>
							
								</select>									
							</div>	
							
						<div class="form-group">
								<label for="">Select Body Text Font Family to Apply</label>
								<select class="form-control" name="Font_family" id="Font_family"  onchange="javascript:$('#Offer_description').css('font-family', $(this).val());">
								<option value="">Select Font Family</option>
								<?php									
								foreach($Font_family as $Font_family)
								{
									?>
										<option value="<?php echo $Font_family['Code_decode']; ?>"><?php echo $Font_family['Code_decode']; ?></option>
									<?php
								}
								?>
								</select>									
							</div>	
								
			
							
							<legend><span>Footer Settings</span></legend>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Footer Note</label>
								<input type="text" name="Footer_notes" id="Footer_notes" class="form-control" placeholder="Enter Footer Note" onkeyup='$("#footer_lable2").html(this.value);'/>									
							</div>	
							<div class="form-group" id="multiple_social">
						<label for="">Set Footer Font Color</label>
						<BR>
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_font_color" value="#000203" class="radio-btn" id="Footer_font_color1" checked  onclick="javascript:$('#footer_lable2').css('color', $(this).val());">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #000203;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_font_color" onclick="javascript:$('#footer_lable2').css('color', $(this).val());" value="#353535" class="radio-btn" id="Footer_font_color2">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #353535;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_font_color"  onclick="javascript:$('#footer_lable2').css('color', $(this).val());"value="#6e6e6e" class="radio-btn" id="Footer_font_color3">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #6e6e6e;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_font_color"  onclick="javascript:$('#footer_lable2').css('color', $(this).val());"  value="#9f9f9e" class="radio-btn" id="Footer_font_color4">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #9f9f9e;"></div>
								
							</label>
							
							
							<label class="radio-group-2" style="margin-left:25px;font-size: 11px;margin-bottom: 0;padding-top: 0;"><br>
					<b>More Colors :</b>
					<input style="width: 25% !important;" onchange="get_color_pallete5();" id="pallete5"  class="color txtbox-3" value="">
					<input type="hidden" name="Footer_font_colorPallet" id="Footer_font_pallet" value="" />
					<font color="red" size="0.3px"><i>*click on box</i></font>
				</label>
							
							
							
						
					</div>	
					
					
					<div class="form-group" id="multiple_social">
						<label for="">Set Footer Background Color</label>
						<BR>
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_background_color" onclick="javascript:$('#footer_lable').css('background-color', $(this).val());" value="#f9ee95" class="radio-btn" id="RadioGroup3_015" checked >
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #f9ee95;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_background_color"  onclick="javascript:$('#footer_lable').css('background-color', $(this).val());" value="#dadada" class="radio-btn" id="RadioGroup3_014">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #dadada;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_background_color"  onclick="javascript:$('#footer_lable').css('background-color', $(this).val());"  value="#bdc9d6" class="radio-btn" id="RadioGroup3_013">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #bdc9d6;"></div>
								
							</label>
							
							<label class="form-check-label" style="margin-left:25px;">
								<input type="radio" name="Footer_background_color"  onclick="javascript:$('#footer_lable').css('background-color', $(this).val());"  value="#67beca" class="radio-btn" id="RadioGroup3_012">
								<div class="color-box1" style="margin-left:25px;margin-top: -22px; background: #67beca;"></div>
								
							</label>
							
							<label class="radio-group-2" style="margin-left:25px;font-size: 11px;margin-bottom: 0;padding-top: 0;"><br>
								<b>More Colors :</b>
								<input style="width: 25% !important;" onchange="get_color_pallete4();" id="pallete4"  class="color txtbox-3" value="">
								<input type="hidden" name="Footer_background_colorpallet" id="Footer_background_colorpallet" value="" />
								<font color="red" size="0.3px"><i>*click on box</i></font>
							</label>
							
					</div>			
							
					
			
			
			
			</div>
									
					
						
					<!-- Modal -->
					<div id="myModal1" class="modal fade" role="dialog" style="overflow: scroll;">
						<div class="modal-dialog"  style="margin-top:18%;width: 100%;" width="100%">

						<!-- Modal content-->
							<div class="modal-content" style="width:900px;margin-left:-16%;">
								<div class="modal-header">
									<h5 class="modal-title text-center">Communication</h5>
								</div>
								<div class="modal-body">
									<div class="table" id="show_multiple_offer"></div>
								</div>
								<!--
								<div class="modal-footer">
									<button type="button" id="close_modal" class="btn btn-primary">Save Applied Rule(s)</button>
									<button type="button" id="close_modal12" class="btn btn-primary">Close</button>
								</div>-->
							</div>

						</div>
					</div>						
						
											
					
					
					<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Submit</button>								
															
					<button type="reset" class="btn btn-primary">Reset</button>
					
					<input type="hidden" name="Company_id" value="<?php echo $Company_id; ?>"/>
					
				</div>
				<!---------------------------Communication Preview---------------------------------------------->	
					
					<div class="col-sm-6" >
						<div class="element-box" >
							<h5 class="form-header">  Email Template Preview</h5>
							<div class="panel-body"  >
								
								<div class="table-responsive">
									<table class="table">
											<tr>
													<td class=""><b>From : </b>example@example.com</td>
													
												</tr>
												<tr>
													<td class="new_td"><b>To : </b>example@example.com</td>
													
												</tr>
												<tr>
													<td class="new_td"><b>Subject : </b><span id="subject"></span></td>
													
												</tr>
												<tr  id="bg-bodyw">
													<td class="new_td" id="new_td2"><b>Email Contents :</b></td>
													
												</tr>
												
									</table>
								</div>
							</div>						
						</div>			
						<div class="element-box"  id="bg-body">
							
							<div class="panel-body"   >
								
								<div class="table-responsive">
									<table class="table">
											
												<tr  id="bg-body2">
												
												<td  id="header"  align="center">&lt;Header&gt;
												<br><img id="blah3" src="#" class="img-responsive left-block" style="display:none" /><br>
												<span id="header2"></span>
												</td>
												</tr>
												
										<tr  id="bg-body3" >
											<td id="Offer_description">&lt;Body&gt;</td>
										</tr>
									<tr  id="bg-body4">
										
										<td  id="footer_lable"  align="center">&lt;Footer&gt;<br>
										<img id="blah4" src="#" class="img-responsive left-block" style="display:none"  width="45px"/>&nbsp;&nbsp;&nbsp;&nbsp;<img id="blah5" src="#" class="img-responsive left-block" style="display:none" width="30px"/><br>
										<img id="blah6" src="#" class="img-responsive left-block" style="display:none"  width="30px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="blah7" src="#" class="img-responsive left-block" style="display:none" width="30px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="blah8" src="#" class="img-responsive left-block" style="display:none" width="30px"/><br>
										<span id="footer_lable2"></span></td>
									</tr>
									</table>
								</div>
							</div>						
						</div>						
					</div>	
			<!---------------------------Communication Preview---------XXX------------------------------------->			
					
				</div>	
					
					
				  
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
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
			  Reference Templates
			  </h5>  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							
							<th class="text-center">Action</th>
							<th class="text-center">Email Template Type</th>
							<th class="text-center">Email Template Name</th>
							<th class="text-center">Template Description</th>
							
							
							
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				$todays = date("Y-m-d");
				
				if($Template_Records != NULL)
				{
					foreach($Template_Records as $row)
					{
										
						
					?>
						<tr>
							
							<td class="row-actions">
									
								<a href="<?php echo base_url()?>index.php/Email_templateC/Edit_Reference_Email_template/?Email_template_id=<?php echo $row->Email_template_id;?>" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
										
								<a href="javascript:void(0);" class="danger"  onclick="delete_me('<?php echo $row->Email_template_id;?>','<?php echo $row->Email_template_name.' ?'; ?>','','Email_templateC/delete_reference_template/?Email_template_id');"  title="Delete"  data-target="#deleteModal" data-toggle="modal" >
									<i class="os-icon os-icon-ui-15"></i>
								</a>
												
							</td>
							<td><?php echo $row->Template_type_name; ?></td>
							<td><?php echo $row->Email_template_name; ?></td>
							<td><?php echo $row->Template_description; ?></td>
							
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




<?php $this->load->view('header/footer'); ?>

<!-- Modal -->
<div id="ImageModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 40%;">

	<!-- Modal content-->
		<div class="modal-content" style="margin-top:10%;">
			<form id="uploadForm" name='upload' action="" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title text-center">Upload Image</h4>
				</div>
				<div class="modal-body">
					<div class="panel panel-default">				
						<div class="panel-body" id="Upload_offer_image">
							<div class="form-group">
								<label for="exampleInputEmail1"><span class="required_info">*</span> Select Image to Upload</label>
								<input type="file" name="file" />								
							</div>
							
							<span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="Upload" class="btn btn-primary">Upload</button>
					<button type="button" id="close_modal4" class="btn btn-primary">Close</button>
				</div>
			</form>
		</div>

	</div>
</div>
<!-- Modal -->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jscolor.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/scripts.js"></script>
<script>	
	$( "#close_modal4" ).click(function(e)
	{
		$('.mce-window').css("z-index","65536");
                $('#ImageModal').hide();
                $("#ImageModal").removeClass( "in" );
                $('.modal-backdrop').remove();
	});
			function get_color_pallete1()
			{ 
					$('input[name="Email_font_color"]').each(function() { 
					this.checked = false; 
				});
				
				var color_pal = $("#pallete1").val();
				color_pal = "#"+color_pal;
				$("#Email_font_pallet").val(color_pal);
				$('#Offer_description').css('color',color_pal);
			}

			function get_color_pallete2()
			{ 
					$('input[name="Email_background_color"]').each(function() { 
					this.checked = false; 
				});
				
				var color_pal = $("#pallete2").val();
				color_pal = "#"+color_pal;
				$("#Email_background_colorpallet").val(color_pal);
				$('#bg-body').css('background-color', color_pal);
				$('#bg-body3').css('background-color', 'white');
			}

			function get_color_pallete6()
			{ 
					$('input[name="Email_Contents_background_color"]').each(function() { 
					this.checked = false; 
				});
				
				var color_pal = $("#pallete6").val();
				color_pal = "#"+color_pal;
				$("#Email_background_colorpallet6").val(color_pal);
				$('#Offer_description').css('background-color', color_pal);
				
			}

			function get_color_pallete3()
			{ 
					$('input[name="Header_background_color"]').each(function() { 
					this.checked = false; 
				});
				
				var color_pal = $("#pallete3").val();
				color_pal = "#"+color_pal;
				$("#Header_background_colorpallet").val(color_pal);
				
				$('#header').css('background-color', color_pal);
			}

			function get_color_pallete4()
			{ 
					$('input[name="Footer_background_color"]').each(function() { 
					this.checked = false; 
				});
				
				var color_pal = $("#pallete4").val();
				color_pal = "#"+color_pal;
				$("#Footer_background_colorpallet").val(color_pal);
				
				$('#footer_lable').css('background-color',color_pal);
				
			}

			function get_color_pallete5()
			{ 
					$('input[name="Footer_font_color"]').each(function() { 
					this.checked = false; 
				});
				
				var color_pal = $("#pallete5").val();
				color_pal = "#"+color_pal;
				$("#Footer_font_pallet").val(color_pal);
				$('#footer_lable2').css('color',color_pal);
				
			}

function insert_BVariable(BVariable){
	// alert("---BVariable----"+BVariable); 	
	 tinymce.activeEditor.execCommand('mceInsertContent', false, BVariable);	
}
function insert_SVariable(variable) 
	{
		// $('#Email_subject').append($('#SVariable').val() + 'more text');
		$("#Email_subject").val($("#Email_subject").val() + variable);
	}
	tinymce.init(
	{
		
		
		selector: "textarea#Email_body1",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		 plugins: [
			" textcolor colorpicker advlist link image lists hr anchor pagebreak fullscreen preview code table"
		], 		
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | print preview media code | forecolor backcolor emoticons",	//link image |
		//toolbar2: " hr | tablecontrols | table",//fontselect | fontsizeselect | 
		
		
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				// alert('htmlContent '+htmlContent);
				$('input[name=Email_body]').val(htmlContent);
				// alert();
				
			});
		}
	});
	
	function fileBrowserCallBack(field_name, url, type, win)
	{
		$('.mce-window').css("z-index","0");
		$('.modal').css("z-index","9999999");
		$('#ImageModal').show();
		$("#ImageModal").addClass( "in" );	
		$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );	

			
		
	}
	
	$(document).ready(function (e)
	{		
		$("#uploadForm").on('submit',(function(e) 
		{
			
			e.preventDefault();
                        // var mce = window.top.tinyMCE.activeEditor;
			$.ajax(
			{
				url: "<?php echo base_url()?>index.php/Administration/upload_offer_images", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					/* alert(data.image_name);
					alert(data.message); */
					if(data.message == '1')
					{
						$('.mce-window').css("z-index","65536");
						
						$('#ImageModal').hide();
						$("#ImageModal").removeClass( "in" );
						$('.modal-backdrop').remove();
						
							// mce.windowManager.close();
							var Content_to_insert = "<img src='"+data.image_name+"' />";
							//tinyMCE.activeEditor.execCommand("mceInsertContent", true, Content_to_insert);
							
							  $('.mce-placeholder').val(data.image_name);
							  
					}
					else
					{
						return false;
					}
				}
			});
		}));
	});
	/*
	tinymce.init(
	{
		selector: "textarea#Email_body1",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | print preview media code | forecolor backcolor emoticons",	//link image |
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				alert('htmlContent** '+htmlContent);
				$('input[name=Email_body]').val(htmlContent);
			});
		}
	});*/
	
	tinymce.init(
	{
		selector: "textarea#Email_body",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
	 
	
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "preview",	
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				$('input[name=Email_body1]').val(htmlContent);
				
			});
		}
	});	
	
</script>




<script>



$('#Register').click(function()
{
      
	if( ($('input[name=r1]:checked').val() == 1) )
	{
			//var htmlContent = tinyMCE.activeEditor.getContent();

			var htmlContent = tinyMCE.get('Email_body1').getContent();
			var ContentLength = htmlContent.length;
			
			if( $('#offer_name').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "")
			{
				/* alert("-----Schedule_flag-------"+$('input[name=Schedule_flag]:checked').val());
				alert("-----Schedule_criteria-------"+$('input[name=Schedule_criteria]:checked').val());
				alert("-----Schedule_weekly-------"+$('input[name=Schedule_weekly]:checked').val());
				alert("-----Selected Date-------"+$("#datepicker3" ).val()); */
				// alert("-----ContentLength---1----"+ContentLength);				
				if(ContentLength == 0)
				{
					// alert("-----ContentLength----2---"+ContentLength);	
					var Title1 = "Application Information";
					var msg1 = 'Please Enter Offer Details!.';
					runjs(Title1,msg1);
					return false;
				}
				// return false;
				// alert("---Link_to_voucher for----"+$('input[name=Link_to_voucher]:checked').val());
				// return false;
				if(($('input[name=Schedule_flag]:checked').val() == 1))
				{
					// alert("-----Schedule_flag-------"+$('input[name=Schedule_flag]:checked').val());					 
					// if(($('input[name=Schedule_flag]:checked').val() == 1))
					if(($('input[name=Schedule_criteria]').is(":checked") == false))
					{			
						var Title1 = "Application Information";
						var msg1 = 'Please select schedule criteria  !.';
						runjs(Title1,msg1);
						return false;
					}
					if(($('input[name=Schedule_criteria]:checked').val() == 1))
					{
						// alert("-----Schedule_flag---Weekly----"+$('input[name=Schedule_criteria]:checked').val());
						if(($('input[name=Schedule_weekly]').is(":checked") == false))
						{			
							var Title1 = "Application Information";
							var msg1 = 'Please select any one week days !.';
							runjs(Title1,msg1);
							return false;
						}						
					}
					if(($('input[name=Schedule_criteria]:checked').val() == 4))
					{
						// alert("-----Schedule_flag---Select----"+$('input[name=Schedule_criteria]:checked').val());
						// alert("---datepicker3----"+$("#datepicker3" ).val());
						
						if($("#datepicker3" ).val()== "")
						{
							var Title1 = "Application Information";
							var msg1 = 'Please select day date!.';
							runjs(Title1,msg1);
							return false;
						}
					}
					// alert("---Link_to_voucher for----"+$('input[name=Link_to_voucher]:checked').val());
					return false;
					if(($('input[name=Link_to_voucher]:checked').val() == 1)){
						
						alert('Checked');
						return false; 
						/* var Title1 = "Application Information";
						var msg1 = 'Please select communication for !.';
						runjs(Title1,msg1);
						return false; */
					}
					// alert("---Communication for----"+$('input[name=r2]:checked').val()); 
					if(($('input[name=r2]').is(":checked") == false))
					{
						var Title1 = "Application Information";
						var msg1 = 'Please select communication for !.';
						runjs(Title1,msg1);
						return false;
					}
					
					if(($('input[name=r2]').is(":checked") == true))
					{
						if(($('input[name=r2]:checked').val() == 1))
						{
							/* if($("#datepicker3" ).val()== "")
							{
								var Title1 = "Application Information";
								var msg1 = 'Please select day date!.';
								runjs(Title1,msg1);
								return false;
							} */
							if($("#mailtoone_memberid" ).val()== "" || $("#mailtoone_memberid" ).val()== '0')
							{
								var Title1 = "Application Information";
								var msg1 = 'Please enter membership id!.';
								runjs(Title1,msg1);
								return false;
							}
						}
						if(($('input[name=r2]:checked').val() == 5))
						{
							if($("#mailtotier" ).val()== "")
							{
								var Title1 = "Application Information";
								var msg1 = 'Please select Tier !.';
								runjs(Title1,msg1);
								return false;
							}
						}
						if(($('input[name=r2]:checked').val() == 7))
						{
							if($("#Segment_code" ).val()== "")
							{
								var Title1 = "Application Information";
								var msg1 = 'Please select Segment !.';
								runjs(Title1,msg1);
								return false;
							}
						}
					}
					
				}
				else
				{
					show_loader();
				
					return true;
				}
				
			}
			
		}
		else if( ($('input[name=r1]').is(":checked") == false) )
		{
			var Title1 = "Application Information";
			var msg1 = 'Please Select Atleast One Option';
			document.getElementById("comm_type").innerHTML=msg1;
			return false;
		}
});

$(".comm_type").click(function() {
	
	document.getElementById("comm_type").innerHTML='';
})


/********************************Voucher-19-02-2020************************************/



	
	$('#Template_type_id').change(function()
	{
		var Template_type_id = $("#Template_type_id").val();
		$.ajax({
			type:"POST",
			data:{Template_type_id:Template_type_id},
			url: "<?php echo base_url()?>index.php/Email_templateC/get_templates_by_temptypes",
			success: function(data)
			{
				$('#Email_template_id').html(data);
			}				
		});
	});
	

// $('textarea#Email_body1').val('amit');
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(120);
                $('#blah3')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(120);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
	

function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah2')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(300)
                    .height(100);
					$('#bg-body').css('background-image', 'url('+ e.target.result +')');
					$('#bg-bodyx').css('background-color', 'white');
					// $('#bg-bodyx').css('background-image', 'url("http://localhost/new_codeignitor/images/no_image.jpeg")');
					// $('#bg-body2').css('background-image', 'url('+ e.target.result +')');
					// $('#bg-body3').css('background-image', 'url('+ e.target.result +')');
					// $('#bg-body4').css('background-image', 'url('+ e.target.result +')');
            };
			
            reader.readAsDataURL(input.files[0]);
        }
    }
	
/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		 minDate: 0,
		changeMonth: true,
		yearRange: "-80:+10",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		 minDate: 0,
		changeMonth: true,
		yearRange: "-80:+10",
		changeYear: true
	});
	
	/* $( "#datepicker3" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	}); */
		
});

$(function () {
     $("#datepicker3").datepicker({
         minDate: 0,
		 changeMonth: true,
		yearRange: "-80:+10",
		changeYear: true

     });
 });
/******calender *********/
function delete_communication_offer(offer_id,seller_id,offerName)
{	
	BootstrapDialog.confirm("Are you sure to Delete the Offer - '"+offerName+"' ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_communication_offer/?id='+offer_id+'&seller_id='+seller_id+'&url=1';
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
</script>

<style>
.color-box1 {
    width: 24px;
    height: 24px;
    margin-left: 3px;
    margin-right: 11px;
    float: inherit;
}
.table th, .table td
{
	border-top: 0px solid rgba(83, 101, 140, 0.33);
}
.txtbox-3 {
    background: #FFF;
    border: solid 1px #CCC;
    padding: 5px;
    width: 93%;
}
</style>