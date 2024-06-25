<?php	
foreach($Category_Publisher as $row)
{
?>
	<option value="<?php echo  $row->Register_beneficiary_id.'*'.$row->Igain_company_id;  ?>"> <?php echo $row->Beneficiary_company_name; ?> </option>
<?php
}
?>