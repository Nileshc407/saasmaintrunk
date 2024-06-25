<?php
if($Outlets != NULL){
	//echo '<option value="0" >All Outlets</option>';
	foreach($Outlets as $Rec)
	{
		
		echo '<option value="'.$Rec->Enrollement_id.'" selected >'.$Rec->First_name.' '.$Rec->Last_name.'</option>';
		
	}
}else
{
	echo '<option value="" >No Outlets Found</option>';
}
?>
