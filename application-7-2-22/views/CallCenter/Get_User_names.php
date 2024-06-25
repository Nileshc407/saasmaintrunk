<?php	
foreach($Get_User_Names as $User)
{
	$User_name=$User->First_name.' '.$User->Last_name;  
	?>
		<option value="<?php echo $User->Enrollement_id; ?>"><?php echo $User_name; ?></option>
	<?php
}
?>