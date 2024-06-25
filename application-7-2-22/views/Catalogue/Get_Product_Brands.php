<option value="" >Select Product Brand</option>
<?php	
foreach($Get_Product_Brands as $Product_Brands)
{
	
	?>
		<option value="<?php echo $Product_Brands->Product_brand_id; ?>"><?php echo $Product_Brands->Product_brand_name; ?></option>
	<?php
	
}
?>