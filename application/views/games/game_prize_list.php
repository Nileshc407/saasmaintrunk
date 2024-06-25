
<?php

	for($i = 1; $i <= $total_winners; $i++)
	{
		if( $i%2 != 0)
		{
?>	
			<div class="row mt-2">
<?php 	} 	
		if($prize_flag == 1)
		{
?>

		<div class="col-md-6">
		<div class="form-group">
			<label for=""><span class="required_info">*</span> Rank <?php echo $i; ?> Points</label>
			<input type="text" placeholder="Enter Points for Winner <?php echo $i; ?> " id="<?php echo "points_".$i; ?>" name="points[]"  class="form-control" required="required" data-error="Please enter points" onkeyup="this.value=this.value.replace(/\D/g,'')" />	
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
		</div>
<?php 
		}
		
		if($prize_flag == 2)
		{
	?>
	
		<div class="col-md-2 px-2">
			<div class="project-users">
			  <img alt="" src="#" class="rounded-circle" id="<?php echo "blah_".$i; ?>">
			</div>
		</div>
		<div class="col-md-4 px-2">
			<div class="form-group">
				<label for=""><span class="required_info">*</span> Rank <?php echo $i; ?> Prize</label>
				<input type="text" placeholder="Enter Rank <?php echo $i; ?> Prize Name" id="<?php echo "prize_".$i; ?>" name="prizes[]"  class="form-control" required="required" data-error="Please enter points" />
				<input type="file" name="file[]" id='<?php echo "file_".$i; ?>' onchange="readImage(this,'<?php echo "blah_".$i; ?>');"/>		
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
	<?php
	
		}

		if( $i%2 == 0 || $i == $total_winners)
		{
?>		
		</div>
<?php 	} 	
	}
?>