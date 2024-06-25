 <?php 
	$this->load->view('header/header');
	$ci_object = &get_instance();
	$ci_object->load->model('Coal_catalogue/Coal_Catelogue_model');
	$ci_object->load->model('POS_catlogueM/POS_catalogue_model');
	
	
	
 ?>

	<div class="row">
		<div class="col-md-12">
			<h1 class="page-head-line">Edit POS Items</h1>
		</div>
	</div>
	
	<div class="row">
	
		<?php echo form_open_multipart('POS_CatalogueC/Edit_POS_Items'); ?>
		
		<input type="hidden" name="Company_merchandise_item_id" id="Company_merchandise_item_id" value="<?php echo $Merchandize_Item_Row->Company_merchandise_item_id; ?>"/>	
		<input type="hidden" name="Company_merchandize_item_code" id="Company_merchandize_item_code" value="<?php echo $Merchandize_Item_Row->Company_merchandize_item_code; ?>"/>	

		
		<div class="col-md-12">
			
			<?php
				if(@$this->session->flashdata('Items_flash') || $this->session->flashdata('upload_error_code'))
				{
				?>
					<script>
						var Title = "Application Information";
						var msg = '<?php echo $this->session->flashdata('Items_flash')."<br>".$this->session->flashdata('upload_error_code'); ?>';
						runjs(Title,msg);
					</script>
				<?php
				}
				
			?>
	
		<div class="panel panel-default"> 
			<div class="panel-body">
			
				<div class="col-md-6">
					
					<div class="form-group has-feedback"  id="has-feedback1">
						<label for="exampleInputEmail1"><span class="required_info">*</span>  Item Code </label>
						<input type="text" name="Company_merchandize_item_code2" id="Company_merchandize_item_code2" class="form-control" disabled value="<?php echo $Merchandize_Item_Row->Company_merchandize_item_code; ?>"/>						
						<span class="glyphicon" id="glyphicon2" aria-hidden="true"></span>
						<div class="help-block" id="help-block2"></div>
					</div>
					
					<div class="form-group has-feedback">
						<label for="exampleInputEmail1"><span class="required_info">*</span> Item Name</label>
						<input type="text" name="Merchandize_item_name" id="Merchandize_item_name" class="form-control" placeholder="Enter Item Name" required value="<?php echo $Merchandize_Item_Row->Merchandize_item_name; ?>"/>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">*</span> Item Description</label>
						<textarea class="form-control" rows="3" id="Merchandise_item_description" name="Merchandise_item_description" required placeholder="Enter item Description"><?php echo $Merchandize_Item_Row->Merchandise_item_description; ?></textarea>
					</div>
					<div class="form-group">
							<label for="exampleInputEmail1"><span class="required_info">*</span> Main Group</label>
								<select class="form-control" name="Main_group_id" id="Main_group_id" required onchange="get_sub_groups(this.value,1);">
									<option value="">Select Main Group</option>
										<?php
										foreach($Product_group_Records as $Product_group)
										{
											if($Merchandize_Item_Row->Product_group_id==$Product_group->Product_group_id)
											{
												echo '<option value="'.$Product_group->Product_group_id.'" selected >'.$Product_group->Product_group_name.'</option>';
											}
											else
											{
												echo '<option value="'.$Product_group->Product_group_id.'">'.$Product_group->Product_group_name.'</option>';
											}
											
										}
										?>
								</select>									
					</div>
												
					<div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">*</span> Sub Group</label>
						<select class="form-control" name="Sub_group_id" id="Sub_group_id"  required>
							<option value="">Select Main Group first</option>
						</select>									
					</div>
							
					<div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">*</span> Menu Group</label>
						
						<select name="Menu_group_id" id="Menu_group_id" class="form-control" size="10" required >
						<?php
							foreach($Merchandize_Category_Records as $Merchandize_Category) {
								
								
									if(!$Merchandize_Category->Parent_category_id) {
										
									$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
									if($Merchandize_Item_Row->Merchandize_category_id==$Merchandize_Category->Merchandize_category_id)
										{
											echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected >'.$Merchandize_Category->Merchandize_category_name.'</option>';
										}
										else
										{
											echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;"  >'.$Merchandize_Category->Merchandize_category_name.'</option>';
										}
										foreach($childs as $row) {
										if($Merchandize_Item_Row->Merchandize_category_id==$row->Merchandize_category_id)
										{
											echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected >--'.$row->Merchandize_category_name.'</option>';
										}
										else
										{
											echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;"  >--'.$row->Merchandize_category_name.'</option>';
										}
									}
									}
								}
								
											
															
							
						?>		
						</select>
					</div>
					
					
					
					
					
					
				</div>			
			
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<label for="exampleInputEmail1">Upload Images of POS Item  <br><font color="RED" align="center" size="0.8em"><i>Image Resolution should be above 800(Horizontal) X 800(Vertical)  for best product view</i></font></label>
						</div>
					
						<div class="panel-body">
						
							<div class="row">
							
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-center"><strong>Item Image-1</strong></p></div>
										<?php if($Merchandize_Item_Row->Item_image1 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image1; ?>" id="no_image1" class="img-responsive" style="width: 50%;">
										<?php }else{ ?>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image1" class="img-responsive" style="width: 50%;">
										<?php } ?>								
										<div class="caption">
											<div class="form-group">
												<input type="file" name="file1" id="file1" onchange="readImage(this,'#no_image1');" style="width: 100%;"  />
												<input type="hidden" name="Item_image1" value="<?php echo $Merchandize_Item_Row->Item_image1;?>">
												<input type="hidden" name="Thumbnail_image1" value="<?php echo $Merchandize_Item_Row->Thumbnail_image1;?>">
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-center"><strong>Item Image-2</strong></p></div>
										<?php if($Merchandize_Item_Row->Item_image2 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image2; ?>" id="no_image2" class="img-responsive" style="width: 50%;">
										<?php }else{ ?>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image2" class="img-responsive" style="width: 50%;">

										<?php } ?>
										
										<div class="caption">
											<div class="form-group">
												<input type="file" name="file2"  id="file2" onchange="readImage(this,'#no_image2');" style="width: 100%;"  />
												<input type="hidden" name="Item_image2" value="<?php echo $Merchandize_Item_Row->Item_image2;?>">
												<input type="hidden" name="Thumbnail_image2" value="<?php echo $Merchandize_Item_Row->Thumbnail_image2;?>">
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
										<?php if($Merchandize_Item_Row->Item_image3 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image3; ?>" id="no_image3" class="img-responsive" style="width: 50%;">
										<?php }else{ ?>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image3" class="img-responsive" style="width: 50%;">
										<?php } ?>
										
										<div class="caption">
											<div class="form-group">
												<input type="file" name="file3" onchange="readImage(this,'#no_image3');" style="width: 100%;" />
												<input type="hidden" name="Item_image3" value="<?php echo $Merchandize_Item_Row->Item_image3;?>">
												<input type="hidden" name="Thumbnail_image3" value="<?php echo $Merchandize_Item_Row->Thumbnail_image3;?>">
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-xs-6 col-md-6">
									<div class="thumbnail">
										<div class="caption"><p class="text-center"><strong>Item Image-4</strong></p></div>
										<?php if($Merchandize_Item_Row->Item_image4 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image4; ?>" id="no_image4" class="img-responsive" style="width: 50%;">
										<?php }else{ ?>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image4" class="img-responsive" style="width: 50%;">
										<?php } ?>
										
										<div class="caption">
											<div class="form-group">
												<input type="file" name="file4" onchange="readImage(this,'#no_image4');" style="width: 100%;" />
												<input type="hidden" name="Item_image4" value="<?php echo $Merchandize_Item_Row->Item_image4;?>">
												<input type="hidden" name="Thumbnail_image4" value="<?php echo $Merchandize_Item_Row->Thumbnail_image4;?>">
											</div>
										</div>
									</div>
								</div>
								
							</div>
							
						</div>
					</div>
				
				</div>
				<div class="col-md-12">
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>What Type of Item is this ? </b></h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
							
								<div class="form-group" >
									
									<label class="radio-inline">
										<input type="radio" name="Item_type"  value="117"  onclick="Item_type_toggle(this.value)"  <?php if($Merchandize_Item_Row->Merchandize_item_type==117){echo 'checked';} ?> >Standard Item

									</label>										
									<label class="radio-inline">
										<input type="radio" name="Item_type"  value="118"  onclick="Item_type_toggle(this.value)"  <?php if($Merchandize_Item_Row->Merchandize_item_type==118){echo 'checked';} ?> >Combo Meal

									</label>									
									<label class="radio-inline">
										<input type="radio" name="Item_type"  value="119"    onclick="Item_type_toggle(this.value)"  <?php if($Merchandize_Item_Row->Merchandize_item_type==119){echo 'checked';} ?> >Condiment 
									</label>
								</div>
							</div>	
							<div class="col-md-4" id="Combo_meal_no_block" <?php if($Merchandize_Item_Row->Merchandize_item_type!=118){echo 'style="display:none;"';} ?> >
							
								<div class="form-group has-feedback">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Enter Combo Meal No.</label>
									<input type="text" name="Combo_meal_no" id="Combo_meal_no" class="form-control" placeholder="Enter Combo Meal No." onkeypress="return isNumberKey2(event);" value="<?php echo $Merchandize_Item_Row->Combo_meal_number; ?>"/>
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				
					<div class="col-md-4">
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Allergies Icons</b></h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
							
								<div class="form-group" >
									
									<select class="form-control" multiple name="Allergies[]"  id="Allergies"  >
													<?php
													
													//print_r($Allergies_selected);
													$Allergies=array();
													if($Allergies_selected != NULL)
													{
														foreach($Allergies_selected as $Rec2)
														{
															$Allergies[]=$Rec2->Condiment_item_code;
														}
													}
													foreach($Allergies_Code_decode as $Rec)
													{
														if(in_array($Rec->Code_decode_id, $Allergies))
														{
															echo '<option value="'.$Rec->Code_decode_id.'" selected>'.$Rec->Code_decode.'</option>';
														}
														else
														{
															echo '<option value="'.$Rec->Code_decode_id.'" >'.$Rec->Code_decode.'</option>';
														}
														
														
													}
													?>
										</select>
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				<div class="col-md-8" id="Condiment_Group_block"  <?php if($Merchandize_Item_Row->Merchandize_item_type!=117){echo 'style="display:none;"';} ?> >
				
				<div class="col-md-6">
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Required Condiment Group</b></h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
							
								<div class="form-group" >
									
									<select class="form-control" multiple name="Required_Condiment_Group[]"  id="Required_Condiment_Group" onchange="Get_cond_values(14);" >
													<?php
													$Req_groups=array();
													if($Required_selected != NULL)
													{
														foreach($Required_selected as $Rec2)
														{
															$Req_groups[]=$Rec2->Group_code;
														}
														
													}
													// print_r($Req_groups);
													foreach($Req_cond_group as $Rec)
													{
														if(in_array($Rec->Group_code, $Req_groups))
														{
															echo '<option value="'.$Rec->Group_code.'" selected>'.$Rec->Group_name.'</option>';
														}
														else
														{
															echo '<option value="'.$Rec->Group_code.'">'.$Rec->Group_name.'</option>';
														}
														
													}
													?>
										</select>
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				
				<div class="col-md-6">
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Optional Condiment Group</b></h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
							
								<div class="form-group" >
									
									<select class="form-control" multiple name="Optional_Condiment_Group[]"  id="Optional_Condiment_Group"  onchange="Get_cond_values(15);">
													<?php
													$Opt_groups=array();
													if($Optional_selected != NULL)
													{
														foreach($Optional_selected as $Rec2)
														{
															$Opt_groups[]=$Rec2->Group_code;
														}
														
													}
													
													foreach($Opt_cond_group as $Rec)
													{
														if(in_array($Rec->Group_code, $Opt_groups))
														{
															echo '<option value="'.$Rec->Group_code.'" selected>'.$Rec->Group_name.'</option>';
														}
														else
														{
															echo '<option value="'.$Rec->Group_code.'">'.$Rec->Group_name.'</option>';
														}
													}
													?>
										</select>
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				</div>
				
				
				
				<div class="col-md-4">
			
			
				</div>
				
				<div class="col-md-4" id="Condiment_Values_block"  <?php if($Merchandize_Item_Row->Merchandize_item_type!=117){echo 'style="display:none;"';} ?> >
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Required Condiment Values</b></h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
							
								<div class="form-group" >
									
									<select class="form-control" multiple name="Required_Condiment_Values[]"  id="Required_Condiment_Values"  >
											<?php
												$Req_groups=array_unique($Req_groups);
												$Req_sel_values=array();
												if($Required_selected != NULL)
												{
													foreach($Required_selected as $Rec2)
													{
														$Req_sel_values[]=$Rec2->Condiment_item_code;
													}
													
												}
												   // print_r($Req_sel_values);
												foreach($Req_groups as $Rec)
												{
													
													$Condiments_details = $ci_object->POS_catalogue_model->Get_cond_group_values($Rec,14,$Company_id);
													// print_r($Condiments_details);
													foreach($Condiments_details as $Rec)
													{
														if(in_array($Rec->Condiment_item_code, $Req_sel_values))
														{
															echo '<option value="'.$Rec->Group_code.'-'.$Rec->Condiment_item_code.'" selected>'.$Rec->Merchandize_item_name.'</option>';
														}
														else
														{
															echo '<option value="'.$Rec->Group_code.'-'.$Rec->Condiment_item_code.'">'.$Rec->Merchandize_item_name.'</option>';
														}
														
													}
												}
												
											?>		
										</select>
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				
				<div class="col-md-4"  id="Optional_Values_block"  <?php if($Merchandize_Item_Row->Merchandize_item_type!=117){echo 'style="display:none;"';} ?> >
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Optional Condiment Values</b></h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
							
								<div class="form-group" >
									
									<select class="form-control" multiple name="Optional_Condiment_Values[]"  id="Optional_Condiment_Values"  >
												<?php
												$Opt_groups=array_unique($Opt_groups);
												$Opt_sel_values=array();
												if($Optional_selected != NULL)
												{
													foreach($Optional_selected as $Rec2)
													{
														$Opt_sel_values[]=$Rec2->Condiment_item_code;
													}
													
												}
												  // print_r($Opt_sel_values);
												foreach($Opt_groups as $Rec)
												{
													
													$Condiments_details = $ci_object->POS_catalogue_model->Get_cond_group_values($Rec,15,$Company_id);
													// print_r($Condiments_details);
													foreach($Condiments_details as $Rec)
													{
														if(in_array($Rec->Condiment_item_code, $Opt_sel_values))
														{
															echo '<option value="'.$Rec->Group_code.'-'.$Rec->Condiment_item_code.'" selected>'.$Rec->Merchandize_item_name.'</option>';
														}
														else
														{
															echo '<option value="'.$Rec->Group_code.'-'.$Rec->Condiment_item_code.'">'.$Rec->Merchandize_item_name.'</option>';
														}
														
													}
												}
												/* if($Optional_selected != NULL)
												{
													
													foreach($Optional_selected as $Rec)
													{
														if($Rec->Group_code!='')
														{
															$Condiments_details = $ci_object->Coal_Catelogue_model->Get_Merchandize_Item_Condiments($Rec->Condiment_item_code);
															
															echo '<option value="'.$Rec->Group_code.'-'.$Rec->Condiment_item_code.'" selected>'.$Condiments_details->Merchandize_item_name.'</option>';
														}
														
													}
													
												} */
											?>	
										</select>
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				<?php
					if($Combo_Main_item != NULL)
					{
						foreach($Combo_Main_item as $rec)
						{
							$Main_Quantity = $rec->Quanity;
							$Main_Price = $rec->Price;
							$Item_details = $ci_object->Coal_Catelogue_model->Get_Merchandize_Item_Condiments($rec->Main_or_side_item_code);
							
							$Main_item_name = $Item_details->Merchandize_item_name;
							$Main_or_side_item_code = $rec->Main_or_side_item_code;
						}
					}
					
				?>
				
				<div class="col-md-12" id="Main_item_block"  <?php if($Merchandize_Item_Row->Merchandize_item_type!=118){echo 'style="display:none;"';} ?> >
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Main Item</b></h3>
							</div>
							<div class="panel-body">
							
							<div class="col-md-4">
							
								<div class="form-group has-feedback">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Item Name</label>
									<input type="text" name="Main_item_name" id="Main_item_name" class="form-control" placeholder="Enter Item Name" value="<?php echo $Main_item_name.':'.$Main_or_side_item_code; ?>" />
									<span class="required_info" id="error_main" style="display:none;">Item Not Found !!!</span>
									<input type="hidden" name="Main_item_code" id="Main_item_code" value="<?php echo $Main_or_side_item_code; ?>" >
								</div>
							</div>	
							<div class="col-md-4">
							
								<div class="form-group has-feedback">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Quantity</label>
									<input type="text" name="Main_Quantity" id="Main_Quantity" class="form-control" placeholder="Enter Quantity" onkeypress="return isNumberKey2(event);" value="<?php echo $Main_Quantity; ?>"/>
								</div>
							</div>	
							<div class="col-md-4">
							
								<div class="form-group has-feedback">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Price</label>
									<input type="text" name="Main_Price" id="Main_Price" class="form-control" placeholder="Enter Price" onkeypress="return isNumberKey2(event);" value="<?php echo $Main_Price; ?>" />
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				
				<?php
					if($Combo_Side_items != NULL)
					{
						$Side_option2=0;
						$Main_or_side_item_code = array();
						$Side_label = array();
						$Side_option = array();
						foreach($Combo_Side_items as $rec)
						{
							if($Side_option2==$rec->Side_option)
							{
								continue;
							}
							$Side_option[] = $rec->Side_option;
							$Side_label[$rec->Side_option] = $rec->Side_label;
							$Main_or_side_item_code[$rec->Side_option] = $rec->Main_or_side_item_code;
							
							$Side_option2=$rec->Side_option;
							
						}
						//$Side_option = array_unique($Side_option);
						 // $Main_or_side_item_code = array_unique($Main_or_side_item_code);
						//$Side_label = array_unique($Side_label);
					}
					
				     // print_r($Side_option);
				      // print_r($Main_or_side_item_code[1]);
				  // die;
				?>
				
				<div class="col-md-12" id="Side_item_block"  <?php if($Merchandize_Item_Row->Merchandize_item_type!=118){echo 'style="display:none;"';} ?> >
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Side Items</b><br><span class="required_info">(* To Edit the Side Item Details , the window will open up when you select /click on the Side Group)</span></h3>
							</div>
							<div class="panel-body">
									<div class="col-md-6">
										<div class="panel panel-default">
									
									
									<div class="panel-body">
										<div class="col-md-12">
											
											<div class="col-md-2">
											<label for="">Active</label>
												<input type="checkbox" name="Side_item_check[]" id="1"  value="1"  onclick="toggle_side_items(this.value);" <?php if(in_array(1, $Side_option)){echo 'checked';} ?>>
													
											</div>	
											<div class="col-md-5">
											<label for="">Link Side Items</label>

												<div class="form-group">
		
													<select name="Main_or_side_item_code1" id="Main_or_side_item_code1" class="form-control"   onclick="Get_side_items(this.value,1);"  <?php if(!in_array(1, $Side_option)){echo 'disabled';} ?> >
													<option value="">Side Option 1</option>
													<?php
													
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																
																if($Main_or_side_item_code[1] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[1] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											<label for="">Side Label</label>
												<div class="form-group">
		
													<input type="text" name="Side_label1" id="Side_label1" class="form-control" placeholder="Enter Side Label 1"   <?php if(!in_array(1, $Side_option)){echo 'disabled';} ?> value="<?php echo $Side_label[1];?>" />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="2"  value="2"  onclick="toggle_side_items(this.value);"  <?php if(in_array(2, $Side_option)){echo 'checked';} ?>>
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code2" id="Main_or_side_item_code2" class="form-control"   onclick="Get_side_items(this.value,2);"   <?php if(!in_array(2, $Side_option)){echo 'disabled';} ?>  >
													<?php
													
													?>
													<option value="">Side Option 2</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																

																if($Main_or_side_item_code[2] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[2] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
															
																					
														
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label2" id="Side_label2" class="form-control" placeholder="Enter Side Label 2"   <?php if(!in_array(2, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[2];?>" />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="3"  value="3"  onclick="toggle_side_items(this.value);" <?php if(in_array(3, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code3" id="Main_or_side_item_code3" class="form-control"   onclick="Get_side_items(this.value,3);"  <?php if(!in_array(3, $Side_option)){echo 'disabled';} ?>  >
													<option value="">Side Option 3</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																

																if($Main_or_side_item_code[3] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															// print_r($Main_or_side_item_code[3]);
															//print_r($childs);
																foreach($childs as $row) {
																	if($Main_or_side_item_code[3] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
															
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label3" id="Side_label3" class="form-control" placeholder="Enter Side Label 3 "    <?php if(!in_array(3, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[3];?>" />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="4"  value="4" onclick="toggle_side_items(this.value);"  <?php if(in_array(4, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code4" id="Main_or_side_item_code4" class="form-control"   onclick="Get_side_items(this.value,4);"   <?php if(!in_array(4, $Side_option)){echo 'disabled';} ?>  >
													<option value="">Side Option 4</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																if($Main_or_side_item_code[4] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[4] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>		
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label4" id="Side_label4" class="form-control" placeholder="Enter Side Label 4 "    <?php if(!in_array(4, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[4];?>"   />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="5"  value="5" onclick="toggle_side_items(this.value);"  <?php if(in_array(5, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code5" id="Main_or_side_item_code5" class="form-control"   onclick="Get_side_items(this.value,5);"   <?php if(!in_array(5, $Side_option)){echo 'disabled';} ?>  >
													<option value="">Side Option 5</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																if($Main_or_side_item_code[5] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[5] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>			
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label5" id="Side_label5" class="form-control" placeholder="Enter Side Label 5 "    <?php if(!in_array(5, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[5];?>"   />
												</div>	
											</div>	
										</div>	
									</div>	
																	
												</div>	
									
										</div>
									<div class="col-md-6">
										<div class="panel panel-default">
									
									
											
											
									<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
												<label for="">Active</label>
												<input type="checkbox" name="Side_item_check[]" id="6"  value="6"  onclick="toggle_side_items(this.value);"  <?php if(in_array(6, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
												<label for="">Link Side Items</label>
												<div class="form-group">
		
													<select name="Main_or_side_item_code6" id="Main_or_side_item_code6" class="form-control"   onclick="Get_side_items(this.value,6);"   <?php if(!in_array(6, $Side_option)){echo 'disabled';} ?>  >
													<option value="">Side Option 6</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																if($Main_or_side_item_code[6] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[6] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>			
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											<label for="">Side Label</label>
												<div class="form-group">
		
													<input type="text" name="Side_label6" id="Side_label6" class="form-control" placeholder="Enter Side Label 6"    <?php if(!in_array(6, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[6];?>"   />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="7"  value="7"  onclick="toggle_side_items(this.value);"  <?php if(in_array(7, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code7" id="Main_or_side_item_code7" class="form-control"   onclick="Get_side_items(this.value,7);"   <?php if(!in_array(7, $Side_option)){echo 'disabled';} ?>  >
													<option value="">Side Option 7</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																if($Main_or_side_item_code[7] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[7] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>			
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label7" id="Side_label7" class="form-control" placeholder="Enter Side Label 7"     <?php if(!in_array(7, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[7];?>"  />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="8"  value="8"  onclick="toggle_side_items(this.value);" <?php if(in_array(8, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code8" id="Main_or_side_item_code8" class="form-control"   onclick="Get_side_items(this.value,8);"   <?php if(!in_array(8, $Side_option)){echo 'disabled';} ?>  >
													<option value="">Side Option 8</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																if($Main_or_side_item_code[8] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[8] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>			
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label8" id="Side_label8" class="form-control" placeholder="Enter Side Label 8 "     <?php if(!in_array(8, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[8];?>"  />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="9"  value="9" onclick="toggle_side_items(this.value);" <?php if(in_array(9, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code9" id="Main_or_side_item_code9" class="form-control"   onclick="Get_side_items(this.value,9);"   <?php if(!in_array(9, $Side_option)){echo 'disabled';} ?>  >
													<option value="">Side Option 9</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																if($Main_or_side_item_code[9] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[9] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>			
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label9" id="Side_label9" class="form-control" placeholder="Enter Side Label 9 "    <?php if(!in_array(9, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[9];?>"   />
												</div>	
											</div>	
										</div>	
									</div>	
											<div class="panel-body">
										<div class="col-md-12">
											<div class="col-md-2">
											
												<input type="checkbox" name="Side_item_check[]" id="10"  value="10" onclick="toggle_side_items(this.value);" <?php if(in_array(10, $Side_option)){echo 'checked';} ?> >
													
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<select name="Main_or_side_item_code10" id="Main_or_side_item_code10" class="form-control"   onclick="Get_side_items(this.value,10);"  <?php if(!in_array(10, $Side_option)){echo 'disabled';} ?> >
													<option value="">Side Option 10</option>
													<?php
														foreach($Merchandize_Category_Records as $Merchandize_Category) {
															
																if(!$Merchandize_Category->Parent_category_id) {
																$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
																if($Main_or_side_item_code[10] == $Merchandize_Category->Merchandize_category_id)
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" selected>'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
																else
																{
																	echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" >'.$Merchandize_Category->Merchandize_category_name.'</option>';
																}
															
																foreach($childs as $row) {
																	if($Main_or_side_item_code[10] == $row->Merchandize_category_id)
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" selected>--'.$row->Merchandize_category_name.'</option>';
																	}
																	else
																	{
																		echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
																	}
																	
																}
																}	
															}
													?>			
													</select>
												</div>	
											</div>	
											<div class="col-md-5">
											
												<div class="form-group">
		
													<input type="text" name="Side_label10" id="Side_label10" class="form-control" placeholder="Enter Side Label 10 "    <?php if(!in_array(10, $Side_option)){echo 'disabled';} ?>   value="<?php echo $Side_label[10];?>"  />
												</div>	
											</div>	
										</div>	
									</div>	
																	
												</div>	
									
										</div>
									
							</div>						
						</div>	
			
				</div>
				<div class="col-md-12"  id="selected_Side_group_item_block"  <?php if($Merchandize_Item_Row->Merchandize_item_type!=118){echo 'style="display:none;"';} ?> >
					<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><b>Selected Side Group Items</b></h3>
								</div>
						<div class="panel-body">
							<div class="col-md-12"  id="Side_group_item_block" >
								<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th class="text-center">Side Option</th>
					<th class="text-center">Side Item Name</th>
					<th class="text-center">Side Group Item Code</th>
					<th class="text-center">Side Group Item Name</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Price</th>
					
				</tr>
				</thead>
				
				<tbody>
				<?php
				
					foreach($Get_pos_side_groups_items as $row)
					{
						
					?>
						<tr>
							
							<td class="text-center"><?php echo $row->Side_option; ?></td>
							<td class="text-center"><?php echo $row->Merchandize_category_name; ?></td>
							<td class="text-center"><?php echo $row->Side_group_item_code; ?></td>
							<td class="text-center"><?php echo $row->Merchandize_item_name; ?></td>
							<td class="text-center"><?php echo $row->Quanity; ?></td>
							<td class="text-center"><?php echo $row->Price; ?></td>
							
							
							
						</tr>
					<?php
					}
				?>	
				</tbody> 
			</table>
						
							</div>
						</div>
					</div>
				</div>
				
				
				
				<?php
					if($POS_prices != NULL)
					{
						foreach($POS_prices as $rec)
						{
							$Item_price_flag[] = $rec->Price_Active_flag;
							$POS_Price[] = $rec->Pos_price;
							$From_date[] = date('m/d/Y',strtotime($rec->From_date));
							$To_date[] = date('m/d/Y',strtotime($rec->To_date));
							
						}
					}
					
				?>
				
			<div class="col-md-12">
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Item Price Setup</b></h3>
							</div>
							<div class="panel-body">
							
				
							<div class="col-md-4">
							<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title"><b><span class="required_info">*</span> POS Price</b><br><span class="required_info">&nbsp;</span></h3>
										</div>
										
										<div class="panel-body">
											<div class="col-md-12">
												<div class="col-md-2">
												
													<input type="radio" name="Item_price_flag"  value="1"  <?php if($Item_price_flag[0]==1){echo 'checked';} ?>>
														
												</div>	
												<div class="col-md-10">
												
														<input type="text" name="POS_Price1" id="POS_Price1" class="form-control" placeholder="Enter Price 1"  onkeypress="return isNumberKey2(event);"  value="<?php echo $POS_Price[0]; ?>" />	
												</div>	
											</div>	
										</div>	
										<div class="panel-body">
											<div class="col-md-12">
												<div class="col-md-2">
												
													<input type="radio" name="Item_price_flag"  value="2"    <?php if($Item_price_flag[1]==1){echo 'checked';} ?>>
														
												</div>	
												<div class="col-md-10">
												
														<input type="text" name="POS_Price2" id="POS_Price2" class="form-control" placeholder="Enter Price 2"  onkeypress="return isNumberKey2(event);"  value="<?php echo $POS_Price[1]; ?>" />	
												</div>	
											</div>	
										</div>		
										<div class="panel-body">
											<div class="col-md-12">
												<div class="col-md-2">
												
													<input type="radio" name="Item_price_flag"  value="3"  <?php if($Item_price_flag[2]==1){echo 'checked';} ?>>
														
												</div>	
												<div class="col-md-10">
												
														<input type="text" name="POS_Price3" id="POS_Price3" class="form-control" placeholder="Enter Price 3"  onkeypress="return isNumberKey2(event);" value="<?php echo $POS_Price[2]; ?>"  />	
												</div>	
											</div>	
										</div>						
								</div>	
						
							</div>
				
							<div class="col-md-4">
							<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title"><b><span class="required_info">*</span> Available From Date <br><span class="required_info">(* click inside textbox)</span></b></h3>
										</div>
										<div class="panel-body">
										<div class="col-md-12">
										
											<div class="input-group">
													<input type="text" name="POS_Valid_from1" id="datepicker1" class="form-control" placeholder="Start Date"  value="<?php echo $From_date[0]; ?>" />			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
												</div>
										</div>	
										</div>		
										<div class="panel-body">
										<div class="col-md-12">
										
											<div class="input-group">
													<input type="text" name="POS_Valid_from2" id="datepicker2" class="form-control" placeholder="Start Date"  value="<?php echo $From_date[1]; ?>"/>			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
												</div>
										</div>	
										</div>		
										<div class="panel-body">
										<div class="col-md-12">
										
											<div class="input-group">
													<input type="text" name="POS_Valid_from3" id="datepicker3" class="form-control" placeholder="Start Date"  value="<?php echo $From_date[2]; ?>"/>			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
												</div>
										</div>	
										</div>						
									</div>	
						
							</div>
				
							<div class="col-md-4">
							<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title"><b><span class="required_info">*</span> Available To Date <br><span class="required_info">(* click inside textbox)</span></b></h3>
										</div>
										<div class="panel-body">
										<div class="col-md-12">
										
											<div class="input-group">
													<input type="text" name="POS_Valid_till1" id="datepicker4" class="form-control" placeholder="End Date"  value="<?php echo $To_date[0]; ?>" />			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
												</div>
										</div>	
										</div>	
										<div class="panel-body">
										<div class="col-md-12">
										
											<div class="input-group">
													<input type="text" name="POS_Valid_till2" id="datepicker5" class="form-control" placeholder="End Date"  value="<?php echo $To_date[1]; ?>" />			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
												</div>
										</div>	
										</div>	
										<div class="panel-body">
										<div class="col-md-12">
										
											<div class="input-group">
													<input type="text" name="POS_Valid_till3" id="datepicker6" class="form-control" placeholder="End Date"  value="<?php echo $To_date[2]; ?>" />			
													<span class="input-group-addon" id="basic-addon2">
														<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
													</span>
												</div>
										</div>	
										</div>						
									</div>	
						
							</div>
							
				</div>
				</div>
				</div>
				
				
				<div class="col-md-12">
				<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Loyalty Linkage</b></h3>
							</div>
							<div class="panel-body">
							<div class="col-md-3">
							<b>Stamp Item</b>

								<div class="form-group" >
									
									<label class="radio-inline">
										<input type="radio" name="Stamp_item_flag"  value="1"  <?php if($Merchandize_Item_Row->Stamp_item_flag==1){echo 'checked';} ?> >Yes

									</label>										
									<label class="radio-inline">
										<input type="radio" name="Stamp_item_flag"  value="0"   <?php if($Merchandize_Item_Row->Stamp_item_flag==0){echo 'checked';} ?>   >No

									</label>									
									
								</div>
							</div>	
							<div class="col-md-3">
							
								<div class="form-group has-feedback">
									<label for="exampleInputEmail1">Extra Earn Points</label>
									<input type="text" name="Extra_earn_points" id="Extra_earn_points" class="form-control" placeholder="Enter Extra Earn Points"  onkeypress="return isNumberKey2(event);" value=" <?php echo $Merchandize_Item_Row->Extra_earn_points;?>"/>
								</div>
							</div>	
							</div>						
						</div>	
			
				</div>
				
						
				<!----------------Food & Beverages--------------XXX-->
				
				
			
			</div>
			
			
					
			
			<div class="panel-footer text-center">
				<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Update</button>
				
			</div>			
			
			
			
		</div>
			
					
		</div>
		<?php echo form_close(); ?>
	</div>
	<br>
	
	<div class="panel panel-info">
	<div class="col-md-2">
		
	</div>
	<div class="col-md-3">
	
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<select class="form-control" onchange="Get_POS_items(this.value,3);" id="Search3">
				<option value="">Search by Menu Group</option>
				<option value="0">All</option>
				<?php
					foreach($Merchandize_Category_Records as $Merchandize_Category)
					{
						echo '<option value="'.$Merchandize_Category->Merchandize_category_id.'">'.$Merchandize_Category->Merchandize_category_name.'</option>';
					}
				?>
			</select>									
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group has-feedback">
			<input type="text" name="Search_item" id="Search_item" class="form-control" placeholder="Enter Item Code / Item Name"   />	
		</div>
	</div>
	<div class="col-md-1">
		<div class="form-group has-feedback">
			<button type="submit" name="Search" value="Search" id="Search" class="btn btn-primary" onclick="Get_POS_items(Search_item.value,4);">Search</button>
		</div>
	</div>
	
		<br><br>
	<div class="panel-heading"><h4>POS Items</h4></div>
	<?php
				if($Merchandize_Items_Records != NULL)
				{?>	
		<div class="table-responsive" id="show_records">
			<table class="table table-bordered table-hover">
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
									<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
								<a href="javascript:void(0);" onclick="Merchandize_Item_inactive('<?php echo $row->Company_merchandise_item_id;?>','<?php echo $row->Merchandize_item_name; ?>');" title="Delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
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
			<div class="panel-footer"><?php echo $pagination; ?></div>
		</div>
		
	</div>

<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
<!-- Side Items Groups Modal -->
			
				<div id="myModal1" class="modal fade" role="dialog">
					<div class="modal-dialog" style="width: 90%;">

					<!-- Modal content-->
						<div class="modal-content">
							
							<div class="modal-body">
								<div  id="show_multiple_offer"></div>
							</div>
							
						</div>

					</div>
				</div>	
			
<script>

$('#Register').click(function()
{
	
	if($('#Company_merchandize_item_code').val() != "" && $('#Merchandize_item_name').val() != "" && $('#Merchandise_item_description').val() != "" && $('#Main_group_id').val() != "" && $('#Menu_group_id').val() != "" && $('#Sub_group_id').val() != "" )
	{
		var Item_type = $("input[name=Item_type]:checked").val();
		var Item_price_flag = $("input[name=Item_price_flag]:checked").val();
		
		if(Item_type==118)//combo
		{
			var Combo_meal_no =$('#Combo_meal_no').val();
			var Main_item_name =$('#Main_item_name').val();
			var Main_Quantity =$('#Main_Quantity').val();
			var Main_Price =$('#Main_Price').val();

		
			if(Combo_meal_no== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter Combo Meal No.';
				runjs(Title,msg);
				return false;
			}
			if(Main_item_name== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter Main Item Name';
				runjs(Title,msg);
				return false;
			}
			if(Main_Quantity== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter Main Item Quantity';
				runjs(Title,msg);
				return false;
			}
			if(Main_Price== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter Main Item Price';
				runjs(Title,msg);
				return false;
			}
			
			for(var i=1; i<=10; i++)
			{
				var Side_options = $("input[id="+i+"]:checked").val();
				
				if(Side_options == i)
				{
					var Main_or_side_item_code =$('#Main_or_side_item_code'+i).val();
					var Side_label =$('#Side_label'+i).val();
					if(Main_or_side_item_code == "")
					{
						var Title = "Application Information";
						var msg = 'Please Select Side Option '+i;
						runjs(Title,msg);
						return false;
					}
					if(Side_label == "")
					{
						var Title = "Application Information";
						var msg = 'Please Enter Side Label '+i;
						runjs(Title,msg);
						return false;
					}
				}
				
			}
		}
		
		
		if(Item_price_flag==1)
		{
			var POS_Price1 =$('#POS_Price1').val();
			var datepicker1 =$('#datepicker1').val();
			var datepicker4 =$('#datepicker4').val();
			if(POS_Price1== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter POS Price 1';
				runjs(Title,msg);
				return false;
			}
			if(datepicker1== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 1 From Date';
				runjs(Title,msg);
				return false;
			}
			if(datepicker4== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 1 To Date';
				runjs(Title,msg);
				return false;
			}
			
		}
		
		if(Item_price_flag==2)
		{
			var POS_Price2 =$('#POS_Price2').val();
			var datepicker2 =$('#datepicker2').val();
			var datepicker5 =$('#datepicker5').val();
			if(POS_Price2== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter POS Price 2';
				runjs(Title,msg);
				return false;
			}
			if(datepicker2== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 2 From Date';
				runjs(Title,msg);
				return false;
			}
			if(datepicker5== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 2 To Date';
				runjs(Title,msg);
				return false;
			}
			
		}
		if(Item_price_flag==3)
		{
			var POS_Price3 =$('#POS_Price3').val();
			var datepicker3 =$('#datepicker3').val();
			var datepicker6 =$('#datepicker6').val();
			if(POS_Price3== "")
			{
				var Title = "Application Information";
				var msg = 'Please Enter POS Price 3';
				runjs(Title,msg);
				return false;
			}
			if(datepicker3== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 3 From Date';
				runjs(Title,msg);
				return false;
			}
			if(datepicker6== "")
			{
				var Title = "Application Information";
				var msg = 'Please Select POS Price 3 To Date';
				runjs(Title,msg);
				return false;
			}
			
		}
		
		show_loader();
	}
	
});


/*********************************Autocomplete***************************************/
		$("#Main_item_name").autocomplete({
			source: "<?php echo base_url()?>index.php/POS_CatalogueC/autocomplete_pos_main_item_name" // path to the get_birds method
		});
	/*********************************Autocomplete***************************************/
	
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
					
						// $('#Required_Condiment_Values option').prop('selected', true);
					
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
					// $('#Optional_Condiment_Values option').prop('selected', true);
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
			
			$("#Condiment_Group_block").hide();
			$("#Combo_meal_no_block").hide();
			$("#selected_Side_group_item_block").hide();
		}
	}
	var Main_group_id = $("#Main_group_id").val();
	
	get_sub_groups(Main_group_id,0);
	
	function get_sub_groups(Main_group_id,flag)
	{
		// var Main_group_id = $("#Main_group_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		// alert(Main_group_id);
		$.ajax({
			type:"POST",
			data:{Main_group_id:Main_group_id, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/POS_CatalogueC/Get_POS_sub_groups",
			success: function(data)
			{
				$('#Sub_group_id').html(data.Product_groups);
				if(flag==0)
				{
					$("select#Sub_group_id").val('<?php echo $Merchandize_Item_Row->Product_brand_id; ?>'); 
				}
				
			}				
		});
	}
	

	function Get_side_items(Item,Side_option)
	{
		
		var Company_id = '<?php echo $Company_id; ?>';
		var Company_merchandize_item_code = $("#Company_merchandize_item_code").val();
		$.ajax({
			type:"POST",
			data:{Item:Item, Company_id:Company_id, Company_merchandize_item_code:Company_merchandize_item_code, Side_option:Side_option},
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
				has_error("#has-feedback1","#glyphicon2","#help-block2","Please Enter POS Item Code..!!");
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
								$('#Company_merchandize_item_code').val('');
								has_error("#has-feedback1","#glyphicon2","#help-block2","POS Item Code Already exist!!");
							}
							else
							{
								has_success("#has-feedback1","#glyphicon2","#help-block2",data);
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

</script>
