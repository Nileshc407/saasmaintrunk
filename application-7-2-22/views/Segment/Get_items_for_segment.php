	
							
								<legend><span  id="title2">Select Items</span></legend>
							
							
							<div class="row">
							
								
								<div class="col-md-6">
								
									<b>Item Code.</b>
									
								</div>	
								<div class="col-md-6">
								
									<b>Item Name</b>
									
								</div>	
								
								<?php	
									if(count($Get_Linked_Items_for_segment)>10)
									{
										$style="style='height: 500px;overflow: auto;'";
									}
									else
									{
										$style="style='overflow: auto;'";
									}
									?>
							</div>	
							<br>	<br>
							<div class="row" <?php echo $style;?>>	
							
							<?php	
							//print_r($Get_Linked_Items_for_segment);
							$Count_items= count($Get_Linked_Items_for_segment);
							$ci_object = &get_instance();
							$ci_object->load->model('administration/Administration_model');
							if($Get_Linked_Items_for_segment!=NULL){
								$i=0;
							foreach($Get_Linked_Items_for_segment as $Items_by_category)
							{
								$Merchandize_category_id= $Items_by_category->Merchandize_category_id;
								
								$Merchandize_category_name= $Items_by_category->Merchandize_category_name;
								
								
								
								$Check_code =0;
								
								$Price =0.00;
								
							?>
							
							
							<div class="col-md-6">
							<label>
								<input type="checkbox" name="Item_check[]" id="Item_check_<?php echo $i; ?>"  value="<?php echo $Items_by_category->Company_merchandize_item_code; ?>" onclick="toggle_items(<?php echo $i; ?>);" <?php if($Check_code==1){echo 'checked';} ?> class="check">
								<?php echo $Items_by_category->Company_merchandize_item_code; ?>
								</label>
							</div>	
							<div class="col-md-6">
							
								
									<?php echo $Items_by_category->Merchandize_item_name; ?>
									<input type="hidden" id="Merchandize_item_name_<?php echo $i; ?>" name="Merchandize_item_name[]" value="<?php echo $Items_by_category->Merchandize_item_name; ?>" >
								
							</div>	
								
							
							<?php $i++;}}else{ 
								$Merchandize_category_name= '';
								$Merchandize_category_id=0;
								$Company_merchandize_item_code=0;
								
							echo 'Items Not Found !!!';} ?>	
							
							</div>	
							
						<div class="modal-footer">
								<span  id="error" style="color:red;"></span>
								<button type="button" id="select_id" class="btn btn-primary" onclick='select_all();' >Select All</button>
								<button type="submit" id="close_modal" class="btn btn-primary" onclick="Save_items_for_Segment();" >Save</button>
								<button type="button" id="close_modal12" class="btn btn-primary">Close</button>
						</div>
						
<script>
	$( "#close_modal12" ).click(function(e)
	{
		
		$('#Item_modal').hide();
		$("#Item_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	$( "#close_modal3" ).click(function(e)
	{
		
		$('#Item_modal').hide();
		$("#Item_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	$('#title2').html('<?php echo "<b>".$Merchandize_category_name." Group Items</b>";?>');
	
	function select_all()//  
	{
		$(".check").prop("checked", true);
		$(".qty").removeAttr("disabled"); 
	}


	function Save_items_for_Segment()
	{
		
		var Count_items = '<?php echo $Count_items; ?>';
		var Merchandize_category_id = '<?php echo $Merchandize_category_id; ?>';
		var Segment_Code = '<?php echo $Segment_Code; ?>';
		var Company_id = '<?php echo $Company_id; ?>';
		var Item_code = new Array();
		var Merchandize_item_name = new Array();
		if(Segment_Code== "")
		{
			var Title = "Application Information";
			var msg = 'Please Enter Item Code first';
			// runjs(Title,msg);
			// alert('Please Enter Discount Code first');
			$('#error').html('Please Enter Segment Code first');
			return false;
		}
		
		var error_count = 0;		
		for(var i=0; i<Count_items; i++ )
		{
			 if(document.getElementById('Item_check_'+i).checked==true)
			{
				var Item_check = $('#Item_check_'+i).val();
				var Merchandize_item_name2 = $('#Merchandize_item_name_'+i).val();
				
				Item_code.push(Item_check);
				Merchandize_item_name.push(Merchandize_item_name2);
				
				error_count = 1;	
			} 
			
		}
		
		if(error_count==0)
		{
			var Title = "Application Information";
			var msg = 'Please Select atleast One !!!';
			// runjs(Title,msg);
			// alert(msg);
			$('#error').html(msg);
			return false;
		} 
		
					
			$.ajax({
			  type: "POST",
			  data: {Item_code: Item_code,Merchandize_category_id: Merchandize_category_id,Segment_Code: Segment_Code,Company_id:Company_id,Merchandize_item_name:Merchandize_item_name,},
			  url: "<?php echo base_url()?>index.php/SegmentC/Save_items_segment",
			  success: function(data)
				{
				   
				   var Title = "Application Information";
					var msg = 'Main Items Saved Successfully !!!';
					$('#error').html(msg);
					$('#Item_modal').hide();
					$("#Item_modal").removeClass( "in" );
					$('.modal-backdrop').remove();
					// alert(msg);
					$("#selected_items").show();
					$('#Linked_items').html(data.Linked_items);
					
					$("#help-block22").html("");
					$("#Register").prop("type", "submit");
					
					$("#linked_itemcode").val(data.linked_itemcode);
					$("#linked_Category_id").val(data.linked_Category_id);
				}
			});  
				
		
	}
</script>	