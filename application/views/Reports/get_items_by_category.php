<?php
if($Items != NULL){
	foreach($Items as $Rec)
	{
		
		echo '<option value="'.$Rec->Company_merchandize_item_code.'"  selected>'.$Rec->Merchandize_item_name.'</option>';
		
	}
}else
{
	echo '<option value="" >No Items Found</option>';
}
?>
