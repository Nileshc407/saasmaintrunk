<?php 
if($MenuGrpArray != null){
	$z = 1;
	
	foreach($MenuGrpArray as $POS_main_group){
		$SequenceArray[] = $POS_main_group['Category_order'];
?>
	<tr>
		<th><input type='number' name='SequenceNo[]' id="SequenceNo<?php echo $z;?>" value="<?php echo $POS_main_group['Category_order']; ?>"  onfocus="removeVal(this.value);" onblur="AddMe('<?php echo $z;?>',this.value);" required>
		<div class="help-block form-text with-errors form-control-feedback" id="Sequence<?php echo $z;?>"></div>
		
		<input type='hidden' name='MenuId[]' value="<?php echo $POS_main_group['Merchandize_category_id']; ?>"></th>
		<?php 
		
		echo "<th>".$POS_main_group['Merchandize_category_name']."</th>";
		?>
		<th> 
			<div class="form-group upload-btn-wrapper">
			<?php if($POS_main_group['Icon'] != null){ ?>
				<img src="<?php echo $POS_main_group['Icon']; ?>" id="no_image<?php echo $z;?>" class="img-responsive" style="width:40%">	
			<?php }else{ ?>
				<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image<?php echo $z;?>" class="img-responsive" style="width:40%">
			<?php } ?>
			
				
				<input type="file" name="files[]" id="files" multiple onchange="readImage(this,'#no_image<?php echo $z;?>');" value="<?php echo $POS_main_group['Icon']; ?>" style="width:40%;" data-error="Please select menu image" />
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</th>
	</tr>
<?php 
		$z++;
	}
	
} ?>