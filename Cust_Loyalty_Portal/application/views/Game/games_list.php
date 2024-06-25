<?php

	if(count($games) > 0)
	{
?>
	<label for="exampleInputEmail1">Game Name</label>
	<select class="form-control" name="Game_id" id="Game_id" required>
		<option value=""> Select Game </option>
		<?php 
		foreach($games as $game_details)
		{

		?>
			<option value="<?php echo $game_details->Company_game_id; ?>" ><?php echo $game_details->Game_name; ?></option>
		<?php 
		}
		?>
	</select>	
<?php
	}
	else
	{
		?>
		<p><h4>Sorry, Currently not set any game. </h4></p>
		<label for="exampleInputEmail1">Game Name</label>
		<select class="form-control" name="Game_id" id="Game_id" required>
			<option value=""> Select Game </option>
		</select>
		<?php
	}
?>
