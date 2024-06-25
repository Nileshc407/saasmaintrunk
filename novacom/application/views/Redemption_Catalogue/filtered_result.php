<?php
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
if($Filter_result != NULL)
{
    foreach ($Filter_result as $product)
    {
	  $Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];
?>

        <?php foreach ($Branches as $Branches2){
										$DBranch_code=$Branches2['Branch_code'];
						} ?>
						<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">
						<div class="col-md-3 ">
						<br>
							<div class="product" style="height:450px;">
								<div class="image">
									<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo $product['Company_merchandise_item_id']; ?>">
										<img src="<?php echo $product['Thumbnail_image1']; ?>" alt=""  style="height:150px;">
									</a>
								</div>
									
								<div class="text">
										<h5 style="line-height: 1.5em; height: 3em;       
										overflow: hidden;"><a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo $product['Company_merchandise_item_id']; ?>"> <?php echo $product['Merchandize_item_name']; ?> </a> </h5>
										<p class="price"><?php  
										if($product['Size_flag'] == 1) 
										{ 
											$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
											$Billing_price_in_points = $Get_item_price->Billing_price_in_points;
											echo $Get_item_price->Billing_price_in_points.' '.$Company_Details->Currency_name;
											$Item_size=$Get_item_price->Item_size;
											
										
										} 
										else 
										{
											$Item_size="0";
											$Billing_price_in_points = $product['Billing_price_in_points'];
											echo $product['Billing_price_in_points'].' '.$Company_Details->Currency_name;
										}
										?></p>
									<?php  if($product['Delivery_method']==0){ ?>	
								<div class="form-group">
									<label class="radio-inline">
										<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);">Pick-up
									</label>
									<label class="radio-inline">
									<input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked>Delivery
									</label>
								</div>
								<div class="form-group" style="display:none;" id="<?php echo $product['Company_merchandise_item_id']; ?>">
									<label for="exampleInputEmail1"><h5><?php echo ('Partner Location'); ?> : </h5></label>
									
									<select class="form-control" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" required>
										<option value=""><?php echo ('Select'); ?></option>
										<?php foreach ($Branches as $Branches3){?>
										<option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
										<?php } ?>
									</select>							
								</div>	
								<?php }elseif($product['Delivery_method']==28){ ?>
									<div class="form-group">
									<label class="radio-inline">
										<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);" checked>Pick-up
									</label>
									</div>
									<div class="form-group" id="<?php echo $product['Company_merchandise_item_id']; ?>">
									<label for="exampleInputEmail1"><h5><?php echo ('Partner Location'); ?> : </h5></label>
									
									<select class="form-control" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" required>
										<option value=""><?php echo ('Select'); ?></option>
										<?php foreach ($Branches as $Branches4){?>
										<option value="<?php echo $Branches4['Branch_code']; ?>"><?php echo $Branches4['Branch_name']; ?></option>
										<?php } ?>
									</select>							
								</div>	
								<?php }else{ ?>
								<div class="form-group">
									
									<label class="radio-inline">
									<input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked>Delivery
									</label>
									<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="0">
								</div>
								<?php }?>
									<div class="text">
											<button type="submit" class="btn btn-template-main" onclick="add_to_cart('<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Delivery_method']; ?>',location_<?php echo $product['Company_merchandise_item_id']; ?>.value,'<?php echo $product['Merchandize_item_name']; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $product['Company_merchandise_item_id']; ?>,<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>);get_item_list();" style="margin-left: -6px;">
												<i class="fa fa-shopping-cart"></i> <?php echo ('Add to cart'); ?>
											</button>		
									</div>	
								</div>	
							</div>	
						</div>
        
<?php
    }
}
?>

