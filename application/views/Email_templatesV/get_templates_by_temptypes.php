<option value="">Select Template Name</option>
<?php	
foreach($Templates as $Templates)
{
	
	?>
		<option value="<?php echo $Templates["Email_template_id"]; ?>"><?php echo $Templates["Email_template_name"]; ?></option>
	<?php
	
}
?>