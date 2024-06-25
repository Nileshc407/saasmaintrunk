
	<?php
		// echo $offers_item_name->Company_merchandise_item_id;
	//echo "<option value=".$offers_item_name->Company_merchandise_item_id.">".$offers_item_name->Merchandize_item_name."</option>";
	/* foreach($offers_item_name as $item_name)
	{
		echo "<option value=".$item_name['Company_merchandise_item_id'].">".$item_name['Merchandize_item_name']."</option>";
	} */
	if($Offer_item_details != NULL)
	{
		foreach($Offer_item_details as $items)
		{
			if (in_array($items->Company_merchandise_item_id, $Selected_items))
			{
				if($offers_item_name->Company_merchandise_item_id !=$items->Company_merchandise_item_id)
				{
					echo "<option value=".$items->Company_merchandise_item_id." selected>".$items->Merchandize_item_name."</option>";
				}
			}
			else
			{
				if($offers_item_name->Company_merchandise_item_id !=$items->Company_merchandise_item_id)
				{
					echo "<option value=".$items->Company_merchandise_item_id.">".$items->Merchandize_item_name."</option>";
				}
			}
			
		}
	}
	?>
