<?php
$CI =& get_instance();
$CI->load->model('Catalogue/Catelogue_model');
?>

<option value="" id="select_menu_group_id">Select Menu Group</option>
<?php	
if($MenuGrpArray != null)
{
	foreach($MenuGrpArray as $POS_menu_group)
	{
		if(!$POS_menu_group['Parent_category_id']) 
		{
			$childs=$CI->Catelogue_model->Get_Merchandize_Parent_Category_details($POS_menu_group['Merchandize_category_id']);
			echo'<option value="'.$POS_menu_group['Merchandize_category_id'].'" style="font-weight:bold;">'.$POS_menu_group['Merchandize_category_name'].'</option>';
		
			foreach($childs as $row) {
				echo'<option value="'.$row->Merchandize_category_id.'" style="margin-left: 20px;">--'.$row->Merchandize_category_name.'</option>';
			}
		}	
								
		/*?>
			<option value="<?php echo $POS_menu_group['Merchandize_category_id']; ?>" style="margin-left: 20px;"><?php echo $POS_menu_group['Merchandize_category_name']; ?></option>
		<?php
		*/
	}
	
}
?>