<?php
if($flag == 1){
if($Users != NULL){
	foreach($Users as $Rec)
	{
		
		echo '<option value="'.$Rec->Enrollement_id.'" selected >'.$Rec->First_name.' '.$Rec->Last_name.'</option>';
		
	}
}else
{
	echo '<option value="" >No Users Found</option>';
}
}
else
{
	if($Users != NULL){
	foreach($Users as $Rec)
	{
		
		echo '<option value="'.$Rec->Enrollement_id.'" selected >'.$Rec->First_name.' '.$Rec->Last_name.'</option>';
		
	}
	}else
	{
		echo '<option value="" >No Users Found</option>';
	}
}
?>
