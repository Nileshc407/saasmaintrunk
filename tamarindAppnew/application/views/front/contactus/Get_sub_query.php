<option value="">Select sub query </option>
<?php	
foreach($Get_subquery_Names as $row) 
{
?>
	<option value="<?php echo $row->Query_id; ?>"> <?php echo $row->Sub_query; ?> </option>
<?php
}
?>