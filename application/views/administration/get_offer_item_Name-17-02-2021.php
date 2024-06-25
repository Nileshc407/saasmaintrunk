
	<?php
		// echo $offers_item_name->Company_merchandise_item_id;
	//echo "<option value=".$offers_item_name->Company_merchandise_item_id.">".$offers_item_name->Merchandize_item_name."</option>";
	/* foreach($offers_item_name as $item_name)
	{
		echo "<option value=".$item_name['Company_merchandise_item_id'].">".$item_name['Merchandize_item_name']."</option>";
	} */
	foreach($Offer_item_details as $items)
	{
		if($offers_item_name->Company_merchandise_item_id !=$items->Company_merchandise_item_id)
		{
			echo "<option value=".$items->Company_merchandise_item_id.">".$items->Merchandize_item_name."</option>";
		}
	}
	?>
