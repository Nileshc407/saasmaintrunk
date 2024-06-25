<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Coal_CatalogueC/Edit_Merchandize_Items',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">EDIT MERCHANDISE ITEM</h6>
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
								  <div class="form-group">
									<label for=""> Company Name</label>
									<select class="form-control" name="Company_id" id="Company_id" required="required">
									  <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
									</select>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Merchandise Item Type</label>
									<select class="form-control" name="Merchandize_item_type" id="Merchandize_item_type" data-error="Please select item type" required="required">
									<?php if($Merchandize_Item_Row->Merchandize_item_type!=0) { ?>
									<option value="<?php echo $Merchandize_Item_Row->Merchandize_item_type; ?>"><?php echo $Merchandize_Item_Row->Code_decode; ?></option>
									<?php } else { ?> <option value="0">Select item type</option> <?php }							?>	
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span> Merchandise Category</label>
									  <select class="form-control" name="Merchandize_category_id" id="Merchandize_category_id"  size="10" data-error="Please select merchandise category" required="required">
									 <?php
										foreach($Merchandize_Category_Records as $Merchandize_Category) {
											
											if(!$Merchandize_Category->Parent_category_id) {
												
												if($Merchandize_Category->Merchandize_category_id==$Merchandize_Item_Row->Merchandize_category_id){ $selected="selected";}else{$selected="";}
												
												
												$childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id);
												
												echo'<option value="'.$Merchandize_Category->Merchandize_category_id.'" style="font-weight:bold;" '.$selected.'>'.$Merchandize_Category->Merchandize_category_name.'</option>';
											
												foreach($childs as $row) {
													
													if($row->Merchandize_category_id==$Merchandize_Item_Row->Merchandize_category_id){ $selected="selected";}else{$selected="";}
													
													echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;" '.$selected.'>--'.$row->Merchandize_category_name.'</option>';
												}
											}							
										}	?>		
									  </select>
									  <div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Merchandise item Code</label>
									<input type="text" class="form-control" name="Company_merchandize_item_code" id="Company_merchandize_item_code" data-error="Please enter merchandise item code" placeholder="Enter merchandise item code" required="required" value="<?php echo $Merchandize_Item_Row->Company_merchandize_item_code;?>" readonly >
									<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
								  </div> 
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Merchandise item Name</label>
									<input type="text" class="form-control" name="Merchandize_item_name" id="Merchandize_item_name" data-error="Please enter merchandise item name" placeholder="Enter merchandise item name" value="<?php echo $Merchandize_Item_Row-> Merchandize_item_name;?>" required="required"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label><span class="required_info">* </span>Merchandise item Information</label>
									<textarea class="form-control" rows="3" name="Merchandise_item_description"  id="Merchandise_item_description" placeholder="Enter merchandise item information" data-error="Please enter merchandise item information" required="required"><?php echo $Merchandize_Item_Row->Merchandise_item_description;?></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>From Date (MM/DD/YYYY)<span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="Valid_from" id="datepicker1" data-error="Please select from date" value="<?php echo date("m/d/Y",strtotime($Merchandize_Item_Row-> Valid_from));?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>Till Date (MM/DD/YYYY)<span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="End Date" type="text"  name="Valid_till" id="datepicker2" data-error="Please select till date" value="<?php echo date("m/d/Y",strtotime($Merchandize_Item_Row-> Valid_till));?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Delivery Method</label>
									<select class="form-control" name="Delivery_method" id="Delivery_method" data-error="Please select delivery method" required="required">
									 <?php
										if($Merchandize_Item_Row->Delivery_method==0)
										{
											echo '<option value="0">Both</option>';
											foreach($Code_decode_Records as $Rec)
											{
												if($Rec->Code_decode_type_id==6)//Delivery Method 
												{ ?>
													<option value="<?php echo $Rec->Code_decode_id;?>"><?php echo $Rec->Code_decode;?></option>
										<?php 	}
											}
										}
										else
										{
											foreach($Code_decode_Records as $Rec)
											{
												if($Rec->Code_decode_type_id==6) //Delivery Method 
												{ ?>
													<option value="<?php echo $Rec->Code_decode_id;?>" <?php if($Rec->Code_decode_id==$Merchandize_Item_Row->Delivery_method){echo "selected";}?>><?php echo $Rec->Code_decode;?></option>
													
										<?php 	}
											}
											echo '<option value="0">Both</option>';	
										}		
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>							  
								</div>	
								
								<div class="col-sm-6">
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Link to Merchandise Partner</label>
									<select class="form-control" name="Partner_id" id="Partner_id" data-error="Please select merchandise partner" onchange="Get_Calculation()" disabled>
									<option value="">Link to merchandise partner</option>
									 <?php
										foreach($Partner_Records as $Partner)
										{
											if($Partner->Partner_type!=4) //Not Shipping Partner
											{	?>									
											<option value="<?php echo $Partner->Partner_id;?>" <?php if($Partner->Partner_id==$Merchandize_Item_Row->Partner_id){echo "selected";}?>><?php echo $Partner->Partner_name;?></option>
									<?php
											}
										}
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
									<input type="hidden" name="Partner_id" value="<?php echo $Merchandize_Item_Row->Partner_id;?>">	
								  </div>
								  
								  <div class="form-group">
										<label for=""><span class="required_info" >* </span>Link to Partner Branches</label>
										<select class="form-control select2" multiple="true" name="partner_branches[]" id="partner_branches" disabled>
										<?php
											foreach($Merchandize_Item_Branches as $Merchandize_Item_Branches)
											{
												echo "<option value='".$Merchandize_Item_Branches->Branch_code."' selected>".$Merchandize_Item_Branches->Branch_name."</option>";
											}
										?>
										</select>
										<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for="">Link to Merchant</label>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="Merchant_flag" id="Merchant_flag" type="radio" value="1" onclick="Merchant_toggle(this.value);" <?php if($Merchandize_Item_Row->Merchant_flag==1){echo "checked";} ?> disabled>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input class="form-check-input" name="Merchant_flag" id="Merchant_flag" type="radio" value="0" onclick="Merchant_toggle(this.value);" <?php if($Merchandize_Item_Row->Merchant_flag==0){echo "checked";} ?> disabled>No</label>
									  </div> 
									</div>
								  </div>
								  <input type="hidden" name="Merchant_flag" value="<?php echo $Merchandize_Item_Row->Merchant_flag; ?>">
								<?php if($Merchandize_Item_Row->Merchant_flag==1){ ?>
								  <div class="form-group" id="Seller_Admin_list">
									<label for=""><span class="required_info">* </span>Select Merchant</label>
									<select class="form-control" name="Seller_id" id="Seller_id" disabled>
									<option value="">Select merchant</option>
								<?php foreach($Subseller_details as $subseller) 
										{ 
											echo $subseller['Enrollement_id'];
										?>								 
											<option value="<?php echo $subseller['Enrollement_id']; ?>" <?php if($subseller['Enrollement_id']==$Merchandize_Item_Row->Seller_id){echo "selected";}?>><?php echo $subseller['First_name'].' '.$subseller['Last_name']; ?></option>
										
								<?php 	} ?>
									</select>
									<input type="hidden" name="Seller_id" value="<?php echo $Merchandize_Item_Row->Seller_id; ?>">
								  </div>
								  <?php }else{ ?>
								  	<div class="form-group" id="Seller_Admin_list" style="display:none;">
										<select class="form-control" name="Seller_id" id="Seller_id" disabled >
										<option value="">Select merchant</option>
										<?php foreach($Subseller_details as $subseller) 
										{ 
											echo $subseller['Enrollement_id'];
										?>								 
											<option value="<?php echo $subseller['Enrollement_id']; ?>"><?php echo $subseller['First_name'].' '.$subseller['Last_name']; ?></option>
								<?php 	} ?>
										</select>
									</div>
								<?php } ?>
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Redemptionratio</label>
									<input type="text" class="form-control" name="Seller_Redemptionratio" id="Seller_Redemptionratio" value="<?php echo $Merchandize_Item_Row->Seller_Redemptionratio;?>" readonly>
								  </div>
								  
								  <div class="form-group" id="Select_tier">
									<label for=""><span class="required_info" >* </span>Link to Tiers</label>
									<select class="form-control select2" multiple="true" name="Tier_id[]" id="Tier_id">
									<?php	
										foreach($Merchandize_Item_Tiers as $Merchandize_Tiers)
										{
											$Merchandize_Tier[]=$Merchandize_Tiers->Tier_id;
										}
										foreach($Tier_list as $Tier)
										{
											if(in_array($Tier->Tier_id, $Merchandize_Tier))
											{
											 ?>
												<option value="<?php echo $Tier->Tier_id;?>" selected ><?php echo $Tier->Tier_name;?></option>
											<?php 
											}
											else								
											{
											?>
												<option value="<?php echo $Tier->Tier_id;?>" 	><?php echo $Tier->Tier_name;?></option>
											<?php
											}
										}
									?>
									</select>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Partner VAT</label>
									<input type="text" class="form-control" name="VAT" id="VAT"  value="<?php echo $Merchandize_Item_Row->VAT;?>" readonly />
								  </div>

								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Partner Margin</label>
									<input type="text" class="form-control" name="margin" id="margin" value="<?php echo $Merchandize_Item_Row-> Markup_percentage;?>" readonly />
								  </div>
								  
									
								  <div class="form-group">
									<label for="">Status</label>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" type="radio" name="show_item"  value="1" <?php if($Merchandize_Item_Row->show_item==1){echo "checked";} ?>>Enable</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:90px;">
										<label class="form-check-label">
										<input class="form-check-input" type="radio" name="show_item" value="0" <?php if($Merchandize_Item_Row->show_item==0){echo "checked";} ?>>Disable</label>
									  </div> 
									</div>
								  </div>
								</div>
							</div>
						
							<div id="Additional_Fields">						
								<fieldset class="form-group">
								<legend><span>Additional Fields</span></legend>
								<div class="row" >
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-4 col-form-label">Link to Item for</label>
											<div class="col-sm-8">
											  <div class="form-check">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Gender_flag"  value="0" <?php if($Merchandize_Item_Row->Gender_flag==0){echo "checked";} ?>>Both</label>
											  </div>
											  <div class="form-check">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Gender_flag" value="1" <?php if($Merchandize_Item_Row->Gender_flag==1){echo "checked";} ?>>Men</label>
											  </div>
											  <div class="form-check">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Gender_flag" value="2" <?php if($Merchandize_Item_Row->Gender_flag==2){echo "checked";} ?>>Women</label>
											  </div>
											</div>
										</div>
										
										<div class="form-group">
											<label for="">Link to e-Commerce</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Ecommerce_flag" id="Ecommerce_flag" value="1" onclick="ecommerce_toggle(this.value)"  <?php if($Merchandize_Item_Row->Ecommerce_flag==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Ecommerce_flag" id="Ecommerce_flag" value="0" onclick="ecommerce_toggle(this.value)" <?php if($Merchandize_Item_Row->Ecommerce_flag==0){echo "checked";} ?>>No</label>
											  </div>  
											</div>
										</div>
										<?php if($Merchandize_Item_Row->Ecommerce_flag==1){?> 
										<div class="form-group" id="Offer_flag_div" style="display:block;">
											<label for="">Offer Item</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Offer_flag" id="Offer_flag" value="1" <?php if($Merchandize_Item_Row->Offer_flag==1){echo "checked";} ?> >Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Offer_flag" id="Offer_flag" value="0" <?php if($Merchandize_Item_Row->Offer_flag==0){echo "checked";} ?>>No</label>
											  </div>  
											</div>
										</div>
										
										<div class="form-group" id="ecommerce_block1" style="display:block;">
											<select class="form-control" name="Product_group_id" id="Product_group_id">
											<?php
												foreach($Product_group_Records as $Product_group)
												{
													if($Merchandize_Item_Row->Product_group_id==$Product_group->Product_group_id)
													{
														echo '<option value="'.$Product_group->Product_group_id.'">'.$Product_group->Product_group_name.'</option>';
													}
												} ?>
											</select>
										</div>
										
										<div class="form-group" id="ecommerce_block2" style="display:block;">
											<select class="form-control" name="Product_brand_id" id="Product_brand_id">
											<?php
												foreach($Get_Product_Brands as $Product_brand)
												{
													if($Merchandize_Item_Row->Product_brand_id==$Product_brand->Product_brand_id)
													{
														echo '<option value="'.$Product_brand->Product_brand_id.'">'.$Product_brand->Product_brand_name.'</option>';
													}
												} ?>
											</select>
										</div>
										<?php } else { ?>
										<div id="Offer_flag_div" style="display:none;" >
											<label for="">Offer Item</label>
											&nbsp;&nbsp;<br>
											<label class="radio-inline">
												<input type="radio" name="Offer_flag" id="Offer_flag"  value="1">Yes
											</label>										
											<label class="radio-inline">
												<input type="radio" name="Offer_flag" id="Offer_flag"  value="0" checked>No
											</label>
										</div>
										<div class="form-group" id="ecommerce_block1" style="display:none;">
											<select class="form-control" name="Product_group_id" id="Product_group_id"  >
												<option value="">Select product group</option>
													<?php
													foreach($Product_group_Records as $Product_group)
													{
														echo '<option value="'.$Product_group->Product_group_id.'">'.$Product_group->Product_group_name.'</option>';
													} ?>
											</select>									
										</div>
										
										<div class="form-group" id="ecommerce_block2" style="display:none;">
											<select class="form-control" name="Product_brand_id" id="Product_brand_id"  >
												<option value="">Select product group first</option>
											</select>									
										</div>
										<?php } ?>
											
										<div class="form-group">
											<label for="">Colour</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;" >
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Colour_flag" id="Colour_flag" value="1" onclick="Colour_toggle(this.value)" <?php if($Merchandize_Item_Row->Colour_flag==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Colour_flag" id="Colour_flag" value="0" onclick="Colour_toggle(this.value)" <?php if($Merchandize_Item_Row->Colour_flag==0){echo "checked";} ?>>No</label>
											  </div>	
											</div>
										</div>
									  <?php if($Merchandize_Item_Row->Colour_flag==1){?> 	
										  <label class="radio-inline" id="colour_block">
											<input type="color" name="Item_Colour" id="Item_Colour"  value="<?php echo $Merchandize_Item_Row->Item_Colour; ?>">
											<br/>
											<font color="RED" align="center" size="0.8em"><i>Select your item colour</i></font>
										 </label>
										<?php }else{ ?>
											<label class="radio-inline" id="colour_block" style="display:none;">
											<input type="color" name="Item_Colour" id="Item_Colour"  value="#ff0000">
											<br><span class="required_info">Select your Item colour</span>
											</label>
										<?php } ?>
										
										<div class="form-group">
											<label for="">Brand</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Brand_flag" id="Brand_flag" value="1" onclick="Brand_toggle(this.value)" <?php if($Merchandize_Item_Row->Brand_flag==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Brand_flag" id="Brand_flag" value="0" onclick="Brand_toggle(this.value)" <?php if($Merchandize_Item_Row->Brand_flag==0){echo "checked";} ?>>No</label>
											  </div> 
											</div>
										</div>
										<?php if($Merchandize_Item_Row->Brand_flag==1){?> 	
										<div class="form-group" id="brand_block">
											<select class="form-control" name="Item_Brand" id="Item_Brand">
												<?php
													foreach($Code_decode_Records as $Rec)
													{
														if($Rec->Code_decode_type_id==1)//Brand
														{
															if($Rec->Code_decode==$Merchandize_Item_Row->Item_Brand)//Brand
															{
																echo '<option value="'.$Rec->Code_decode.'" selected>'.$Rec->Code_decode.'</option>';
															}
															else
															{
																echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
															}
														}
													} ?>
											</select>
										</div>
										<?php }else{ ?>
										<div class="form-group" id="brand_block" style="display:none;">
											<!--<label for="exampleInputEmail1"><span class="required_info">*</span> Select Item Brand</label>-->
											<select class="form-control" name="Item_Brand" id="Item_Brand"  >
												<option value="">Select item brand</option>
													<?php
													foreach($Code_decode_Records as $Rec)
													{
														if($Rec->Code_decode_type_id==1)//Brand
														{
															echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
														}
													} ?>
											</select>									
										</div>
										<?php } ?>
										<?php if($Company_details->Allow_redeem_item_enrollment==1){ ?>
										<div class="form-group">
											<label for="">Send Freebies on Member Enrollment</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Link_to_Member_Enrollment_flag"  value="1" <?php if($Merchandize_Item_Row->Link_to_Member_Enrollment_flag==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Link_to_Member_Enrollment_flag" value="0" <?php if($Merchandize_Item_Row->Link_to_Member_Enrollment_flag==0){echo "checked";} ?>>No</label>
											  </div> 
											</div>
										</div>
											<?php } ?>
										<?php if($Company_details->Cron_freebies_once_flag==1){ ?>	
										<div class="form-group">
											<label for="">Send Freebies Once in a Year</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Send_once_year"  value="1" <?php if($Merchandize_Item_Row->Send_once_year==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Send_once_year" value="0"  <?php if($Merchandize_Item_Row->Send_once_year==0){echo "checked";} ?>>No</label>
											  </div> 
											</div>
										</div>
										<?php } 
										if($Company_details->Cron_freebies_other_benefit_flag==1){ ?>
										<div class="form-group">
											<label for="">Link to Other Benefits Freebies</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Send_other_benefits"  value="1" <?php if($Merchandize_Item_Row->Send_other_benefits==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Send_other_benefits" value="0" <?php if($Merchandize_Item_Row->Send_other_benefits==0){echo "checked";} ?>>No</label>
											  </div> 
											</div>
										</div>
										<?php } ?>
									</div>
									<div class="col-sm-6" >
										<div class="form-group">
											<label for="">Manufacturer</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Manufacturer_flag"  id="Manufacturer_flag" value="1" onclick="Manufacturer_toggle(this.value)" <?php if($Merchandize_Item_Row->Manufacturer_flag==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Manufacturer_flag" id="Manufacturer_flag" value="0" onclick="Manufacturer_toggle(this.value)" <?php if($Merchandize_Item_Row->Manufacturer_flag==0){echo "checked";} ?>>No</label>
											  </div> 
											</div>
										</div>
										<?php if($Merchandize_Item_Row->Manufacturer_flag==1){?>
										<div class="form-group" id="manufacturer_block">
											<select class="form-control" name="Item_Manufacturer" id="Item_Manufacturer">
											<?php
												foreach($Code_decode_Records as $Rec)
												{
													if($Rec->Code_decode_type_id==4)//Manufacturer
													{
														if($Merchandize_Item_Row->Item_Manufacturer==$Rec->Code_decode)
														{
															echo '<option value="'.$Rec->Code_decode.'" selected>'.$Rec->Code_decode.'</option>';
														}
														else
														{
															echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';	
														}
													}
												}
											?>
											</select>
										</div>
										<?php }else{ ?>
										<div class="form-group" id="manufacturer_block" style="display:none;">
											<select class="form-control" name="Item_Manufacturer" id="Item_Manufacturer"  >
												<option value="">Select manufacturer</option>
												<?php
												foreach($Code_decode_Records as $Rec)
												{
													if($Rec->Code_decode_type_id==4)//Manufacturer
													{
														echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
													}
												}
												?>
											</select>									
										</div>
									<?php } ?>
										<div class="form-group">
											<label for="">Size</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Size_flag"  id="Size_flag" value="1" onclick="Size_toggle(this.value)" <?php if($Merchandize_Item_Row->Size_flag==1){echo "checked";} ?> disabled>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Size_flag" id="Size_flag" value="0" onclick="Size_toggle(this.value)" <?php if($Merchandize_Item_Row->Size_flag==0){echo "checked";} ?> disabled>No</label>
											  </div> 
											</div>
											<input type="hidden" name="Size_flag" value="<?php echo $Merchandize_Item_Row->Size_flag; ?>">
										</div>
										
										<div class="form-group">
											<label for="">Attach Size Chart</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Size_Chart"  id="Size_Chart" value="1" onclick="Size_Chart_toggle(this.value)" <?php if($Merchandize_Item_Row->Size_chart==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Size_Chart" id="Size_Chart" value="0" onclick="Size_Chart_toggle(this.value)" <?php if($Merchandize_Item_Row->Size_chart==0){echo "checked";} ?>>No</label>
											  </div> 
											</div>
										</div>
										
										<div class="form-group" id="Size_Chart_block" style="display:none;">
											<select class="form-control" name="Size_chart_image" id="Size_chart_image" onchange="Show_size_chart_image(this.value)">
												<option value="">Select size chart image</option>
												<option value="1">Upload your size chart</option>
												<option value="Apparel Shirt - Male">Apparel Shirt - Male</option>
												<option value="Apparel Trouser - Male">Apparel Trouser - Male</option>
												<option value="Apparel Shirt - Female">Apparel Shirt - Female</option>
												<option value="Apparel Trouser - Female">Apparel Trouser - Female</option>
												<option value="Footwear Male">Footwear Male</option>
												<option value="Footwear Female">Footwear Female</option>
											</select>
											<input type="hidden" name="old_Size_chart_image" value="<?php echo $Merchandize_Item_Row->Size_chart_image;?>">	
										</div>
										<div class="form-group" id="Size_Chart_upload_img_block" style="display:none;">
											<input type="file" name="Size_Chart_upload_img" id="Size_Chart_upload_img" />						
										</div>
										<div class="form-group" id="Size_Chart_img_block1" style="display:none;" data-toggle="modal" data-target="#myModal1">
											<img src="<?php echo base_url(); ?>Size_chart_images/Apparel Shirt - Male.png" width="100" style="cursor:pointer;">								
										</div>	
										<div id="myModal1" class="modal fade">
										  <div class="modal-dialog" >
											<div class="modal-content" >
												<div class="modal-body" >
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h5>Apparel Shirt - Male Size Chart</h5>
													<img src="<?php echo base_url(); ?>Size_chart_images/Apparel Shirt - Male.png" class="img-responsive">
												</div>
											</div>
										  </div>
										</div>
										
										<div class="form-group" id="Size_Chart_img_block2" style="display:none;" data-toggle="modal" data-target="#myModal2">
											<img src="<?php echo base_url(); ?>Size_chart_images/Apparel Trouser- Male.png" width="100" style="cursor:pointer;">								
										</div>	
										<div id="myModal2" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-body">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h5>Apparel Trouser- Male Size Chart</h5>
													<img src="<?php echo base_url(); ?>Size_chart_images/Apparel Trouser- Male.png" class="img-responsive">
												</div>
											</div>
										  </div>
										</div>
										
										<div class="form-group" id="Size_Chart_img_block3" style="display:none;" data-toggle="modal" data-target="#myModal33">
											<img src="<?php echo base_url(); ?>Size_chart_images/Apparel - Women.png" width="100" style="cursor:pointer;">								
										</div>	
										<div id="myModal33" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-body">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h5>Apparel - Women Size Chart</h5>
													<img src="<?php echo base_url(); ?>Size_chart_images/Apparel - Women.png" class="img-responsive">
												</div>
											</div>
										  </div>
										</div>
										
										<div class="form-group" id="Size_Chart_img_block4" style="display:none;" data-toggle="modal" data-target="#myModal4">
											<img src="<?php echo base_url(); ?>Size_chart_images/Apparel Trouser - Female.png" width="100" style="cursor:pointer;">								
										</div>	
										<div id="myModal4" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-body">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h5>Apparel Trouser - Female Size Chart</h5>
													<img src="<?php echo base_url(); ?>Size_chart_images/Apparel Trouser - Female.png" class="img-responsive">
												</div>
											</div>
										  </div>
										</div>
										
										<div class="form-group" id="Size_Chart_img_block5" style="display:none;" data-toggle="modal" data-target="#myModal5">
											<img src="<?php echo base_url(); ?>Size_chart_images/Footwear Male.png" width="100" style="cursor:pointer;">								
										</div>	
										<div id="myModal5" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-body">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h5>Footwear Male Size Chart</h5>
													<img src="<?php echo base_url(); ?>Size_chart_images/Footwear Male.png" class="img-responsive">
												</div>
											</div>
										  </div>
										</div>
										
										<div class="form-group" id="Size_Chart_img_block6" style="display:none;" data-toggle="modal" data-target="#myModal6">
											<img src="<?php echo base_url(); ?>Size_chart_images/Footwear Female.png" width="100" style="cursor:pointer;">								
										</div>	
										<div id="myModal6" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-body">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h5>Footwear Female Size Chart</h5>
													<img src="<?php echo base_url(); ?>Size_chart_images/Footwear Female.png" class="img-responsive">
												</div>
											</div>
										  </div>
										</div>

										<div class="form-group">
											<label for="">Dimensions</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Dimension_flag"  id="Dimension_flag" value="1" onclick="Dimension_toggle(this.value)" <?php if($Merchandize_Item_Row->Dimension_flag==1){echo "checked";} ?> disabled>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Dimension_flag" id="Dimension_flag" value="0" onclick="Dimension_toggle(this.value)" <?php if($Merchandize_Item_Row->Dimension_flag==0){echo "checked";} ?> disabled>No</label>
												<input type="hidden" name="Dimension_flag" value="<?php echo $Merchandize_Item_Row->Dimension_flag; ?>">
											  </div> 
											</div>
										</div>
										<input type="hidden" name="Weight_flag" value="<?php echo $Merchandize_Item_Row->Weight_flag; ?>">	
									</div>
								</div>
								</fieldset>
							</div>
							<!----------------Quantity---------------->
							<div id="Quantity">
							<fieldset class="form-group">
								<legend><span>Quantity Description</span></legend>
								<div class="row" >
									<div class="col-sm-4" >
										<div class="form-group">
											<label for="">Enable Quantity</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Quantity_flag"  id="Quantity_flag" value="1" onclick="Quantity_flag_toggle(this.value)" <?php if($Merchandize_Item_Row->Quantity_flag==1){echo "checked";} ?>>Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" type="radio" name="Quantity_flag" id="Quantity_flag" value="0" onclick="Quantity_flag_toggle(this.value)" <?php if($Merchandize_Item_Row->Quantity_flag==0){echo "checked";} ?> >No</label>
											  </div> 
											</div>
										</div>
									</div>
									<div class="col-sm-4" id="quantity_block1" style="display:none;">
										 <div class="form-group">
											<label for="">Opening Quantity</label>
											<input type="text" class="form-control" name="Stock_quantity" id="Stock_quantity" placeholder="Enter Opening Quantity" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Merchandize_Item_Row->Stock_quantity; ?>"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										 </div>
									</div>
									<div id="quantity_block2" style="display:none;" >
										<div class="col-sm-12">
											<div class="table-responsive">
												<table class="table table-lightborder">
													<tr>
														<th class="text-center">Slab</th>
														<th class="text-center">Quantity</th>
														<th class="text-center">Offer</th>
													</tr>
													<tr>
														<td class="text-center">Slab 1</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab1_Quantity" id="Slab1_Quantity"  placeholder="Enter Slab 1 Quantity" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Slab1_Quantity; ?>"/>
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab1_Offer" id="Slab1_Offer"  placeholder="Enter Slab 1 Offer" value="<?php echo $Slab1_Offer; ?>"/>
														</td>
													</tr>
													<tr>
														<td class="text-center">Slab 2</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab2_Quantity" id="Slab2_Quantity"  placeholder="Enter Slab 2 Quantity" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Slab2_Quantity; ?>"/>
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab2_Offer" id="Slab2_Offer"  placeholder="Enter Slab 2 Offer" value="<?php echo $Slab2_Offer; ?>"/>
														</td>
													</tr>
													<tr>
														<td class="text-center">Slab 3</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab3_Quantity" id="Slab3_Quantity"  placeholder="Enter Slab 3 Quantity" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Slab3_Quantity; ?>"/>
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab3_Offer" id="Slab3_Offer"  placeholder="Enter Slab 3 Offer" value="<?php echo $Slab3_Offer; ?>"/>
														</td>
													</tr>
													<tr>
														<td class="text-center">Slab 4</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab4_Quantity" id="Slab4_Quantity"  placeholder="Enter Slab 4 Quantity" value="<?php echo $Slab4_Quantity; ?>"/>
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab4_Offer" id="Slab4_Offer"  placeholder="Enter Slab 4 Offer" value="<?php echo $Slab4_Offer; ?>"/>
														</td>
													</tr>
													<tr>
														<td class="text-center">Slab 5</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab5_Quantity" id="Slab5_Quantity"  placeholder="Enter Slab 5 Quantity" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Slab1_Offer; ?>"/>
														</td>
														<td class="text-center">
															<input class="form-control" type="text" name="Slab5_Offer" id="Slab5_Offer"  placeholder="Enter Slab 5 Offer" value="<?php echo $Slab5_Offer; ?>"/>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
							</fieldset>
							</div>
						<?php if($Merchandize_Item_Row->Size_flag==0){?>
							<div id="default_block">
								<fieldset class="form-group">
								<legend><span>Item Description</span></legend>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label for="">Cost Price</label>
											<input class="form-control"  placeholder="Enter cost price"  type="text" name="Cost_price" id="Cost_price" onkeypress="return isNumberKey2(event);" onchange="Get_Calculation()" value="<?php echo $Merchandize_Item_Row-> Cost_price;?>" readonly />
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="">Billing Price</label>
											<input class="form-control" type="text" name="Billing_price" id="Billing_price" value="<?php echo $Merchandize_Item_Row-> Billing_price;?>" readonly>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="">Redeemable <?php echo $Company_details->Currency_name; ?></label>
											<input class="form-control" type="text" name="Points" id="Points" value="<?php echo $Merchandize_Item_Row-> Billing_price_in_points;?>" readonly>
										</div>
									</div>
									
								</div>
								<?php if($Merchandize_Item_Row->Dimension_flag==1){
								$exp=explode('X',$Item_Dimension);
								   // print_r($exp);
								$Length =explode('(',$exp[0]);
								$Length=str_replace(' ', '', $Length[1]);
								
								$Width = str_replace(' ', '', $exp[1]);
								$exp2 =explode(')',$exp[2]);
								$Height =str_replace(' ', '', $exp2[0]);
								
								$Unit =$exp2[1];
								$Unit = str_replace(' ', '', $Unit);
								
								?> 	
								<div id="dimension_block">
									<div class="row">
										<div class="col-sm-3">
											Dimension 
											<div class="form-group">
												<input class="form-control" type="text" name="Length" id="Length"  placeholder="Length"  onkeypress="return isNumberKey2(event);" value="<?php echo $Length; ?>" readonly />	
											</div>
										</div>
										
										<div class="col-sm-3">
											&nbsp;
											<div class="form-grou">
												<input class="form-control" type="text" name="Width" id="Width"  placeholder="Width" onkeypress="return isNumberKey2(event);" value="<?php echo $Width; ?>"readonly />
											</div>
										</div>
										<div class="col-sm-2">
										&nbsp;
											<div class="form-group">
												<input class="form-control" type="text" name="Height" id="Height" placeholder="Height" onkeypress="return isNumberKey2(event);" value="<?php echo $Height; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-4">
										&nbsp;
											<div class="form-group">
												<select class="form-control" name="Dimension_unit" id="Dimension_unit"  readonly>
												<?php
													foreach($Code_decode_Records as $Rec)
													{
														if($Rec->Code_decode_type_id==2)//Dimensions
														{
															if($Rec->Code_decode==$Unit)//Dimensions
															{
																echo '<option value="'.$Rec->Code_decode.'" selected>'.$Rec->Code_decode.'</option>';
															}
															else
															{
																echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
															}
														}
													}	?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<?php } else { ?>
								<div class="form-group" id="dimension_block" style="display:none;">
									<div class="panel-body">
										<div class="col-sm-3">
											Dimension 
											<div class="form-group">
												<input type="text" name="Length" id="Length" class="form-control" placeholder="Length"  onkeypress="return isNumberKey2(event);" />	
											</div>
											
										</div>
										
										<div class="col-sm-3">
											&nbsp;
											<div class="form-group">
												<input type="text" name="Width" id="Width"  placeholder="Width" class="form-control"   onkeypress="return isNumberKey2(event);"/>
											</div>
										</div>
										<div class="col-sm-2">
										&nbsp;
											<div class="form-group">
												<input type="text" name="Height" id="Height" placeholder="Height" class="form-control"  onkeypress="return isNumberKey2(event);" />
											</div>
										</div>
									<div class="col-sm-4">
										&nbsp;
											<div class="form-group">
												<select class="form-control" name="Dimension_unit" id="Dimension_unit"  >
													<option value="">Select dimension unit</option>
														<?php
														foreach($Code_decode_Records as $Rec)
														{
															if($Rec->Code_decode_type_id==2)//Dimensions
															{
																echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
															}
														} ?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($Merchandize_Item_Row->Weight_flag==1){?>
								<div class="form-group" id="weight_block">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">Weight</label>
												<input class="form-control" type="text" name="Weight" id="Weight" placeholder="Enter weight" onkeypress="return isNumberKey2(event);" value="<?php echo $Merchandize_Item_Row->Item_Weight; ?>"  readonly />
											</div>
										</div>
										<div class="col-sm-6">
										&nbsp;
										<select class="form-control" name="Weight_unit" id="Weight_unit" readonly>
											<?php
												foreach($Code_decode_Records as $Rec)
												{
													if($Rec->Code_decode_type_id==3)//Weight
													{ ?>
														<option value="<?php echo $Rec->Code_decode_id; ?>" <?php if($Rec->Code_decode_id==$Merchandize_Item_Row->Weight_unit_id){echo 'selected';}?>><?php echo $Rec->Code_decode; ?></option>
														
											<?php 	}
												} ?>
										</select>						
										</div>
									</div>
								</div>
								<?php }else{ ?>
								<div class="form-group" id="weight_block" style="display:none;">
									<div class="panel-body">
										<select class="form-control" name="Weight_unit" id="Weight_unit"  >
											<option value="">Select weight unit</option>
												<?php
												foreach($Code_decode_Records as $Rec)
												{
													if($Rec->Code_decode_type_id==3)//Weight
													{
														echo '<option value="'.$Rec->Code_decode_id.'">'.$Rec->Code_decode.'</option>';
													}
												} ?>
										</select>	
										<br>
										<div class="form-group has-feedback">
											<input type="text" name="Weight" id="Weight" placeholder="Enter Weight" class="form-control"  onkeypress="return isNumberKey2(event);" />
										</div>						
									</div>
								</div>
									<?php } ?>
								</fieldset>
							</div>
							<?php } else{ ?>
							<!-------------------SMALL---------------------->
							<div id="small_block">
								<fieldset class="form-group">
								<legend><span>Item Description</span></legend>
								</fieldset>
								<fieldset class="form-group">
								<legend><span>Small Item Description</span></legend>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Small Cost Price</label>
											<input class="form-control"  placeholder="Enter cost price"  type="text" name="small_Cost_price" id="small_Cost_price" onkeypress="return isNumberKey2(event);" onchange="Get_Calculation_small()" value="<?php echo $small_Cost_price;?>"  readonly />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Billing Price</label>
											<input class="form-control" type="text" name="small_Billing_price" id="small_Billing_price" value="<?php echo $small_Billing_price;?>" readonly>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Redeemable <?php echo $Company_details->Currency_name; ?></label>
											<input class="form-control" type="text" name="small_Points" id="small_Points" value="<?php echo $small_Points;?>" readonly>
										</div>
									</div>
									
								</div>
								<?php if($Merchandize_Item_Row->Weight_flag==1){ ?>
								<div class="form-group" id="weight_block_small">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">Small Item Weight</label>
												<input class="form-control" type="text" name="Small_Weight" id="Small_Weight" placeholder="Enter weight" onkeypress="return isNumberKey2(event);" value="<?php echo $small_Item_weight; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-6">
										&nbsp;
										<select class="form-control" name="Small_Weight_unit" id="Small_Weight_unit" readonly>
											<?php
										foreach($Code_decode_Records as $Rec)
										{
											if($Rec->Code_decode_type_id==3)//Weight
											{ ?>
												<option value="<?php echo $Rec->Code_decode_id; ?>" <?php if($Rec->Code_decode_id==$small_Weight_unit_id){echo 'selected';}?>><?php echo $Rec->Code_decode; ?></option>
									<?php 	}
										}	?>
										</select>						
										</div>
									</div>
								</div>
								<?php } ?>
								<!--------------SMALL ITEM WEIGHT----END-------->
								<?php if($Merchandize_Item_Row->Dimension_flag==1){
											$exp_sm=explode('X',$small_Item_Dimension);
											   // print_r($exp_sm);
											$Length_sm =explode('(',$exp_sm[0]);
											$Length_sm=str_replace(' ', '', $Length_sm[1]);
											
											$Width_sm = str_replace(' ', '', $exp_sm[1]);
											$exp2_sm =explode(')',$exp_sm[2]);
											$Height_sm =str_replace(' ', '', $exp2_sm[0]);
											
											$Unit_sm =$exp2_sm[1];
											$Unit_sm = str_replace(' ', '', $Unit_sm);
								?> 	
								<!--------------SMALL ITEM DMENSION--------------->
								<div id="dimension_block_small">
									<div class="row">
										<div class="col-sm-3">
											Small Item Dimension 
											<div class="form-group">
												<input class="form-control" type="text" name="Small_Length" id="Small_Length"  placeholder="Length" onkeypress="return isNumberKey2(event);" value="<?php echo $Length_sm; ?>" readonly  />	
											</div>
										</div>
										
										<div class="col-sm-3">
											&nbsp;
											<div class="form-grou">
												<input class="form-control" type="text" name="Small_Width" id="Small_Width"  placeholder="Width" onkeypress="return isNumberKey2(event);" value="<?php echo $Width_sm; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-2">
										&nbsp;
											<div class="form-group">
												<input class="form-control" type="text" name="Small_Height" id="Small_Height" placeholder="Height" onkeypress="return isNumberKey2(event);"  value="<?php echo $Height_sm; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-4">
										&nbsp;
											<div class="form-group">
												<select class="form-control" name="Small_Dimension_unit" id="Small_Dimension_unit"  >
												<?php
													foreach($Code_decode_Records as $Rec)
													{
														if($Rec->Code_decode_type_id==2)//Dimensions
														{
															if($Rec->Code_decode==$Unit_sm)//Dimensions
															{
																echo '<option value="'.$Rec->Code_decode.'" selected>'.$Rec->Code_decode.'</option>';
															}
															else
															{
																echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
															}
														}
													} ?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<?php }?>
								</fieldset>
								<!-------------------SMALL---------------------->
								<!------------------MEDIUM-------------------->
								<fieldset class="form-group">
								<legend><span>Medium Item Description</span></legend>
								<div class="row" id="medium_block">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Medium Cost Price</label>
											<input class="form-control"  placeholder="Enter cost price"  type="text" name="medium_Cost_price" id="medium_Cost_price" onkeypress="return isNumberKey2(event);" onchange="Get_Calculation_medium()"  value="<?php echo $medium_Cost_price;?>" readonly/>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Billing Price</label>
											<input class="form-control" type="text" name="medium_Billing_price" id="medium_Billing_price" readonly  value="<?php echo $medium_Billing_price;?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Redeemable <?php echo $Company_details->Currency_name; ?></label>
											<input class="form-control" type="text" name="medium_Points" id="medium_Points" value="<?php echo $medium_Points;?>" readonly >
										</div>
									</div>
									
								</div>
								<?php if($Merchandize_Item_Row->Weight_flag==1){ ?>
								<div class="form-group" id="weight_block_medium">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">Medium Item Weight</label>
												<input class="form-control" type="text" name="Medium_Weight" id="Medium_Weight" placeholder="Enter weight" onkeypress="return isNumberKey2(event);" value="<?php echo $medium_Item_weight; ?>"    readonly  />
											</div>
										</div>
										<div class="col-sm-6">
										&nbsp;
										<select class="form-control" name="Medium_Weight_unit" id="Medium_Weight_unit" readonly>
									<?php
										foreach($Code_decode_Records as $Rec)
										{	
											if($Rec->Code_decode_type_id==3)//Weight
											{ ?>
												<option value="<?php echo $Rec->Code_decode_id; ?>" <?php if($Rec->Code_decode_id==$medium_Weight_unit_id){echo 'selected';}?>><?php echo $Rec->Code_decode; ?></option>
												
									<?php 	}
										} ?>
										</select>						
										</div>
									</div>
								</div>
								<?php } ?>
								<!--------------Medium ITEM WEIGHT----END-------->
							<?php if($Merchandize_Item_Row->Dimension_flag==1){
									$exp_md=explode('X',$medium_Item_Dimension);
									  // print_r($exp);
									$Length_md =explode('(',$exp_md[0]);
									$Length_md=str_replace(' ', '', $Length_md[1]);
									
									$Width_md = str_replace(' ', '', $exp_md[1]);
									$exp2_md =explode(')',$exp_md[2]);
									$Height_md =str_replace(' ', '', $exp2_md[0]);
									
									$Unit_md =$exp2_md[1];
									$Unit_md = str_replace(' ', '', $Unit_md);
							?> 	
								<!--------------Medium ITEM DMENSION--------------->
								<div id="dimension_block_medium">
									<div class="row">
										<div class="col-sm-3">
											Medium Item Dimension 
											<div class="form-group">
												<input class="form-control" type="text" name="Medium_Length" id="Medium_Length"  placeholder="Length"  onkeypress="return isNumberKey2(event);" value="<?php echo $Length_md; ?>" readonly />	
											</div>
										</div>
										
										<div class="col-sm-3">
											&nbsp;
											<div class="form-grou">
												<input class="form-control" type="text" name="Medium_Width" id="Medium_Width"  placeholder="Width" onkeypress="return isNumberKey2(event);" value="<?php echo $Width_md; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-2">
										&nbsp;
											<div class="form-group">
												<input class="form-control" type="text" name="Medium_Height" id="Medium_Height" placeholder="Height" onkeypress="return isNumberKey2(event);"value="<?php echo $Height_md; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-4">
										&nbsp;
											<div class="form-group">
												<select class="form-control" name="Medium_Dimension_unit" id="Medium_Dimension_unit"  readonly>
												<?php
													foreach($Code_decode_Records as $Rec)
													{
														if($Rec->Code_decode_type_id==2)//Dimensions
														{
															 // echo "<br>if($Rec->Code_decode==$Unit)";//Dimensions
															if($Rec->Code_decode==$Unit_md)//Dimensions
															{
																echo '<option value="'.$Rec->Code_decode.'" selected>'.$Rec->Code_decode.'</option>';
															}
															else
															{
																echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
															}
														}
													} ?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								</fieldset>
								
								<!----------------------LARGE---------------------->
								
								<fieldset class="form-group">
								<legend><span>Large Item Description</span></legend>
								<div class="row" id="large_block">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Large Cost Price</label>
											<input class="form-control"  placeholder="Enter cost price"  type="text" name="large_Cost_price" id="large_Cost_price" onkeypress="return isNumberKey2(event);" onchange="Get_Calculation_large()" value="<?php echo $large_Cost_price;?>" readonly />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Billing Price</label>
											<input class="form-control" type="text" name="large_Billing_price" id="large_Billing_price" value="<?php echo $large_Billing_price;?>" readonly>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Redeemable <?php echo $Company_details->Currency_name; ?></label>
											<input class="form-control" type="text" name="large_Points" id="large_Points" value="<?php echo $large_Points;?>" readonly>
										</div>
									</div>
									
								</div>
									<?php if($Merchandize_Item_Row->Weight_flag==1){ ?>
								<div class="form-group" id="weight_block_large">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">Large Item Weight</label>
												<input class="form-control" type="text" name="Large_Weight" id="Large_Weight" placeholder="Enter weight" onkeypress="return isNumberKey2(event);" value="<?php echo $large_Item_weight; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-6">
										&nbsp;
										<select class="form-control" name="Large_Weight_unit" id="Large_Weight_unit" readonly>
											<?php
										foreach($Code_decode_Records as $Rec)
										{
											
											if($Rec->Code_decode_type_id==3)//Weight
											{ ?>
												<option value="<?php echo $Rec->Code_decode_id; ?>" <?php if($Rec->Code_decode_id==$large_Weight_unit_id){echo 'selected';}?>><?php echo $Rec->Code_decode; ?></option>
												
									<?php 	}
										} ?>
										</select>						
										</div>
									</div>
								</div>
								<?php }?>
								<!--------------Large ITEM WEIGHT----END-------->
							<?php if($Merchandize_Item_Row->Dimension_flag==1){
								$exp_l=explode('X',$large_Item_Dimension);
								  // print_r($exp);
								$Length_l =explode('(',$exp_l[0]);
								$Length_l=str_replace(' ', '', $Length_l[1]);
								
								$Width_l = str_replace(' ', '', $exp_l[1]);
								$exp21 =explode(')',$exp_l[2]);
								$Height_l =str_replace(' ', '', $exp21[0]);
								
								$Unit_l =$exp21[1];
								$Unit_l = str_replace(' ', '', $Unit_l);
							?> 
								<!--------------Large ITEM DMENSION--------------->
								<div id="dimension_block_large">
									<div class="row">
										<div class="col-sm-3">
											Large Item Dimension  
											<div class="form-group">
												<input class="form-control" type="text" name="Large_Length" id="Large_Length"  placeholder="Length"  onkeypress="return isNumberKey2(event);" value="<?php echo $Length_l; ?>" readonly />	
											</div>
										</div>
										
										<div class="col-sm-3">
											&nbsp;
											<div class="form-grou">
												<input class="form-control" type="text" name="Large_Width" id="Large_Width"  placeholder="Width" onkeypress="return isNumberKey2(event);" value="<?php echo $Width_l; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-2">
										&nbsp;
											<div class="form-group">
												<input class="form-control" type="text" name="Large_Height" id="Large_Height" placeholder="Height" onkeypress="return isNumberKey2(event);" value="<?php echo $Height_l; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-4">
										&nbsp;
											<div class="form-group">
												<select class="form-control" name="Large_Dimension_unit" id="Large_Dimension_unit"  readonly>
												<?php
													foreach($Code_decode_Records as $Rec)
													{
														if($Rec->Code_decode_type_id==2)//Dimensions
														{
															 // echo "<br>if($Rec->Code_decode==$Unit)";//Dimensions
															if($Rec->Code_decode==$Unit_l)//Dimensions
															{
																echo '<option value="'.$Rec->Code_decode.'" selected>'.$Rec->Code_decode.'</option>';
															}
															else
															{
																echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
															}
														}
													}	?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<?php }?>
								</fieldset>
								<!--------------------Extra LARGE--------------------->
								<fieldset class="form-group">
								<legend><span>Extra Large Item Description</span></legend>
								<div class="row" id="elarge_block">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Extra Large Cost Price</label>
											<input class="form-control"  placeholder="Enter cost price"  type="text" name="elarge_Cost_price" id="elarge_Cost_price" onkeypress="return isNumberKey2(event);" onchange="Get_Calculation_extra_large()" value="<?php echo $elarge_Cost_price;?>" readonly/>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Billing Price</label>
											<input class="form-control" type="text" name="elarge_Billing_price" id="elarge_Billing_price" readonly  value="<?php echo $elarge_Billing_price;?>" >
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="">Redeemable <?php echo $Company_details->Currency_name; ?></label>
											<input class="form-control" type="text" name="elarge_Points" id="elarge_Points" value="<?php echo $elarge_Points;?>" readonly>
										</div>
									</div>
									
								</div>
								<?php if($Merchandize_Item_Row->Weight_flag==1){ ?>
								<div class="form-group" id="eweight_block_large">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">Extra Large Item Weight</label>
												<input class="form-control" type="text" name="eLarge_Weight" id="eLarge_Weight" placeholder="Enter weight" onkeypress="return isNumberKey2(event);"  value="<?php echo $elarge_Item_weight; ?>"  readonly />
											</div>
										</div>
										<div class="col-sm-6">
										&nbsp;
										<select class="form-control" name="eLarge_Weight_unit" id="eLarge_Weight_unit" readonly>
											<?php
										foreach($Code_decode_Records as $Rec)
										{
											
											if($Rec->Code_decode_type_id==3)//Weight
											{ ?>
												<option value="<?php echo $Rec->Code_decode_id; ?>" <?php if($Rec->Code_decode_id==$elarge_Weight_unit_id){echo 'selected';}?>><?php echo $Rec->Code_decode; ?></option>
									<?php 	}
										} ?>
										</select>						
										</div>
									</div>
								</div>
							<?php }
								if($Merchandize_Item_Row->Dimension_flag==1){
								$eexp_l=explode('X',$elarge_Item_Dimension);
								  // print_r($exp);
								$eLength_l =explode('(',$eexp_l[0]);
								$eLength_l=str_replace(' ', '', $eLength_l[1]);
								
								$eWidth_l = str_replace(' ', '', $eexp_l[1]);
								$eexp21 =explode(')',$eexp_l[2]);
								$eHeight_l =str_replace(' ', '', $eexp21[0]);
								
								$eUnit_l =$eexp21[1];
								$eUnit_l = str_replace(' ', '', $eUnit_l);
							?> 
								<!--------------extra Large ITEM DMENSION--------------->
								<div id="edimension_block_large">
									<div class="row">
										<div class="col-sm-3">
											Extra Large Item Dimension  
											<div class="form-group">
												<input class="form-control" type="text" name="eLarge_Length" id="eLarge_Length"  placeholder="Length"  onkeypress="return isNumberKey2(event);" value="<?php echo $eLength_l; ?>"   readonly />	
											</div>
										</div>
										
										<div class="col-sm-3">
											&nbsp;
											<div class="form-grou">
												<input class="form-control" type="text" name="eLarge_Width" id="eLarge_Width"  placeholder="Width" onkeypress="return isNumberKey2(event);" value="<?php echo $eWidth_l; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-2">
										&nbsp;
											<div class="form-group">
												<input class="form-control" type="text" name="eLarge_Height" id="eLarge_Height" placeholder="Height" onkeypress="return isNumberKey2(event);"value="<?php echo $eHeight_l; ?>" readonly />
											</div>
										</div>
										<div class="col-sm-4">
										&nbsp;
											<div class="form-group">
												<select class="form-control" name="eLarge_Dimension_unit" id="eLarge_Dimension_unit"  readonly>
													<?php
														foreach($Code_decode_Records as $Rec)
														{
															if($Rec->Code_decode_type_id==2)//Dimensions
															{
																 // echo "<br>if($Rec->Code_decode==$Unit)";//Dimensions
																if($Rec->Code_decode==$eUnit_l)//Dimensions
																{
																	echo '<option value="'.$Rec->Code_decode.'" selected>'.$Rec->Code_decode.'</option>';
																}
																else
																{
																	echo '<option value="'.$Rec->Code_decode.'">'.$Rec->Code_decode.'</option>';
																}
															}
														}	?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<?php }?>
								</fieldset>
							</div>
							<?php } ?>
							
							<fieldset class="form-group">
								<legend><span>Upload Images of Merchandise Item  <font color="RED" align="center" size="0.8em"><i>&nbsp;&nbsp;&nbsp;&nbsp;Image Resolution should be above 800(Horizontal) X 800(Vertical)  for best product view</i></font></span></legend>
								<div class="row">
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Merchandise item image-1</strong></p></div>
											<?php if($Merchandize_Item_Row->Item_image1 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image1; ?>" class="img-responsive" id="no_image1" style="width: 50%;">
											<?php }else{ ?>	
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image1" class="img-responsive" style="width: 50%;">
										<?php } ?>	
									
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file1" id="file1" onchange="readImage(this,'#no_image1');" style="width: 100%;">
													<input type="hidden" name="Item_image1" value="<?php echo $Merchandize_Item_Row->Item_image1;?>">
													<input type="hidden" name="Thumbnail_image1" value="<?php echo $Merchandize_Item_Row->Thumbnail_image1;?>">
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Merchandise item image-2</strong></p></div>
											<?php if($Merchandize_Item_Row->Item_image2 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image2; ?>" id="no_image2" class="img-responsive" style="width: 50%;">
										<?php }else{ ?>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image2" class="img-responsive" style="width: 50%;">
										<?php } ?>
											
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file2"  id="file2" onchange="readImage(this,'#no_image2');" style="width: 100%;">
													<input type="hidden" name="Item_image2" value="<?php echo $Merchandize_Item_Row->Item_image2;?>">
													<input type="hidden" name="Thumbnail_image2" value="<?php echo $Merchandize_Item_Row->Thumbnail_image2;?>">
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Merchandise item image-3</strong></p></div>
											<?php if($Merchandize_Item_Row->Item_image3 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image3; ?>" id="no_image3" class="img-responsive" style="width: 50%;">
										<?php }else{ ?>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image3" class="img-responsive" style="width: 50%;">
										<?php } ?>
											
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file3" onchange="readImage(this,'#no_image3');" style="width: 100%;" />
													<input type="hidden" name="Item_image3" value="<?php echo $Merchandize_Item_Row->Item_image3;?>">
													<input type="hidden" name="Thumbnail_image3" value="<?php echo $Merchandize_Item_Row->Thumbnail_image3;?>">
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Merchandise item image-4</strong></p></div>
											<?php if($Merchandize_Item_Row->Item_image4 != ""){ ?>
											<img src="<?php echo $Merchandize_Item_Row->Item_image4; ?>" id="no_image4" class="img-responsive" style="width: 50%;">
										<?php }else{ ?>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image4" class="img-responsive" style="width: 50%;">
										<?php } ?>
											
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file4" onchange="readImage(this,'#no_image4');" style="width: 100%;" />
													<input type="hidden" name="Item_image4" value="<?php echo $Merchandize_Item_Row->Item_image4;?>">
													<input type="hidden" name="Thumbnail_image4" value="<?php echo $Merchandize_Item_Row->Thumbnail_image4;?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</fieldset>	
							<!-------------------------->
							<input type="hidden" name="Cost_payable_to_partner" id="Cost_payable_to_partner" class="form-control" readonly value="0">					
							<input type="hidden" name="small_Cost_payable_to_partner" id="small_Cost_payable_to_partner" class="form-control" readonly value="0">					
							<input type="hidden" name="medium_Cost_payable_to_partner" id="medium_Cost_payable_to_partner" class="form-control" readonly value="0">					
							<input type="hidden" name="large_Cost_payable_to_partner" id="large_Cost_payable_to_partner" class="form-control" readonly value="0">					
							<input type="hidden" name="elarge_Cost_payable_to_partner" id="elarge_Cost_payable_to_partner" class="form-control" readonly value="0">					
							<!--------------------------->	
							<input type="hidden" name="Company_merchandise_item_id" value="<?php echo $Merchandize_Item_Row->Company_merchandise_item_id;?>">
							<input type="hidden" name="Update_user_id" value="<?php echo $enroll;?>">
							<input type="hidden" name="Update_date" value="<?php echo date("Y-m-d H:i:s");?>">
							<input type="hidden" name="Create_User_id" value="<?php echo $Merchandize_Item_Row->Create_User_id;?>">
							<input type="hidden" name="Creation_date" value="<?php echo $Merchandize_Item_Row->Creation_date;?>">	
						 
						<div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" value="Register" id="Register">Update</button>
							
							<button class="btn btn-primary" type="button" value="Cost" id="Cost" onclick="delete_me('<?php echo $Merchandize_Item_Row->Company_merchandise_item_id;?>','<?php echo $Merchandize_Item_Row->Merchandize_item_name; ?>','Merchandise Item And Modify the Cost Price?','Coal_CatalogueC/Modify_cost_Price/?Company_merchandise_item_id');" data-target="#deleteModal" data-toggle="modal">Modify Cost Price</button>
						</div>
					</div>
				</div>
			<?php echo form_close(); ?>	
			
			<!--------------Table------------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Merchandise Items
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Item Code</th>
									<th>Merchandise Item Name</th>
									<th>Merchandise Category</th>
									<th>Link to Merchant</th>
									<th>Validity</th>
									<th>Status</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Item Code</th>
									<th>Merchandise Item Name</th>
									<th>Merchandise Category</th>
									<th>Link to Merchant</th>
									<th>Validity</th>
									<th>Status</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($Merchandize_Items_Records != NULL)
							{
								foreach($Merchandize_Items_Records as $row)
								{
									$Todays_date=date("Y-m-d");
									$Color="";
									$Status="<font color='red'>Disable</font>";
									
									if($Todays_date>=$row->Valid_from && $Todays_date<=$row->Valid_till)
									{
										$Color="green";
									}
									if($row->show_item==1)
									{
										$Status="<font color='green'>Enable</font>";
									}
									if($row->Size_flag==1)
									{
										$Size_flag="Yes";
									}
									else
									{
										$Size_flag="No";
									}
									if($row->Merchant_flag==1)
									{
										$Merchant_flag="Yes";
									}
									else
									{
										$Merchant_flag="No";
									}
							?>
								<tr>
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/Coal_CatalogueC/Edit_Merchandize_Items/?Company_merchandise_item_id=<?php echo $row->Company_merchandise_item_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Company_merchandise_item_id;?>','<?php echo $row->Merchandize_item_name; ?>','','Coal_CatalogueC/InActive_Merchandize_Item/?Company_merchandise_item_id');"  data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
									</td>
									<td><?php echo $row->Company_merchandize_item_code; ?></td>
									<td><?php echo $row->Merchandize_item_name;?></td>
									<td><?php echo $row->Merchandize_category_name;?></td>
									<td><?php echo $Merchant_flag;?></td>
									<td><?php echo "<font color=".$Color.">".$row->Valid_from.' To '.$row->Valid_till."</font>"; ?></td>
									<td><?php echo $Status;?></td>
								</tr>
					<?php 		}
							}	?>
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
<?php $this->load->view('header/footer'); ?>

<script>
<?php 
	if($Merchandize_Item_Row->Quantity_flag==1)
	{ ?>
		Quantity_flag_toggle(1);
<?php }  ?>

	function Modify_cost_Price(Company_merchandise_item_id,Merchandize_item_name)
	{	
		var url = '<?php echo base_url()?>index.php/Coal_CatalogueC/Modify_cost_Price/?Company_merchandise_item_id='+Company_merchandise_item_id;
		BootstrapDialog.confirm("Are you sure you want to Delete Existing '"+Merchandize_item_name+"'  Merchandise Item And Modify the Cost Price?", function(result) 
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
	
	$('#Register').click(function()
	{			   
		if( $('#Company_id').val() != "" && $('#Merchandize_category_id').val() != "" && $('#Company_merchandize_item_code').val() != "" && $('#Merchandize_item_name').val() != "" && $('#Merchandise_item_description').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" && $('#Partner_id').val() != "" && $('#partner_branches').val() != "" && $('#Delivery_method').val() != "")
		{
			//$('#Cost_price').val() != "" && 
			var Size_flag = $("input[name=Size_flag]:checked").val();
			var Merchant_flag = $("input[name=Merchant_flag]:checked").val();
			var Seller_id=$('#Seller_id').val();
			
			var Brand_flag = $("input[name=Brand_flag]:checked").val();
			var Item_Brand=$('#Item_Brand').val();
			
			var Dimension_flag = $("input[name=Dimension_flag]:checked").val();
			var Dimension_unit=$('#Dimension_unit').val();
			var Length=$('#Length').val();
			var Width=$('#Width').val();
			var Height=$('#Height').val();
			
			// var Weight_flag = $("input[name=Weight_flag]:checked").val();
			var Weight_flag = 1;
			var Weight_unit=$('#Weight_unit').val();
			var Weight=$('#Weight').val();
			
			var Manufacturer_flag = $("input[name=Manufacturer_flag]:checked").val();
			var Item_Manufacturer=$('#Item_Manufacturer').val();
			
			var Seller_Redemptionratio=$('#Seller_Redemptionratio').val();
			if(Seller_Redemptionratio=="" || Seller_Redemptionratio <= 0 )
			{
				var msg = 'Please Enter Valid Redemptionratio';
				$('#alert_box').show();			
				$("#alert_box").html(msg);
				jQuery("#alert_box").attr("tabindex",-1).focus();
				setTimeout(function(){ $('#alert_box').hide(); }, 4000);
				return false;
			}
			if(Merchant_flag==1 && Seller_id== "")
			{
				var msg = 'Please Select Merchant';
				$('#alert_box').show();			
				$("#alert_box").html(msg);
				jQuery("#alert_box").attr("tabindex",-1).focus();
				setTimeout(function(){ $('#alert_box').hide(); }, 4000);
				return false;
			}
			
			if(Brand_flag==1 && Item_Brand== "")
			{
				var msg = 'Please Select Item Brand';
				$('#alert_box').show();			
				$("#alert_box").html(msg);
				jQuery("#alert_box").attr("tabindex",-1).focus();
				setTimeout(function(){ $('#alert_box').hide(); }, 4000);
				return false;
			}
			
			if(Manufacturer_flag==1 && Item_Manufacturer== "")
			{
				var msg = 'Please Select Item Manufacturer';
				$('#alert_box').show();			
				$("#alert_box").html(msg);
				jQuery("#alert_box").attr("tabindex",-1).focus();
				setTimeout(function(){ $('#alert_box').hide(); }, 4000);
				return false;
			}
			
			var Quantity_flag = $("input[name=Quantity_flag]:checked").val();
			var Stock_quantity=$('#Stock_quantity').val();
			if(Quantity_flag==1 && Stock_quantity== "")
			{
				var msg = 'Please Enter Opening Quantity !!!';
				$('#alert_box').show();			
				$("#alert_box").html(msg);
				jQuery("#alert_box").attr("tabindex",-1).focus();
				setTimeout(function(){ $('#alert_box').hide(); }, 4000);
				return false;
			}
			if(Quantity_flag==1 && Stock_quantity== 0)
			{
				var msg = '0 not allowed in Opening Quantity !!!';
				$('#alert_box').show();			
				$("#alert_box").html(msg);
				jQuery("#alert_box").attr("tabindex",-1).focus();
				setTimeout(function(){ $('#alert_box').hide(); }, 4000);
				return false;
			}
			
			if(Quantity_flag==1 && Stock_quantity!= "")
			{
				var Title2 = "Application Information";
				var msg2 = "0 not allowed in slab Quantity ";
				
				var Slab1_Quantity=$('#Slab1_Quantity').val();
				var Slab2_Quantity=$('#Slab2_Quantity').val();
				var Slab3_Quantity=$('#Slab3_Quantity').val();
				var Slab4_Quantity=$('#Slab4_Quantity').val();
				var Slab5_Quantity=$('#Slab5_Quantity').val();
				
				// if(Slab1_Quantity==0 && Slab1_Quantity!=""){runjs(Title2,msg2);return false;}
				// if(Slab2_Quantity==0 && Slab2_Quantity!=""){runjs(Title2,msg2);return false;}
				// if(Slab3_Quantity==0 && Slab3_Quantity!=""){runjs(Title2,msg2);return false;}
				// if(Slab4_Quantity==0 && Slab4_Quantity!=""){runjs(Title2,msg2);return false;}
				// if(Slab5_Quantity==0 && Slab5_Quantity!=""){runjs(Title2,msg2);return false;}
				
				if(Slab1_Quantity==0 && Slab1_Quantity!="")
				{
					$('#alert_box').show();			
					$("#alert_box").html(msg2);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				if(Slab2_Quantity==0 && Slab2_Quantity!="")
				{
					$('#alert_box').show();			
					$("#alert_box").html(msg2);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				if(Slab3_Quantity==0 && Slab3_Quantity!="")
				{
					$('#alert_box').show();			
					$("#alert_box").html(msg2);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				if(Slab4_Quantity==0 && Slab4_Quantity!="")
				{
					$('#alert_box').show();			
					$("#alert_box").html(msg2);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				if(Slab5_Quantity==0 && Slab5_Quantity!="")
				{
					$('#alert_box').show();			
					$("#alert_box").html(msg2);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				
				if(Slab1_Quantity==""){Slab1_Quantity=0;}
				if(Slab2_Quantity==""){Slab2_Quantity=0;}
				if(Slab3_Quantity==""){Slab3_Quantity=0;}
				if(Slab4_Quantity==""){Slab4_Quantity=0;}
				if(Slab5_Quantity==""){Slab5_Quantity=0;}
				
				var Calc_total_slab_qty = parseFloat(Slab1_Quantity) + parseFloat(Slab2_Quantity) + parseFloat(Slab3_Quantity) + parseFloat(Slab4_Quantity) + parseFloat(Slab5_Quantity);
				
				
					
				if((Stock_quantity<Calc_total_slab_qty || Calc_total_slab_qty<Stock_quantity) && (Calc_total_slab_qty!=0))
				{
					var msg = "Total Slab Quantity "+Calc_total_slab_qty+" should be equal to Opening Quantity "+Stock_quantity;
					$('#alert_box').show();			
					$("#alert_box").html(msg);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}	
				
			}
			
			if(Size_flag==1)
			{
				if($('#small_Cost_price').val() == "" && $('#medium_Cost_price').val() == "" && $('#large_Cost_price').val() == "" && $('#elarge_Cost_price').val() == "")
				{
					var msg = 'Please Enter atleast one Cost Price of Small, Medium or Large or Extra Large';
					$('#alert_box').show();			
					$("#alert_box").html(msg);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				else
				{
					if($('#small_Cost_price').val() != "")
					{
						/*******Small Item Weight Validation*********************/
						var Small_Weight_unit=$('#Small_Weight_unit').val();
						var Small_Weight=$('#Small_Weight').val();	
						if(Weight_flag==1 && Small_Weight== "")
						{
							var msg = 'Please Enter Small Item Weight';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Weight_flag==1 && Small_Weight_unit== "")
						{
							var msg = 'Please Select Small Item Weight Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						/*******xxx*********************/
						/*******Small Item Dimension Validation*********************/
						var Small_Length=$('#Small_Length').val();
						var Small_Width=$('#Small_Width').val();
						var Small_Height=$('#Small_Height').val();
						var Small_Dimension_unit=$('#Small_Dimension_unit').val();
						if(Dimension_flag==1 && (Small_Length== "" || Small_Width== "" || Small_Height== ""))
						{
							var msg = 'Please Enter Small Item Dimension Length,Width and Height';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Dimension_flag==1 && Small_Dimension_unit== "")
						{
							var msg = 'Please Select Small Item Dimension Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						
						/******************XXXXXX***********************/
						
					}
					if($('#medium_Cost_price').val() != "")
					{
						/*******Medium Item Weight Validation*********************/
						var Medium_Weight_unit=$('#Medium_Weight_unit').val();
						var Medium_Weight=$('#Medium_Weight').val();	
						if(Weight_flag==1 && Medium_Weight== "")
						{
							var msg = 'Please Enter Medium Item Weight';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Weight_flag==1 && Medium_Weight_unit== "")
						{
							var msg = 'Please Select Medium Item Weight Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						/******************XXXXXX***********************/
						/*******Medium Item Dimension Validation*********************/
						var Medium_Length=$('#Medium_Length').val();
						var Medium_Width=$('#Medium_Width').val();
						var Medium_Height=$('#Medium_Height').val();
						var Medium_Dimension_unit=$('#Medium_Dimension_unit').val();
						if(Dimension_flag==1 && (Medium_Length== "" || Medium_Width== "" || Medium_Height== ""))
						{
							var msg = 'Please Enter Medium Item Dimension Length,Width and Height';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Dimension_flag==1 && Medium_Dimension_unit== "")
						{
							var msg = 'Please Select Medium Item Dimension Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						
						/******************XXXXXX***********************/
					}
					if($('#large_Cost_price').val() != "")
					{
						/*******Large Item Weight Validation*********************/
						var Large_Weight_unit=$('#Large_Weight_unit').val();
						var Large_Weight=$('#Large_Weight').val();	
						if(Weight_flag==1 && Large_Weight== "")
						{
							var msg = 'Please Enter Large Item Weight';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Weight_flag==1 && Large_Weight_unit== "")
						{
							var msg = 'Please Select Large Item Weight Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						/******************XXXXXX***********************/
						
						/*******Large Item Dimension Validation*************/
						var Large_Length=$('#Large_Length').val();
						var Large_Width=$('#Large_Width').val();
						var Large_Height=$('#Large_Height').val();
						var Large_Dimension_unit=$('#Large_Dimension_unit').val();
						if(Dimension_flag==1 && (Large_Length== "" || Large_Width== "" || Large_Height== ""))
						{
							var msg = 'Please Enter Large Item Dimension Length,Width and Height';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Dimension_flag==1 && Large_Dimension_unit== "")
						{
							var msg = 'Please Select Large Item Dimension Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						
						/******************XXXXXX***********************/
					}
					if($('#elarge_Cost_price').val() != "")
					{
						/*******Extra Large Item Weight Validation*********************/
						var eLarge_Weight_unit=$('#eLarge_Weight_unit').val();
						var eLarge_Weight=$('#eLarge_Weight').val();	
						if(Weight_flag==1 && eLarge_Weight== "")
						{
							var msg = 'Please Enter Extra Large Item Weight';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Weight_flag==1 && eLarge_Weight_unit== "")
						{
							var msg = 'Please Select Extra Large Item Weight Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						/******************XXXXXX***********************/
						
						/*******Extra Large Item Dimension Validation*********************/
						var eLarge_Length=$('#eLarge_Length').val();
						var eLarge_Width=$('#eLarge_Width').val();
						var eLarge_Height=$('#eLarge_Height').val();
						var eLarge_Dimension_unit=$('#eLarge_Dimension_unit').val();
						if(Dimension_flag==1 && (eLarge_Length== "" || eLarge_Width== "" || eLarge_Height== ""))
						{
							var msg = 'Please Enter Extra Large Item Dimension Length,Width and Height';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						if(Dimension_flag==1 && eLarge_Dimension_unit== "")
						{
							var msg = 'Please Select Extra Large Item Dimension Unit';
							$('#alert_box').show();			
							$("#alert_box").html(msg);
							jQuery("#alert_box").attr("tabindex",-1).focus();
							setTimeout(function(){ $('#alert_box').hide(); }, 4000);
							return false;
						}
						
						/******************XXXXXX***********************/
					}
					
					if($('#small_Cost_price').val() != "" || $('#medium_Cost_price').val() != "" || $('#large_Cost_price').val() != "" || $('#elarge_Cost_price').val() != "")
					{
						show_loader();
					}
				}
			}
			else
			{
				if($('#Cost_price').val() == "")
				{
					var msg = 'Please Enter Cost Price';
					$('#alert_box').show();			
					$("#alert_box").html(msg);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				if(Dimension_flag==1 && (Length== "" || Width== "" || Height== ""))
				{
					var msg = 'Please Enter Dimension Length,Width and Height';
					$('#alert_box').show();			
					$("#alert_box").html(msg);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				if(Dimension_flag==1 && Dimension_unit== "")
				{
					var msg = 'Please Select Dimension Unit';
					$('#alert_box').show();			
					$("#alert_box").html(msg);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				
				
				if(Weight_flag==1 && Weight== "")
				{
					var msg = 'Please Enter Weight';
					$('#alert_box').show();			
					$("#alert_box").html(msg);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				if(Weight_flag==1 && Weight_unit== "")
				{
					var msg = 'Please Select Weight Unit';
					$('#alert_box').show();			
					$("#alert_box").html(msg);
					jQuery("#alert_box").attr("tabindex",-1).focus();
					setTimeout(function(){ $('#alert_box').hide(); }, 4000);
					return false;
				}
				
				if($('#Cost_price').val() != "")
				{
					show_loader();
				}
			}
			/******************e-Commerce*****************/
				var Ecommerce_flag = $("input[name=Ecommerce_flag]:checked").val();
				// var Offer_flag = $("input[name=Offer_flag]:checked").val();
				// var Offer_flag = $('#Offer_flag').val();
				var Product_group_id = $('#Product_group_id').val();
				var Product_brand_id = $('#Product_brand_id').val();
				// alert(Ecommerce_flag);
				
				if(Ecommerce_flag==1)
				{
					if(Product_group_id== "" || Product_brand_id== "")
					{
						var msg = 'Please Select Product Group and Product Brand';
						$('#alert_box').show();			
						$("#alert_box").html(msg);
						jQuery("#alert_box").attr("tabindex",-1).focus();
						setTimeout(function(){ $('#alert_box').hide(); }, 4000);
						return false;
					}
				}
				// return false;
			/*************e-Commerce*************/
		}
	});
	function Get_Calculation_extra_large()
	{
		var partner_vat = document.getElementById('VAT').value;
		var Cost_price = document.getElementById('elarge_Cost_price').value;
		var margin = document.getElementById('margin').value;
		var Partner_id = document.getElementById('Partner_id').value;
		
		if(Cost_price !="" && Partner_id!="")
		{
			var cost_to_partner = parseFloat(Cost_price) + ( parseFloat(Cost_price) * (parseFloat(partner_vat)/100) );
			//var cost_to_partner = (Cost_price+ (Cost_price * (partner_vat/100))) ;
			document.getElementById('elarge_Cost_payable_to_partner').value = cost_to_partner//Math.round(cost_to_partner); 
			
			var Cost_payable_to_partner = document.getElementById('elarge_Cost_payable_to_partner').value;
			var Billing_price = parseFloat(Cost_payable_to_partner) + ( parseFloat(Cost_payable_to_partner) * (parseFloat(margin)/100) );
			document.getElementById('elarge_Billing_price').value=Billing_price.toFixed(2);//Math.round(Billing_price);
			
			// var Redemptionratio = '<?php echo $Company_details->Redemptionratio; ?>';
			//alert(Redemptionratio);
			var Redemptionratio=$('#Seller_Redemptionratio').val();
			var total1 =(parseFloat(Billing_price) * parseFloat(Redemptionratio));
			
			document.getElementById('elarge_Points').value=total1.toFixed(0);
		}
	}

	/*function Size_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('small_block').style.display="";
			document.getElementById('medium_block').style.display="";
			document.getElementById('large_block').style.display="";
			document.getElementById('default_block').style.display="none";
		}
		else
		{
			document.getElementById('small_block').style.display="none";
			document.getElementById('medium_block').style.display="none";
			document.getElementById('large_block').style.display="none";
			document.getElementById('default_block').style.display="";
		}
	} */
	
	function Colour_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('colour_block').style.display="";
		}
		else
		{
			document.getElementById('colour_block').style.display="none";
		}
	}
	function Brand_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('brand_block').style.display="";
		
		}
		else
		{
			document.getElementById('brand_block').style.display="none";
		}
	}
	function Dimension_toggle(flag)
	{
		var Size_flag = $('input[name=Size_flag]:checked').val();
		if(Size_flag==0)
		{
			if(flag==1)
			{
				document.getElementById('dimension_block').style.display="";
			}
			else
			{
				document.getElementById('dimension_block').style.display="none";
			}
		}
		else
		{
			if(flag==1)
			{
				document.getElementById('dimension_block_small').style.display="";
				document.getElementById('dimension_block_medium').style.display="";
				document.getElementById('dimension_block_large').style.display="";
				document.getElementById('edimension_block_large').style.display="";
			}
			else
			{
				document.getElementById('dimension_block_small').style.display="none";
				document.getElementById('dimension_block_medium').style.display="none";
				document.getElementById('dimension_block_large').style.display="none";
				document.getElementById('edimension_block_large').style.display="none";
			}
		}
	}
	
	function Weight_toggle(flag)
	{
		var Size_flag = $('input[name=Size_flag]:checked').val();
		
		if(Size_flag==0)
		{
			if(flag==1)
			{
				document.getElementById('weight_block').style.display="";
			}
			else
			{
				document.getElementById('weight_block').style.display="none";
			}
		}
		else
		{
			if(flag==1)
			{
				document.getElementById('weight_block_small').style.display="";
				document.getElementById('weight_block_medium').style.display="";
				document.getElementById('weight_block_large').style.display="";
				document.getElementById('eweight_block_large').style.display="";
			}
			else
			{
				document.getElementById('weight_block_small').style.display="none";
				document.getElementById('weight_block_medium').style.display="none";
				document.getElementById('weight_block_large').style.display="none";
				document.getElementById('eweight_block_large').style.display="none";
			}
		}
	}
	function Quantity_flag_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('quantity_block1').style.display="";
			document.getElementById('quantity_block2').style.display="";
			$("#Stock_quantity").attr("required","required");	
			
		}
		else
		{
			document.getElementById('quantity_block1').style.display="none";
			document.getElementById('quantity_block2').style.display="none";
			$("#Stock_quantity").removeAttr("required");
		}
	}
	function Manufacturer_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('manufacturer_block').style.display="";
		}
		else
		{
			document.getElementById('manufacturer_block').style.display="none";
		}
	}
	function Merchant_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('Seller_Admin_list').style.display="";
		}
		else
		{
			document.getElementById('Seller_Admin_list').style.display="none";
		}
	}
	
	function Merchandize_Item_inactive(Company_merchandise_item_id,Merchandize_item_name)
	{	
		var url = '<?php echo base_url()?>index.php/Coal_CatalogueC/InActive_Merchandize_Item/?Company_merchandise_item_id='+Company_merchandise_item_id;
		BootstrapDialog.confirm("Are you sure to Modify Cost Price of Merchandise Item '"+Merchandize_item_name+"' ?", function(result) 
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

	$('#Partner_id').change(function()
	{
		
		var Partner_id = $("#Partner_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			type:"POST",
			data:{Partner_id:Partner_id, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/CatalogueC/Get_Partner_Branches",
			success: function(data)
			{
				//alert(data)
				$('#partner_branches').html(data.Get_Partner_Branches2);
				$('#VAT').val(data.VAT);
				$('#margin').val(data.margin);
				//Get_Calculation();
				var Size_flag = $("input[name=Size_flag]:checked").val();
				if(Size_flag==1)
				{
					Get_Calculation_small();
					Get_Calculation_medium();
					Get_Calculation_large();
					Get_Calculation_extra_large();
				}
				else
				{
					Get_Calculation();
				}
				//$('#key_wory_heading').html("Key Customers");
			}				
		});
	});
	
	function Get_Calculation_small()
	{
		var partner_vat = document.getElementById('VAT').value;
		var Cost_price = document.getElementById('small_Cost_price').value;
		var margin = document.getElementById('margin').value;
		var Partner_id = document.getElementById('Partner_id').value;
		
		if(Cost_price !="" && Partner_id!="")
		{
			var cost_to_partner = parseFloat(Cost_price) + ( parseFloat(Cost_price) * (parseFloat(partner_vat)/100) );
			//var cost_to_partner = (Cost_price+ (Cost_price * (partner_vat/100))) ;
			document.getElementById('small_Cost_payable_to_partner').value = cost_to_partner//Math.round(cost_to_partner); 
			
			var Cost_payable_to_partner = document.getElementById('small_Cost_payable_to_partner').value;
			var Billing_price = parseFloat(Cost_payable_to_partner) + ( parseFloat(Cost_payable_to_partner) * (parseFloat(margin)/100) );
			document.getElementById('small_Billing_price').value=Billing_price.toFixed(2);//Math.round(Billing_price);
			
			// var Redemptionratio = '<?php echo $Company_details->Redemptionratio; ?>';
			//alert(Redemptionratio);
			var Redemptionratio=$('#Seller_Redemptionratio').val();
			var total1 =(parseFloat(Billing_price) * parseFloat(Redemptionratio));
			
			document.getElementById('small_Points').value=total1.toFixed(0);
		}
	}
	
	function Get_Calculation_medium()
	{
		var partner_vat = document.getElementById('VAT').value;
		var Cost_price = document.getElementById('medium_Cost_price').value;
		var margin = document.getElementById('margin').value;
		var Partner_id = document.getElementById('Partner_id').value;
		
		if(Cost_price !="" && Partner_id!="")
		{
			var cost_to_partner = parseFloat(Cost_price) + ( parseFloat(Cost_price) * (parseFloat(partner_vat)/100) );
			//var cost_to_partner = (Cost_price+ (Cost_price * (partner_vat/100))) ;
			document.getElementById('medium_Cost_payable_to_partner').value = cost_to_partner//Math.round(cost_to_partner); 
			
			var Cost_payable_to_partner = document.getElementById('medium_Cost_payable_to_partner').value;
			var Billing_price = parseFloat(Cost_payable_to_partner) + ( parseFloat(Cost_payable_to_partner) * (parseFloat(margin)/100) );
			document.getElementById('medium_Billing_price').value=Billing_price.toFixed(2);//Math.round(Billing_price);
			
			// var Redemptionratio = '<?php echo $Company_details->Redemptionratio; ?>';
			//alert(Redemptionratio);
			var Redemptionratio=$('#Seller_Redemptionratio').val();
			var total1 =(parseFloat(Billing_price) * parseFloat(Redemptionratio));
			
			document.getElementById('medium_Points').value=total1.toFixed(0);
		}
	}
	
	function Get_Calculation_large()
	{
		var partner_vat = document.getElementById('VAT').value;
		var Cost_price = document.getElementById('large_Cost_price').value;
		var margin = document.getElementById('margin').value;
		var Partner_id = document.getElementById('Partner_id').value;
		
		if(Cost_price !="" && Partner_id!="")
		{
			var cost_to_partner = parseFloat(Cost_price) + ( parseFloat(Cost_price) * (parseFloat(partner_vat)/100) );
			//var cost_to_partner = (Cost_price+ (Cost_price * (partner_vat/100))) ;
			document.getElementById('large_Cost_payable_to_partner').value = cost_to_partner//Math.round(cost_to_partner); 
			
			var Cost_payable_to_partner = document.getElementById('large_Cost_payable_to_partner').value;
			var Billing_price = parseFloat(Cost_payable_to_partner) + ( parseFloat(Cost_payable_to_partner) * (parseFloat(margin)/100) );
			document.getElementById('large_Billing_price').value=Billing_price.toFixed(2);//Math.round(Billing_price);
			
			// var Redemptionratio = '<?php echo $Company_details->Redemptionratio; ?>';
			//alert(Redemptionratio);
			var Redemptionratio=$('#Seller_Redemptionratio').val();
			var total1 =(parseFloat(Billing_price) * parseFloat(Redemptionratio));
			
			document.getElementById('large_Points').value=total1.toFixed(0);
		}
	}	
	
	function ecommerce_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('ecommerce_block1').style.display="";
			document.getElementById('ecommerce_block2').style.display="";
			document.getElementById('Offer_flag_div').style.display="";
			$("#Product_group_id").attr("required","required");
			$("#Product_brand_id").attr("required","required");	
			$("#Offer_flag").attr("required","required");	
		}
		else
		{
			document.getElementById('ecommerce_block1').style.display="none";
			document.getElementById('ecommerce_block2').style.display="none";
			document.getElementById('Offer_flag_div').style.display="none";
			
			$("#Product_group_id").removeAttr("required");	
			$("#Product_brand_id").removeAttr("required");	
			$("#Offer_flag").removeAttr("required");	
		}
	}
		
	$('#Product_group_id').change(function()
	{
		var Product_group_id = $("#Product_group_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			type:"POST",
			data:{Product_group_id:Product_group_id, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/CatalogueC/Get_Product_Brands",
			success: function(data)
			{
				//alert(data)
				$('#Product_brand_id').html(data.Product_groups);
				
				//$('#key_wory_heading').html("Key Customers");
			}				
		});
	});
	
	function Get_Calculation()
	{
		var partner_vat = document.getElementById('VAT').value;
		var Cost_price = document.getElementById('Cost_price').value;
		var margin = document.getElementById('margin').value;
		var Partner_id = document.getElementById('Partner_id').value;
		
		if(Cost_price !="" && Partner_id!="")
		{
			var cost_to_partner = parseFloat(Cost_price) + ( parseFloat(Cost_price) * (parseFloat(partner_vat)/100) );
			//var cost_to_partner = (Cost_price+ (Cost_price * (partner_vat/100))) ;
			document.getElementById('Cost_payable_to_partner').value = cost_to_partner//Math.round(cost_to_partner); 
			
			var Cost_payable_to_partner = document.getElementById('Cost_payable_to_partner').value;
			var Billing_price = parseFloat(Cost_payable_to_partner) + ( parseFloat(Cost_payable_to_partner) * (parseFloat(margin)/100) );
			document.getElementById('Billing_price').value=Billing_price//Math.round(Billing_price);
			
			var Seller_Redemptionratio = '<?php echo $Seller_Redemptionratio->Seller_Redemptionratio; ?>';
			var total1 =(Billing_price/Seller_Redemptionratio);
			
			document.getElementById('Points').value=total1.toFixed(0);
		}
	}
	
	$('#Company_merchandize_item_code').blur(function()
	{
		//alert();
		if( $("#Company_merchandize_item_code").val()  == "" )
		{
			$("#help-block1").html("Please enter merchandise item code");
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
		
	$('#Seller_id').change(function()
	{
		var Seller_id = $("#Seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Coal_Transactionc/get_Seller_Redemptionratio",
			success: function(data)
			{
				//alert(data.Seller_Redemptionratio)
				$('#Seller_Redemptionratio').val(data.Seller_Redemptionratio);
				//Get_Calculation();
				var Size_flag = $("input[name=Size_flag]:checked").val();
				if(Size_flag==1)
				{
					Get_Calculation_small();
					Get_Calculation_medium();
					Get_Calculation_large();
					Get_Calculation_extra_large();
				}
				else
				{
					Get_Calculation();
				}
			}				
		});
	});
	
	function Size_toggle(flag)
	{	
		// var Weight_flag = $('input[name=Weight_flag]:checked').val();
		var Weight_flag =1;
		Weight_toggle(Weight_flag);
		
		var Dimension_flag = $('input[name=Dimension_flag]:checked').val();
		Dimension_toggle(Dimension_flag);
		
		
		if(flag==1)
		{
			document.getElementById('small_block').style.display="";
			document.getElementById('medium_block').style.display="";
			document.getElementById('large_block').style.display="";
			document.getElementById('elarge_block').style.display="";
			document.getElementById('default_block').style.display="none";
		}
		else
		{
			document.getElementById('small_block').style.display="none";
			document.getElementById('medium_block').style.display="none";
			document.getElementById('large_block').style.display="none";
			document.getElementById('elarge_block').style.display="none";
			document.getElementById('default_block').style.display="";
		}
	}
	
	function Size_Chart_toggle(flag)
	{
		if(flag==1)
		{
			document.getElementById('Size_Chart_block').style.display="";
		}
		else
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="none";
			document.getElementById('Size_Chart_block').style.display="none";
			document.getElementById('Size_Chart_img_block1').style.display="none";
			document.getElementById('Size_Chart_img_block2').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="none";
		}
	}

	function Show_size_chart_image(val)
	{
		
		if(val=='Apparel Shirt - Male')
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="none";
			document.getElementById('Size_Chart_img_block1').style.display="";
			document.getElementById('Size_Chart_img_block2').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="none";
		}
		else if(val=='Apparel Trouser - Male')
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="none";
			document.getElementById('Size_Chart_img_block2').style.display="";
			document.getElementById('Size_Chart_img_block1').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="none";
		}
		else if(val=='Apparel Shirt - Female')
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="";
			document.getElementById('Size_Chart_img_block1').style.display="none";
			document.getElementById('Size_Chart_img_block2').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="none";
		}
		else if(val=='Apparel Trouser - Female')
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="";
			document.getElementById('Size_Chart_img_block1').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="none";
			document.getElementById('Size_Chart_img_block2').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="none";
		}
		else if(val=='Footwear Male')
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="";
			document.getElementById('Size_Chart_img_block1').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="none";
			document.getElementById('Size_Chart_img_block2').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="none";
		}
		else if(val=='Footwear Female')
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="";
			document.getElementById('Size_Chart_img_block1').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="none";
			document.getElementById('Size_Chart_img_block2').style.display="none";
		}
		else
		{
			document.getElementById('Size_Chart_upload_img_block').style.display="";
			document.getElementById('Size_Chart_img_block1').style.display="none";
			document.getElementById('Size_Chart_img_block2').style.display="none";
			document.getElementById('Size_Chart_img_block3').style.display="none";
			document.getElementById('Size_Chart_img_block4').style.display="none";
			document.getElementById('Size_Chart_img_block5').style.display="none";
			document.getElementById('Size_Chart_img_block6').style.display="none";
		}
	}
	
	/*********calender*********/
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
			
	});
	/*********calender*********/
	
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