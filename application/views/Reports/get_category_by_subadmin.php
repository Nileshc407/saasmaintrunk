<?php
if($Category != NULL){
	echo "<option value='0'>All</option>";
	foreach($Category as $Rec)
	{
		
		echo '<option value="'.$Rec->Merchandize_category_id.'"  >'.$Rec->Merchandize_category_name.'</option>';
		
	}
}else
{
	echo '<option value="" >No Menu Group Found</option>';
}
?>
