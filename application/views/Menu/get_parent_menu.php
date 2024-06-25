<select class="form-control" name="parent_menu_id" id="parent_menu_id">
	<option value="">Select Parent Menu</option>
	<?php
	if($Parent_menu != NULL)
	{
		foreach($Parent_menu as $menu)
		{
		?>
		
			<option value="<?php echo $menu['Menu_id']; ?>"><?php echo $menu['Menu_name']; ?></option>
		
		<?php
		}
	}
	?>
</select>
