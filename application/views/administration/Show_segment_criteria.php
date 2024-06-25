<?php 
	/* $Segment_operation=array();
	foreach($Criteria_records as $rec)
	{
		// echo $rec->Segment_type_name." ".$rec->Operator." '".$rec->Value."'";
		$Segment_operation[]=$rec->Segment_type_name." ".$rec->Operator." '".$rec->Value."'";		
		$lv_Segment_operation=implode(" AND ",$Segment_operation);	
	}
	echo $lv_Segment_operation; */	
	foreach($Criteria_records as $row)
	{		
		$lv_Segment_code=$row->Segment_code;
		
		$ci_object = &get_instance();
		$ci_object->load->model('Segment/Segment_model');
		$Get_segments = $ci_object->Segment_model->edit_segment_code($row->Company_id,$lv_Segment_code);
		$Segment_operation=array();
		$Segment_type_id=$row->Segment_type_id;
		
		
		$flag=0;
		$lv_Category_id = 0;
		foreach($Get_segments as $Get_segments)
		{
			$Segment_type_id2=$Get_segments->Segment_type_id;
			$Segment_code2=$Get_segments->Segment_code;
			
				
				if($Segment_type_id2==13 && $flag==0)//Item Category
				{
					
					$Get_linked_segment_items = $ci_object->Segment_model->Get_linked_items_segment_child2($row->Company_id,$lv_Segment_code);
					if($Get_linked_segment_items != NULL)
					{
						 $Segment_operation[] =$Get_linked_segment_items;
						// $Segment_operation[]='<a href="javascript:Get_segment_linked_items_table('."'$lv_Segment_code'".');">Item Category</a>';
						
							/* foreach($Get_linked_segment_items as $row)
							{
								
								// $row->Company_merchandize_item_code; 
								 $Segment_operation[] =$row->Merchandize_item_name;
							} */
						
						$flag=1;
					}
				}
				
				
				if($Get_segments->Operator=='Between')
				{
					$Segment_operation[]=$Get_segments->Segment_type_name." ".$Get_segments->Operator." (".$Get_segments->Value1.",".$Get_segments->Value2.")";
				}
				else
				{
					if($Segment_type_id2!=13 && $Segment_type_id2!=14)//Not Item Category 
					{
						if($Segment_type_id2==17)//Tier
						{
							$Get_tier = $ci_object->Igain_model->get_tier_detail($Get_segments->Value);
							if($Get_tier != NULL)
							{
								$Get_segments->Value = $Get_tier->Tier_name;
							}
						}
						if($Segment_type_id2==16)//Outlet
						{
							$Get_outlet = $ci_object->Igain_model->get_seller_details($Get_segments->Value);
							if($Get_outlet != NULL)
							{
								foreach($Get_outlet as $Get_outlet){
								$Get_segments->Value = $Get_outlet->First_name.' '.$Get_outlet->Last_name;}
							}
						}
						$Segment_operation[]=$Get_segments->Segment_type_name." ".$Get_segments->Operator." '".$Get_segments->Value."'";
					}
					
					if($Segment_type_id2==14)//Hobbies
					{
						$Get_hobbies = $ci_object->Segment_model->Get_linked_segment_hobbies($Get_segments->Value);
						if($Get_hobbies != NULL)
						{
							$Segment_operation[]=$Get_segments->Segment_type_name." ".$Get_segments->Operator." '".$Get_hobbies->Hobbies."'";
						}
					}
				}
			
			
		}
		// if(count($Segment_operation_item) > 0)
		// {
			// $Segment_operation[] = $Segment_operation_item;
		// }
		$lv_Segment_operation=implode(" AND ",$Segment_operation);
	}
	echo $lv_Segment_operation;
?>
							
