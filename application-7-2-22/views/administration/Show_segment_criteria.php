<?php 
	$Segment_operation=array();
	foreach($Criteria_records as $rec)
	{
		// echo $rec->Segment_type_name." ".$rec->Operator." '".$rec->Value."'";
		$Segment_operation[]=$rec->Segment_type_name." ".$rec->Operator." '".$rec->Value."'";		
		$lv_Segment_operation=implode(" AND ",$Segment_operation);	
	}
		echo $lv_Segment_operation;
?>
							
