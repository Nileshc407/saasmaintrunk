<?php $this->load->view('header/header');$ci_object = &get_instance(); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				 echo form_open_multipart('POS_CatalogueC/Create_POS_items'); ?>
				 <input type="hidden" name="Main_item_code" id="Main_item_code" >
				<input type="hidden" name="Create_user_id" value="<?php echo $enroll;?>">
				<input type="hidden" name="Create_date" value="<?php echo date("Y-m-d H:i:s");?>">
				<div class="element-wrapper">
					<h6 class="element-header">Create POS Items</h6>
					<div class="element-box">
					<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_box" style="display:none;"></div>
				<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code'); ?>
							</div>
				<?php 	} 
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
				<?php 	} ?>
							<div class="row">
								<div class="col-sm-6">										
										<div class="form-group has-feedback"  id="has-feedback1">
						<label for=""><span class="required_info">*</span>  Item Code </label>
						<input type="text" name="Company_merchandize_item_code" id="Company_merchandize_item_code" class="form-control" placeholder="Enter Item Code " required/>						
						<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					</div>
					
					<div class="form-group has-feedback">
						<label for=""><span class="required_info">*</span> Item Name</label>
						<input type="text" name="Merchandize_item_name" id="Merchandize_item_name" class="form-control" placeholder="Enter Item Name" required />
					</div>
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Item Description</label>
						<textarea class="form-control" rows="3" id="Merchandise_item_description" name="Merchandise_item_description" required placeholder="Enter item Description"></textarea>
					</div>
					
					 <div class="form-group">
						<label for="">Merchant Name</label>
						<select class="form-control" name="seller_id" ID="seller_id">
							<option value="0">All Merchant</option>
							<?php
							
							/* for artCafe to link product groups to link sellers **sandeep**13-03-2020***/
							
							//echo $Logged_user_id."-----".$Super_seller;
								if($Logged_user_id > 2 || $Super_seller == 1)
								{
									echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
								}							
									foreach($Seller_array as $seller_val)
									{
										echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
									}
								?> 
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					<div class="form-group">
							<label for=""><span class="required_info">*</span> Main Group</label>
								<select class="form-control" name="Main_group_id" id="Main_group_id" required >
									<option value="">Select Main Group</option>
										<?php
										foreach($Product_group_Records as $Product_group)
										{
											echo '<option value="'.$Product_group->Product_group_id.'">'.$Product_group->Product_group_name.'</option>';
										}
										?>
								</select>									
					</div>
												
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Sub Group</label>
						<select class="form-control" name="Sub_group_id" id="Sub_group_id"  required>
							<option value="">Select Main Group first</option>
							
						</select>									
					</div>
							
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Menu Group</label>
						
						<select name="Menu_group_id" id="Menu_group_id" class="form-control" size="10" required>
						
						<?php
							foreach($Merchandize_Category_Records as $Merchandize_Category) {
								if(!$Merchandize_Category->Parent_category_id) {
									$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
									echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
								
									foreach($childs as $row) {
										echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
									}
								}							
							}
						?>		
						</select>
					</div>						
								</div>	
								
								<div class="col-sm-6">
									<div class="panel panel-default">
						<div class="panel-heading">
							<label for="">Upload Images of POS Item  <br><font color="RED" align="center" size="0.8em"><i>Image Resolution should be above 800(Horizontal) X 800(Vertical)  for best product view</i></font></label>
						</div>
					
						<div class="panel-body">
						
							<div class="row">
							
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-center"><strong>Item Image-1</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image1" class="img-responsive" style="width: 50%;">									
										<div class="caption">
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file1" id="file1" onchange="readImage(this,'#no_image1');" style="width: 100%;" data-error="Please select merchandise item image-1" />
													<div class="help-block form-text with-errors form-control-feedback"></div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-center"><strong>Item Image-2</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image2" class="img-responsive" style="width: 50%;">
										
										<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file2"  id="file2" onchange="readImage(this,'#no_image2');" style="width: 100%;" data-error="Please select merchandise item image-2" />
													<div class="help-block form-text with-errors form-control-feedback"></div>
												</div>
											</div>
									</div>
								</div>
								
							
								
							</div>
							
						</div>
						<div class="panel-body">
						
							<div class="row">
							
								
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-center"><strong>Item Image-3</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image3" class="img-responsive" style="width: 50%;">
										
										<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file3" onchange="readImage(this,'#no_image3');" style="width: 100%;" />
												</div>
											</div>
									</div>
								</div>
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-center"><strong>Item Image-4</strong></p></div>
										<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image4" class="img-responsive" style="width: 50%;">
										
										<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file4" onchange="readImage(this,'#no_image4');" style="width: 100%;" />
												</div>
											</div>
									</div>
								</div>
								
							</div>
							
						</div>
					</div>
				
								</div>
							</div>
						
							<div>						
								<fieldset class="form-group">
								<legend><span>What Type of Item is this ? </span></legend>
								<div class="row" >
										<div class="col-sm-12">
											<div class="form-group" >
										
												<label class="radio-inline">
													<input type="radio" name="Item_type"  value="117"  onclick="Item_type_toggle(this.value)"  checked>&nbsp;Standard Item

												</label>	
													&nbsp;&nbsp;
												<label class="radio-inline">
													<input type="radio" name="Item_type"  value="118"  onclick="Item_type_toggle(this.value)">&nbsp;Combo Meal

												</label>
												&nbsp;&nbsp;			
												<label class="radio-inline">
													<input type="radio" name="Item_type"  value="119"    onclick="Item_type_toggle(this.value)">&nbsp;Condiment 
												</label>
											</div>
										
									</div>
									
								</div>
								<div class="row" >
										<div class="col-md-4" id="Combo_meal_no_block" style="display:none;">
							
											<div class="form-group has-feedback">
												<label for=""><span class="required_info">*</span> Enter Combo Meal No.</label>
												<input type="text" name="Combo_meal_no" id="Combo_meal_no" class="form-control" placeholder="Enter Combo Meal No." onkeypress="return isNumberKey2(event);" />
											</div>
										</div>	
									
								</div>
								</fieldset>
							</div>
							
						<div class='row'>
							<div class="col-md-4">
								<label for=""><b>Allergies Icons</b></label>
								<div class="col-md-12">
									<div class="form-group" >
										<select class="form-control" multiple name="Allergies[]"  id="Allergies"  >
													<?php
													
													foreach($Allergies_Code_decode as $Rec)
													{
														echo '<option value="'.$Rec->Code_decode_id.'">'.$Rec->Code_decode.'</option>';
														
													}
													?>
										</select>
									</div>
								</div>	
							</div>
							
							<div class="col-md-8" id="Condiment_Group_block">
								<div class='row'>
									<div class="col-md-6">
										<label for=""><b>Required Condiment Group</b></label>
							
										<div class="col-md-12">
											<div class="form-group" >
												<select class="form-control" multiple name="Required_Condiment_Group[]"  id="Required_Condiment_Group" onchange="Get_cond_values(14);" >
																<?php
																foreach($Req_cond_group as $Rec)
																{
																	echo '<option value="'.$Rec->Group_code.'">'.$Rec->Group_name.'</option>';
																}
																?>
												</select>
											</div>
										</div>	
									</div>
				
									<div class="col-md-6">
										<label for=""><b>Optional Condiment Group</b></label>
										<div class="col-md-12">
											<div class="form-group" >
												<select class="form-control" multiple name="Optional_Condiment_Group[]"  id="Optional_Condiment_Group"  onchange="Get_cond_values(15);">
														<?php
														foreach($Opt_cond_group as $Rec)
														{
															
																echo '<option value="'.$Rec->Group_code.'">'.$Rec->Group_name.'</option>';
															
														}
														?>
												</select>
											</div>
										</div>	
									</div>
								</div>
							</div>
						</div>
				
						<div class="row">
							<div class="col-md-4">
							</div>
								
							<div class="col-md-4" id="Condiment_Values_block">
								
								<label for=""><b>Required Condiment Values</b></label>
								<div class="col-md-12">
									<div class="form-group" >
										<select class="form-control" multiple name="Required_Condiment_Values[]"  id="Required_Condiment_Values"  >
										</select>
									</div>
								</div>	
							</div>
								
							<div class="col-md-4"  id="Optional_Values_block">
								
								<label for=""><b>Optional Condiment Values</b></label>
									<div class="col-md-12">
										<div class="form-group" >
											<select class="form-control" multiple name="Optional_Condiment_Values[]"  id="Optional_Condiment_Values"  >
											</select>
										</div>
									</div>
							</div>
						</div>
				
							
							<div  id="Main_item_block" style="display:none;">
								<fieldset class="form-group">
								<legend><span>Main Item</span></legend>
								<div class="row">
									<div class="col-md-4">
											<br>
												<div class="form-group">
		
													<select name="Main_or_side_item_code0" id="Main_or_side_item_code0" class="form-control"   onchange="Get_side_items(this.value,0);" >
													<option value="">Select Menu Group</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
												</div>	
													<div class="col-md-5">
											<label for=""><span class="required_info">*</span> Main Item Label</label>
												<div class="form-group">
		
													<input type="text" name="Main_Side_label" id="Main_Side_label" class="form-control" placeholder="Enter Main Item Label "   />
												</div>	
											</div>
								
								</div>
								
								
								
								</fieldset>
							</div>
							
							<div class="col-md-12"  id="selected_main_item_block" style="display:none;">
								<div class="panel panel-default">
											<div class="panel-heading">
												<legend><span>Linked Main Group Items</span></legend>
											</div>
									<div class="panel-body">
										<div class="col-md-12"  id="Saved_Main_item_block" >
										
									
										</div>
									</div>
								</div>
							</div>
				
							<div  id="Side_item_block" style="display:none;">
								<fieldset class="form-group">
								<legend><span>Side Items</span></legend>
								<br><span class="required_info">(* To Enter the Side Item Details the window will open up when you select the Side Group)</span>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
										<div class="col-md-2" align="center">
											<label for=""><b>Active</b></label><BR>
												<input type="checkbox" name="Side_item_check[]" id="1"  value="1"  onclick="toggle_side_items(this.value);" >
													
											</div>	
											<div class="col-md-5">
											<label for=""><b>Link Side Items</b></label>

												<div class="form-group">
		
													<select name="Main_or_side_item_code1" id="Main_or_side_item_code1" class="form-control"   onchange="Get_side_items(this.value,1);" disabled>
													<option value="">Side Option 1</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											<label for=""><b>Side Label</b></label>
												<div class="form-group">
		
													<input type="text" name="Side_label1" id="Side_label1" class="form-control" placeholder="Enter Side Label 1"  disabled />
												</div>	
											</div>	
										
										</div>	
										<div class="row">
											<div class="col-md-2" align="center">
												<input type="checkbox" name="Side_item_check[]" id="2"  value="2"  onclick="toggle_side_items(this.value);">
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code2" id="Main_or_side_item_code2" class="form-control"   onchange="Get_side_items(this.value,2);"  disabled >
													<option value="">Side Option 2</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label2" id="Side_label2" class="form-control" placeholder="Enter Side Label 2"   disabled  />
												</div>	
											</div>	
										
										</div>	
										<div class="row">
											<div class="col-md-2" align="center">
												<input type="checkbox" name="Side_item_check[]" id="3"  value="3"  onclick="toggle_side_items(this.value);">
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code3" id="Main_or_side_item_code3" class="form-control"   onchange="Get_side_items(this.value,3);"  disabled >
													<option value="">Side Option 3</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label3" id="Side_label3" class="form-control" placeholder="Enter Side Label 3 "    disabled />
												</div>	
											</div>	
										</div>	
										<div class="row">
											<div class="col-md-2" align="center">
												<input type="checkbox" name="Side_item_check[]" id="4"  value="4" onclick="toggle_side_items(this.value);" >
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code4" id="Main_or_side_item_code4" class="form-control"   onchange="Get_side_items(this.value,4);"  disabled >
													<option value="">Side Option 4</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label4" id="Side_label4" class="form-control" placeholder="Enter Side Label 4 "   disabled  />
												</div>	
											</div>	
										</div>	
										<div class="row">
											<div class="col-md-2" align="center">
												<input type="checkbox" name="Side_item_check[]" id="5"  value="5" onclick="toggle_side_items(this.value);" >
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code5" id="Main_or_side_item_code5" class="form-control"   onchange="Get_side_items(this.value,5);"  disabled >
													<option value="">Side Option 5</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label5" id="Side_label5" class="form-control" placeholder="Enter Side Label 5 "   disabled  />
												</div>	
											</div>	
										</div>	
																	
									</div>	
									
									<div class="col-md-6">
											
										<div class="row">
											<div class="col-md-2" align="center">
												<label for=""><b>Active</b></label><BR>
												<input type="checkbox" name="Side_item_check[]" id="6"  value="6"  onclick="toggle_side_items(this.value);"  >
													
											</div>	
											<div class="col-md-5">
												<label for=""><b>Link Side Items</b></label>
												<div class="form-group">
		
													<select name="Main_or_side_item_code6" id="Main_or_side_item_code6" class="form-control"   onchange="Get_side_items(this.value,6);"  disabled >
													<option value="">Side Option 6</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											<label for=""><b>Side Label</b></label>
												<div class="form-group">
		
													<input type="text" name="Side_label6" id="Side_label6" class="form-control" placeholder="Enter Side Label 6"   disabled  />
												</div>	
											</div>	
										</div>	
										<div class="row">
											<div class="col-md-2" align="center">
											
												<input type="checkbox" name="Side_item_check[]" id="7"  value="7"  onclick="toggle_side_items(this.value);" >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code7" id="Main_or_side_item_code7" class="form-control"   onchange="Get_side_items(this.value,7);"  disabled >
													<option value="">Side Option 7</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label7" id="Side_label7" class="form-control" placeholder="Enter Side Label 7"    disabled />
												</div>	
											</div>	
										</div>	
										<div class="row">
											<div class="col-md-2" align="center">
											
												<input type="checkbox" name="Side_item_check[]" id="8"  value="8"  onclick="toggle_side_items(this.value);">
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code8" id="Main_or_side_item_code8" class="form-control"   onchange="Get_side_items(this.value,8);"  disabled >
													<option value="">Side Option 8</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label8" id="Side_label8" class="form-control" placeholder="Enter Side Label 8 "    disabled />
												</div>	
											</div>	
										</div>	
										<div class="row">
											<div class="col-md-2" align="center">
											
												<input type="checkbox" name="Side_item_check[]" id="9"  value="9" onclick="toggle_side_items(this.value);">
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code9" id="Main_or_side_item_code9" class="form-control"   onchange="Get_side_items(this.value,9);"  disabled >
													<option value="">Side Option 9</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label9" id="Side_label9" class="form-control" placeholder="Enter Side Label 9 "   disabled  />
												</div>	
											</div>	
										</div>	
										
										<div class="row">
											<div class="col-md-2" align="center">
											
												<input type="checkbox" name="Side_item_check[]" id="10"  value="10" onclick="toggle_side_items(this.value);">
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code10" id="Main_or_side_item_code10" class="form-control"   onchange="Get_side_items(this.value,10);" disabled>
													<option value="">Side Option 10</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;">'.$Merchandize_Category->Merchandize_category_name.'</option>';
															
																foreach($childs as $row) {
																	echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																}
															}							
														}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label10" id="Side_label10" class="form-control" placeholder="Enter Side Label 10 "   disabled />
												</div>	
											</div>	
										</div>	
									
														
										</div>
								</div>
								</fieldset>
							</div>
							
							<div class="row"  id="selected_Side_group_item_block" style="display:none;">
								<legend><span>Linked Side Group Items</span></legend>
									<div class="col-md-12"  id="Side_group_item_block" >
									</div>
							</div>
							
							
							<div class="row">
									
									<legend><span>Item Price Setup</span></legend>
									<div class="col-md-4">
										
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span class="required_info">*</span> POS Price</b><br><span class="required_info">&nbsp;</span>
								
											<div class="row">
												<div class="col-md-2">
												
													<input type="radio" name="Item_price_flag"  value="1" checked >
														
												</div>	
												<div class="col-md-10">
													<div class="form-group has-feedback">
														<input type="text" name="POS_Price1" id="POS_Price1" class="form-control" placeholder="Enter Price 1"  onkeypress="return isNumberKey2(event);" />
													</div>			
												</div>	
											</div>	
											<div class="row">
												<div class="col-md-2">
												
													<input type="radio" name="Item_price_flag"  value="2"   >
														
												</div>	
												<div class="col-md-10">
														<div class="form-group has-feedback">
														<input type="text" name="POS_Price2" id="POS_Price2" class="form-control" placeholder="Enter Price 2"  onkeypress="return isNumberKey2(event);" />	
												</div>	
												</div>	
											</div>	
										
											<div class="row">
												<div class="col-md-2">
												
													<input type="radio" name="Item_price_flag"  value="3" >
														
												</div>	
												<div class="col-md-10">
												<div class="form-group has-feedback">
														<input type="text" name="POS_Price3" id="POS_Price3" class="form-control" placeholder="Enter Price 3"  onkeypress="return isNumberKey2(event);" />	
												</div>	
												</div>	
											</div>	
								
									</div>
				
							<div class="col-md-4">
								<b><span class="required_info">*</span> Available From Date <br><span class="required_info">(* click inside textbox)</span></b>
									<div class="row">
											<div class="col-md-12">
											<div class="form-group has-feedback">
														<input type="text" name="POS_Valid_from1" id="datepicker1" class="form-control" placeholder="Start Date" />			
														<span class="input-group-addon" id="basic-addon2">
															<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
														</span>
													
											</div>	
											</div>	
											
											
											<div class="col-md-12">
											<div class="form-group has-feedback">
														<input type="text" name="POS_Valid_from2" id="datepicker2" class="form-control" placeholder="Start Date" />			
														<span class="input-group-addon" id="basic-addon2">
															<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
														</span>
													
											</div>	
											</div>	
											
											
											<div class="col-md-12">
											<div class="form-group has-feedback">
														<input type="text" name="POS_Valid_from3" id="datepicker3" class="form-control" placeholder="Start Date" />			
														<span class="input-group-addon" id="basic-addon2">
															<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
														</span>
													
											</div>						
											</div>						
																	
										</div>						
									
							</div>
				
							<div class="col-md-4">
							
									
											<b><span class="required_info">*</span> Available To Date <br><span class="required_info">(* click inside textbox)</span></b>
										
									<div class="row">
									
										<div class="col-md-12">
										<div class="form-group has-feedback">
													<input type="text" name="POS_Valid_till1" id="datepicker4" class="form-control" placeholder="End Date" />			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
											
										</div>	
										</div>	
										
										
										<div class="col-md-12">
										<div class="form-group has-feedback">
													<input type="text" name="POS_Valid_till2" id="datepicker5" class="form-control" placeholder="End Date" />			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
												
										</div>	
										</div>	
										
										
										
										
											<div class="col-md-12">
												<div class="form-group has-feedback">
													<input type="text" name="POS_Valid_till3" id="datepicker6" class="form-control" placeholder="End Date" />			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
														
												</div>	
											</div>	
										</div>	
									</div>
							</div>
						
							<div class="row">
								<legend><span>Loyalty Linkage</span></legend>
								<div class="col-md-3">
								Stamp Item

									<div class="form-group has-feedback" >
										
										<label class="radio-inline">
											<input type="radio" name="Stamp_item_flag"  value="1">&nbsp;Yes

										</label>
										&nbsp;&nbsp;		
										<label class="radio-inline">
											<input type="radio" name="Stamp_item_flag"  value="0"  checked  >&nbsp;No

										</label>									
										
									</div>
								</div>	
								<div class="col-md-3">
								
									<div class="form-group has-feedback">
										<label for="exampleInputEmail1">Extra Earn Points</label>
										<input type="text" name="Extra_earn_points" id="Extra_earn_points" class="form-control" placeholder="Enter Extra Earn Points"  onkeypress="return isNumberKey2(event);" />
									</div>
								</div>	
			
							</div>
							<div class="row">
								<legend><span>Voucher Item Linkage</span><span class="required_info">(item linkage for product or revenue voucher)</span></legend>
								<div class="col-md-3">
								Voucher Item

									<div class="form-group has-feedback" >
										
										<label class="radio-inline">
											<input type="radio" name="Voucher_item_flag"  value="1">&nbsp;Yes

										</label>
										&nbsp;&nbsp;		
										<label class="radio-inline">
											<input type="radio" name="Voucher_item_flag"  value="0"  checked  >&nbsp;No

										</label>									
										
									</div>
								</div>	
								<div class="col-md-3">
								
									
								</div>	
			
							</div>
							
							
							
							
							
							
							
							
							
							
								
						  <div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" id="Register">Submit</button>
							<button class="btn btn-primary" type="reset">Reset</button>
							
						  </div>
					</div>
				</div>
				<?php echo form_close(); ?>	
				
				<!--------------Table------------->	
<?php
				if($Merchandize_Items_Records != NULL)
				{?>					
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Active POS Items
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
					<th class="text-center">Action</th>
					<th class="text-center">Item Code</th>
					<th class="text-center">Item Type</th>
					<th class="text-center">POS Item Name</th>
					<th class="text-center">Menu Category</th>
					<th class="text-center">Validity</th>
					
				</tr>
							</thead>						
							<tfoot>
								<tr>
					<th class="text-center">Action</th>
					<th class="text-center">Item Code</th>
					<th class="text-center">Item Type</th>
					<th class="text-center">POS Item Name</th>
					<th class="text-center">Menu Category</th>
					<th class="text-center">Validity</th>
					
				</tr>
							</tfoot>
							<tbody>
						<?php
				
					foreach($Merchandize_Items_Records as $row)
					{
						$Todays_date=date("Y-m-d");
						$Color="";
						if($Todays_date>=$row->Valid_from && $Todays_date<=$row->Valid_till)
						{
							$Color="green";
						}
						
						
						$Item_type_details = $ci_object->POS_catalogue_model->Get_Specific_Code_decode_master($row->Merchandize_item_type);
						
						$POS_item_type= $Item_type_details->Code_decode;
						
						
						
					?>
					
						<tr>
							<td class="text-center">
								<a href="<?php echo base_url()?>index.php/POS_CatalogueC/Edit_POS_Items/?Company_merchandise_item_id=<?php echo $row->Company_merchandise_item_id;?>" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
								<a href="javascript:void(0);" onclick="delete_me('<?php echo $row->Company_merchandise_item_id;?>','<?php echo $row->Merchandize_item_name; ?>','','POS_CatalogueC/InActive_POS_Item/?Company_merchandise_item_id');"  data-target="#deleteModal" data-toggle="modal" title="Delete">
									<i class="os-icon os-icon-ui-15"></i>
										</a>
							</td>
							<td class="text-center"><?php echo $row->Company_merchandize_item_code; ?></td>
							<td class="text-center"><?php echo $POS_item_type; ?></td>
							<td><?php echo $row->Merchandize_item_name; ?></td>
							<td><?php echo $row->Merchandize_category_name; ?></td>
							
							<td><?php echo "<font color=".$Color.">".$row->Valid_from.' To '.$row->Valid_till."</font>"; ?></td>
							
							
						</tr>
					<?php
					}
				} else
	{
	?>
	
	<div class="panel panel-info">
		<div class="panel-heading text-center"><h4>No Records Found</h4></div>
	</div>
	
	<?php } ?>	
							</tbody>
						</table>
					  </div>
					</div>
				</div>
				<!--------------Table--------------->
				
				
				<!--------------Table------------->	
<?php
				if($InActive_Merchandize_Items_Records != NULL)
				{?>					
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					 Inactive POS Items
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
					<th class="text-center">Action</th>
					<th class="text-center">Item Code</th>
					<th class="text-center">Item Type</th>
					<th class="text-center">POS Item Name</th>
					<th class="text-center">Menu Category</th>
					<th class="text-center">Validity</th>
					
				</tr>
							</thead>						
							<tfoot>
								<tr>
					<th class="text-center">Action</th>
					<th class="text-center">Item Code</th>
					<th class="text-center">Item Type</th>
					<th class="text-center">POS Item Name</th>
					<th class="text-center">Menu Category</th>
					<th class="text-center">Validity</th>
					
				</tr>
							</tfoot>
							<tbody>
						<?php
				
					foreach($InActive_Merchandize_Items_Records as $row)
					{
						$Todays_date=date("Y-m-d");
						$Color="";
						if($Todays_date>=$row->Valid_from && $Todays_date<=$row->Valid_till)
						{
							$Color="green";
						}
						
						
						$Item_type_details = $ci_object->POS_catalogue_model->Get_Specific_Code_decode_master($row->Merchandize_item_type);
						
						$POS_item_type= $Item_type_details->Code_decode;
						
						
						
					?>
					
						<tr>
							<td class="text-center">
								<a href="<?php echo base_url()?>index.php/POS_CatalogueC/Edit_POS_Items/?Company_merchandise_item_id=<?php echo $row->Company_merchandise_item_id;?>" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
								<a href="javascript:void(0);" onclick="delete_me_inactive('<?php echo $row->Company_merchandise_item_id;?>','<?php echo $row->Merchandize_item_name; ?>','','POS_CatalogueC/Active_POS_Item/?Company_merchandise_item_id');"  data-target="#deleteModal2" data-toggle="modal" title="Delete">
									<i class="os-icon os-icon-ui-15"></i>
										</a>
							</td>
							<td class="text-center"><?php echo $row->Company_merchandize_item_code; ?></td>
							<td class="text-center"><?php echo $POS_item_type; ?></td>
							<td><?php echo $row->Merchandize_item_name; ?></td>
							<td><?php echo $row->Merchandize_category_name; ?></td>
							
							<td><?php echo "<font color=".$Color.">".$row->Valid_from.' To '.$row->Valid_till."</font>"; ?></td>
							
							
						</tr>
							
					<?php
					}
				} ?>
						</tbody>
						</table>
					  </div>
					</div>
				</div>
				<!--------------Table--------------->
			</div>
		</div>	
	</div>
</div>


	<div id="myModal1" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-lg" style="margin-top:11%;">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<h5 class="modal-title" id="exampleModalLabel">
				   Receipt Details
				</h5>-->
			  </div>
			  <div class="modal-body">
				<div  id="show_multiple_offer"></div>
			  </div>
			 
			</div>
		</div>
    </div>
	
<!-- Side Items Groups Modal --
			
				<div id="myModal1" class="modal fade" role="dialog">
					<div class="modal-dialog" style="width: 90%;">

					
						<div class="modal-content">
							
							<div class="modal-body">
								<div  id="show_multiple_offer"></div>
							</div>
							
						</div>

					</div>
				</div>	
	<!-- Modal content-->			
<?php $this->load->view('header/footer'); ?>
<!-------------------- Delete - Start -------------------->	
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show" id="deleteModal2" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Please Wait
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="arg11" id="arg11" value=""/>
                <input type="hidden" name="arg21" id="arg21" value=""/>
                <input type="hidden" name="arg31" id="arg31" value="">
                <input type="hidden" name="argUrl1" id="argUrl1" value=""/>
                Are you sure to Active the <b id="arg21"></b><br><span id="arg31" class="text-danger"></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button"> Cancel</button>
                <button class="btn btn-primary" type="button" onclick="confirmed_delete2(arg11.value, arg21.value, arg31.value, argUrl1.value)">Delete</button>
            </div>
        </div>
    </div>
</div>	



<!-------------------- Delete - End ---------------------->		
<script>
function confirmed_delete2(arg1, arg2, arg3, argUrl) {

    if (argUrl)
    {
        var url = '<?php echo base_url(); ?>index.php/' + argUrl + '=' + arg1;
        $('#deleteModal2').modal('hide');
        show_loader();
        setTimeout(function () {
            window.location = url;
        }, 3000)


        return true;
    } else
    {
        return false;
    }

}
function delete_me_inactive(arg1, arg2, arg3, argUrl) 
{

    $(".modal-body #arg11").val(arg1);
    $(".modal-body #arg11").html(arg1);

    $(".modal-body #arg21").val(arg2);
    $(".modal-body #arg21").html(arg2);


    $(".modal-body #arg31").val(arg3);
	
    $(".modal-body #argUrl1").val(argUrl);

}
	$( "#close_modal12" ).click(function(e)
	{
	
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
$('#Register').click(function()
{
	if($('#Company_merchandize_item_code').val() != "" && $('#Merchandize_item_name').val() != "" && $('#Merchandise_item_description').val() != "" && $('#Main_group_id').val() != "" && $('#Menu_group_id').val() != "" && $('#Sub_group_id').val() != "" )
	{
		var Item_type = $("input[name=Item_type]:checked").val();
		var Item_price_flag = $("input[name=Item_price_flag]:checked").val();
		$('#Combo_meal_no').removeAttr('required');
		$('#Main_or_side_item_code0').removeAttr('required');
		$('#Main_Side_label').removeAttr('required');
			
		if(Item_type==118)//combo
		{
			var Combo_meal_no =$('#Combo_meal_no').val();
			var Main_or_side_item_code0 =$('#Main_or_side_item_code0').val();
			var Main_Side_label =$('#Main_Side_label').val();
			
			$('#Combo_meal_no').attr('required', 'required');
			$('#Main_or_side_item_code0').attr('required', 'required');
			$('#Main_Side_label').attr('required', 'required');
			
			
			
			/*if(Combo_meal_no== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter Combo Meal No.';
				alert(msg);
				return false;
			}
		
			if(Main_or_side_item_code0== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select Menu Group for Main Item !!!';
				alert(msg);
				return false;
			}
		
			if(Main_Side_label== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter Side Label for Main Item !!!';
				runjs(Title,msg);
				return false;
			}*/
			
			for(var i=1; i<=10; i++)
			{
				var Side_options = $("input[id="+i+"]:checked").val();
				
				if(Side_options == i)
				{
					var Main_or_side_item_code =$('#Main_or_side_item_code'+i).val();
					var Side_label =$('#Side_label'+i).val();
					$('#Main_or_side_item_code'+i).attr('required', 'required');
					$('#Side_label'+i).attr('required', 'required');
					/*if(Main_or_side_item_code == "")
					{
						var Title = "Application Information";
						var msg = 'Please Select Side Option '+i;
						alert(msg);
						return false;
					}
					if(Side_label == "")
					{
						var Title = "Application Information";
						var msg = 'Please Enter Side Label '+i;
						alert(msg);
						return false;
					}*/
				}
				
			}
		}
		
		
		if(Item_price_flag==1)
		{
			var POS_Price1 =$('#POS_Price1').val();
			var datepicker1 =$('#datepicker1').val();
			var datepicker4 =$('#datepicker4').val();
			
			$('#POS_Price1').attr('required', 'required');
			$('#datepicker1').attr('required', 'required');
			$('#datepicker4').attr('required', 'required');
			
			$('#POS_Price2').removeAttr('required');
			$('#datepicker2').removeAttr('required');
			$('#datepicker5').removeAttr('required');
			
			$('#POS_Price3').removeAttr('required');
			$('#datepicker3').removeAttr('required');
			$('#datepicker6').removeAttr('required');
			/*if(POS_Price1== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter POS Price 1';
				alert(msg);
				return false;
			}
			if(datepicker1== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 1 From Date';
				alert(msg);
				return false;
			}
			if(datepicker4== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 1 To Date';
				alert(msg);
				return false;
			}
			*/
		}
		
		if(Item_price_flag==2)
		{
			var POS_Price2 =$('#POS_Price2').val();
			var datepicker2 =$('#datepicker2').val();
			var datepicker5 =$('#datepicker5').val();
			
			$('#POS_Price2').attr('required', 'required');
			$('#datepicker2').attr('required', 'required');
			$('#datepicker5').attr('required', 'required');
			
			$('#POS_Price1').removeAttr('required');
			$('#datepicker1').removeAttr('required');
			$('#datepicker4').removeAttr('required');
			
			$('#POS_Price3').removeAttr('required');
			$('#datepicker3').removeAttr('required');
			$('#datepicker6').removeAttr('required');
			/*if(POS_Price2== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter POS Price 2';
				alert(msg);
				return false;
			}
			if(datepicker2== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 2 From Date';
				alert(msg);
				return false;
			}
			if(datepicker5== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 2 To Date';
				alert(msg);
				return false;
			}
			*/
		}
		if(Item_price_flag==3)
		{
			var POS_Price3 =$('#POS_Price3').val();
			var datepicker3 =$('#datepicker3').val();
			var datepicker6 =$('#datepicker6').val();
			
			$('#POS_Price3').attr('required', 'required');
			$('#datepicker3').attr('required', 'required');
			$('#datepicker6').attr('required', 'required');
			
			$('#POS_Price1').removeAttr('required');
			$('#datepicker1').removeAttr('required');
			$('#datepicker4').removeAttr('required');
			
			$('#POS_Price2').removeAttr('required');
			$('#datepicker2').removeAttr('required');
			$('#datepicker5').removeAttr('required');
			
			
			
			/*if(POS_Price3== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter POS Price 3';
				alert(msg);
				return false;
			}
			if(datepicker3== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 3 From Date';
				alert(msg);
				return false;
			}
			if(datepicker6== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 3 To Date';
				alert(msg);
				return false;
			}
			*/
		}
		
		// show_loader();
	}
});



	
	function toggle_side_items(id)//  
	{
		if(document.getElementById(id).checked==true)
		{
			$("#Main_or_side_item_code"+id).removeAttr("disabled"); 
			$("#Side_label"+id).removeAttr("disabled"); 
		}
		else
		{
			$("#Main_or_side_item_code"+id).val('');
			$("#Main_or_side_item_code"+id).attr("disabled", "disabled"); 
			$("#Side_label"+id).attr("disabled", "disabled"); 
			
			var Menu_Item_code = $("#Company_merchandize_item_code").val();
			$.ajax({
					  type: "POST",
					  data: {Menu_Item_code: Menu_Item_code,Side_option: id},
					  url: "<?php echo base_url()?>index.php/POS_CatalogueC/Delete_side_group_child",
					  success: function(data)
						{
						  $('#Side_group_item_block').html(data.Linked_side_group_items);
						}
				});
		}
		
	}
	
	$('#Main_item_name').blur(function()
	{
		
		var Main_item_name = $("#Main_item_name").val();
		
		var res = Main_item_name.split(":");
		var Company_id = '<?php echo $Company_id; ?>';
		
			var Company_merchandize_item_code = res[1];
			var Main_item_name = res[0];
				var Company_id = '<?php echo $Company_id; ?>';
				//alert(Branch_code);
				$.ajax({
					  type: "POST",
					  data: {Company_merchandize_item_code: Company_merchandize_item_code, Company_id: Company_id, Main_item_name: Main_item_name},
					  url: "<?php echo base_url()?>index.php/POS_CatalogueC/Check_POS_Item",
					  success: function(data)
					  {
						  // alert(data);
							 if(data == 1)
							{
								$('#Main_item_code').val(res[1]);
								$('#error_main').hide();
							}
							else
							{
								$('#Main_item_code').val(0);
								$('#Main_item_name').val('');
								$('#error_main').show();
							} 
					}
				});
		
	});
	
	function Get_cond_values(Cond_type)
	{
		var Company_id = '<?php echo $Company_id; ?>';
		if(Cond_type==14) //Required
		{
			var Group_code = $('#Required_Condiment_Group').val(); 
		}
		else
		{
			var Group_code = $('#Optional_Condiment_Group').val(); 
		} 
		 
		  // alert(Group_code);
		$.ajax({
			type:"POST",
			data:{Group_code:Group_code, Cond_type:Cond_type, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/POS_CatalogueC/Get_cond_group_values",
			success: function(data)
			{
				 // alert(data.Condiment_item_code);
				 // alert(data.Condiment_item_code.length);
				 if(Cond_type==14) //Required
				{
					$('#Required_Condiment_Values').empty();
					for (var i = 0; i < data.Condiment_item_code.length; ++i)
					{
						optionText = data.Merchandize_item_name[i]; 
						optionValue = data.Condiment_item_code[i]; 
						// $("#Required_Condiment_Values option[value="+val+"]").remove();
						$('#Required_Condiment_Values').append(new Option(optionText, optionValue)); 
					}
					// $('#Required_Condiment_Values').html(data.POS_group_values);
				}
				else
				{
					$('#Optional_Condiment_Values').empty();
					for (var i = 0; i < data.Condiment_item_code.length; ++i)
					{
						optionText = data.Merchandize_item_name[i]; 
						optionValue = data.Condiment_item_code[i]; 
						// $("#Required_Condiment_Values option[value="+val+"]").remove();
						$('#Optional_Condiment_Values').append(new Option(optionText, optionValue)); 
					}
					// $('#Optional_Condiment_Values').html(data.POS_group_values);
				} 
			}				
		});
	}
	function Item_type_toggle(flag)
	{
		
		if(flag==117) //Standard
		{
			
			$("#Combo_meal_no_block").hide();
			$("#Main_item_block").hide();
			$("#Side_item_block").hide();
			$("#Side_group_item_block").hide();
			$("#selected_Side_group_item_block").hide();
			$("#selected_main_item_block").hide();
			$("#Condiment_Group_block").show();
			$("#Optional_Values_block").show();
			$("#Condiment_Values_block").show();
			
			// $("#Product_brand_id").attr("required","required");	
		}
		else if(flag==118)//Combo
		{
			$("#Optional_Values_block").hide();
			$("#Condiment_Values_block").hide();
			$("#Condiment_Group_block").hide();
			$("#selected_main_item_block").show();
			$("#Combo_meal_no_block").show();
			$("#Main_item_block").show();
			$("#Side_item_block").show();
			$("#Side_group_item_block").show();
			$("#selected_Side_group_item_block").show();
			
			// $("#Product_group_id").removeAttr("required");	
		}
		else //Condiment
		{
			$("#Main_item_block").hide();
			$("#Side_item_block").hide();
			$("#Side_group_item_block").hide();
			
			$("#Optional_Values_block").hide();
			$("#Condiment_Values_block").hide();
			$("#selected_main_item_block").hide();
			$("#Condiment_Group_block").hide();
			$("#Combo_meal_no_block").hide();
			$("#selected_Side_group_item_block").hide();
		}
	}

	//******* sandeep *****************
	$('#seller_id').change(function()
	{
		var seller_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/POS_CatalogueC/get_seller_main_groups',
			success:function(opData){
				$('#Main_group_id').html(opData);
			}
		});
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/POS_CatalogueC/get_seller_menu_groups',
			success:function(opData2){
				$('#Menu_group_id').html(opData2);
			}
		});
	});
	
	//******* sandeep *****************
	$('#Main_group_id').change(function()
	{
		var Main_group_id = $("#Main_group_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Main_group_id:Main_group_id, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/POS_CatalogueC/Get_POS_sub_groups",
			success: function(data)
			{
				$('#Sub_group_id').html(data.Product_groups);
			}				
		});
	});
	

	function Get_side_items(Item,Side_option)
	{
		
		var Company_id = '<?php echo $Company_id; ?>';
		var Company_merchandize_item_code = $("#Company_merchandize_item_code").val();
		var Main_Side_label = $("#Main_Side_label").val();
		$.ajax({
			type:"POST",
			data:{Item:Item, Company_id:Company_id, Company_merchandize_item_code:Company_merchandize_item_code, Side_option:Side_option,Main_Side_label:Main_Side_label},
			url: "<?php echo base_url()?>index.php/POS_CatalogueC/Get_side_groups_items",
			success: function(data)
			{
				//alert(data.Side_Group_Items);
				 // $('#Side_group_item_block').html(data.Side_Group_Items);
				 
				 
				 $("#show_multiple_offer").html(data.Side_Group_Items);	
					$('#myModal1').show();
					$("#myModal1").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
			}				
		});
	}
function Get_POS_items(Menu_group_id,search_flag)
{
		if(search_flag==3)
		{
			$('#Search1').val('');
			$('#Search2').val('');
		}
		else 
		{
			$('#Search1').val('');
			$('#Search2').val('');
			$('#Search3').val('');
		}
		
		
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
				type: "POST",
				data: {Menu_group_id: Menu_group_id,search_flag: search_flag, Company_id: Company_id},
				url: "<?php echo base_url()?>index.php/POS_CatalogueC/Get_POS_items",
				success: function(data)
				{
					// alert(data.records);
					$('#show_records').html(data.records);
				}
		});
	
}

/**********Get Partner details***********************/

var Company_id = '<?php echo $Company_id; ?>';



function Merchandize_Item_inactive(Company_merchandise_item_id,Merchandize_item_name)
{	

		var url = '<?php echo base_url()?>index.php/POS_CatalogueC/InActive_POS_Item/?Company_merchandise_item_id='+Company_merchandise_item_id;
		BootstrapDialog.confirm("Are you sure to Delete the POS Item '"+Merchandize_item_name+"' ?", function(result) 
		{
		
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
function isNumberKey2(evt)
{
	
  var charCode = (evt.which) ? evt.which : event.keyCode
// alert(charCode);
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}

	
	$('#Company_merchandize_item_code').blur(function()
		{
			//alert();
			if( $("#Company_merchandize_item_code").val()  == "" )
			{
				$("#Company_merchandize_item_code").val("");					
				$("#help-block1").html("Please enter Item code");
				$("#Company_merchandize_item_code").addClass("form-control has-error");
			}
			else
			{
				var Company_merchandize_item_code = $("#Company_merchandize_item_code").val();
				var Company_id = '<?php echo $Company_id; ?>';
				//alert(Branch_code);
				$.ajax({
					  type: "POST",
					  data: {Company_merchandize_item_code: Company_merchandize_item_code, Company_id: Company_id},
					  url: "<?php echo base_url()?>index.php/CatalogueC/Check_Merchandize_Item_Code",
					  success: function(data)
					  {
						  //alert(data.length);
							if(data.length == 13)
							{
								$("#Company_merchandize_item_code").val("");					
								$("#help-block1").html("Already exist");
								$("#Company_merchandize_item_code").addClass("form-control has-error");
							}
							else
							{
								$("#Company_merchandize_item_code").removeClass("has-error");
								$("#help-block1").html("");
							}
						
							
					  }
				});
			}
		});

	

	
/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
	$( "#datepicker3" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
	$( "#datepicker4" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
	$( "#datepicker5" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
	$( "#datepicker6" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
});
/******calender *********/
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
	$(document).ready(function() {
		$('table#dataTable2').DataTable();
	});
</script>

<style>
.thumbnail {
    display: block;
    padding: 4px;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
}
.thumbnail>img 
{
    margin-right: auto;
    margin-left: auto;
}
.img-responsive, .thumbnail>img {
    display: block;
    max-width: 100%;
    height: auto;
}
</style>