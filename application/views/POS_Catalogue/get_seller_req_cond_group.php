
<?php
	foreach($Req_cond_group as $Rec)
	{
		echo '<option value="'.$Rec->Group_code.'">'.$Rec->Group_name.'</option>';
	}
?>
			