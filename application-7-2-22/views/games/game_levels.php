
<?php
	$l = 1;
	foreach($game_levels as $level)
	{

	?>
	<div class="col-sm-6">	
		<div class="form-group" >
			<label for=""> <span class="required_info">* </span>Level </label>								
			<input class="form-control" id='<?php echo "level_".$l; ?>' name="game_levels[]" type="text" readonly value="<?php echo $level->Game_level; ?>">
		</div>
	</div>
	<div class="col-sm-6">	
		<div class="form-group" >
			<label for=""> <span class="required_info">* </span>Points </label>								
			<input class="form-control" id='<?php echo "points_".$l; ?>' name="level_points[]" type="text" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')">
		</div>
	</div>
					  
	<?php
		$l++;
		
	}
?>
	<input type="hidden" id="total_levels" value="<?php echo $l;?>" name="total_levels" class="form-control" />	

