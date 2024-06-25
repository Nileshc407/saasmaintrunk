<option value="0" selected>All</option>
<?php	
foreach($Get_Partner_Branches as $Branch)
{
	
	?>
		<option value="<?php echo $Branch->Branch_code; ?>"><?php echo $Branch->Branch_name; ?></option>
	<?php
	
}
?>